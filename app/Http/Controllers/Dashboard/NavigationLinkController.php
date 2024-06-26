<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NavigationLink;
use Illuminate\Http\Request;

class NavigationLinkController extends Controller
{
    public function index()
    {
        $navigationLinks = NavigationLink::all();
        $parents =NavigationLink::with('children')->get();
        return view('dashboard.navigation-links', compact('navigationLinks', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'url' => 'required',
            'parent_id' => 'nullable|exists:navigation_links,id',
        ]);

        $link = NavigationLink::create([
            'text' => $request->input('text'),
            'url' => $request->input('url'),
           'parent_id' => $request->input('parent_id') ?: null, // Set parent_id to null if not provided
        ]);

        $link->save();

        return response()->json(['success' => true, 'message' => 'Navigation link added successfully.', 'link' => $link]);
    }

    public function update(Request $request, NavigationLink $navigationLink)
    {
        $request->validate([
            'text' => 'required|string',
            'url' => 'required',
            'parent_id' => 'nullable|exists:navigation_links,id',
        ]);

        $navigationLink->update([
            'text' => $request->input('text'),
            'url' => $request->input('url'),
            'parent_id' => $request->input('parent_id') ?: null, // Set parent_id to null if not provided
        ]);

        return response()->json(['success' => true, 'message' => 'Navigation link updated successfully.', 'link' => $navigationLink]);
    }

    public function destroy(NavigationLink $navigationLink)
    {
        $navigationLink->delete();

        return response()->json(['success' => true, 'message' => 'Navigation link deleted successfully.']);
    }
}
