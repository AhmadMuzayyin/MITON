<?php

use Carbon\Carbon;
use App\Http\Controllers\Login;
use App\Models\InputActivation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PakController;
use App\Http\Controllers\PPTKController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SchuduleController;
use App\Http\Controllers\UserPPTKController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InputActivationController;
use App\Http\Controllers\PenggunaAnggaranController;
use App\Models\UserPPTK;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Login::class, 'index'])->name('login');
Route::post('/auth', [Login::class, 'auth'])->name('auth');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [Login::class, 'logout'])->name('logout');
    Route::get('/pak/anggaran', [PakController::class, 'pak'])->name('PAK');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-data', [DashboardController::class, 'indexData'])->name('dashboard-data');
    Route::get('/dashboard-data-kg', [DashboardController::class, 'indexData2'])->name('dashboard-data-kg');
    Route::resources([
        '/activity' => ActivityController::class,
        '/schedule' => SchuduleController::class,
        '/volume' => VolumeController::class,
        '/UserPPTK' => UserPPTKController::class,
        '/pptk' => PPTKController::class,
        '/location' => LocationController::class,
        '/target' => TargetController::class,
        '/user' => UserController::class,
        '/pak' => PakController::class,
        '/pa' => PenggunaAnggaranController::class,
    ]);
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
    Route::post('anggaran/perubahanstore', [AnggaranController::class, 'perubahanstore'])->name('anggaran.perubahanstore');
    Route::post('anggaran/store', [AnggaranController::class, 'store'])->name('anggaran.store');
    Route::post('/UserPPTK/update', [UserPPTKController::class, 'updateUser'])->name('PPTKuser.update');
    Route::post('/activity/update', [ActivityController::class, 'update'])->name('kegiatan.up');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.up');
    Route::get('/schedule/{schedule}/edit/volume', [SchuduleController::class, 'volume']);
    Route::get('/schedule/{schedule}/edit/pptk', [SchuduleController::class, 'pptk']);
    Route::get('/schedule/{schedule}/edit/target', [SchuduleController::class, 'target']);
    Route::post('/target/update', [TargetController::class, 'update']);

    Route::post('/pak/kunci', [PakController::class, 'kunci'])->name('pak.unlock');
    Route::post('/dashbord', [PakController::class, 'redirect'])->name('p-to-d');
    Route::get('/redirect', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::post('/report/store', [ReportController::class, 'store'])->name('report.store');
    Route::post('/getReport', [ReportController::class, 'getReport'])->name('getReport');

    // Grafik
    Route::get('/cetakRekap', [GrafikController::class, 'cetakRekap'])->name('cetakRekap');
    Route::post('/getrekapadmin', [GrafikController::class, 'getRekapAdmin'])->name('rekapAdmin');
    Route::get('/rekapitulasi', [GrafikController::class, 'rekap'])->name('rekap');
    Route::get('/realisasi', [GrafikController::class, 'realisasi'])->name('realisasi');
    Route::get('/realFisik', [GrafikController::class, 'realFisik'])->name('realFisik');
    Route::get('/realKeuangan', [GrafikController::class, 'realKeuangan'])->name('realKeuangan');
    Route::get('/realPengadaan', [GrafikController::class, 'realPengadaan'])->name('realPengadaan');
    Route::post('/arsip', [GrafikController::class, 'getArsip'])->name('get.arsip');
    Route::get('/arsip', [GrafikController::class, 'arsip'])->name('arsip');
    Route::post('/arsip/cover', [GrafikController::class, 'getCover'])->name('get.Cover');
    Route::post('/arsip/jadwal', [GrafikController::class, 'getJadwal'])->name('get.Jadwal');
    Route::post('/arsip/rfk', [GrafikController::class, 'getRFK'])->name('get.RFK');
    Route::post('/arsip/grafik', [GrafikController::class, 'getgrafik'])->name('get.grafik');
    Route::get('/arsip/grafik-data', [GrafikController::class, 'dataGrafik'])->name('dataGrafik');

    Route::get('/pengadaan', [GrafikController::class, 'pengadaan'])->name('pengadaan');
    Route::get('/pengadaan-data', [GrafikController::class, 'pengadaanData'])->name('pengadaan-data');

    Route::get('/sebaran', [GrafikController::class, 'sebaran'])->name('sebaran');
    Route::get('/get-sebaran', [GrafikController::class, 'getSebaran'])->name('getSebaran');
    Route::get('/laporan', [GrafikController::class, 'laporan'])->name('laporan');
    Route::get('/program', [GrafikController::class, 'program'])->name('program');
    Route::get('/sumber-dana', [GrafikController::class, 'sumberdana'])->name('sumber-dana');
    Route::get('/getdana', [GrafikController::class, 'getdana'])->name('getdana');
    Route::get('/pelaksanaan', [GrafikController::class, 'pelaksanaan'])->name('pelaksanaan');
    Route::get('/getpelaksanaan', [GrafikController::class, 'getpelaksanaan'])->name('getpelaksanaan');

    // Print
    Route::get('/print/dau', [PrintController::class, 'PrintDAU'])->name('print.DAU');
    Route::get('/print/dak', [PrintController::class, 'PrintDAK'])->name('print.DAK');
    Route::get('/print/dbhc', [PrintController::class, 'PrintDBHC'])->name('print.DBHC');
    Route::get('/print/kontruksi', [PrintController::class, 'PrintKontruksi'])->name('print.kontruksi');
    Route::get('/print/barang', [PrintController::class, 'PrintBarang'])->name('print.barang');
    Route::get('/print/konsultasi', [PrintController::class, 'PrintKonsultasi'])->name('print.konsultasi');
    Route::get('/print/jasa', [PrintController::class, 'PrintLain'])->name('print.jasa');
    Route::get('/print/prioritas', [PrintController::class, 'prinprioritas'])->name('print.prioritas');
    Route::get('/print/kendala', [PrintController::class, 'prinkendala'])->name('print.kendala');

    // Activation
    Route::get('/activation', [InputActivationController::class, 'index'])->name('activation.index');
    Route::post('/activation/update', [InputActivationController::class, 'ganti'])->name('activation.ganti');
    Route::get('/users/export', [UserController::class, 'export'])->name('user.export');
    Route::get('/activity/export', [ActivityController::class, 'export'])->name('Activity.export');
    Route::get('/test', function () {
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";

        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . public_path() . "/app/backup/" . $filename;
        return view('admin.index');
    });

    Route::get('/profil/{id}', [DashboardController::class, 'profil']);
    Route::post('/profil/update/{id}', [DashboardController::class, 'updateProfil']);
});
