<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\PurchaseCompletedMail;
use Illuminate\Support\Facades\Mail;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function indexAdmin(Request $request)
    {
        $itemsPerPage = Config::get('app.items_per_page');
        $query = Store::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($itemsPerPage);

        $products->appends($request->except('page'));

        return view('dashboard.store.show', compact('products'));
    }

    public function index(Request $request)
    {
        $itemsPerPage = Config::get('app.items_per_page');
        $query = Store::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($itemsPerPage);

        $products->appends($request->except('page'));

        $sliderStores = Store::inRandomOrder()->take(8)->get();

        return view('index', compact('products', 'sliderStores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.store.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric',
            'link_en' => 'required|string|max:255',
            'link_ar' => 'required|string|max:255',
            'img.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if (Store::where('link_en', $validatedData['link_en'])->exists()) {
            $validatedData['link_en'] .= '-' . substr(Str::uuid(), 0, 10);
        }

        if (Store::where('link_ar', $validatedData['link_ar'])->exists()) {
            $validatedData['link_ar'] .= '-' . substr(Str::uuid(), 0, 10);
        }


        $store = Store::create($validatedData);

        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $file) {
                $path = $file->store('products', 'public');

                StoreImage::create([
                    'store_id' => $store->id,
                    'img' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Store and images added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($link)
    {
        $sliderStores = Store::inRandomOrder()->take(6)->get();

        $product = Store::with('images')->where('link_en', $link)->orWhere('link_ar', $link)->firstOrFail();

        function processDescription($html)
        {
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $elements = $dom->getElementsByTagName('*');

            foreach ($elements as $element) {
                $text = trim($element->textContent);
                $cleanText = str_replace("\xc2\xa0", ' ', $text);
                if (strlen($cleanText) > 50) {
                    return substr($cleanText, 0, 80) . '...';
                }
            }
            return $html;
        }

        $product->info_ar = processDescription($product->description_ar);
        $product->info_en = processDescription($product->description_en);

        return view('stores.show', compact('product', 'sliderStores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $store = Store::with('images')->findOrFail($id);

        return view('dashboard.store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'price' => 'required|numeric',
            'link_en' => 'required|string|max:255',
            'link_ar' => 'required|string|max:255',
            'img.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $store = Store::findOrFail($id);
        $store->update($validatedData);

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = StoreImage::findOrFail($imageId);
                Storage::disk('public')->delete($image->img);
                $image->delete();
            }
        }

        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $file) {
                $path = $file->store('products', 'public');
                StoreImage::create([
                    'store_id' => $store->id,
                    'img' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Store and images updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        $images = StoreImage::where('store_id', $store->id)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->img);

            $image->delete();
        }

        $store->delete();

        return redirect()->back()->with('success', 'Store and associated images deleted successfully.');
    }

    public function showCart($id)
    {
        $product = Store::with('images')->find($id);

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found']);
        }
    }

    public function languageGet()
    {
        abort(404);
    }

    public function language(Request $request)
    {
        $request->validate(['language' => 'required|in:en,ar']);
        Session::put('locale', $request->language);

        return redirect()->back();
    }

    public function purchaseNotFound()
    {
        return view('stores.purchase');
    }


    public function purchaseComplete(Request $request)
    {
        $cartItems = json_decode($request->input('cart_items'), true);

        if (!is_array($cartItems)) {
            return redirect()->back()->with('error', 'Invalid cart items data.');
        }

        $data = $request->all();
        $data['cart_items'] = $cartItems;

        Mail::to('oror010155@gmail.com')->send(new PurchaseCompletedMail($data));

        $requestLang = "";

        if (Session::get('locale') == 'ar') {
            $requestLang = "تم إتمام الشراء بنجاح";
        } else {
            $requestLang = "Purchase completed successfully";
        }

        return redirect()->route('index.store')->with([
            'success' => $requestLang,
            'removeitemsCart' => true,
        ]);
    }
}
