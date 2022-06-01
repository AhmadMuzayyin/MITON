<?php

namespace App\Http\Controllers;

use App\Models\InputActivation;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class InputActivationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = InputActivation::all();
        return view('admin.activation.activation', [
            'page' => 'index',
            'data' => $data
        ]);
    }

    public function ganti(Request $request)
    {
        try {
            $cek = InputActivation::firstWhere('id', $request->id);
            
            $g = InputActivation::find($request->id);
            $g->status = $cek->status == 1 ? 0 : 1;
            $g->save();

            return redirect()->route('activation.index')->with('success', 'Data Berhasil diganti!');
        } catch (\Throwable $th) {
            return response()->json(['tryErr', $th->getMessage()]);
        }
    }
}
