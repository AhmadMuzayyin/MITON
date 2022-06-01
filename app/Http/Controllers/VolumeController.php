<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
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
            $cek = Volume::firstWhere('schedule_id', $request->id);
            if ($cek == true) {
                $s = Volume::find($cek->id);
                $s->schedule_id = $request->id;
                $s->volume = $request->volume;
                $s->satuan = $request->satuan;
                $s->save();
            }else{
                $v = new Volume;
                $v->schedule_id = $request->id;
                $v->volume = $request->volume;
                $v->satuan = $request->satuan;
                $v->save();

               $s = Schedule::find($request->id);
                if ($s == null) {
                    $s->persentase = 20;
                }
                $s->persentase = $s->persentase + 20;
                $s->save();
            }
            
            
            return redirect('/schedule/'. $request->id .'/edit/volume')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function show(Volume $volume)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function edit(Volume $volume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Volume $volume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volume $volume)
    {
        //
    }
}
