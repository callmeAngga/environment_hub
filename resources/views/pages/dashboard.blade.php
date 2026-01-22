@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Data Lingkungan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h2 class="dashboard-title">Dashboard Overview</h2>
        <p class="dashboard-subtitle">Ringkasan data lingkungan yang dimonitor</p>
    </div>
    
    <!-- Menu Cards -->
    <div class="menu-cards">
        <!-- WWTP Card -->
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

        <!-- TPS Produksi Card -->
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

        <!-- TPS Domestik Card -->
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
    
    <!-- Filter Periode -->
    <div class="filter-section">
        <div class="filter-header">
            <h3 class="filter-title">Grafik Monitoring WWTP</h3>
            <div class="filter-buttons">
                <button onclick="loadChartData(1)" id="btn-1" class="filter-btn active">
                    1 Hari
                </button>
                <button onclick="loadChartData(7)" id="btn-7" class="filter-btn">
                    7 Hari
                </button>
                <button onclick="loadChartData(14)" id="btn-14" class="filter-btn">
                    14 Hari
                </button>
                <button onclick="loadChartData(30)" id="btn-30" class="filter-btn">
                    30 Hari
                </button>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- SV30 Chart -->
        <div class="chart-card">
            <h3 class="chart-title">Trend SV30 Aerasi</h3>
            <div class="chart-container">
                <canvas id="chartSV30"></canvas>
            </div>
        </div>
        
        <!-- DO Chart -->
        <div class="chart-card">
            <h3 class="chart-title">Trend DO (Dissolved Oxygen) Aerasi</h3>
            <div class="chart-container">
                <canvas id="chartDO"></canvas>
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

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    loadChartData(1);
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
                    backgroundColor: 'rgba(249, 168, 37, 0.1)',
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true
                },
                {
                    label: 'SV30 Aerasi 2',
                    data: [],
                    borderColor: '#E65100',
                    backgroundColor: 'rgba(230, 81, 0, 0.1)',
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true
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
                    backgroundColor: 'rgba(245, 124, 0, 0.1)',
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true
                },
                {
                    label: 'DO Aerasi 2',
                    data: [],
                    borderColor: '#FBC02D',
                    backgroundColor: 'rgba(251, 192, 45, 0.1)',
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true
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

function loadChartData(days) {
    currentDays = days;
    
    // Update button states
    ['btn-1', 'btn-7', 'btn-14', 'btn-30'].forEach(id => {
        const btn = document.getElementById(id);
        if (id === `btn-${days}`) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Show loading state
    showLoadingState();

    fetch(`{{ route('dashboard.chart-data') }}?days=${days}`)
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