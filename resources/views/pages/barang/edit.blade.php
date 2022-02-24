@extends('layouts.default')

@section('title')
    {{ __('Edit Barang') }}
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Barang</li>
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
                    <h3 class="card-title">Form Edit Barang</h3>
                  </div>
                  <form action="{{ route('barang.update', $item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('nama_barang') ?? $item->nama_barang }}" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" required>
                      </div>
                      <div class="form-group">
                        <label for="description">Keterangan</label>
                        <input type="text" value="{{ old('keterangan') ?? $item->keterangan }}" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
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