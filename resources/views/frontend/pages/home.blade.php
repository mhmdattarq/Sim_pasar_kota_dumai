@extends('frontend.app')

@section('content')
    <div class="container-fluid pt-5 pt-md-7 pt-lg-9 min-height: 500px;"
        style="background: url('{{ asset('frontend/assets/img/bannerhome.jpeg') }}') no-repeat center center; background-size: cover;">

        <div class="row mt-4">
            <!-- Chart di kiri -->
            <div class="col-lg-6 mt-5">
                <div class="card rounded-4 shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Monthly Orders</h6>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#togglebutton"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#togglebutton">Action</a></li>
                                    <li><a class="dropdown-item" href="#togglebutton">Another action</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="chart-container-0">
                            <canvas id="chart2" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login form di kanan -->
            <div class="col-lg-6 mb-3 d-flex align-items-center justify-content-center mt-5">
                <div class="card shadow-lg p-4 rounded-4"
                    style="width: 660px; min-height: 403px; background: rgba(255,255,255,0.9);">
                    <div class="text-center mb-5">
                        <h5 class="mt-2 fw-bold">LOGIN SIMPASAR</h5>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Username / NIK</label>
                            <input type="text" name="login" value="{{ old('login') }}"
                                class="form-control @error('login') is-invalid @enderror" autofocus>
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-50">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table di bawah -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card rounded-4 shadow">
                    <div class="card-body">
                        <h6 class="mb-3">Data Kios, Los, dan Pelataran</h6>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pasar</th>
                                        <th>Kios</th>
                                        <th>Los</th>
                                        <th>Pelataran</th>
                                        <th>Total Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Pasar Kelakap</td>
                                        <td>25</td>
                                        <td>40</td>
                                        <td>15</td>
                                        <td><b>80</b></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Pasar Pulau Payung</td>
                                        <td>30</td>
                                        <td>20</td>
                                        <td>10</td>
                                        <td><b>60</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('registered') && !Auth::check())
                Swal.fire({
                    title: 'Registrasi Berhasil!',
                    text: 'Silakan login untuk melanjutkan.',
                    icon: 'success',
                    confirmButtonText: 'Login',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            @endif

            @if (session('login_error'))
                Swal.fire({
                    title: 'Login Gagal',
                    text: "{{ session('login_error') }}",
                    icon: 'error',
                    confirmButtonText: 'Coba Lagi'
                });
            @endif
        });
    </script>
@endpush
