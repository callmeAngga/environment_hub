@extends('layouts.app')

@section('title', 'TPS Domestik')

@section('content')
<div class="container">

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-content">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <div class="alert-content">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <div class="alert-content-block">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <p class="alert-title">Terdapat kesalahan:</p>
                <ul class="alert-list">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="alert-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header-modern">
        <div class="header-top compact">
            <div class="header-icon domestik">
                <i class="fas fa-home"></i>
            </div>

            <div class="header-text">
                <h2 class="page-title-main">Tempat Penampungan Sementara Domestik</h2>
                <p class="page-subtitle-main">
                    Kelola data sampah domestik keluar
                </p>
            </div>
        </div>
    </div>

    {{-- DATA SECTION (No Tabs) --}}
    <div class="data-section">
        <div class="filter-actions-bar">
            <form method="GET" action="{{ route('tps-domestik.index') }}" class="filter-inputs" id="filter-domestik">
                <input type="hidden" name="sort_domestik" id="input-sort-domestik" value="{{ request('sort_domestik', 'asc') }}">

                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari"
                        value="{{ request('tanggal_dari') }}" class="filter-input-inline">
                </div>
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                        value="{{ request('tanggal_sampai') }}" class="filter-input-inline">
                </div>
            </form>
            <div class="action-buttons-group">
                <button type="submit" form="filter-domestik" class="btn-modern btn-filter">
                    <i class="fas fa-filter"></i> <span>Filter</span>
                </button>
                <form action="{{ route('tps-domestik.index') }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn-modern btn-reset">
                        <i class="fas fa-redo"></i> <span>Reset</span>
                    </button>
                </form>
                <!-- <button onclick="toggleSortDomestik()" class="btn-modern btn-sort" id="btn-sort-domestik">
                    <i class="fas fa-sort-amount-{{ request('sort_domestik', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                    <span>{{ request('sort_domestik', 'asc') === 'asc' ? 'Terlama' : 'Terbaru' }}</span>
                </button> -->
                <button onclick="exportExcel()" class="btn-modern btn-export">
                    <i class="fas fa-file-excel"></i> <span>Export</span>
                </button>
                <button onclick="openTambahDomestik()" class="btn-modern btn-add">
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
                        <th>Berat Bersih (kg)</th>
                        <th>Jenis Sampah</th>
                        <th>Penerima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataDomestik as $index => $item)
                    <tr>
                        <td>{{ $item->tps->nama_tps ?? '-' }}</td>
                        <td class="text-mono text-primary">{{ $item->no_sampah_keluar }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengangkutan)->format('d/m/Y') }}</td>
                        <td>{{ $item->ekspedisi->nama_ekspedisi ?? '-' }}</td>
                        <td class="text-mono">{{ $item->no_kendaraan }}</td>
                        <td class="text-bold text-success">{{ number_format($item->berat_bersih_kg, 2, ',', '.') }}</td>
                        <td>{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>
                        <td>{{ $item->penerima->nama_penerima ?? '-' }}</td>
                        <td>
                            <div class="action-buttons-stacked">
                                <button onclick="openEditDomestik('{{$item->id}}')"
                                    class="btn-table btn-table-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="confirmDeleteDomestik('{{$item->id}}', '{{ $item->no_sampah_keluar }}')"
                                    class="btn-table btn-table-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="table-empty-modern">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data sampah domestik keluar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($dataDomestik->hasPages())
        <div style="padding: 20px 24px; border-top: 2px solid #e8e8e8;">
            {{ $dataDomestik->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Include Modals --}}
@include('components.form-tps-domestik')
@include('components.delete-confirmation')

@endsection

@push('scripts')
<script src="{{ asset('js/data-pages-common.js') }}"></script>
<script src="{{ asset('js/tps-domestik.js') }}"></script>
@endpush