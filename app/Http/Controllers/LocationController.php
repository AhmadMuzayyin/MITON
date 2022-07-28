<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class LocationController extends Controller
{
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
                $l->activity_id = $request->activity_id;
                $l->lokasi = $request->lokasi;
                $l->latitude = $request->latt;
                $l->longitude = $request->long;
                $l->save();
            } else {
                $l = new Location;
                $l->schedule_id = $request->id;
                $l->activity_id = $request->activity_id;
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

            toastr()->success('Data lokasi berhasil ditambah!');
            return redirect('/schedule/' . $request->id . '/edit');
        } catch (QueryException $th) {
            toastr()->success('Gagal menambahkan data lokasi!');
            return redirect()->back();
        }
    }
    public function destroy(Location $location)
    {
        try {
            Location::destroy($location->id);
            return response()->json(['success', 'Data lokasi berhasil dihapus']);
        } catch (QueryException $th) {
            toastr()->error('Gagal menghapus data lokasi');
            return redirect()->back();
        }
    }
}
