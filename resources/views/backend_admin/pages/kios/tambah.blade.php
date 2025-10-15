@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Kios</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Penambahan Kios</li>
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
                                    <h5 class="mb-0 text-info">Tambah Kios</h5>
                                </div>
                                <hr />
                                <form action="{{ route('kios.store') }}" method="POST" class="user">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="nomor_kios" class="col-sm-3 col-form-label">Nomor Kios</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nomor_kios" name="nomor_kios"
                                                placeholder="Masukkan Nomor Kios..">
                                            @error('nomor_kios')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="ukuran_kios" class="col-sm-3 col-form-label">Ukuran Kios</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="ukuran_kios" name="ukuran_kios"
                                                placeholder="Masukkan Ukuran Kios..">
                                            @error('ukuran_kios')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="harga_sewa" class="col-sm-3 col-form-label">Harga
                                            Sewa/Restribusi</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa"
                                                placeholder="Masukkan Harga Sewa..">
                                            @error('harga_sewa')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="satuan_retribusi" class="col-sm-3 col-form-label">Satuan
                                            Restribusi</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="satuan_retribusi" name="satuan_retribusi">
                                                <option selected>Masukkan Satuan Retribusi</option>
                                                <option value="hari">Hari</option>
                                                <option value="bulan">Bulan</option>
                                                <option value="tahun">Tahun</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="status_kios" class="col-sm-3 col-form-label">Status Kios</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="status_kios" name="status_kios">
                                                <option selected>Masukkan Status Kios</option>
                                                <option value="tersedia">Tersedia</option>
                                                <option value="disewa">Disewa</option>
                                                <option value="kosong">Kosong</option>
                                            </select>
                                            @error('status_kios')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="lokasi_kios" class="col-sm-3 col-form-label">Lokasi Kios</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="lokasi_kios" name="lokasi_kios"
                                                placeholder="Masukkan Lokasi Kios..">
                                            @error('lokasi_kios')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pasar_id" class="col-sm-3 col-form-label">Pasar</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="pasar_id" name="pasar_id">
                                                <option selected>-- Masukkan Pasar --</option>
                                                @foreach ($pasars as $pasar)
                                                    <option value="{{ $pasar->id }}">{{ $pasar->nama_pasar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pasar_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5">Tambah Kios</button>
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
