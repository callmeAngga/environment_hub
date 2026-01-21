@extends('layouts.app')

@section('title', 'WWTP - Sistem Manajemen Data Lingkungan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/wwtp.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
@section('content')

<div class="wwtp-container">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <span>{{ session('success') }}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <span>{{ session('error') }}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Header -->
    <div class="wwtp-header">
        <div class="wwtp-title">
            <h2>Waste Water Treatment Plant (WWTP)</h2>
            <p>Kelola data monitoring pengolahan air limbah</p>
        </div>
        <div id="button-harian-container">
            <button onclick="openModalTambahHarian()" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Data Harian
            </button>
        </div>
        <div id="button-bulanan-container" class="hidden">
            <button onclick="openModalTambahBulanan()" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Data Bulanan
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs-nav">
        <button onclick="switchTab('harian')" id="tab-harian" class="tab-button active">
            Data Harian
        </button>
        <button onclick="switchTab('bulanan')" id="tab-bulanan" class="tab-button">
            Data Bulanan
        </button>
    </div>

    <!-- Filter Harian -->
    <div id="filter-harian" class="filter-section">
        <form method="GET" action="{{ route('wwtp.index') }}">
            <div class="filter-grid">
                <div class="form-group">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari"
                        value="{{ request('tanggal_dari') }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                        value="{{ request('tanggal_sampai') }}" class="form-input">
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('wwtp.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
                <div>
                    <button type="button" onclick="exportHarianExcel()" class="btn btn-success" style="width: 100%;">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Filter Bulanan -->
    <div id="filter-bulanan" class="filter-section hidden">
        <form method="GET" action="{{ route('wwtp.index') }}">
            <div class="filter-grid filter-grid-6">
                <div class="form-group">
                    <label class="form-label">Bulan Dari</label>
                    <select name="bulan_dari" id="bulan_dari" class="form-select">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan_dari') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                            @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Dari</label>
                    <select name="tahun_dari" id="tahun_dari" class="form-select">
                        <option value="">Pilih Tahun</option>
                        @for($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request('tahun_dari') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Bulan Sampai</label>
                    <select name="bulan_sampai" id="bulan_sampai" class="form-select">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan_sampai') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                            @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Sampai</label>
                    <select name="tahun_sampai" id="tahun_sampai" class="form-select">
                        <option value="">Pilih Tahun</option>
                        @for($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request('tahun_sampai') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('wwtp.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
                <div>
                    <button type="button" onclick="exportBulananExcel()" class="btn btn-success" style="width: 100%;">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Harian Table -->
    <div id="content-harian" class="table-container">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Operator</th>
                        <th>Debit In</th>
                        <th>Debit Out</th>
                        <th>pH Eku 1</th>
                        <th>pH Eku 2</th>
                        <th>Suhu Eku 1</th>
                        <th>Suhu Eku 2</th>
                        <th>pH Aer 1</th>
                        <th>pH Aer 2</th>
                        <th>SV30 Aer 1</th>
                        <th>SV30 Aer 2</th>
                        <th>DO Aer 1</th>
                        <th>DO Aer 2</th>
                        <th>pH Out</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataHarian as $harian)
                    <tr>
                        <td>{{ $harian->wwtp->nama_wwtp ?? '-' }}</td>
                        <td>{{ $harian->tanggal->format('d/m/Y') }}</td>
                        <td>{{ substr($harian->waktu, 0, 5) }}</td>
                        <td>{{ $harian->operator->nama_operator ?? '-' }}</td>
                        <td>{{ $harian->display_debit_inlet ?? '-' }}</td>
                        <td>{{ $harian->display_debit_outlet ?? '-' }}</td>
                        <td>{{ $harian->display_ph_ekualisasi_1 ?? '-' }}</td>
                        <td>{{ $harian->display_ph_ekualisasi_2 ?? '-' }}</td>
                        <td>{{ $harian->display_suhu_ekualisasi_1 ?? '-' }}</td>
                        <td>{{ $harian->display_suhu_ekualisasi_2 ?? '-' }}</td>
                        <td>{{ $harian->display_ph_aerasi_1 ?? '-' }}</td>
                        <td>{{ $harian->display_ph_aerasi_2 ?? '-' }}</td>
                        <td>{{ $harian->sv30_aerasi_1 ? $harian->sv30_aerasi_1 . '%' : '-' }}</td>
                        <td>{{ $harian->sv30_aerasi_2 ? $harian->sv30_aerasi_2 . '%' : '-' }}</td>
                        <td>{{ $harian->display_do_aerasi_1 ?? '-' }}</td>
                        <td>{{ $harian->display_do_aerasi_2 ?? '-' }}</td>
                        <td>{{ $harian->display_ph_outlet ?? '-' }}</td>
                        <td class="text-truncate" title="{{ $harian->keterangan ?? '' }}">
                            {{ Str::limit($harian->keterangan ?? '-', 20) }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="editDataHarian('{{ $harian->id }}')" class="btn-icon">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    class="btn-icon btn-delete"
                                    data-type="harian"
                                    data-id="{{ $harian->id }}"
                                    data-label="{{ ($harian->wwtp->nama_wwtp ?? 'Data') . ' - ' . $harian->tanggal->format('d/m/Y') }}"
                                    onclick="confirmDelete(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="19" class="table-empty">
                            Belum ada data harian
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Bulanan Table -->
    <div id="content-bulanan" class="table-container hidden">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Lokasi</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>TSS In/Out</th>
                        <th>TDS In/Out</th>
                        <th>BOD In/Out</th>
                        <th>COD In/Out</th>
                        <th>M&L In/Out</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataBulanan as $bulanan)
                    <tr>
                        <td>{{ $bulanan->wwtp->nama_wwtp ?? '-' }}</td>
                        <td>{{ $bulanan->nama_bulan }}</td>
                        <td>{{ $bulanan->tahun }}</td>
                        <td>
                            <div class="text-small">
                                <div class="text-blue">In: {{ $bulanan->display_tss_inlet }}</div>
                                <div class="text-green">Out: {{ $bulanan->display_tss_outlet }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="text-small">
                                <div class="text-blue">In: {{ $bulanan->display_tds_inlet }}</div>
                                <div class="text-green">Out: {{ $bulanan->display_tds_outlet }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="text-small">
                                <div class="text-blue">In: {{ $bulanan->display_bod_inlet }}</div>
                                <div class="text-green">Out: {{ $bulanan->display_bod_outlet }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="text-small">
                                <div class="text-blue">In: {{ $bulanan->display_cod_inlet }}</div>
                                <div class="text-green">Out: {{ $bulanan->display_cod_outlet }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="text-small">
                                <div class="text-blue">In: {{ $bulanan->display_minyak_lemak_inlet }}</div>
                                <div class="text-green">Out: {{ $bulanan->display_minyak_lemak_outlet }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="editDataBulanan('{{ $bulanan->id }}')" class="btn-icon">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    class="btn-icon btn-delete"
                                    data-type="bulanan"
                                    data-id="{{ $bulanan->id }}"
                                    data-label="{{ ($bulanan->wwtp->nama_wwtp ?? 'Data') . ' - ' . $bulanan->bulan_tahun }}"
                                    onclick="confirmDelete(this)">

                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="table-empty">
                            Belum ada data bulanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('components.modals.form-wwtp-harian')
@include('components.modals.form-wwtp-bulanan')
@include('components.modals.delete-confirmation')

@push('scripts')
<script src="{{ asset('js/wwtp.js') }}"></script>
@endpush

@endsection