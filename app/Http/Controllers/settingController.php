<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use App\Models\Page;
use Illuminate\Http\Request;

class settingController extends Controller
{
    function index()
    {
        $data = Page::orderBy('title', 'asc')->get();
        return view('dashboard.setting.index')->with('data', $data);
    }

    function update(Request $request)
    {
        Metadata::updateOrCreate(['meta_key' => 'about'], ['meta_value' => $request->about]);
        Metadata::updateOrCreate(['meta_key' => 'award'], ['meta_value' => $request->award]);
        Metadata::updateOrCreate(['meta_key' => 'interest'], ['meta_value' => $request->interest]);

        return redirect()->route('setting.index')->with('message', 'update');
    }
}
