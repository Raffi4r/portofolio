<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use Illuminate\Http\Request;

class skillController extends Controller
{
    public function index()
    {
        $skill_url = public_path('admin/devicon.json');
        $skill_data = file_get_contents($skill_url);
        $skill_data = json_decode($skill_data, true);
        $skill = array_column($skill_data, 'name');
        $skill = "'" . implode("','", $skill) . "'";

        return view('dashboard.skills.index')->with(['skill' => $skill]);
    }

    public function update(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate(
                [
                    'languages'     => 'required',
                    'workflow'      => 'required'
                ],
                [
                    'languages.required'    => 'Languages cannot be empty',
                    'workflow.required'     => 'Workflow cannot be empty'
                ]
            );
        }

        Metadata::updateOrCreate(['meta_key' => 'languages'], ['meta_value' => $request->languages]);
        Metadata::updateOrCreate(['meta_key' => 'workflow'], ['meta_value' => $request->workflow]);

        return redirect()->route('skills.index')->with('message', 'update');
    }
}
