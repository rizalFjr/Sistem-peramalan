@extends('layouts.default')

@section('title')
    {{ __('Tambah Penjualan') }}
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Penjualan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Penjualan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content-header -->
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Form Tambah Penjualan</h3>
                  </div>
                  <form action="{{ route('penjualan.store') }}" method="post" enctype="multipart/form-data">
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
                        <label for="tahun">Tahun <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('tahun') }}" class="form-control" id="tahun" name="tahun" placeholder="Masukkan Tahun" required>
                      </div>
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Jumlah Penjualan</h4>
                        </div>
                        <div class="card-body">
                            @foreach ( $bulan as $bulan )
                              <div class="form-group">
                                <label for="jumlah_penjualan">{{ $bulan->nama_bulan }}</label>
                                <input type="hidden" value="{{ $bulan->kode }}" class="form-control" id="bulan[]" name="bulan[]" placeholder="Masukkan Bulan">
                                <input type="text" value="{{ old('jumlah_penjualan[]') }}" class="form-control" id="jumlah_penjualan[]" name="jumlah_penjualan[]" placeholder="Masukkan Jumlah Penjualan">
                              </div>
                            @endforeach 
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <p><span class="text-danger">*</span> Wajib diisi</p>
                      </div>
                      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      <a class="btn btn-warning" href="{{ url()->previous() }}">
                          <i class="fas fa-arrow-left"></i> Kembali
                      </a>
                    </div>
                  </form>
              </div>
          </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection

@push('js')
  <script src="{{ asset('js/backend/penjualan/add_penjualan.js') }}"></script>
  
@endpush