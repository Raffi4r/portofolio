<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class experinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = History::orderBy('date_start', 'asc')->get();
        foreach ($data as $item) {
            $start = Carbon::parse($item->date_start);
            $item->start_date = $start->format('d F Y');
            if (is_null($item->date_end)) {
                $item->end_date = 'Present';
            } else {
                $end = Carbon::parse($item->date_end);
                $item->end_date = $end->format('d F Y');
            }
        }
        return view('dashboard.experiences.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.experiences.create');
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
        Session::flash('info1', $request->info1);
        Session::flash('date_start', $request->date_start);
        Session::flash('description', $request->description);

        $request->validate(
            [
                'title'         => 'required',
                'info1'         => 'required',
                'date_start'    => 'required',
                'description'   => 'required'
            ],
            [
                'title.required'        => 'Title cannot be empty',
                'info1.required'        => 'Company cannot be empty',
                'date_start.required'   => 'Date start cannot be empty',
                'description.required'  => 'Description cannot be empty',

            ]
        );

        $data = [
            'title'         => $request->title,
            'type'         => 'experience',
            'info1'         => $request->info1,
            'date_start'    => $request->date_start,
            'date_end'      => $request->date_end,
            'description'   => $request->description
        ];
        History::create($data);

        return redirect()->route('experiences.index')->with('success', 'Experince saved successfully');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
