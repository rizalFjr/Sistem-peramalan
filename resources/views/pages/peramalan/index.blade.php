@extends('layouts.default')

@section('title')
    {{ __('Hitung Peramalan') }}
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Peramalan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Peramalan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content-header -->
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- START: Form Hitung -->
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Form Hitung Peramalan</h3>
                  </div>
                  <form action="{{ route('hitung') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="barang_id">Nama Barang <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" id="barang_id" name="barang_id" value="{{ old('barang_id') }}">
                          <option label="Pilih Barang"></option>
                          @foreach ($barang as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tahun">Tanggal Awal <span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-6">
                            <select class="form-control select2bs4" id="tahun_awal" name="tahun_awal" value="{{ old('tahun_awal') }}">
                              <option label="Pilih Tahun Awal"></option>
                              @foreach ($tahun as $tahun_awal)
                                <option value="{{ $tahun_awal->tahun }}">{{ $tahun_awal->tahun }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-6">
                            <select class="form-control select2bs4" id="bulan_awal" name="bulan_awal" value="{{ old('bulan_awal') }}">
                              <option label="Pilih Bulan Awal"></option>
                              @foreach ($bulan as $bulan_awal)
                                <option value="{{ $bulan_awal->kode }}">{{ $bulan_awal->nama_bulan }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="tahun">Tanggal Akhir <span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-6">
                            <select class="form-control select2bs4" id="tahun_akhir" name="tahun_akhir" value="{{ old('tahun_akhir') }}">
                              <option label="Pilih Tahun Akhir"></option>
                              @foreach ($tahun as $tahun_akhir)
                                <option value="{{ $tahun_akhir->tahun }}">{{ $tahun_akhir->tahun }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-6">
                            <select class="form-control select2bs4" id="bulan_akhir" name="bulan_akhir" value="{{ old('bulan_akhir') }}">
                              <option label="Pilih Bulan Akhir"></option>
                              @foreach ($bulan as $bulan_akhir)
                                <option value="{{ $bulan_akhir->kode }}">{{ $bulan_akhir->nama_bulan }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="barang_id">Alpha <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" id="alpha" name="alpha" value="{{ old('alpha') }}">
                          <option label="Pilih Alpha"></option>
                          @foreach ($alpha as $alpha)
                            <option value="{{ $alpha }}">{{ $alpha }}</option>
                          @endforeach
                        </select>
                      </div>
                      
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <p><span class="text-danger">*</span> Wajib diisi</p>
                      </div>
                      <button type="submit" class="btn btn-primary"><i class="fas fa-calculator"></i> Hitung</button>
                      <button type="reset" value="reset" class="btn btn-warning"><i class="fas fa-sync"></i> Reset</button>
                    </div>
                  </form>
              </div>
          </div>
      </div>
      <!-- END: Form Hitung -->

      @if (isset($penjualan))
      <!-- START: Grafik Hitung -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Grafik Hasil Peramalan</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END: Grafik Hitung -->

      <!-- START: Table Hitung -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Hasil Peramalan</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-striped table-bordered table-hover" id="table-ramal">
                <caption>Hasil peramalan data Barang "<strong>{{ $penjualan[0]->nama_barang }}</strong>" dengan nilai alpha <strong>{{ $penjualan[0]->alpha }}</strong> memiliki nilai MAPE sebesar <strong>{{ $mape }}</strong></caption>
                <thead>
                  <tr>
                    <th class="text-center" style="width: 1%">#</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Periode</th>  
                    <th class="text-center">Alpha</th>                                
                    <th class="text-center">Data Aktual</th>                              
                    <th class="text-center">Hasil Ramalan</th> 
                    <th class="text-center">FE</th>                                
                  </tr>
                </thead>
                <tbody id="table-data">
                  @if (isset($penjualan))
                    @foreach ($penjualan as $key => $penjualan)
                      <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="text-left">{{ $penjualan->nama_barang }}</td>
                        <td class="text-center">{{ $penjualan->periode }}</td>
                        <td class="text-center">{{ $penjualan->alpha }}</td>
                        <td class="text-center">{{ $penjualan->data_aktual }}</td>
                        <td class="text-center">{{ $penjualan->hasil_peramalan }}</td>
                        <td class="text-center">{{ $penjualan->fe }}</td>
                      </tr>
                    @endforeach
                    <tfoot>
                      <tr>
                        <td class="text-right" colspan="6">MAPE</td>
                        <td class="text-center">{{ $mape }}</td>
                      </tr>
                    </tfoot>
                  @else
                    <tr>
                      <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- END: Table Hitung -->
      @endif
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection

@push('js')
  <script>
    var periode = {{ json_encode($periode) }}
    var dataAktual = {{ json_encode($data_aktual) }}
    var dataRamal = {{ json_encode($data_ramal) }}
  </script>
  <script src="{{ asset('js/backend/peramalan/peramalan.js') }}"></script>
@endpush