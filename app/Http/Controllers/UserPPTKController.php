<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\UserPPTK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPPTKController extends Controller
{
    public function store(Request $request)
    {
        try {
            $up = new UserPPTK;
            $up->user_id = Auth()->user()->id;
            $up->nama = $request->nama;
            $up->nip = $request->nip;
            $up->save();

            toastr()->success('Berhasil menambah data PPTK!');
            return redirect('/schedule/' . $request->id . '/edit/pptk');
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error('Gagal menambah data PPTK');
            return redirect()->back();
        }
    }
    public function updateUser(Request $request)
    {
        try {
            $user = UserPPTK::find($request->id);
            $user->nip = $request->nip;
            $user->nama = $request->nama;
            $user->save();
            return response()->json(['success' => 'Data PPTK Berhasil dirubah!']);
        } catch (\Illuminate\Database\QueryException $th) {
            return response()->json(['error' => $th->errorInfo]);
        }
    }
    public function destroy(UserPPTK $UserPPTK)
    {
        try {
            UserPPTK::destroy($UserPPTK->id);
            return response()->json(['success' => 'Data PPTK berhasil dihapus!']);
        } catch (\Illuminate\Database\QueryException $th) {
            return response()->json(['error' => $th->errorInfo]);
        }
    }
}
