<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SocialIcon;
use Illuminate\Http\Request;

class SocialIconController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialIcon = SocialIcon::orderBy('created_at', 'desc')->get();

        return view('dashboard.pages.socialIcon', ['socialIcon' => $socialIcon]);
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
        $validated = $request->validate([
            'link' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        SocialIcon::create($validated);

        return redirect()->back()->with('success', 'Added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialIcon $socialIcon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialIcon $socialIcon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $SocialIcon = SocialIcon::find($id);
        $SocialIcon->update($request->only(['link', 'icon']));

        return redirect()->back()->with('success', 'Social Icon updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $SocialIcon = SocialIcon::findOrFail($id);
        $SocialIcon->delete();

        return redirect()->back()->with('success', 'Social Icon deleted successfully');
    }
}
