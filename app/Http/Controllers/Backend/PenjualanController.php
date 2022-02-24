<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Bulan;
use App\Models\Tahun;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Penjualan::select(['penjualan.barang_id', 'barang.nama_barang', DB::raw('YEAR(penjualan.tanggal_penjualan) as tahun')])
                                ->join('barang', 'barang.id', '=', 'penjualan.barang_id')
                                ->groupBy('penjualan.barang_id', DB::raw('YEAR(penjualan.tanggal_penjualan)'))
                                ->orderBy('barang.id', 'asc')
                                ->orderBy(DB::raw('YEAR(penjualan.tanggal_penjualan)'), 'asc')
                                ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        return '<div class="dropdown dropleft">
                                    <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <form action="'.route('penjualan.detail').'" method="POST">
                                            '.csrf_field().'
                                            <input type="hidden" name="tahun" value="'.$row->tahun.'" />
                                            <input type="hidden" name="barang_id" value="'.$row->barang_id.'" />
                                            <button type="submit" class="dropdown-item"><i class="fas fa-eyes"></i> Detail</button>
                                        </form>
                                    </div>
                                </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('pages.penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bulan = Bulan::select(['id', 'nama_bulan', 'kode'])->get();
        $barang = Barang::select(['id', 'nama_barang'])->get();
        return view('pages.penjualan.create', [
            'bulan' => $bulan,
            'barang' => $barang,
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
        $validate = Validator::make(
            $request->all(),
            [
                'barang_id' => 'required|string|max:255',
                'tahun' => 'required|integer|min:1',
            ]
        );
        if($validate->fails()) {
            return back()->with('errors', $validate->messages()->all()[0])->withInput();           
        } else {
            $tahun = Tahun::where('tahun', '=', $request->tahun)->count();
            if ($tahun < 1) {
                Tahun::create([
                    'tahun' => $request->tahun,
                ]);
            }
            foreach($request->jumlah_penjualan as $key => $jumlah) {
                $check_penjualan = Penjualan::where('tanggal_penjualan', '=', $request->tahun.'-'.$request->bulan[$key].'-01')
                                                ->where('barang_id', '=', $request->barang_id)
                                                ->count();
                if($check_penjualan < 1) {
                    $penjualan = Penjualan::create([
                        'barang_id' => $request->barang_id,
                        'tanggal_penjualan' => $request->tahun.'-'.$request->bulan[$key].'-01',
                        'jumlah_penjualan' => $jumlah,
                    ]);
                } else {
                    $penjualan = Penjualan::where('tanggal_penjualan', '=', $request->tahun.'-'.$request->bulan[$key].'-01')
                                            ->where('barang_id', '=', $request->barang_id)->first();
                    $penjualan->update([
                        'barang_id' => $request->barang_id,
                        'tanggal_penjualan' => $request->tahun.'-'.$request->bulan[$key].'-01',
                        'jumlah_penjualan' => $jumlah,
                    ]);
                }
            }

            if($penjualan) {
                return redirect()->route('penjualan.index')->with('success','Data berhasil ditambahkan.');
            } else {
                return back()->with('errors', 'Terjadi kesalahan.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $bulan = Bulan::select(['id', 'nama_bulan', 'kode'])->get();
        $barang = Barang::select(['id', 'nama_barang'])->get();
        return view('pages.penjualan.edit', [
            'bulan' => $bulan,
            'barang' => $barang,
            'item' => $penjualan,
        ]);
        
        
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
        $validate = Validator::make(
            $request->all(),
            [
                'barang_id' => 'required',
                'jumlah_penjualan' => 'required|integer|min:1',
                'tahun' => 'required|integer|min:1',
            ]
        );
        if ($validate->fails()) {
            return back()->with('errors', $validate->messages()->all()[0])->withInput();
        } else {

            $penjualan = Penjualan::findOrFail($id);

            $penjualan->update([
                'barang_id' => $request->barang_id,
                'tanggal_penjualan' => $request->tahun.'-'.$request->bulan.'-01',
                'jumlah_penjualan' => $request->jumlah_penjualan,
            ]);

            if($penjualan) {
                return redirect()->route('penjualan.index')->with('success', 'Data berhasil diperbarui.');
            } else {
                return back()->with('errors', 'Terjadi kesalahan.');
            }
        }       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();
    
        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function detail (Request $request)
    {   
        return view('pages.penjualan.detail.index', [
            'tahun' => $request->tahun,
            'barang_id' => $request->barang_id
        ]);
    }

    public function dataDetail ($tahun, $barang_id)
    {
        $data = Penjualan::select(['penjualan.*', 'barang.nama_barang'])
                                ->join('barang', 'barang.id', '=', 'penjualan.barang_id')
                                ->orderBy('penjualan.tanggal_penjualan', 'asc')
                                ->where('penjualan.barang_id', $barang_id)
                                ->where(DB::raw('YEAR(penjualan.tanggal_penjualan)'), $tahun)
                                ->get();

        return Datatables::of($data)
                                ->addIndexColumn()
                                ->editColumn('tanggal_penjualan', function ($row) {
                                    return Carbon::parse($row->tanggal_penjualan)->isoFormat('Y');
                                })            
                                ->addColumn('action', function($row){
            
                                    return '<div class="dropdown dropleft">
                                                <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-bars"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="'.route('penjualan.edit', $row->id).'"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    <form action="'.route('penjualan.destroy', $row->id).'" method="POST">
                                                        '.method_field("DELETE").'
                                                        '.csrf_field().'
                                                        <button type="submit" class="dropdown-item btn-delete" onclick="return confirm(\'Are You Sure Want to Delete?\')"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>';
                                })
                                ->rawColumns(['action'])
                                ->make(true);
    }
}
