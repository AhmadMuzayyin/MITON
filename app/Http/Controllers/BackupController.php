<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index()
    {
        $data = scandir(storage_path('app/backup'));
        // dd($cek);
        return view('admin.backup.index', [
            'data' => $data
        ]);
    }

    public function download(Request $request)
    {
        $file = public_path() . "/db" . '/' . $request->file;
        $headers = array(
            'Content-Type: application/gz'
        );
        return response()->download($file, $request->value, $headers);
    }
}
