@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Data Lingkungan')

@section('content')
<div class="container">
    <div class="menu-cards">
        <a href="{{ route('wwtp.index') }}" class="menu-card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-icon wwtp-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h3 class="card-title">Waste Water Treatment Plant</h3>
                    <p class="card-description">Monitoring pengolahan air limbah</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('tps-produksi.index') }}" class="menu-card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-icon produksi-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h3 class="card-title">TPS Produksi</h3>
                    <p class="card-description">Penampungan sementara sampah produksi</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('tps-domestik.index') }}" class="menu-card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-icon domestik-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="card-title">TPS Domestik</h3>
                    <p class="card-description">Penampungan sementara sampah domestik</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="filter-section">
        <div class="filter-header">
            <h3 class="filter-title">GRAFIK MONITORING WWTP</h3>
            <div class="filter-controls">
                <div class="filter-group">
                    <label class="filter-label">Lokasi WWTP</label>
                    <select id="filter-lokasi" class="filter-select">
                        <option value="">Semua Lokasi</option>
                        @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_wwtp }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tanggal Dari</label>
                    <input type="date" id="filter-tanggal-dari" class="filter-select">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tanggal Sampai</label>
                    <input type="date" id="filter-tanggal-sampai" class="filter-select">
                </div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-card">
                <h3 class="chart-title">Trend SV30 Aerasi</h3>
                <div class="chart-container">
                    <canvas id="chartSV30"></canvas>
                </div>
            </div>
    
            <div class="chart-card">
                <h3 class="chart-title">Trend DO (Dissolved Oxygen) Aerasi</h3>
                <div class="chart-container">
                    <canvas id="chartDO"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="filter-section" style="margin-top: 40px;">
        <div class="filter-header">
            <h3 class="filter-title">GRAFIK STOK SAMPAH TPS PRODUKSI</h3>
            <div class="filter-controls">
                <div class="filter-group">
                    <label class="filter-label">Lokasi TPS</label>
                    <select id="filter-tps" class="filter-select">
                        <option value="">Semua TPS</option>
                        @foreach($tpsList as $tps)
                        <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tanggal Dari</label>
                    <input type="date" id="filter-tanggal-dari-sampah" class="filter-select">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tanggal Sampai</label>
                    <input type="date" id="filter-tanggal-sampai-sampah" class="filter-select">
                </div>
            </div>
        </div>
        <div class="charts-grid-full">
            <div class="chart-card">
                <h3 class="chart-title">Monitoring Stok Sampah Produksi</h3>
                <div class="chart-info">
                    <span class="info-badge">
                        <i class="fas fa-info-circle"></i>
                        Stok Awal Periode: <strong id="stok-awal-display">-</strong> unit
                    </span>
                </div>
                <div class="chart-container">
                    <canvas id="chartStokSampah"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    let chartSV30, chartDO, chartStokSampah;
    let currentTanggalDari = '';
    let currentTanggalSampai = '';
    let currentLokasi = '';
    let currentTanggalDariSampah = '';
    let currentTanggalSampaiSampah = '';
    let currentTps = '';
    let debounceTimerWWTP = null;
    let debounceTimerSampah = null;

    document.addEventListener('DOMContentLoaded', function() {
        setDefaultDates();
        
        initializeCharts();
        loadChartData();
        loadChartStokSampah();

        document.getElementById('filter-lokasi').addEventListener('change', function() {
            currentLokasi = this.value;
            loadChartData();
        });

        document.getElementById('filter-tanggal-dari').addEventListener('change', function() {
            currentTanggalDari = this.value;
            debouncedValidateAndLoadWWTP();
        });

        document.getElementById('filter-tanggal-sampai').addEventListener('change', function() {
            currentTanggalSampai = this.value;
            debouncedValidateAndLoadWWTP();
        });

        document.getElementById('filter-tps').addEventListener('change', function() {
            currentTps = this.value;
            loadChartStokSampah();
        });

        document.getElementById('filter-tanggal-dari-sampah').addEventListener('change', function() {
            currentTanggalDariSampah = this.value;
            debouncedValidateAndLoadSampah();
        });

        document.getElementById('filter-tanggal-sampai-sampah').addEventListener('change', function() {
            currentTanggalSampaiSampah = this.value;
            debouncedValidateAndLoadSampah();
        });
    });

    function setDefaultDates() {
        const today = new Date();
        const sevenDaysAgo = new Date();
        sevenDaysAgo.setDate(today.getDate() - 6); 

        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        currentTanggalDari = formatDate(sevenDaysAgo);
        currentTanggalSampai = formatDate(today);
        currentTanggalDariSampah = formatDate(sevenDaysAgo);
        currentTanggalSampaiSampah = formatDate(today);

        document.getElementById('filter-tanggal-dari').value = currentTanggalDari;
        document.getElementById('filter-tanggal-sampai').value = currentTanggalSampai;
        document.getElementById('filter-tanggal-dari-sampah').value = currentTanggalDariSampah;
        document.getElementById('filter-tanggal-sampai-sampah').value = currentTanggalSampaiSampah;
    }

    function validateDateRange(dari, sampai) {
        if (!dari || !sampai) {
            return { valid: false, message: 'Tanggal dari dan sampai harus diisi' };
        }

        const startDate = new Date(dari);
        const endDate = new Date(sampai);

        if (startDate > endDate) {
            return { valid: false, message: 'Tanggal dari tidak boleh lebih besar dari tanggal sampai' };
        }

        const daysDiff = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        if (daysDiff > 90) {
            return { valid: false, message: 'Rentang tanggal maksimal 90 hari' };
        }

        return { valid: true };
    }

    function showValidationError(message) {
        document.getElementById('validationErrorMessage').textContent = message;
        openModal('modalValidationError');
    }

    function debouncedValidateAndLoadWWTP() {
        // Clear timeout sebelumnya
        if (debounceTimerWWTP) {
            clearTimeout(debounceTimerWWTP);
        }

        // Set timeout baru (500ms delay)
        debounceTimerWWTP = setTimeout(() => {
            validateAndLoadWWTP();
        }, 500);
    }

    function debouncedValidateAndLoadSampah() {
        // Clear timeout sebelumnya
        if (debounceTimerSampah) {
            clearTimeout(debounceTimerSampah);
        }

        // Set timeout baru (500ms delay)
        debounceTimerSampah = setTimeout(() => {
            validateAndLoadSampah();
        }, 500);
    }

    function validateAndLoadWWTP() {
        const validation = validateDateRange(currentTanggalDari, currentTanggalSampai);
        if (validation.valid) {
            loadChartData();
        } else {
            showValidationError(validation.message);
        }
    }

    function validateAndLoadSampah() {
        const validation = validateDateRange(currentTanggalDariSampah, currentTanggalSampaiSampah);
        if (validation.valid) {
            loadChartStokSampah();
        } else {
            showValidationError(validation.message);
        }
    }

    function initializeCharts() {
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 4,
                    titleFont: {
                        size: 13
                    },
                    bodyFont: {
                        size: 12
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        };

        const ctxSV30 = document.getElementById('chartSV30').getContext('2d');
        chartSV30 = new Chart(ctxSV30, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                        label: 'SV30 Aerasi 1',
                        data: [],
                        borderColor: '#F9A825',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#F9A825',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'SV30 Aerasi 2',
                        data: [],
                        borderColor: '#E65100',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#E65100',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        title: {
                            display: true,
                            text: 'SV30 (%)',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ...commonOptions.scales.x,
                        title: {
                            display: true,
                            text: 'Waktu',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        const ctxDO = document.getElementById('chartDO').getContext('2d');
        chartDO = new Chart(ctxDO, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                        label: 'DO Aerasi 1',
                        data: [],
                        borderColor: '#F57C00',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#F57C00',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'DO Aerasi 2',
                        data: [],
                        borderColor: '#FBC02D',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#FBC02D',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        title: {
                            display: true,
                            text: 'DO (mg/L)',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ...commonOptions.scales.x,
                        title: {
                            display: true,
                            text: 'Waktu',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // Chart Stok Sampah
        const ctxStok = document.getElementById('chartStokSampah').getContext('2d');
        chartStokSampah = new Chart(ctxStok, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                        label: 'Stok Sampah',
                        data: [],
                        borderColor: '#2E7D32',
                        backgroundColor: 'rgba(46, 125, 50, 0.1)',
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#2E7D32',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Sampah Masuk',
                        data: [],
                        borderColor: '#1976D2',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#1976D2',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        borderDash: [5, 5]
                    },
                    {
                        label: 'Sampah Keluar',
                        data: [],
                        borderColor: '#D32F2F',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#D32F2F',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        title: {
                            display: true,
                            text: 'Jumlah (Unit)',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ...commonOptions.scales.x,
                        title: {
                            display: true,
                            text: 'Tanggal',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...commonOptions.plugins.tooltip,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + ' unit';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    function loadChartData() {
        if (!currentTanggalDari || !currentTanggalSampai) {
            return;
        }

        showLoadingState('.charts-grid');

        const params = new URLSearchParams({
            tanggal_dari: currentTanggalDari,
            tanggal_sampai: currentTanggalSampai,
            lokasi_id: currentLokasi
        });

        fetch(`{{ route('dashboard.chart-data') }}?${params}`)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.error || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Update SV30 chart
                chartSV30.data.labels = data.labels;
                chartSV30.data.datasets[0].data = data.sv30.aerasi_1;
                chartSV30.data.datasets[1].data = data.sv30.aerasi_2;
                chartSV30.update('active');

                // Update DO chart
                chartDO.data.labels = data.labels;
                chartDO.data.datasets[0].data = data.do.aerasi_1;
                chartDO.data.datasets[1].data = data.do.aerasi_2;
                chartDO.update('active');

                hideLoadingState('.charts-grid');
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
                hideLoadingState('.charts-grid');
                showValidationError('Gagal memuat data chart WWTP: ' + error.message);
            });
    }

    function loadChartStokSampah() {
        if (!currentTanggalDariSampah || !currentTanggalSampaiSampah) {
            return;
        }

        showLoadingState('.charts-grid-full');

        const params = new URLSearchParams({
            tanggal_dari: currentTanggalDariSampah,
            tanggal_sampai: currentTanggalSampaiSampah,
            tps_id: currentTps
        });

        fetch(`{{ route('dashboard.chart-stok-sampah') }}?${params}`)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.error || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Update stok awal display
                document.getElementById('stok-awal-display').textContent = data.stok_awal;

                // Update chart
                chartStokSampah.data.labels = data.labels;
                chartStokSampah.data.datasets[0].data = data.stok;
                chartStokSampah.data.datasets[1].data = data.masuk;
                chartStokSampah.data.datasets[2].data = data.keluar;
                chartStokSampah.update('active');

                hideLoadingState('.charts-grid-full');
            })
            .catch(error => {
                console.error('Error loading stok sampah data:', error);
                hideLoadingState('.charts-grid-full');
                showValidationError('Gagal memuat data stok sampah: ' + error.message);
            });
    }

    function showLoadingState(selector) {
        document.querySelectorAll(selector + ' .chart-card').forEach(card => {
            card.style.opacity = '0.6';
        });
    }

    function hideLoadingState(selector) {
        document.querySelectorAll(selector + ' .chart-card').forEach(card => {
            card.style.opacity = '1';
        });
    }
</script>
@endpush