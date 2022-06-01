<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index', [
            'page' => 'index',
            'data' =>User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.index', [
            'page' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'kode' => 'required|unique:users,kode_SKPD',
            'username' => 'required|unique:users'
        ]);
        try {
            $user = new User;
            $fileName = $request->file('profil') ? time().'_'.$request->file('profil')->getClientOriginalName() : 'default.jpg';
            $request->file('profil') ? $request->file('profil')->storeAs('public/uploads', $fileName) : '';

            $user->kode_SKPD = $request->kode;
            $user->nama_SKPD = $request->skpd;
            $user->nama_operator = $request->namaoperator;
            $user->no_hp = $request->nooperator;
            $user->no_kantor = $request->nokantor;
            $user->alamat_kantor = $request->alamatkantor;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->nama_KPA = $request->kpa;
            $user->foto = $fileName;
            $user->isAdmin = $request->level;
            $user->save();

            return redirect()->route('user.index')->with('success', 'Data berhasil ditambah!');
        } catch (\Throwable $th) {
            return back()->with('tryError', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        return Excel::download(new UsersExport, 'OPD.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.user.index', [
            'page' => 'edit',
            'data' => User::where('id', $id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        try {
            $user = User::find($request->id);
            $fileName = $request->file('profil') ? time().'_'.$request->file('profil')->getClientOriginalName() : Auth()->user()->foto;
            $request->file('profil') ? $request->file('profil')->move(public_path('uploads'), $fileName) : '';
            $password = $request->password ? bcrypt($request->password) : Auth()->user()->password;
            $user->kode_SKPD = $request->kode;
            $user->nama_SKPD = $request->skpd;
            $user->nama_operator = $request->namaoperator;
            $user->no_hp = $request->nooperator;
            $user->no_kantor = $request->nokantor;
            $user->alamat_kantor = $request->alamatkantor;
            $user->username = $request->username;
            $user->password = $password;
            $user->nama_KPA = $request->kpa;
            $user->foto = $fileName;
            $user->isAdmin = $request->level;
            $user->save();

            return redirect()->route('user.index')->with('success', 'Data berhasil ditambah!');
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            File::delete(public_path('storage/uploads/'.$user->foto));
            User::destroy($user->id);
            DB::table('targets')->where('user_id', $user->id)->delete();
            DB::table('t_keuangans')->where('user_id', $user->id)->delete();
            DB::table('reports')->where('user_id', $user->id)->delete();
            $activity = Activity::where('user_id', $user->id)->get();
            return response()->json(['success', 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }
}
