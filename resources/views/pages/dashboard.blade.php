@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Data Lingkungan')

@section('content')
<div class="dashboard-container">    
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
            <h3 class="filter-title">Grafik Monitoring WWTP</h3>
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
                    <label class="filter-label">Periode</label>
                    <select id="filter-periode" class="filter-select">
                        <option value="1" selected>1 Hari</option>
                        <option value="7">7 Hari</option>
                        <option value="14">14 Hari</option>
                        <option value="30">30 Hari</option>
                    </select>
                </div>
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

    <div class="charts-grid">
        <div class="chart-card">
            <h3 class="chart-title">Chart Parameter Lainnya</h3>
            <div class="chart-container">
                <div class="chart-placeholder">
                    Chart akan ditambahkan di sini
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
let chartSV30, chartDO;
let currentDays = 1;
let currentLokasi = '';

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    loadChartData();

    document.getElementById('filter-lokasi').addEventListener('change', function() {
        currentLokasi = this.value;
        loadChartData();
    });

    document.getElementById('filter-periode').addEventListener('change', function() {
        currentDays = parseInt(this.value);
        loadChartData();
    });
});

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
            datasets: [
                {
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
            datasets: [
                {
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
}

function loadChartData() {
    showLoadingState();

    const params = new URLSearchParams({
        days: currentDays,
        lokasi_id: currentLokasi
    });

    fetch(`{{ route('dashboard.chart-data') }}?${params}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
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

            hideLoadingState();
        })
        .catch(error => {
            console.error('Error loading chart data:', error);
            hideLoadingState();
            alert('Gagal memuat data chart. Silakan coba lagi.');
        });
}

function showLoadingState() {
    document.querySelectorAll('.chart-card').forEach(card => {
        card.style.opacity = '0.6';
    });
}

function hideLoadingState() {
    document.querySelectorAll('.chart-card').forEach(card => {
        card.style.opacity = '1';
    });
}
</script>
@endpush