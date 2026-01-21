@extends('layouts.app')

@section('title', 'TPS Domestik')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tps-domestik.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h2 class="page-title">Tempat Penampungan Sementara Domestik</h2>
            <p class="page-subtitle">Kelola data sampah domestik keluar</p>
        </div>
        <div class="header-actions">
            <button onclick="exportExcel()" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <button onclick="openTambahDomestik()" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
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
    <div class="alert alert-danger">
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
    <div class="alert alert-danger">
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

    <!-- Filter Section -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="padding: 1.5rem;">
            <form method="GET" action="{{ route('tps-domestik.index') }}">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari"
                            value="{{ request('tanggal_dari') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                            value="{{ request('tanggal_sampai') }}" class="form-control">
                    </div>
                    <div class="form-group" style="display: flex; gap: 0.5rem; align-items: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('tps-domestik.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="data-table">
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
                        <th class="text-center">Aksi</th>
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
                            <div class="action-buttons">
                                <button onclick="openEditDomestik('{{$item->id}}')"
                                    class="btn-icon btn-icon-edit"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="confirmDelete('{{$item->id}}', '{{ $item->no_sampah_keluar }}')"
                                    class="btn-icon btn-icon-delete"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <div class="empty-state-content">
                                <i class="fas fa-inbox"></i>
                                <p class="empty-state-title">Belum ada data sampah domestik keluar</p>
                                <p class="empty-state-subtitle">Klik tombol "Tambah Data" untuk menambah data baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($dataDomestik->hasPages())
        <div class="pagination-wrapper">
            {{ $dataDomestik->links() }}
        </div>
        @endif
    </div>
</div>

@include('components.modals.form-tps-domestik')
@include('components.modals.delete-confirmation')

@endsection

@push('scripts')
<script src="{{ asset('js/tps-domestik.js') }}"></script>
@endpush