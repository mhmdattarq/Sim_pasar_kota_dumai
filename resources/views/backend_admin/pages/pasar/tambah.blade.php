@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Pasar</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Penambahan Pasar</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="col-xl-9 mx-auto">
                    <div class="card border-top  border-4 border-info">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <strong>Terjadi kesalahan!</strong>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="border p-4 rounded">

                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bxs-home me-1 font-22 text-info"></i>
                                    </div>
                                    <h5 class="mb-0 text-info">Tambah Pasar</h5>
                                </div>
                                <hr />
                                <form action="{{ route('pasar.store') }}" method="POST" class="user"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="nama_pasar" class="col-sm-3 col-form-label">Nama Pasar</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_pasar" class="form-control" id="nama_pasar"
                                                placeholder="Masukkan Nama Pasar..">
                                            @error('nama_pasar')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="alamat" class="form-control" id="alamat"
                                                placeholder="Masukkan Alamat..">
                                            @error('alamat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="total_kios" class="col-sm-3 col-form-label">Total Kios</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="total_kios" class="form-control" id="total_kios"
                                                placeholder="Masukkan Total Kios..">
                                            @error('total_kios')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="total_los" class="col-sm-3 col-form-label">Total Los</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="total_los" class="form-control" id="total_los"
                                                placeholder="Masukkan Total Los..">
                                            @error('total_los')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="total_pelataran" class="col-sm-3 col-form-label">Total Pelataran</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="total_pelataran" class="form-control"
                                                id="total_pelataran" placeholder="Masukkan Total Pelataran..">
                                            @error('total_pelataran')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="foto_depan" class="col-sm-3 col-form-label">Foto Tampak Depan</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="foto_depan" class="form-control" id="foto_depan"
                                                accept="image/*" required>
                                            @error('foto_depan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="foto_belakang" class="col-sm-3 col-form-label">Foto Tampak
                                            Belakang</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="foto_belakang" class="form-control"
                                                id="foto_belakang" accept="image/*" required>
                                            @error('foto_belakang')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="foto_dalam" class="col-sm-3 col-form-label">Foto Tampak Dalam</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="foto_dalam" class="form-control" id="foto_dalam"
                                                accept="image/*" required>
                                            @error('foto_dalam')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Google Maps Embed -->
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Lokasi Peta</label>
                                        <div class="col-sm-9">
                                            <textarea name="lokasi_peta" class="form-control" rows="3"
                                                placeholder="Tempel iframe embed dari Google Maps di sini..." required></textarea>
                                        </div>
                                    </div>
                                    <!-- End Google Maps Embed -->

                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5">Tambah Pasar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
