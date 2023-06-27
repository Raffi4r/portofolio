<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\History;
use Illuminate\Http\Request;

class educationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = History::where('type', 'education')->orderBy('date_start', 'asc')->paginate(10);
        foreach ($data as $item) {
            $start = Carbon::parse($item->date_start);
            $end = Carbon::parse($item->date_end);
            $item->start_date = $start->format('d F Y');
            $item->end_date = $end->format('d F Y');
        }
        return view('dashboard.educations.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.educations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'         => 'required',
                'info1'         => 'required',
                'info2'         => 'required',
                'info3'         => 'required',
                'date_start'    => 'required',
                'date_end'      => 'required'
            ],
            [
                'title.required'        => 'University cannot be empty',
                'info1.required'        => 'Faculty cannot be empty',
                'info2.required'        => 'Major cannot be empty',
                'info3.required'        => 'GPA cannot be empty',
                'date_start.required'   => 'Date start cannot be empty',
                'date_end.required'     => 'Date start cannot be empty'

            ]
        );

        $data = [
            'title'         => $request->title,
            'type'         => 'education',
            'info1'         => $request->info1,
            'info2'         => $request->info2,
            'info3'         => $request->info3,
            'date_start'    => $request->date_start,
            'date_end'      => $request->date_end,
        ];
        History::create($data);
        return redirect()->route('educations.index')->with('message', 'save');
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
        return view('dashboard.educations.edit')->with('data', $data);
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
        $request->validate(
            [
                'title'         => 'required',
                'info1'         => 'required',
                'info2'         => 'required',
                'info3'         => 'required',
                'date_start'    => 'required',
                'date_end'      => 'required'
            ],
            [
                'title.required'        => 'University cannot be empty',
                'info1.required'        => 'Faculty cannot be empty',
                'info2.required'        => 'Major cannot be empty',
                'info3.required'        => 'GPA cannot be empty',
                'date_start.required'   => 'Date start cannot be empty',
                'date_end.required'     => 'Date start cannot be empty'

            ]
        );

        $data = [
            'title'         => $request->title,
            'type'         => 'education',
            'info1'         => $request->info1,
            'info2'         => $request->info2,
            'info3'         => $request->info3,
            'date_start'    => $request->date_start,
            'date_end'      => $request->date_end,
        ];
        History::where('id', $id)->update($data);
        return redirect()->route('educations.index')->with('message', 'update');
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
        return redirect()->route('educations.index')->with('message', 'delete');
    }
}
