<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Website_meta_description;
use App\Models\WebsiteMetaTitle;
use Illuminate\Http\Request;

class WebsiteDescription extends Controller
{
    public function create()
    {
        return view('dashboard.meta-description.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['description' => 'required|string|max:150']);
        Website_meta_description::create($data);
        return redirect()->route('dashboard.settings')->with('sucess_message', 'Website meta description added');
    }

    public function edit($id)
    {
        $website_meta_description = Website_meta_description::findOrfail($id);
        return view('dashboard.meta-description.edit', compact('website_meta_description'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['description' => 'required|string|max:150']);
        $website_meta_description = Website_meta_description::findOrFail($id);
        $website_meta_description->update($data);
        return redirect()->route('dashboard.settings')->with('sucess_message', 'Website meta description updated successfully');
    }

    public function destroy($id)
    {
      Website_meta_description::findOrFail($id)->delete();
        return redirect()->route('dashboard.settings')->with('sucess_message', 'Website meta description Removed successfully');
    }


    // meta title or website title

    public function createMetaTitle()

    {
        return view('dashboard.meta-title.create');
    }

    public function storeMetaTitle(Request $request)

    {
        $data = $request->validate(['meta_title' => 'nullable|string|max:50']);
        WebsiteMetaTitle::create($data);
        return redirect()->route('dashboard.settings')->with('sucess_message', 'Website meta title updated');
    }

    public function editMetaTitle($id)

    {
        $website_title = WebsiteMetaTitle::findOrFail($id); 
        return view('dashboard.meta-title.edit', compact('website_title'));
    }

    public function updateMetaTitle(Request $request, $id)

    {
        $data = $request->validate(['meta_title' => 'nullable|string|max:50']);
        $meta_title = WebsiteMetaTitle::findOrFail($id);
        $meta_title->update($data);
        return redirect()->route('dashboard.settings')->with('sucess_message', 'Website meta title updated');

    }
}
