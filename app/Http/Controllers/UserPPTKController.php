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

            return redirect('/schedule/' . $request->id . '/edit/pptk')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return response()->json(['tryError', $th->getMessage()]);
        }
    }
    public function updateUser(Request $request)
    {
        try {
            $user = UserPPTK::find($request->id);
            $user->nip = $request->nip;
            $user->nama = $request->nama;
            $user->save();
            return response()->json(['success' => 'Data Berhasil dirubah!']);
        } catch (\Throwable $th) {
            return response()->json(['tryErr' => $th->getMessage()]);
        }
    }
    public function destroy(UserPPTK $UserPPTK)
    {
        try {
            UserPPTK::destroy($UserPPTK->id);
            return response()->json(['success' => 'Data berhasil dihapus!']);
        } catch (\Throwable $th) {
            return response()->json(['tryErr' => $th->getMessage()]);
        }
    }
}
