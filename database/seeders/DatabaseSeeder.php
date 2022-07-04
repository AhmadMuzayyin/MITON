<?php

namespace Database\Seeders;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\InputActivation;
use App\Models\LockPak;
use App\Models\Month;
use App\Models\Pak;
use App\Models\Pelaksanaan;
use App\Models\Pengadaan;
use App\Models\SumberDana;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DBAL\TimestampType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'kode_SKPD' => '1.1.1',
            'nama_SKPD' => 'admin',
            'nama_operator' => 'Ahmad Muzayyin',
            'no_hp' => '123456789',
            'no_kantor' => '4321',
            'alamat_kantor' => 'Pamekasan',
            'username' => 'admin',
            'password' => bcrypt('12345'),
            'nama_KPA' => 'Ahmad Muzayyin',
            'foto' => 'admin.jpg',
            'isAdmin' => true
        ]);
        User::create([
            'kode_SKPD' => '1.1.2',
            'nama_SKPD' => 'ADMINISTRASI PEMBANGUNAN',
            'nama_operator' => 'Ahmad Muzayyin',
            'no_hp' => '123456789',
            'no_kantor' => '4321',
            'alamat_kantor' => 'Pamekasan',
            'username' => 'user',
            'password' => bcrypt('12345'),
            'nama_KPA' => 'Ahmad Muzayyin',
            'foto' => 'default.jpg',
            'isAdmin' => false
        ]);
        // User::create([
        //     'kode_SKPD' => '1.1.3',
        //     'nama_SKPD' => 'SEKRETARIS KABUPATEN PAMEKASAN',
        //     'nama_operator' => 'Zainal Fatah',
        //     'no_hp' => '123456789',
        //     'no_kantor' => '4321',
        //     'alamat_kantor' => 'Pamekasan',
        //     'username' => 'zainal',
        //     'password' => bcrypt('12345'),
        //     'nama_KPA' => 'Zainal Fatah',
        //     'foto' => '',
        //     'isAdmin' => false
        // ]);

        InputActivation::create([
            'nama' => 'Entry Kegiatan',
            'aktif' => Carbon::now()->format('Y-m-d'),
            'nonaktif' => Carbon::now()->format('Y-m-d'),
            'status' => true
        ]);
        InputActivation::create([
            'nama' => 'Target Fisik & Target Keuangan',
            'aktif' => Carbon::now()->format('Y-m-d'),
            'nonaktif' => Carbon::now()->format('Y-m-d'),
            'status' => true
        ]);
        InputActivation::create([
            'nama' => 'Laporan RFK',
            'aktif' => Carbon::now()->format('Y-m-d'),
            'nonaktif' => Carbon::now()->format('Y-m-d'),
            'status' => true
        ]);

        SumberDana::create([
            'nama' => 'APBD KABUPATEN PAMEKSAN',
        ]);
        SumberDana::create([
            'nama' => 'APBD PROVINSI',
        ]);
        SumberDana::create([
            'nama' => 'APBN',
        ]);

        Pengadaan::create([
            'nama' => 'Konstruksi'
        ]);
        Pengadaan::create([
            'nama' => 'Barang'
        ]);
        Pengadaan::create([
            'nama' => 'Konsultansi'
        ]);
        Pengadaan::create([
            'nama' => 'Jasa Lainya'
        ]);

        Pelaksanaan::create([
            'nama' => 'Tender'
        ]);
        Pelaksanaan::create([
            'nama' => 'Penunjukan Langsung'
        ]);
        Pelaksanaan::create([
            'nama' => 'Pengadaan Langsung'
        ]);
        Pelaksanaan::create([
            'nama' => 'ePucrhasing'
        ]);
        Pelaksanaan::create([
            'nama' => 'Swakelola'
        ]);
        Pelaksanaan::create([
            'nama' => 'Seleksi'
        ]);

        $pak = Pak::create([
            'nama' => Carbon::now()->format('Y'),
        ]);
        for ($i = 0; $i < 2; $i++) {
            LockPak::create([
                'pak_id' => $pak->id,
                'kondisi' => $i,
                'status' => true
            ]);
        }

        $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        foreach ($bulan as $key => $value) {
            Month::create([
                'nama' => $value
            ]);
        }
    }
}
