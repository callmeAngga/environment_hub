@extends('layouts.app')

@section('title', 'TPS Produksi')

@section('content')
<div class="container">

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
        <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <ul style="list-style: disc; padding-left: 20px;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header-modern">
        <div class="header-top compact">
            <div class="header-icon produksi">
                <i class="fas fa-industry"></i>
            </div>

            <div class="header-text">
                <h2 class="page-title-main">TPS Produksi</h2>
                <p class="page-subtitle-main">
                    Kelola data sampah produksi masuk dan keluar
                </p>
            </div>
        </div>
    </div>


    {{-- Tabs Navigation --}}
    <div class="page-tabs">
        <button onclick="switchTabProduksi('masuk')" id="tab-masuk" class="page-tab-btn active">
            <i class="fas fa-sign-in-alt"></i>
            <span>Sampah Masuk</span>
        </button>
        <button onclick="switchTabProduksi('keluar')" id="tab-keluar" class="page-tab-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sampah Keluar</span>
        </button>
    </div>

    {{-- DATA SAMPAH MASUK SECTION --}}
    <div id="content-masuk" class="data-section">
        <div class="filter-actions-bar">
            <form method="GET" action="{{ route('tps-produksi.index') }}" class="filter-inputs" id="filter-masuk">
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tanggal Dari</label>
                    <input type="date" name="tanggal_masuk_dari" id="tanggal_masuk_dari"
                        value="{{ request('tanggal_masuk_dari') }}" class="filter-input-inline">
                </div>
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tanggal Sampai</label>
                    <input type="date" name="tanggal_masuk_sampai" id="tanggal_masuk_sampai"
                        value="{{ request('tanggal_masuk_sampai') }}" class="filter-input-inline">
                </div>
            </form>
            <div class="action-buttons-group">
                <button type="submit" form="filter-masuk" class="btn-modern btn-filter">
                    <i class="fas fa-filter"></i> <span>Filter</span>
                </button>
                <form action="{{ route('tps-produksi.index') }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn-modern btn-reset">
                        <i class="fas fa-redo"></i> <span>Reset</span>
                    </button>
                </form>
                <button onclick="exportMasukExcel()" class="btn-modern btn-export">
                    <i class="fas fa-file-excel"></i> <span>Export</span>
                </button>
                <button onclick="openTambahMasuk()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Data</span>
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama TPS</th>
                        <th>Tanggal</th>
                        <th>Jumlah Sampah</th>
                        <th>Satuan</th>
                        <th>Jenis Sampah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataMasuk as $item)
                    <tr>
                        <td>{{ $item->tps->nama_tps ?? '-' }}</td>
                        <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                        <td>{{ number_format($item->jumlah_sampah, 0, ',', '.') }}</td>
                        <td>{{ $item->satuanSampah->nama_satuan ?? '-' }}</td>
                        <td>{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>
                        <td>
                            <div class="action-buttons-stacked">
                                <button onclick="openEditMasuk('{{ $item->id }}')" class="btn-table btn-table-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="confirmDeleteProduksi('masuk', '{{ $item->id }}', '{{ $item->tps->nama_tps }} - {{ $item->tanggal }}')"
                                    class="btn-table btn-table-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="table-empty-modern">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data sampah masuk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DATA SAMPAH KELUAR SECTION --}}
    <div id="content-keluar" class="data-section hidden">
        <div class="filter-actions-bar">
            <form method="GET" action="{{ route('tps-produksi.index') }}" class="filter-inputs" id="filter-keluar">
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tanggal Dari</label>
                    <input type="date" name="tanggal_keluar_dari" id="tanggal_keluar_dari"
                        value="{{ request('tanggal_keluar_dari') }}" class="filter-input-inline">
                </div>
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tanggal Sampai</label>
                    <input type="date" name="tanggal_keluar_sampai" id="tanggal_keluar_sampai"
                        value="{{ request('tanggal_keluar_sampai') }}" class="filter-input-inline">
                </div>
            </form>
            <div class="action-buttons-group">
                <button type="submit" form="filter-keluar" class="btn-modern btn-filter">
                    <i class="fas fa-filter"></i> <span>Filter</span>
                </button>
                <form action="{{ route('tps-produksi.index') }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn-modern btn-reset">
                        <i class="fas fa-redo"></i> <span>Reset</span>
                    </button>
                </form>
                <button onclick="exportKeluarExcel()" class="btn-modern btn-export">
                    <i class="fas fa-file-excel"></i> <span>Export</span>
                </button>
                <button onclick="openTambahKeluar()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Data</span>
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama TPS</th>
                        <th>No. Sampah Keluar</th>
                        <th>Tanggal</th>
                        <th>Ekspedisi</th>
                        <th>No. Kendaraan</th>
                        <th>Berat Kosong (kg)</th>
                        <th>Berat Isi (kg)</th>
                        <th>Berat Bersih (kg)</th>
                        <th>Total Unit</th>
                        <th>Status Sampah</th>
                        <th>Jenis Sampah</th>
                        <th>Penerima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataKeluar as $item)
                    <tr>
                        <td>{{ $item->tps->nama_tps ?? '-' }}</td>
                        <td class="text-mono text-primary">{{ $item->no_sampah_keluar }}</td>
                        <td>{{ $item->tanggal_pengangkutan ? $item->tanggal_pengangkutan->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->ekspedisi->nama_ekspedisi ?? '-' }}</td>
                        <td class="text-mono">{{ $item->no_kendaraan }}</td>
                        <td>{{ number_format($item->berat_kosong_kg, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->berat_isi_kg, 2, ',', '.') }}</td>
                        <td class="text-bold text-success">{{ number_format($item->berat_isi_kg - $item->berat_kosong_kg, 2, ',', '.') }}</td>
                        <td>{{ $item->total_unit }}</td>
                        <td>{{ $item->statusSampah->nama_status ?? '-' }}</td>
                        <td>{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>
                        <td>{{ $item->penerima->nama_penerima ?? '-' }}</td>
                        <td>
                            <div class="action-buttons-stacked">
                                <a href="{{ route('tps-produksi.export.single.pdf', $item->id) }}"
                                    class="btn-table btn-table-pdf" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <button onclick="openEditKeluar('{{ $item->id }}')" class="btn-table btn-table-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="confirmDeleteProduksi('keluar', '{{ $item->id }}', '{{ $item->no_sampah_keluar }}')"
                                    class="btn-table btn-table-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="table-empty-modern">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data sampah keluar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('components.form-tps-produksi-masuk')
@include('components.form-tps-produksi-keluar')
@include('components.delete-confirmation')

@endsection

@push('scripts')
<script src="{{ asset('js/data-pages-common.js') }}"></script>
<script src="{{ asset('js/tps-produksi.js') }}"></script>
@endpush