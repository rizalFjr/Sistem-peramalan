@extends('layouts.default')

@section('title')
    {{ __('Edit Penjualan') }}
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
                    <h3 class="card-title">Form Edit Penjualan</h3>
                  </div>
                  <form action="{{ route('penjualan.update', $item->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                      <div class="form-group">
                        <label for="barang_id">Nama Barang <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" id="barang_id" name="barang_id">
                          <option label="Pilih Barang"></option>
                          @if (old('barang_id') != null)
                            @foreach ($barang as $barang)
                              <option value="{{ $barang->id }}" @if(old('barang_id') == $barang->id) selected @endif>{{ $barang->nama_barang }}</option>
                            @endforeach
                          @else
                            @foreach ($barang as $barang)
                              <option value="{{ $barang->id }}" @if($item->barang_id == $barang->id) selected @endif>{{ $barang->nama_barang }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="tahun">Tanggal Penjualan <span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-6">
                            <select class="form-control select2bs4" id="bulan" name="bulan" value="{{ old('bulan') }}">
                              <option label="Pilih Bulan"></option>
                                @if (old('bulan') != null)
                                  @foreach ($bulan as $bulan)
                                    <option value="{{ $bulan->kode }}" @if(old('bulan') == $bulan->kode) selected @endif>{{ $bulan->nama_bulan }}</option>
                                  @endforeach
                                @else
                                  @foreach ($bulan as $bulan)
                                    <option value="{{ $bulan->kode }}" @if(date('m', strtotime($item->tanggal_penjualan)) == $bulan->kode) selected @endif>{{ $bulan->nama_bulan }}</option>
                                  @endforeach
                                @endif
                            </select>
                          </div>
                          <div class="col-6">
                            <input type="number" value="{{ old('tahun') ?? date('Y', strtotime($item->tanggal_penjualan)) }}" class="form-control" id="tahun" name="tahun" placeholder="Masukkan Tahun" required>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="jumlah_penjualan">Jumlah Penjualan <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('jumlah_penjualan') ?? $item->jumlah_penjualan }}" class="form-control" id="jumlah_penjualan" name="jumlah_penjualan" placeholder="Masukkan Jumlah Penjualan">
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
  <script src="{{ asset('js/backend/penjualan/edit_penjualan.js') }}"></script>
  
@endpush