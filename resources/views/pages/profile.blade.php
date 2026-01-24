@extends('layouts.app')

@section('title', 'Profile Control')

@section('content')
<div class="container">
    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-content">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <div class="alert-content">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
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
        </div>
        <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header-modern">
        <div class="header-top compact">
            <div class="header-icon produksi">
                <i class="fas fa-user-cog"></i>
            </div>

            <div class="header-text">
                <h2 class="page-title-main">Profile Control</h2>
                <p class="page-subtitle-main">
                    Kelola profil lokasi, master data, dan pengaturan sistem
                </p>
            </div>
        </div>
    </div>


    {{-- Tabs Navigation --}}
    <div class="page-tabs">
        <button onclick="switchTabProfile('wwtp')" id="tab-wwtp-profile" class="page-tab-btn active">
            <i class="fas fa-tint"></i>
            <span>WWTP</span>
        </button>
        <button onclick="switchTabProfile('tps-produksi')" id="tab-tps-produksi-profile" class="page-tab-btn">
            <i class="fas fa-industry"></i>
            <span>TPS Produksi</span>
        </button>
        <button onclick="switchTabProfile('tps-domestik')" id="tab-tps-domestik-profile" class="page-tab-btn">
            <i class="fas fa-home"></i>
            <span>TPS Domestik</span>
        </button>
        @if(Auth::user()->role === 'ADMIN')
        <button onclick="switchTabProfile('pengguna')" id="tab-pengguna-profile" class="page-tab-btn">
            <i class="fas fa-users"></i>
            <span>Pengguna</span>
        </button>
        @endif
    </div>

    {{-- TAB WWTP --}}
    <div id="content-wwtp-profile" class="data-section">
        {{-- TAB WWTP --}}
        <div id="content-wwtp-profile" class="data-section">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">WWTP</h3>
                    <button onclick="openWWTPModal()" class="btn-modern btn-add">
                        <i class="fas fa-plus"></i> <span>Tambah WWTP</span>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Nama WWTP</th>
                                <th>Alamat</th>
                                <th>Koordinat</th>
                                <th>Kapasitas</th>
                                <th style="text-align: end;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wwtps as $wwtp)
                            <tr>
                                <td>{{ $wwtp->nama_wwtp }}</td>
                                <td>{{ $wwtp->alamat }}</td>
                                <td>
                                    {{ $wwtp->koordinat_lat }},
                                    {{ $wwtp->koordinat_lng }}
                                </td>
                                <td>
                                    {{ $wwtp->kapasitas_debit
                                ? number_format($wwtp->kapasitas_debit, 2) . ' m³'
                                : '-' }}
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px; justify-content: end;">
                                        <button
                                            onclick="openWWTPModal(
                                        '{{ $wwtp->id }}',
                                        '{{ addslashes($wwtp->nama_wwtp) }}',
                                        '{{ addslashes($wwtp->alamat) }}',
                                        '{{ $wwtp->koordinat_lat }}',
                                        '{{ $wwtp->koordinat_lng }}',
                                        '{{ $wwtp->kapasitas_debit }}'
                                    )"
                                            class="btn-table btn-table-edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('wwtp.destroy', $wwtp->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus WWTP {{ $wwtp->nama_wwtp }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-table btn-table-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center text-gray"
                                    style="padding: 40px;">
                                    <i class="fas fa-inbox"
                                        style="font-size: 32px; display:block; margin-bottom:12px;"></i>
                                    Belum ada data WWTP
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">OPERATOR</h3>
                <button onclick="openOperatorModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Operator</span>
                </button>
            </div>
            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Operator</th>
                            <th>Tanggal Dibuat</th>
                            <th style="text-align: end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($operators as $op)
                        <tr>
                            <td>{{ $op->nama_operator }}</td>
                            <td>{{ $op->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: end;">
                                    <button onclick="openOperatorModal('{{ $op->id }}', '{{ addslashes($op->nama_operator) }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('operator.destroy', $op->id) }}" method="POST" onsubmit="return confirm('Hapus operator?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data operator</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">LAB</h3>
                <button onclick="openLabModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Lab</span>
                </button>
            </div>
            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Lab</th>
                            <th>Lokasi</th>
                            <th style="text-align: end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labs as $lab)
                        <tr>
                            <td>{{ $lab->nama_lab }}</td>
                            <td>{{ $lab->lokasi }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: end;">
                                    <button onclick="openLabModal('{{ $lab->id }}', '{{ addslashes($lab->nama_lab) }}', '{{ addslashes($lab->lokasi) }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('lab.destroy', $lab->id) }}" method="POST" onsubmit="return confirm('Hapus lab?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data Lab</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TAB TPS PRODUKSI --}}
    <div id="content-tps-produksi-profile" class="data-section hidden">

        {{-- DATA TPS PRODUKSI --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">TPS PRODUKSI</h3>
                <button onclick="openTPSModal(null, '', '', '', '', '', 'PRODUKSI')" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah TPS</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama TPS</th>
                            <th>Alamat</th>
                            <th>Kapasitas</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tps_produksi as $tp)
                        <tr>
                            <td>{{ $tp->nama_tps }}</td>
                            <td>{{ $tp->alamat }}</td>
                            <td>{{ $tp->kapasitas_max ? number_format($tp->kapasitas_max, 2).' m³' : '-' }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button onclick="openTPSModal('{{ $tp->id }}','{{ addslashes($tp->nama_tps) }}','{{ addslashes($tp->alamat) }}','{{ $tp->koordinat_lat }}','{{ $tp->koordinat_lng }}','{{ $tp->kapasitas_max }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('tps.destroy', $tp->id) }}" method="POST" onsubmit="return confirm('Hapus TPS?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data TPS</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">EKSPEDISI</h3>
                <button onclick="openEkspedisiModal(null, '', '', 'PRODUKSI')" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Ekspedisi</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Ekspedisi</th>
                            <th>Alamat</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekspedisi_produksi as $ekspedisi)
                        <tr>
                            <td>{{ $ekspedisi->nama_ekspedisi }}</td>
                            <td>{{ $ekspedisi->alamat ?? '-' }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button
                                        onclick="openEkspedisiModal(
                                        '{{ $ekspedisi->id }}',
                                        '{{ addslashes($ekspedisi->nama_ekspedisi) }}',
                                        '{{ addslashes($ekspedisi->alamat) }}'
                                    )"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('daftar-ekspedisi.destroy', $ekspedisi->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data Ekspedisi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">JENIS SAMPAH</h3>
                <button onclick="openJenisSampahModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Jenis</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Jenis</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenis_sampah as $jenis)
                        <tr>
                            <td>{{ $jenis->nama_jenis }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button onclick="openJenisSampahModal('{{ $jenis->id }}','{{ addslashes($jenis->nama_jenis) }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('jenis-sampah.destroy',$jenis->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="table-empty-modern">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">STATUS SAMPAH</h3>
                <button onclick="openStatusSampahModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Status</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Status</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($status_sampah as $status)
                        <tr>
                            <td>{{ $status->nama_status }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button onclick="openStatusSampahModal('{{ $status->id }}','{{ addslashes($status->nama_status) }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('status-sampah.destroy',$status->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="table-empty-modern">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SATUAN SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">SATUAN SAMPAH</h3>
                <button onclick="openSatuanSampahModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Satuan</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Satuan</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($satuan_sampah as $sat)
                        <tr>
                            <td>{{ $sat->nama_satuan }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button onclick="openSatuanSampahModal('{{ $sat->id }}','{{ addslashes($sat->nama_satuan) }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('satuan-sampah.destroy',$sat->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="table-empty-modern">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DAFTAR PENERIMA SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PENERIMA SAMPAH</h3>
                <button onclick="openPenerimaModal(null, '', '', 'PRODUKSI')" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Penerima</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Penerima</th>
                            <th>Alamat</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerima_produksi as $penerima)
                        <tr>
                            <td>{{ $penerima->nama_penerima }}</td>
                            <td>{{ $penerima->alamat ?? '-' }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button
                                        onclick="openPenerimaModal(
                                        '{{ $penerima->id }}',
                                        '{{ addslashes($penerima->nama_penerima) }}',
                                        '{{ addslashes($penerima->alamat) }}'
                                    )"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('daftar-penerima.destroy',$penerima->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data penerima sampah</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    {{-- TAB TPS DOMESTIK --}}
    {{-- TAB TPS DOMESTIK --}}
    <div id="content-tps-domestik-profile" class="data-section hidden">

        {{-- DATA TPS DOMESTIK --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">TPS DOMESTIK</h3>
                <button onclick="openTPSModal(null, '', '', '', '', '', 'DOMESTIK')" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah TPS</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama TPS</th>
                            <th>Alamat</th>
                            <th>Kapasitas</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tps_domestik as $tp)
                        <tr>
                            <td>{{ $tp->nama_tps }}</td>
                            <td>{{ $tp->alamat }}</td>
                            <td>
                                {{ $tp->kapasitas_max ? number_format($tp->kapasitas_max,2).' m³' : '-' }}
                            </td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button
                                        onclick="openTPSModal(
                                        '{{ $tp->id }}',
                                        '{{ addslashes($tp->nama_tps) }}',
                                        '{{ addslashes($tp->alamat) }}',
                                        '{{ $tp->koordinat_lat }}',
                                        '{{ $tp->koordinat_lng }}',
                                        '{{ $tp->kapasitas_max }}'
                                    )"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('tps.destroy',$tp->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus TPS?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data TPS</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">EKSPEDISI</h3>
                <button onclick="openEkspedisiModal(null, '', '', 'DOMESTIK')" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Ekspedisi</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Ekspedisi</th>
                            <th>Alamat</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekspedisi_domestik as $ekspedisi)
                        <tr>
                            <td>{{ $ekspedisi->nama_ekspedisi }}</td>
                            <td>{{ $ekspedisi->alamat ?? '-' }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button
                                        onclick="openEkspedisiModal(
                                        '{{ $ekspedisi->id }}',
                                        '{{ addslashes($ekspedisi->nama_ekspedisi) }}',
                                        '{{ addslashes($ekspedisi->alamat) }}'
                                    )"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('daftar-ekspedisi.destroy', $ekspedisi->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data Ekspedisi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- JENIS SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">JENIS SAMPAH</h3>
                <button onclick="openJenisSampahModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Jenis</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Jenis</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenis_sampah as $jenis)
                        <tr>
                            <td>{{ $jenis->nama_jenis }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button onclick="openJenisSampahModal('{{ $jenis->id }}','{{ addslashes($jenis->nama_jenis) }}')"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('jenis-sampah.destroy',$jenis->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="table-empty-modern">
                                Belum ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DAFTAR PENERIMA SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PENERIMA SAMPAH</h3>
                <button onclick="openPenerimaModal(null, '', '', 'DOMESTIK')" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Penerima</span>
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nama Penerima</th>
                            <th>Alamat</th>
                            <th style="text-align:end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerima_domestik as $penerima)
                        <tr>
                            <td>{{ $penerima->nama_penerima }}</td>
                            <td>{{ $penerima->alamat ?? '-' }}</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button
                                        onclick="openPenerimaModal(
                                        '{{ $penerima->id }}',
                                        '{{ addslashes($penerima->nama_penerima) }}',
                                        '{{ addslashes($penerima->alamat) }}'
                                    )"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('daftar-penerima.destroy',$penerima->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="table-empty-modern">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data penerima sampah</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- TAB PENGGUNA --}}
    @if(Auth::user()->role === 'ADMIN')
    <div id="content-pengguna-profile" class="hidden">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">MANAJEMEN PENGGUNA</h3>
                <button onclick="openUserModal()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> Tambah User
                </button>
            </div>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="text-align: end;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usersList as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <span style="
                                background:#dbeafe;
                                color:#1e40af;
                                padding:2px 8px;
                                border-radius:4px;
                                font-size:0.8rem;
                            ">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: end;">
                                    <button
                                        onclick="openUserModal('{{ $u->id }}', '{{ $u->email }}')"
                                        class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form
                                        action="{{ route('users.destroy', $u->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus user ini? Akses mereka akan hilang.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-table btn-table-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray">
                                Tidak ada data pengguna found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endif
</div>


<!-- Modals WWTP -->
@include('components.form-lokasi-wwtp')
@include('components.form-operator-wwtp')
@include('components.form-lab')

<!-- Modals TPS -->
@include('components.form-tps')
@include('components.form-ekspedisi')
@include('components.form-jenis-sampah')
@include('components.form-status-sampah')
@include('components.form-satuan-sampah')
@include('components.form-penerima-sampah')

<!-- Modals Pengguna -->
@include('components.form-pengguna')

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush
@endsection