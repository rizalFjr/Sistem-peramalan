<?php

namespace App\Imports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\ToModel;

class PenjualanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Penjualan([
            'barang_id' => $row['barang_id'],
            'tanggal_penjualan' => $row['tanggal_penjualan'],
            'jumlah_penjualan' => $row['jumlah_penjualan'],
        ]);
    }
}
