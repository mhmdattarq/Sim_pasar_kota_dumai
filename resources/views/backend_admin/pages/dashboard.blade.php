@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-lg-4">
                <!-- Card Total Pasar -->
                <div class="col">
                    <div class="card rounded-4 bg-gradient-rainbow bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div>
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
                <!-- Card Total Unit per Pasar -->
                @forelse ($totalUnits as $nama_pasar => $data)
                    <div class="col">
                        <div class="card rounded-4 {{ $loop->index % 3 == 0 ? 'bg-gradient-burning' : ($loop->index % 3 == 1 ? 'bg-gradient-moonlit' : 'bg-gradient-cosmic') }} bubble position-relative overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-0">
                                    <div>
                                        <h4 class="mb-0 text-white">{{ $data['total'] ?? 0 }}</h4>
                                        <p class="mb-0 text-white">Total Unit <br>{{ $data['nama_pasar'] }}</p>
                                    </div>
                                    <div class="fs-1 text-white">
                                        <i class="bx {{ $loop->index % 3 == 0 ? 'bx-group' : ($loop->index % 3 == 1 ? 'bx-wallet' : 'bx-line-chart-down') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-burning bubble position-relative overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-0">
                                    <div>
                                        <h4 class="mb-0 text-white">0</h4>
                                        <p class="mb-0 text-white">Total Unit <br>Tidak ada data pasar</p>
                                    </div>
                                    <div class="fs-1 text-white">
                                        <i class="bx bx-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <!--end row-->
        </div>
    </div>
@endsection