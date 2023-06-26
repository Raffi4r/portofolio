<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\History;
use Illuminate\Http\Request;

class experienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = History::orderBy('date_start', 'asc')->paginate(10);
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
        if (is_null($request->present)) {
            $request->validate(
                [
                    'title'         => 'required',
                    'info1'         => 'required',
                    'date_start'    => 'required',
                    'date_end'      => 'required',
                    'description'   => 'required'
                ],
                [
                    'title.required'        => 'Title cannot be empty',
                    'info1.required'        => 'Company cannot be empty',
                    'date_start.required'   => 'Date start cannot be empty',
                    'date_end.required'     => 'Date start cannot be empty',
                    'description.required'  => 'Description cannot be empty',

                ]
            );
        } else {
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
        }

        $data = [
            'title'         => $request->title,
            'type'         => 'experience',
            'info1'         => $request->info1,
            'date_start'    => $request->date_start,
            'date_end'      => $request->date_end,
            'description'   => $request->description
        ];
        History::create($data);

        return redirect()->route('experiences.index')->with('message', 'save');
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
        $data = History::where('id', $id)->first();
        return view('dashboard.experiences.edit')->with('data', $data);
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
        if (is_null($request->present)) {
            $request->validate(
                [
                    'title'         => 'required',
                    'info1'         => 'required',
                    'date_start'    => 'required',
                    'date_end'      => 'required',
                    'description'   => 'required'
                ],
                [
                    'title.required'        => 'Title cannot be empty',
                    'info1.required'        => 'Company cannot be empty',
                    'date_start.required'   => 'Date start cannot be empty',
                    'date_end.required'     => 'Date start cannot be empty',
                    'description.required'  => 'Description cannot be empty',

                ]
            );
        } else {
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
        }

        $data = [
            'title'         => $request->title,
            'type'         => 'experience',
            'info1'         => $request->info1,
            'date_start'    => $request->date_start,
            'date_end'      => $request->date_end,
            'description'   => $request->description
        ];
        History::where('id', $id)->update($data);

        return redirect()->route('experiences.index')->with('message', 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        History::where('id', $id)->delete();
        return redirect()->route('experiences.index')->with('message', 'delete');
    }
}
