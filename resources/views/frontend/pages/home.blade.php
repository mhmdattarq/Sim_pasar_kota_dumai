@extends('frontend.app')

@section('content')
    <div class="container-fluid pt-5" style="background: url('{{ asset('frontend/assets/img/bannerhome.jpeg') }}') no-repeat center center; background-size: cover; padding-bottom: 100px; min-height: 100vh;">
    <div class="row mt-4 mt-lg-5">
        <!-- Chart di kiri -->
        <div class="col-12 col-lg-6 mt-3">
            <div class="card rounded-4 shadow">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">Data Harga Pangan</h6> <!-- Ganti judul -->
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="javascript:void(0)" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0)">Refresh Data</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)">Lihat Detail</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="chart-container-0" style="text-align: center;">
                        <canvas id="hargaPanganChart" style="display: inline-block;" height="200"></canvas> <!-- Ganti ID -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Login form di kanan --> 
        <!-- TIDAK DIUBAH -->
        <div class="col-12 col-lg-6 mt-3">
            <div class="card shadow-lg p-4 rounded-4" style="min-height: 420px;">
                <div class="text-center mb-5">
                    <h5 class="mt-2 fw-bold">LOGIN SIMPASAR</h5>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username / NIK</label>
                        <div class="input-group input-group-lg"> <span class="input-group-text bg-transparent @error('login') is-invalid @enderror"><i class='bx bxs-user'></i></span>
                            <input type="text" name="login" value="{{ old('login') }}"
                                class="form-control @error('login') is-invalid @enderror" placeholder="Masukkan Username / NIK" autofocus>
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-lg"> <span class="input-group-text bg-transparent @error('password') is-invalid @enderror"><i class='bx bxs-lock-open'></i></span>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-lg px-5 w-100 mb-3"><i class='bx bxs-lock-open'></i>Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Table di bawah --> 
    <!-- TIDAK DIUBAH -->
    <div class="row mt-5 mb-5">
        <div class="col-12 mb-5">
            <div class="card rounded-4 shadow">
                <div class="card-body">
                    <h6 class="mb-3">Data Kios, Los, dan Pelataran</h6>
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasar</th>
                                    <th>Kios</th>
                                    <th>Los</th>
                                    <th>Pelataran</th>
                                    <th>Total Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pasars = $pasars ?? collect();
                                @endphp
                                @if ($pasars->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pasar atau terjadi error. Cek log Laravel.</td>
                                    </tr>
                                @else
                                    @foreach ($pasars as $index => $pasar)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pasar->nama_pasar ?? 'N/A' }}</td>
                                            <td>{{ $pasar->total_kios ?? 0 }}</td>
                                            <td>{{ $pasar->total_los ?? 0 }}</td>
                                            <td>{{ $pasar->total_pelataran ?? 0 }}</td>
                                            <td><b>{{ $pasar->total_unit ?? 0 }}</b></td>
                                        </tr>
                                    @endforeach
                                @endif
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            loadHargaPanganData();

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

        async function loadHargaPanganData() {
            try {
                console.log('Fetching data from proxy...');
                
                const response = await fetch('{{ url("/api/harga-pangan") }}');
                
                console.log('Response status:', response.status);
                
                const result = await response.json();
                console.log('API Data via Proxy:', result);
                
                initializeHargaPanganChart(result);
                
            } catch (error) {
                console.error('Error fetching API:', error);
                initializeHargaPanganChart({ data: [] }); // Kirim data kosong
            }
        }

        function initializeHargaPanganChart(apiData) {
            const ctx = document.getElementById('hargaPanganChart').getContext('2d');
            
            console.log('Chart Data Structure:', apiData);
            
            // Handle berbagai format response
            let chartData = [];
            let isMockData = false;
            
            if (apiData && apiData.data && Array.isArray(apiData.data)) {
                chartData = apiData.data;
                // Cek jika ini mock data (ada field satuan)
                if (apiData.data.length > 0 && apiData.data[0].satuan) {
                    isMockData = true;
                }
            } else if (apiData && Array.isArray(apiData)) {
                chartData = apiData;
            }

            console.log('Processed Chart Data:', chartData);
            console.log('Is Mock Data:', isMockData);

            // Default data kalo API kosong
            if (!chartData || chartData.length === 0) {
                createEmptyChart(ctx, 'Data Harga Pangan Sedang Tidak Tersedia');
                return;
            }

            // Process data untuk chart
            const processedData = processChartData(chartData);
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: processedData.labels,
                    datasets: [{
                        label: isMockData ? 'Harga (Rp) - Data Contoh' : 'Harga Komoditas (Rp)',
                        data: processedData.prices,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: isMockData ? 'Data Harga Pangan' : 'Data Harga Pangan Terkini'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const price = context.raw.toLocaleString();
                                    const item = chartData[context.dataIndex];
                                    const satuan = item.satuan ? `/${item.satuan}` : '';
                                    return `Rp ${price}${satuan}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Harga (Rp)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Komoditas'
                            }
                        }
                    }
                }
            });
        }

        function processChartData(apiData) {
            // Ambil maksimal 6 data pertama untuk chart
            const limitedData = apiData.slice(0, 6);
            
            const labels = limitedData.map(item => {
                // Handle berbagai field name
                const name = item.nama_komoditas || item.nama_bomoditas || item.nama_pasar || 'Komoditas';
                return name.length > 12 ? name.substring(0, 12) + '...' : name;
            });
            
            const prices = limitedData.map(item => {
                // Handle berbagai format harga field
                let harga = item.harga || item.harga_komoditas || item.harpd || item.harpd_komodita || 0;
                
                if (typeof harga === 'string') {
                    // Remove non-numeric characters
                    harga = harga.replace(/[^\d]/g, '');
                }
                
                return parseInt(harga) || 0;
            });

            return { labels, prices };
        }

        function createEmptyChart(ctx, message) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [message],
                    datasets: [{
                        label: 'Harga',
                        data: [0],
                        backgroundColor: 'rgba(200, 200, 200, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: message
                        }
                    },
                    scales: {
                        y: { display: false },
                        x: { display: false }
                    }
                }
            });
        }
    </script>
@endpush