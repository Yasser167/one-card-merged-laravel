<?php

namespace App\Http\Controllers\admin\setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.settings');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $settings = Setting::find($id);

        $request->validate([
            'logo_og' => 'nullable|image|mimes:png|max:2048',
            'logo_site' => 'nullable|image|mimes:png|max:2048',
            'favicon' => 'nullable|mimes:ico|max:2048',
            'title_en' => 'nullable|string|max:50',
            'title_ar' => 'nullable|string|max:50',
            'description_en' => 'nullable|string|max:150',
            'description_ar' => 'nullable|string|max:150',
            'keywords' => 'nullable|string|max:255',
            'head' => 'nullable|string',
        ]);


        if ($request->hasFile('logo_og')) {
            if ($settings->logo_og && Storage::disk('public')->exists($settings->logo_og)) {
                Storage::disk('public')->delete($settings->logo_og);
            }

            $file = $request->file('logo_og');
            $settings->logo_og = $file->store('settings', 'public');
        }

        if ($request->hasFile('logo_site')) {
            if ($settings->logo_site && Storage::disk('public')->exists($settings->logo_site)) {
                Storage::disk('public')->delete($settings->logo_site);
            }

            $file = $request->file('logo_site');
            $settings->logo_site = $file->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }

            $file = $request->file('favicon');
            $settings->favicon = $file->store('favicon', 'public');
        }


        $settings->title_en = $request->input('title_en');
        $settings->title_ar = $request->input('title_ar');
        $settings->description_en = $request->input('description_en');
        $settings->description_ar = $request->input('description_ar');
        $settings->keywords = $request->input('keywords');
        $settings->head = $request->input('head');

        $settings->save();

        return redirect()->back()->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
