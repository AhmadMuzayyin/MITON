<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Exports\UsersExport;
use App\Models\Anggaran;
use App\Models\Location;
use App\Models\PPTK;
use App\Models\Schedule;
use App\Models\Volume;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
        $data = User::all();
        return view('admin.user.index', [
            'page' => 'index',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.userCreate');
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
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:users,kode_SKPD',
            'username' => 'required|unique:users,username',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->errors());
            return back();
        }
        try {
            $user = new User;

            $user->kode_SKPD = $request->kode;
            $user->nama_SKPD = $request->skpd;
            $user->nama_operator = $request->namaoperator;
            $user->no_hp = $request->nooperator;
            $user->no_kantor = $request->nokantor;
            $user->alamat_kantor = $request->alamatkantor;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->nama_KPA = $request->kpa;
            $user->foto = 'default.jpg';
            $user->isAdmin = $request->level;
            $user->save();

            toastr()->success('Berhasil menambah data OPD');
            return redirect()->route('user.index');
        } catch (QueryException $th) {
            toastr()->error($th->errorInfo);
            return redirect()->back();
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
        return view('admin.user.useredit', [
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
            $fileName = $request->file('profil') ? time() . '_' . $request->file('profil')->getClientOriginalName() : Auth()->user()->foto;
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

            toastr()->success('Berhasil memperbarui data OPD!');
            return redirect()->route('user.index');
        } catch (QueryException $th) {
            toastr()->error($th->errorInfo);
            return redirect()->back();
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
            $activity = Activity::where('user_id', $user->id)->get();
            foreach ($activity as $value) {
                $schedule = Schedule::where('activity_id', $value->id)->get();
                foreach ($schedule as $scID) {
                    Location::where('schedule_id', $scID->id)->delete();
                    PPTK::where('schedule_id', $scID->id)->delete();
                    Volume::where('schedule_id', $scID->id)->delete();
                }
                Schedule::where('activity_id', $value->id)->delete();
                Anggaran::where('activity_id', $value->id)->delete();
            }
            if ($user->foto != 'default.jpg') {
                File::delete(public_path('storage/uploads/' . $user->foto));
            }
            DB::table('targets')->where('user_id', $user->id)->delete();
            DB::table('t_keuangans')->where('user_id', $user->id)->delete();
            DB::table('reports')->where('user_id', $user->id)->delete();
            DB::table('user_p_p_t_k_s')->where('user_id', $user->id)->delete();
            DB::table('activities')->where('user_id', $user->id)->delete();
            User::destroy($user->id);

            toastr()->success('Berhasil menghapus data OPD!');
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error($th->errorInfo);
            return redirect()->back();
        }
    }
}
