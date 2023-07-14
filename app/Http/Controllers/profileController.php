<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use Illuminate\Http\Request;

class profileController extends Controller
{
    function index()
    {
        return view('dashboard.profile.index');
    }

    function update(Request $request)
    {
        $rules = [
            'photo'     => 'image|mimes:jpg,jpeg,png',
            'province'  => 'required',
            'city'      => 'required',
            'phone'     => 'required',
            'email'     => 'required',
        ];

        $messages = [
            'photo.image'       => 'Only images are allowed for the photo',
            'photo.mimes'       => 'Only .jpg, .jpeg, and .png files are allowed for the photo',
            'province.required' => 'Province cannot be empty',
            'city.required'     => 'City cannot be empty',
            'phone.required'    => 'Phone number cannot be empty',
            'email.required'    => 'Email cannot be empty'
        ];

        if ($request->isMethod('post')) {
            $request->validate($rules, $messages);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'profile_picture.' . $file->getClientOriginalExtension();
            $filePath = 'admin/images/profile/';
            $file->move(public_path($filePath), $fileName);

            Metadata::updateOrCreate(['meta_key' => 'photo'], ['meta_value' => $fileName]);
        }

        $metadataKeys = [
            'province', 'city', 'phone', 'email', 'facebook',
            'instagram', 'discord', 'twitter', 'linkedin', 'github'
        ];

        foreach ($metadataKeys as $key) {
            Metadata::updateOrCreate(['meta_key' => $key], ['meta_value' => $request->input($key)]);
        }

        return redirect()->route('profile.index')->with('message', 'update');
    }
}
