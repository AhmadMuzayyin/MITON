<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $cek = Location::firstWhere('schedule_id', $request->id);
            if ($cek == true) {
                // $l = Location::find($cek->id);
                // $l->schedule_id = $request->id;
                // $l->lokasi = $request->lokasi;
                // $l->save();

                $l = new Location;
                $l->schedule_id = $request->id;
                $l->lokasi = $request->lokasi;
                $l->latitude = $request->latt;
                $l->longitude = $request->long;
                $l->save();
            }else{
                $l = new Location;
                $l->schedule_id = $request->id;
                $l->lokasi = $request->lokasi;
                $l->latitude = $request->latt;
                $l->longitude = $request->long;
                $l->save();

                $s = Schedule::find($request->id);
                if ($s == null) {
                    $s->persentase = 20;
                }
                $s->persentase = $s->persentase + 20;
                $s->save();
            }

            return redirect('/schedule/'. $request->id .'/edit')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        try {
            Location::destroy($location->id);
            return response()->json(['success', 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }
}
