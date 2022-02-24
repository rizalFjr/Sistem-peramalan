<?php

namespace App\Http\Controllers\Backend;

use App\Models\Bulan;
use App\Models\Tahun;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\HasilPeramalan;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use stdClass;

class PeramalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $alpha = [
            '0.1',
            '0.2',
            '0.3',
            '0.4',
            '0.5',
            '0.6',
            '0.7',
            '0.8',
            '0.9',
        ];
        
        $barang = Barang::select(['id', 'nama_barang'])->get();
        $tahun = Tahun::select(['id', 'tahun'])->orderBy('tahun', 'ASC')->get();
        $bulan = Bulan::select(['id', 'nama_bulan', 'kode'])->orderBy('kode', 'ASC')->get();

        return view('pages.peramalan.index', [
            'bulan' => $bulan,
            'periode' => '',
            'data_aktual' => '',
            'data_ramal' => '',
            'barang' => $barang,
            'alpha' => $alpha,
            'tahun' => $tahun,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function hitung(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'barang_id' => 'required|string|max:255',
                'alpha' => 'required|numeric|between:0.1,0.9',
            ]
        );
        
        if($validate->fails()) {
            return back()->with('errors', $validate->messages()->all()[0])->withInput();           
        } else {
            $alpha = [
                '0.1',
                '0.2',
                '0.3',
                '0.4',
                '0.5',
                '0.6',
                '0.7',
                '0.8',
                '0.9',
            ];
            $barang = Barang::select(['id', 'nama_barang'])->get();
            $tahun = Tahun::select(['id', 'tahun'])->orderBy('tahun', 'ASC')->get();
            $bulan = Bulan::select(['id', 'nama_bulan', 'kode'])->orderBy('kode', 'ASC')->get();

            $data = [];
            $periodeVar = [];
            $dataAktual = [];
            $hasilRamal = [];

            $penjualan = Penjualan::where('tanggal_penjualan', '>=', $request->tahun_awal.'-'.$request->bulan_awal.'-01')
                                    ->where('tanggal_penjualan', '<=', $request->tahun_akhir.'-'.$request->bulan_akhir.'-01')
                                    ->where('barang_id', '=', $request->barang_id)
                                    ->join('barang', 'barang.id', '=', 'penjualan.barang_id')
                                    ->select(['penjualan.id', 'barang.nama_barang', 'jumlah_penjualan'])
                                    ->get();
            
            $peramalan = HasilPeramalan::where('penjualan.tanggal_penjualan', '>=', $request->tahun_awal.'-'.$request->bulan_awal.'-01')
                                        ->where('penjualan.tanggal_penjualan', '<=', $request->tahun_akhir.'-'.$request->bulan_akhir.'-01')
                                        ->where('penjualan.barang_id', '=', $request->barang_id)
                                        ->where('hasil_peramalan.alpha', '=', $request->alpha)
                                        ->join('penjualan', 'penjualan.id', '=', 'hasil_peramalan.penjualan_id')
                                        ->select(['hasil_peramalan.id'])
                                        ->get();
            if (count($peramalan) > 0) {
                HasilPeramalan::whereIn('id', $peramalan->pluck('id')->toArray())->delete();
            }

            $length = count($penjualan);
            $mape = 0;

            for($i = 0; $i < ($length + 1); $i++){
                if ($i >= 0 && $i < $length) 
                {
                    if ($i == 0) 
                    {
                        $periode = $i+1;
                        $form_alpha = $request->alpha;
                        $data_aktual = $penjualan[$i]->jumlah_penjualan;
                        $hasil_peramalan = ($form_alpha*$data_aktual)+((1-$form_alpha)*$data_aktual);
                        $fe = abs((($data_aktual-$hasil_peramalan)/$data_aktual)*100);
                        $mape += $fe;
    
                        $data[$i] = (object) [
                            'nama_barang' => $penjualan[$i]->nama_barang,
                            'penjualan_id' => $penjualan[$i]->id,
                            'periode' => $periode,
                            'data_aktual' => $this->numberFormat($data_aktual),
                            'alpha' => $form_alpha,
                            'data_peramalan' => $hasil_peramalan,
                            'hasil_peramalan' => $this->numberFormat($hasil_peramalan),
                            'fe' => $this->numberFormat($fe)
                        ];

                        array_push($periodeVar, $periode);
                        array_push($dataAktual, $data_aktual);
                        array_push($hasilRamal, $hasil_peramalan);
                    }
                    else if ($i > 0 && $i < $length) 
                    {
                        $periode = $i+1;
                        $form_alpha = $request->alpha;
                        $data_aktual = $penjualan[$i]->jumlah_penjualan;
                        $hasil_peramalan_sebelumnya = $data[$i-1]->data_peramalan;
                        $hasil_peramalan = ($form_alpha*$data_aktual)+((1-$form_alpha)*$hasil_peramalan_sebelumnya);
                        $fe = abs((($data_aktual-$hasil_peramalan)/$data_aktual)*100);
                        $mape += $fe;
    
                        $data[$i] = (object) [
                            'nama_barang' => $penjualan[$i]->nama_barang,
                            'penjualan_id' => $penjualan[$i]->id,
                            'periode' => $periode,
                            'data_aktual' => $this->numberFormat($data_aktual),
                            'alpha' => $form_alpha,
                            'data_peramalan' => $hasil_peramalan,
                            'hasil_peramalan' => $this->numberFormat($hasil_peramalan),
                            'fe' => $this->numberFormat($fe)
                        ];

                        array_push($periodeVar, $periode);
                        array_push($dataAktual, $data_aktual);
                        array_push($hasilRamal, $hasil_peramalan);
                    }

                    HasilPeramalan::create([
                        'penjualan_id' => $penjualan[$i]->id,
                        'alpha' => $form_alpha,
                        'hasil_peramalan' => $hasil_peramalan,
                        'fe' => $fe
                    ]);
                }
                
                else if ($i >= $length && $i < ($length+1)){
                    $periode = $i+1;
                    $form_alpha = $request->alpha;
                    $data_aktual = $penjualan[$length-1]->jumlah_penjualan;
                    $hasil_peramalan_sebelumnya = $data[$i-1]->data_peramalan;
                    $hasil_peramalan = ($form_alpha*$data_aktual)+((1-$form_alpha)*$hasil_peramalan_sebelumnya);

                    $data[$i] = (object) [
                        'nama_barang' => $penjualan[$length-1]->nama_barang,
                        'penjualan_id' => $penjualan[$length-1]->id,
                        'periode' => $periode,
                        'data_aktual' => '-',
                        'alpha' => $form_alpha,
                        'data_peramalan' => $hasil_peramalan,
                        'hasil_peramalan' => $this->numberFormat($hasil_peramalan),
                        'fe' => '-'
                    ];

                    array_push($periodeVar, $periode);
                    array_push($hasilRamal, $hasil_peramalan);
                }

            }

            return view('pages.peramalan.index', [
                'bulan' => $bulan,
                'barang' => $barang,
                'alpha' => $alpha,
                'tahun' => $tahun,
                'penjualan' => $data,
                'periode'   => $periodeVar,
                'data_aktual'   => $dataAktual,
                'data_ramal'   => $hasilRamal,
                'mape'  => $this->numberFormat($mape/$length)
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function numberFormat($number)
    {
        return number_format((float) $number, 2, ',', '.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
