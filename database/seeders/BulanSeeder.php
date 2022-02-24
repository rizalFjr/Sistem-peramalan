<?php

namespace Database\Seeders;


use App\Models\Bulan;
use Illuminate\Database\Seeder;

class BulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bulan::create([
            'kode' => '01',
            'nama_bulan' => 'Januari',
        ]);

        Bulan::create([
            'kode' => '02',
            'nama_bulan' => 'Februari',
        ]);

        Bulan::create([
            'kode' => '03',
            'nama_bulan' => 'Maret',
        ]);

        Bulan::create([
            'kode' => '04',
            'nama_bulan' => 'April',
        ]);

        Bulan::create([
            'kode' => '05',
            'nama_bulan' => 'Mei',
        ]);

        Bulan::create([
            'kode' => '06',
            'nama_bulan' => 'Juni',
        ]);

        Bulan::create([
            'kode' => '07',
            'nama_bulan' => 'Juli',
        ]);

        Bulan::create([
            'kode' => '08',
            'nama_bulan' => 'Agustus',
        ]);

        Bulan::create([
            'kode' => '09',
            'nama_bulan' => 'September',
        ]);

        Bulan::create([
            'kode' => '10',
            'nama_bulan' => 'Oktober',
        ]);

        Bulan::create([
            'kode' => '11',
            'nama_bulan' => 'November',
        ]);

        Bulan::create([
            'kode' => '12',
            'nama_bulan' => 'Desember',
        ]);
    }
}
