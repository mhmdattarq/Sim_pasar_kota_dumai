@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Los</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Los</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <h6 class="mb-0 text-uppercase">Table Los</h6>
            <hr />
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_los" class="table table-striped table-bordered">
                            <!-- kalo mau menggunakan search dan button print itu ganti jadi example2-->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Los</th>
                                    <th>Ukuran Los</th>
                                    <th>Harga Sewa/Retribusi</th>
                                    <th>Satuan Retribusi</th>
                                    <th>Status Los</th>
                                    <th>Lokasi Los</th>
                                    <th>Pasar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($los as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nomor_los }}</td>
                                        <td>{{ $data->ukuran_los }}</td>
                                        <td>{{ $data->harga_sewa }}</td>
                                        <td>{{ $data->satuan_retribusi }}</td>
                                        <td>{{ $data->status_los }}</td>
                                        <td>{{ $data->lokasi_los }}</td>
                                        <td>{{ $data->nama_pasar }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
