<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lab;
use App\Http\Resources\Lab as LabResource;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get labs
        $labs = Lab::orderBy('created_at', 'desc')->paginate(15);

        //return lab collection as a resource
        return LabResource::collection($labs);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lab = $request->isMethod('put') ? Lab::findOrFail($request->lab_id) : new Lab;

        $lab->id = $request->input('lab_id');
        $lab->name = $request->input('name');
        $lab->lat = $request->input('lat');
        $lab->long = $request->input('long');

        if ($lab->save()) {
            return new LabResource($lab);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check()) {
            $lab = Lab::findOrFail($id);

            return new LabResource($lab);
        } else {
            return redirect('login');
        }
        // Get a single lab
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lab = Lab::findOrFail($id);

        if ($lab->delete()) {
            return new LabResource($lab);
        }
    }
}
