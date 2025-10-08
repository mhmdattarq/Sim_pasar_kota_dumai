@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-lg-4">
                <div class="col">
                    <div class="card rounded-4 bg-gradient-rainbow bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $totalPasar ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Total Pasar <br>Kota Dumai</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-burning bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $totalUnitKelakap ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Total Unit <br>Pasar Kelakap Tujuh</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-group"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-moonlit bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $totalUnitBundaran ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Total Unit <br>Pasar Bundaran Sri Mersing</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-cosmic bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $totalUnitTamanLepin ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Total Unit <br>Pasar Taman Lepin</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-line-chart-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
@endsection