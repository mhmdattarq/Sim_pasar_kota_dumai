@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pasar</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Pasar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <h6 class="mb-0 text-uppercase">Table Pasar</h6>
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
                        <table id="table_pasar" class="table table-striped table-bordered">
                            <!-- kalo mau menggunakan search dan button print itu ganti jadi example2-->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasar</th>
                                    <th>alamat</th>
                                    <th>Foto Tampak Depan</th>
                                    <th>Foto Tampak Dalam</th>
                                    <th>Foto Tampak Belakang</th>
                                    <th>Lokasi Peta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasar as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_pasar }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $data->foto_depan) }}" alt="Foto Tampak Depan"
                                                width="150">
                                        </td>
                                        <td>
                                            <img src="{{ asset('storage/' . $data->foto_belakang) }}"
                                                alt="Foto Tampak Depan" width="150">
                                        </td>
                                        <td>
                                            <img src="{{ asset('storage/' . $data->foto_dalam) }}" alt="Foto Tampak Depan"
                                                width="150">
                                        </td>
                                        <td>
                                            <div class="map-container" style="width: 100%; height: 400px;">
                                                {!! $data->lokasi_peta !!}
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
