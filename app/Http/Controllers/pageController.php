<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class pageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Page::orderBy('title', 'asc')->get();
        return view('dashboard.pages.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('title', $request->title);
        Session::flash('description', $request->description);

        $request->validate(
            [
                'title'         => 'required',
                'description'   => 'required'
            ],
            [
                'title.required'        => 'Title cannot be empty',
                'description.required'   => 'Description cannot be empty'
            ]
        );

        $data = [
            'title'         => $request->title,
            'description'   => $request->description
        ];
        Page::create($data);

        return redirect()->route('pages.index')->with('success', 'Page saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Page::where('id', $id)->first();
        return view('dashboard.pages.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Session::flash('title', $request->title);
        Session::flash('description', $request->description);

        $request->validate(
            [
                'title'         => 'required',
                'description'   => 'required'
            ],
            [
                'title.required'        => 'Title cannot be empty',
                'description.required'   => 'Description cannot be empty'
            ]
        );

        $data = [
            'title'         => $request->title,
            'description'   => $request->description
        ];
        Page::where('id', $id)->update($data);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::where('id', $id)->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully');
    }
}
