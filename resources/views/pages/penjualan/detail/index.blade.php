@extends('layouts.default')

@section('title')
    {{ __('Data Penjualan') }}
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Penjualan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/penjualan">Penjualan</a></li>
            <li class="breadcrumb-item active">Detail Penjualan</li>
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
                    <h3 class="card-title"> Detail Penjualan</h3>
                    <div class="card-tools">
                        <a href="/penjualan" class="btn btn-tool pull-right">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover table-datatable data-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 1%">#</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Tanggal</th>                                
                                <th class="text-center">Jumlah penjualan</th>
                                <th class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-data"></tbody>
                    </table>
                  </div>
              </div>
          </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection

@push('js')
    <script type="text/javascript">
        $(function () {
        
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('penjualan.data-detail', [$tahun, $barang_id]) }}",
                columns: [
                    {
                        data: "DT_RowIndex", 
                        name: "DT_RowIndex", 
                        class: "text-center", 
                        orderable: false, 
                        searchable: false,
                    },
                    {data: 'nama_barang', name: 'barang.nama_barang'},
                    {data: 'tanggal_penjualan', name: 'tanggal_penjualan'},
                    {data: 'jumlah_penjualan', name: 'jumlah_penjualan'},
                    {
                        data: 'action', 
                        name: 'action',
                        class: 'text-center', 
                        orderable: false, 
                        searchable: false,
                    },
                ]
            });
        
        });
    </script>
@endpush