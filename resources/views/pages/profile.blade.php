@extends('layouts.app')

@section('title', 'Profile Control')

@section('content')
<div class="container">
    <div class="flex-between mb-4">
        <h2 class="header-title" style="color: #333;">Profile Control</h2>
    </div>

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

    <div class="tab-nav">
        <button onclick="switchTabProfile('wwtp')" id="tab-wwtp-profile" class="tab-btn active">WWTP</button>
        <button onclick="switchTabProfile('tps-produksi')" id="tab-tps-produksi-profile" class="tab-btn">TPS Produksi</button>
        <button onclick="switchTabProfile('tps-domestik')" id="tab-tps-domestik-profile" class="tab-btn">TPS Domestik</button>

        @if(Auth::user()->role === 'ADMIN')
            <button onclick="switchTabProfile('pengguna')" id="tab-pengguna-profile" class="tab-btn">Pengguna</button>
        @endif
    </div>

    <div id="content-wwtp-profile">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data WWTP</h3>
                <button onclick="openWWTPModal()" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah WWTP
                </button>
            </div>
            <div class="grid-container">
                @forelse($wwtps as $wwtp)
                <div class="grid-item">
                    <div class="item-header">
                        <span class="item-title">{{ $wwtp->nama_wwtp }}</span>
                        <div class="flex-gap">
                            <button onclick="openWWTPModal('{{ $wwtp->id }}', '{{ addslashes($wwtp->nama_wwtp) }}', '{{ addslashes($wwtp->alamat) }}', '{{ $wwtp->koordinat_lat }}', '{{ $wwtp->koordinat_lng }}', '{{ $wwtp->kapasitas_debit }}')" class="btn-icon text-blue">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('wwtp.destroy', $wwtp->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="item-details">
                        <p><strong>Alamat:</strong> {{ $wwtp->alamat }}</p>
                        <p><strong>Koordinat:</strong> {{ $wwtp->koordinat_lat }}, {{ $wwtp->koordinat_lng }}</p>
                        <p><strong>Kapasitas:</strong> {{ $wwtp->kapasitas_debit }} m³</p>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray" style="grid-column: 1/-1;">Belum ada data WWTP</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Operator</h3>
                <button onclick="openOperatorModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Operator</button>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Operator</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($operators as $op)
                        <tr>
                            <td>{{ $op->nama_operator }}</td>
                            <td>{{ $op->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="flex-gap">
                                    <button onclick="openOperatorModal('{{ $op->id }}', '{{ addslashes($op->nama_operator) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('operator.destroy', $op->id) }}" method="POST" onsubmit="return confirm('Hapus operator?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada data operator</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Lab</h3>
                <button onclick="openLabModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Lab</button>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Lab</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labs as $lab)
                        <tr>
                            <td>{{ $lab->nama_lab }}</td>
                            <td>{{ $lab->lokasi }}</td>
                            <td>
                                <div class="flex-gap">
                                    <button onclick="openLabModal('{{ $lab->id }}', '{{ addslashes($lab->nama_lab) }}', '{{ addslashes($lab->lokasi) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('lab.destroy', $lab->id) }}" method="POST" onsubmit="return confirm('Hapus lab?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada data Lab</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="content-tps-produksi-profile" class="hidden">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data TPS Produksi</h3>
                <button onclick="openTPSModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah TPS</button>
            </div>
            <div class="grid-container">
                @forelse($tps as $tp)
                <div class="grid-item">
                    <div class="item-header">
                        <span class="item-title">{{ $tp->nama_tps }}</span>
                        <div class="flex-gap">
                            <button onclick="openTPSModal('{{ $tp->id }}', '{{ addslashes($tp->nama_tps) }}', '{{ addslashes($tp->alamat) }}', '{{ $tp->koordinat_lat }}', '{{ $tp->koordinat_lng }}', '{{ $tp->kapasitas_max }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('tps.destroy', $tp->id) }}" method="POST" onsubmit="return confirm('Hapus TPS?')">
                                @csrf @method('DELETE')
                                <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="item-details">
                        <p><strong>Alamat:</strong> {{ $tp->alamat }}</p>
                        <p><strong>Kapasitas:</strong> {{ $tp->kapasitas_max }} m³</p>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray" style="grid-column: 1/-1;">Belum ada data TPS</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jenis Sampah</h3>
                <button onclick="openJenisSampahModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Jenis</button>
            </div>
            <div class="grid-container" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                @forelse($jenis_sampah as $jenis)
                <div class="grid-item flex-between">
                    <span>{{ $jenis->nama_jenis }}</span>
                    <div class="flex-gap">
                        <button onclick="openJenisSampahModal('{{ $jenis->id }}', '{{ addslashes($jenis->nama_jenis) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('jenis-sampah.destroy', $jenis->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn-icon text-red"><i class="fas fa-times"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray">Belum ada data</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Satuan Sampah</h3>
                <button onclick="openSatuanSampahModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Satuan</button>
            </div>
            <div class="grid-container" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));">
                @forelse($satuan_sampah as $sat)
                <div class="grid-item flex-between">
                    <span>{{ $sat->nama_satuan }}</span>
                    <div class="flex-gap">
                        <button onclick="openSatuanSampahModal('{{ $sat->id }}', '{{ addslashes($sat->nama_satuan) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('satuan-sampah.destroy', $sat->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn-icon text-red"><i class="fas fa-times"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray">Belum ada data</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Ekspedisi</h3>
                <button onclick="openEkspedisiModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead><tr><th>Nama Ekspedisi</th><th>Alamat</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($daftar_ekspedisi as $eks)
                        <tr>
                            <td>{{ $eks->nama_ekspedisi }}</td>
                            <td>{{ $eks->alamat }}</td>
                            <td>
                                <div class="flex-gap">
                                    <button onclick="openEkspedisiModal('{{ $eks->id }}', '{{ $eks->nama_ekspedisi }}', '{{ $eks->alamat }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('daftar-ekspedisi.destroy', $eks->id) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn-icon text-red"><i class="fas fa-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="content-tps-domestik-profile" class="hidden">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data TPS Domestik</h3>
                <button onclick="openTPSModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah TPS</button>
            </div>
            <div class="grid-container">
                @forelse($tps as $tp)
                <div class="grid-item">
                    <div class="item-header">
                        <span class="item-title">{{ $tp->nama_tps }}</span>
                        <div class="flex-gap">
                            <button onclick="openTPSModal('{{ $tp->id }}', '{{ addslashes($tp->nama_tps) }}', '{{ addslashes($tp->alamat) }}', '{{ $tp->koordinat_lat }}', '{{ $tp->koordinat_lng }}', '{{ $tp->kapasitas_max }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('tps.destroy', $tp->id) }}" method="POST" onsubmit="return confirm('Hapus TPS?')">
                                @csrf @method('DELETE')
                                <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="item-details">
                        <p><strong>Alamat:</strong> {{ $tp->alamat }}</p>
                        <p><strong>Kapasitas:</strong> {{ $tp->kapasitas_max ? number_format($tp->kapasitas_max, 2) . ' m³' : '-' }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray" style="grid-column: 1/-1;">Belum ada data TPS</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Ekspedisi</h3>
                <button onclick="openEkspedisiModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Ekspedisi</button>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead><tr><th>Nama Ekspedisi</th><th>Alamat</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($daftar_ekspedisi as $eks)
                        <tr>
                            <td>{{ $eks->nama_ekspedisi }}</td>
                            <td>{{ $eks->alamat ?? '-' }}</td>
                            <td>
                                <div class="flex-gap">
                                    <button onclick="openEkspedisiModal('{{ $eks->id }}', '{{ addslashes($eks->nama_ekspedisi) }}', '{{ addslashes($eks->alamat) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('daftar-ekspedisi.destroy', $eks->id) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn-icon text-red"><i class="fas fa-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jenis Sampah</h3>
                <button onclick="openJenisSampahModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Jenis</button>
            </div>
            <div class="grid-container" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                @forelse($jenis_sampah as $jenis)
                <div class="grid-item flex-between">
                    <span>{{ $jenis->nama_jenis }}</span>
                    <div class="flex-gap">
                        <button onclick="openJenisSampahModal('{{ $jenis->id }}', '{{ addslashes($jenis->nama_jenis) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('jenis-sampah.destroy', $jenis->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn-icon text-red"><i class="fas fa-times"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray">Belum ada data</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Penerima Sampah</h3>
                <button onclick="openPenerimaModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Penerima</button>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead><tr><th>Nama Penerima</th><th>Alamat</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($daftar_penerima as $penerima)
                        <tr>
                            <td>{{ $penerima->nama_penerima }}</td>
                            <td>{{ $penerima->alamat ?? '-' }}</td>
                            <td>
                                <div class="flex-gap">
                                    <button onclick="openPenerimaModal('{{ $penerima->id }}', '{{ addslashes($penerima->nama_penerima) }}', '{{ addslashes($penerima->alamat) }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('daftar-penerima.destroy', $penerima->id) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn-icon text-red"><i class="fas fa-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(Auth::user()->role === 'ADMIN')
        <div id="content-pengguna-profile" class="hidden">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Pengguna</h3>
                    <button onclick="openUserModal()" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>

                <div style="padding: 0 20px 20px 20px;">
                    <form action="{{ route('profile.index') }}" method="GET" class="flex-gap">
                        <input type="text" name="search_user" value="{{ request('search_user') }}" 
                            placeholder="Cari nama atau email..." class="form-control" style="max-width: 300px;">
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
                        @if(request('search_user'))
                            <a href="{{ route('profile.index') }}" class="btn btn-danger">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($usersList as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td><span style="background:#dbeafe; color:#1e40af; padding:2px 8px; border-radius:4px; font-size:0.8rem;">{{ $u->role }}</span></td>
                                <td>
                                    <div class="flex-gap">
                                        <button onclick="openUserModal('{{ $u->id }}', '{{ $u->email }}')" class="btn-icon text-blue">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini? Akses mereka akan hilang.')">
                                            @csrf @method('DELETE')
                                            <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray">Tidak ada data pengguna found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>

<div id="modalLokasiWWTP" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalLokasiWWTPTitle" class="card-title">Form WWTP</h3>
            <button onclick="closeModal('modalLokasiWWTP')" class="btn-icon">&times;</button>
        </div>
        <form id="formWWTP" method="POST">
            @csrf <input type="hidden" id="wwtp_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Nama WWTP</label><input type="text" name="nama_wwtp" id="nama_wwtp" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Alamat</label><textarea name="alamat" id="alamat_wwtp" class="form-control" required></textarea></div>
                <div class="flex-gap">
                    <div class="form-group" style="flex:1"><label class="form-label">Latitude</label><input type="text" name="koordinat_lat" id="koordinat_lat_wwtp" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">Longitude</label><input type="text" name="koordinat_lng" id="koordinat_lng_wwtp" class="form-control"></div>
                </div>
                <div class="form-group"><label class="form-label">Kapasitas (m³)</label><input type="number" step="0.01" name="kapasitas_debit" id="kapasitas_debit" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLokasiWWTP')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitWWTP" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalOperatorWwtp" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header"><h3 id="modalOperatorWwtpTitle" class="card-title">Form Operator</h3><button onclick="closeModal('modalOperatorWwtp')" class="btn-icon">&times;</button></div>
        <form id="formOperator" method="POST">
            @csrf <input type="hidden" id="operator_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Nama Operator</label><input type="text" name="nama_operator" id="nama_operator" class="form-control" required></div>
            </div>
            <div class="modal-footer"><button type="button" onclick="closeModal('modalOperatorWwtp')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitOperator" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<div id="modalLab" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header"><h3 id="modalLabTitle" class="card-title">Form Lab</h3><button onclick="closeModal('modalLab')" class="btn-icon">&times;</button></div>
        <form id="formLab" method="POST">
            @csrf <input type="hidden" id="lab_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Nama Lab</label><input type="text" name="nama_lab" id="nama_lab" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Lokasi</label><input type="text" name="lokasi" id="lokasi" class="form-control" required></div>
            </div>
            <div class="modal-footer"><button type="button" onclick="closeModal('modalLab')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitLab" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<div id="modalTPS" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header"><h3 id="modalTPSTitle" class="card-title">Form TPS</h3><button onclick="closeModal('modalTPS')" class="btn-icon">&times;</button></div>
        <form id="formTPS" method="POST">
            @csrf <input type="hidden" id="tps_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group"><label class="form-label">Nama TPS</label><input type="text" name="nama_tps" id="nama_tps" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Alamat</label><textarea name="alamat" id="alamat_tps" class="form-control"></textarea></div>
                <div class="flex-gap">
                    <div class="form-group" style="flex:1"><label class="form-label">Lat</label><input type="text" name="koordinat_lat" id="koordinat_lat_tps" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">Lng</label><input type="text" name="koordinat_lng" id="koordinat_lng_tps" class="form-control"></div>
                </div>
                <div class="form-group"><label class="form-label">Kapasitas Max</label><input type="number" name="kapasitas_max" id="kapasitas_max" class="form-control"></div>
            </div>
            <div class="modal-footer"><button type="button" onclick="closeModal('modalTPS')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitTPS" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<div id="modalSatuanSampah" class="modal-overlay"><div class="modal-content"><div class="modal-header"><h3 id="modalSatuanSampahTitle">Form Satuan</h3><button onclick="closeModal('modalSatuanSampah')" class="btn-icon">&times;</button></div><form id="formSatuanSampah" method="POST">@csrf <input type="hidden" id="satuan_sampah_method" name="_method" value="POST"><div class="modal-body"><div class="form-group"><label class="form-label">Nama Satuan</label><input type="text" name="nama_satuan" id="nama_satuan" class="form-control" required></div></div><div class="modal-footer"><button type="button" onclick="closeModal('modalSatuanSampah')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitSatuanSampah" class="btn btn-primary">Simpan</button></div></form></div></div>

<div id="modalJenisSampah" class="modal-overlay"><div class="modal-content"><div class="modal-header"><h3 id="modalJenisSampahTitle">Form Jenis</h3><button onclick="closeModal('modalJenisSampah')" class="btn-icon">&times;</button></div><form id="formJenisSampah" method="POST">@csrf <input type="hidden" id="jenis_sampah_method" name="_method" value="POST"><div class="modal-body"><div class="form-group"><label class="form-label">Nama Jenis</label><input type="text" name="nama_jenis" id="nama_jenis" class="form-control" required></div></div><div class="modal-footer"><button type="button" onclick="closeModal('modalJenisSampah')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitJenisSampah" class="btn btn-primary">Simpan</button></div></form></div></div>

<div id="modalEkspedisi" class="modal-overlay"><div class="modal-content"><div class="modal-header"><h3 id="modalEkspedisiTitle">Form Ekspedisi</h3><button onclick="closeModal('modalEkspedisi')" class="btn-icon">&times;</button></div><form id="formEkspedisi" method="POST">@csrf <input type="hidden" id="ekspedisi_method" name="_method" value="POST"><div class="modal-body"><div class="form-group"><label class="form-label">Nama Ekspedisi</label><input type="text" name="nama_ekspedisi" id="nama_ekspedisi" class="form-control" required></div><div class="form-group"><label class="form-label">Alamat</label><textarea name="alamat" id="alamat_ekspedisi" class="form-control"></textarea></div></div><div class="modal-footer"><button type="button" onclick="closeModal('modalEkspedisi')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitEkspedisi" class="btn btn-primary">Simpan</button></div></form></div></div>

<div id="modalPenerimaSampah" class="modal-overlay"><div class="modal-content"><div class="modal-header"><h3 id="modalPenerimaSampahTitle">Form Penerima Sampah</h3><button onclick="closeModal('modalPenerimaSampah')" class="btn-icon">&times;</button></div><form id="formPenerimaSampah" method="POST">@csrf <input type="hidden" id="penerima_sampah_method" name="_method" value="POST"><div class="modal-body"><div class="form-group"><label class="form-label">Nama Penerima Sampah</label><input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required></div><div class="form-group"><label class="form-label">Alamat</label><textarea name="alamat" id="alamat_penerima_sampah" class="form-control"></textarea></div></div><div class="modal-footer"><button type="button" onclick="closeModal('modalPenerimaSampah')" class="btn btn-secondary">Batal</button><button type="submit" id="btnSubmitPenerimaSampah" class="btn btn-primary">Simpan</button></div></form></div></div>

@include('components.modals.form-pengguna')

@push('scripts')
<script>
    // Logic Tab
    function switchTabProfile(tab) {
        ['wwtp', 'tps-produksi', 'tps-domestik', 'pengguna'].forEach(t => {
           const btn = document.getElementById('tab-' + t + '-profile');
            const content = document.getElementById('content-' + t + '-profile');
        
            if(btn && content) {
                btn.classList.remove('active');
                content.classList.add('hidden');
            }
        });
        const activeBtn = document.getElementById('tab-' + tab + '-profile');
        const activeContent = document.getElementById('content-' + tab + '-profile');

        if(activeBtn && activeContent) {
            activeBtn.classList.add('active');
            activeContent.classList.remove('hidden');
        }
    }

    @if(request('search_user'))
        document.addEventListener("DOMContentLoaded", function() {
            switchTabProfile('pengguna');
        });
    @endif

    // Logic Modal CSS (Gunakan class 'show')
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
    }

    // --- POPUP FUNCTIONS (Logic Isi Form Sama Seperti Sebelumnya) ---
    function openWWTPModal(id = null, nama = '', alamat = '', lat = '', lng = '', kapasitas = '') {
        if (id) {
            document.getElementById('modalLokasiWWTPTitle').textContent = 'Edit WWTP';
            document.getElementById('btnSubmitWWTP').textContent = 'Update';
            document.getElementById('wwtp_method').value = 'PUT';
            document.getElementById('formWWTP').action = '/profile/wwtp/' + id;
            document.getElementById('nama_wwtp').value = nama;
            document.getElementById('alamat_wwtp').value = alamat;
            document.getElementById('koordinat_lat_wwtp').value = lat;
            document.getElementById('koordinat_lng_wwtp').value = lng;
            document.getElementById('kapasitas_debit').value = kapasitas;
        } else {
            document.getElementById('modalLokasiWWTPTitle').textContent = 'Tambah WWTP';
            document.getElementById('btnSubmitWWTP').textContent = 'Simpan';
            document.getElementById('wwtp_method').value = 'POST';
            document.getElementById('formWWTP').action = '{{ route("wwtp.store") }}';
            document.getElementById('formWWTP').reset();
        }
        openModal('modalLokasiWWTP');
    }

    function openOperatorModal(id = null, nama = '') {
        if (id) {
            document.getElementById('modalOperatorWwtpTitle').textContent = 'Edit Operator';
            document.getElementById('btnSubmitOperator').textContent = 'Update';
            document.getElementById('operator_method').value = 'PUT';
            document.getElementById('formOperator').action = '/profile/operator/' + id;
            document.getElementById('nama_operator').value = nama;
        } else {
            document.getElementById('modalOperatorWwtpTitle').textContent = 'Tambah Operator';
            document.getElementById('btnSubmitOperator').textContent = 'Simpan';
            document.getElementById('operator_method').value = 'POST';
            document.getElementById('formOperator').action = '{{ route("operator.store") }}';
            document.getElementById('formOperator').reset();
        }
        openModal('modalOperatorWwtp');
    }

    function openLabModal(id = null, nama = '', lokasi = '') {
        if (id) {
            document.getElementById('modalLabTitle').textContent = 'Edit Lab';
            document.getElementById('btnSubmitLab').textContent = 'Update';
            document.getElementById('lab_method').value = 'PUT';
            document.getElementById('formLab').action = '/profile/lab/' + id;
            document.getElementById('nama_lab').value = nama;
            document.getElementById('lokasi').value = lokasi;
        } else {
            document.getElementById('modalLabTitle').textContent = 'Tambah Lab';
            document.getElementById('btnSubmitLab').textContent = 'Simpan';
            document.getElementById('lab_method').value = 'POST';
            document.getElementById('formLab').action = '{{ route("lab.store") }}';
            document.getElementById('formLab').reset();
        }
        openModal('modalLab');
    }

    function openTPSModal(id = null, nama = '', alamat = '', lat = '', lng = '', kapasitas = '') {
        if (id) {
            document.getElementById('modalTPSTitle').textContent = 'Edit TPS';
            document.getElementById('btnSubmitTPS').textContent = 'Update';
            document.getElementById('tps_method').value = 'PUT';
            document.getElementById('formTPS').action = '/profile/tps/' + id;
            document.getElementById('nama_tps').value = nama;
            document.getElementById('alamat_tps').value = alamat;
            document.getElementById('koordinat_lat_tps').value = lat;
            document.getElementById('koordinat_lng_tps').value = lng;
            document.getElementById('kapasitas_max').value = kapasitas;
        } else {
            document.getElementById('modalTPSTitle').textContent = 'Tambah TPS';
            document.getElementById('btnSubmitTPS').textContent = 'Simpan';
            document.getElementById('tps_method').value = 'POST';
            document.getElementById('formTPS').action = '{{ route("tps.store") }}';
            document.getElementById('formTPS').reset();
        }
        openModal('modalTPS');
    }

    // (Fungsi untuk Satuan, Jenis, Ekspedisi ikuti pola yang sama)
    function openSatuanSampahModal(id=null, nama='') {
        if(id) {
            document.getElementById('modalSatuanSampahTitle').innerText = "Edit Satuan";
            document.getElementById('satuan_sampah_method').value = "PUT";
            document.getElementById('formSatuanSampah').action = "/profile/satuan-sampah/"+id;
            document.getElementById('nama_satuan').value = nama;
        } else {
            document.getElementById('modalSatuanSampahTitle').innerText = "Tambah Satuan";
            document.getElementById('satuan_sampah_method').value = "POST";
            document.getElementById('formSatuanSampah').action = "{{ route('satuan-sampah.store') }}";
            document.getElementById('formSatuanSampah').reset();
        }
        openModal('modalSatuanSampah');
    }

    function openJenisSampahModal(id=null, nama='') {
        if(id) {
            document.getElementById('modalJenisSampahTitle').innerText = "Edit Jenis";
            document.getElementById('jenis_sampah_method').value = "PUT";
            document.getElementById('formJenisSampah').action = "/profile/jenis-sampah/"+id;
            document.getElementById('nama_jenis').value = nama;
        } else {
            document.getElementById('modalJenisSampahTitle').innerText = "Tambah Jenis";
            document.getElementById('jenis_sampah_method').value = "POST";
            document.getElementById('formJenisSampah').action = "{{ route('jenis-sampah.store') }}";
            document.getElementById('formJenisSampah').reset();
        }
        openModal('modalJenisSampah');
    }

    function openPenerimaModal(id=null, nama='', alamat='') {
        if(id) {
            document.getElementById('modalPenerimaSampahTitle').innerText = "Edit Penerima";
            document.getElementById('penerima_sampah_method').value = "PUT";
            document.getElementById('formPenerimaSampah').action = "/profile/daftar-penerima/" + id;
            document.getElementById('nama_penerima').value = nama;
            document.getElementById('alamat_penerima_sampah').value = alamat;
        } else {
            document.getElementById('modalPenerimaSampahTitle').innerText = "Tambah Penerima";
            document.getElementById('penerima_sampah_method').value = "POST";
            document.getElementById('formPenerimaSampah').action = "{{ route('daftar-penerima.store') }}";
            document.getElementById('formPenerimaSampah').reset();
        }
        openModal('modalPenerimaSampah');
    }

    function openEkspedisiModal(id=null, nama='', alamat='') {
        if(id) {
            document.getElementById('modalEkspedisiTitle').innerText = "Edit Ekspedisi";
            document.getElementById('ekspedisi_method').value = "PUT";
            document.getElementById('formEkspedisi').action = "/profile/daftar-ekspedisi/"+id;
            document.getElementById('nama_ekspedisi').value = nama;
            document.getElementById('alamat_ekspedisi').value = alamat;
        } else {
            document.getElementById('modalEkspedisiTitle').innerText = "Tambah Ekspedisi";
            document.getElementById('ekspedisi_method').value = "POST";
            document.getElementById('formEkspedisi').action = "{{ route('daftar-ekspedisi.store') }}";
            document.getElementById('formEkspedisi').reset();
        }
        openModal('modalEkspedisi');
    }
</script>
@endpush
@endsection