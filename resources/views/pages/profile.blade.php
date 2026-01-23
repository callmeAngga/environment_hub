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
                    <h3 class="card-title">Data WWTP</h3>
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
                <h3 class="card-title">Daftar Operator</h3>
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
                <h3 class="card-title">Daftar Lab</h3>
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
    {{-- TAB TPS PRODUKSI --}}
    <div id="content-tps-produksi-profile" class="data-section hidden">

        {{-- DATA TPS PRODUKSI --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data TPS Produksi</h3>
                <button onclick="openTPSModal()" class="btn-modern btn-add">
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
                        @forelse($tps as $tp)
                        <tr>
                            <td>{{ $tp->nama_tps }}</td>
                            <td>{{ $tp->alamat }}</td>
                            <td>{{ $tp->kapasitas_max }} m³</td>
                            <td>
                                <div style="display:flex; gap:8px; justify-content:end;">
                                    <button onclick="openTPSModal('{{ $tp->id }}','{{ addslashes($tp->nama_tps) }}','{{ addslashes($tp->alamat) }}','{{ $tp->koordinat_lat }}','{{ $tp->koordinat_lng }}','{{ $tp->kapasitas_max }}')" class="btn-table btn-table-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('tps.destroy',$tp->id) }}" method="POST" onsubmit="return confirm('Hapus TPS?')">
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

        {{-- JENIS SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jenis Sampah</h3>
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

        {{-- SATUAN SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Satuan Sampah</h3>
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

    </div>


    {{-- TAB TPS DOMESTIK --}}
    {{-- TAB TPS DOMESTIK --}}
    <div id="content-tps-domestik-profile" class="data-section hidden">

        {{-- DATA TPS DOMESTIK --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data TPS Domestik</h3>
                <button onclick="openTPSModal()" class="btn-modern btn-add">
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
                        @forelse($tps as $tp)
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

        {{-- JENIS SAMPAH --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jenis Sampah</h3>
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
                <h3 class="card-title">Daftar Penerima Sampah</h3>
                <button onclick="openPenerimaModal()" class="btn-modern btn-add">
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
                        @forelse($daftar_penerima as $penerima)
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
                <h3 class="card-title">Manajemen Pengguna</h3>
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

{{-- Modal WWTP --}}
<div id="modalLokasiWWTP" class="modal-overlay">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 id="modalLokasiWWTPTitle" class="modal-title">Form WWTP</h3>
            <button type="button" onclick="closeModal('modalLokasiWWTP')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formWWTP" method="POST">
            @csrf
            <input type="hidden" id="wwtp_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-section">
                    <h4 class="form-section-title">Informasi WWTP</h4>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Nama WWTP <span class="required-mark">*</span></label>
                            <input type="text" name="nama_wwtp" id="nama_wwtp" class="form-input" required>
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Alamat <span class="required-mark">*</span></label>
                            <textarea name="alamat" id="alamat_wwtp" class="form-input" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="koordinat_lat" id="koordinat_lat_wwtp" class="form-input" placeholder="-6.9175">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="koordinat_lng" id="koordinat_lng_wwtp" class="form-input" placeholder="107.6191">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Kapasitas Debit (m³)</label>
                            <input type="number" step="0.01" name="kapasitas_debit" id="kapasitas_debit" class="form-input">
                            <span class="form-help">Masukkan kapasitas dalam meter kubik</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLokasiWWTP')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitWWTP" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Operator --}}
<div id="modalOperatorWwtp" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalOperatorWwtpTitle" class="modal-title">Form Operator</h3>
            <button type="button" onclick="closeModal('modalOperatorWwtp')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formOperator" method="POST">
            @csrf
            <input type="hidden" id="operator_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Operator <span class="required-mark">*</span></label>
                    <input type="text" name="nama_operator" id="nama_operator" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalOperatorWwtp')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitOperator" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Lab --}}
<div id="modalLab" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalLabTitle" class="modal-title">Form Lab</h3>
            <button type="button" onclick="closeModal('modalLab')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formLab" method="POST">
            @csrf
            <input type="hidden" id="lab_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lab <span class="required-mark">*</span></label>
                    <input type="text" name="nama_lab" id="nama_lab" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi <span class="required-mark">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLab')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitLab" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal TPS --}}
<div id="modalTPS" class="modal-overlay">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 id="modalTPSTitle" class="modal-title">Form TPS</h3>
            <button type="button" onclick="closeModal('modalTPS')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formTPS" method="POST">
            @csrf
            <input type="hidden" id="tps_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-section">
                    <h4 class="form-section-title">Informasi TPS</h4>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Nama TPS <span class="required-mark">*</span></label>
                            <input type="text" name="nama_tps" id="nama_tps" class="form-input" required>
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat_tps" class="form-input" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="koordinat_lat" id="koordinat_lat_tps" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="koordinat_lng" id="koordinat_lng_tps" class="form-input">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Kapasitas Maximum (m³)</label>
                            <input type="number" step="0.01" name="kapasitas_max" id="kapasitas_max" class="form-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTPS')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitTPS" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Satuan Sampah --}}
<div id="modalSatuanSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalSatuanSampahTitle" class="modal-title">Form Satuan</h3>
            <button type="button" onclick="closeModal('modalSatuanSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formSatuanSampah" method="POST">
            @csrf
            <input type="hidden" id="satuan_sampah_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Satuan <span class="required-mark">*</span></label>
                    <input type="text" name="nama_satuan" id="nama_satuan" class="form-input" required placeholder="Contoh: kg, ton, m³">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSatuanSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitSatuanSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Jenis Sampah --}}
<div id="modalJenisSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalJenisSampahTitle" class="modal-title">Form Jenis</h3>
            <button type="button" onclick="closeModal('modalJenisSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formJenisSampah" method="POST">
            @csrf
            <input type="hidden" id="jenis_sampah_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Jenis <span class="required-mark">*</span></label>
                    <input type="text" name="nama_jenis" id="nama_jenis" class="form-input" required placeholder="Contoh: Organik, Anorganik">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalJenisSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitJenisSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ekspedisi --}}
<div id="modalEkspedisi" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalEkspedisiTitle" class="modal-title">Form Ekspedisi</h3>
            <button type="button" onclick="closeModal('modalEkspedisi')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEkspedisi" method="POST">
            @csrf
            <input type="hidden" id="ekspedisi_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Ekspedisi <span class="required-mark">*</span></label>
                    <input type="text" name="nama_ekspedisi" id="nama_ekspedisi" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_ekspedisi" class="form-input" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalEkspedisi')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitEkspedisi" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Penerima Sampah --}}
<div id="modalPenerimaSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalPenerimaSampahTitle" class="modal-title">Form Penerima Sampah</h3>
            <button type="button" onclick="closeModal('modalPenerimaSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formPenerimaSampah" method="POST">
            @csrf
            <input type="hidden" id="penerima_sampah_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Penerima Sampah <span class="required-mark">*</span></label>
                    <input type="text" name="nama_penerima" id="nama_penerima" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_penerima_sampah" class="form-input" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalPenerimaSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitPenerimaSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@include('components.form-pengguna')

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush
@endsection