@extends('layouts.app')

@section('title', 'TPS Produksi')

@section('content')
<div class="container">
    <div class="card-header" style="border:none; padding-left:0; padding-right:0;">
        <div>
            <h2 class="header-title" style="color: #333;">TPS Produksi</h2>
            <p class="text-gray" style="margin-top: 5px;">Kelola data sampah produksi masuk dan keluar</p>
        </div>
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
        <button onclick="switchTabProduksi('masuk')" id="tab-masuk" class="tab-btn active">Sampah Masuk</button>
        <button onclick="switchTabProduksi('keluar')" id="tab-keluar" class="tab-btn">Sampah Keluar</button>
    </div>

    <div id="filter-masuk" class="card" style="padding: 20px;">
        <form method="GET" action="{{ route('tps-produksi.index') }}" id="form-filter-masuk">
            <div class="filter-box">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_masuk_dari" id="tanggal_masuk_dari" value="{{ request('tanggal_masuk_dari') }}" class="form-control">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_masuk_sampai" id="tanggal_masuk_sampai" value="{{ request('tanggal_masuk_sampai') }}" class="form-control">
                </div>
                <div class="flex-gap">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="{{ route('tps-produksi.index') }}" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
                </div>
                <div>
                    <button type="button" onclick="exportMasukExcel()" class="btn btn-primary" style="width:100%"><i class="fas fa-file-excel"></i> Export Excel</button>
                </div>
            </div>
        </form>
    </div>

    <div id="content-masuk" class="card">
        <div class="card-header">
            <h3 class="card-title">Data Sampah Masuk</h3>
            <button onclick="openTambahMasuk()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama TPS</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Jenis</th>
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
                            <div class="flex-gap">
                                <button onclick="openEditMasuk('{{ $item->id }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('tps-produksi.masuk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-gray">Belum ada data sampah masuk</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="filter-keluar" class="card hidden" style="padding: 20px;">
        <form method="GET" action="{{ route('tps-produksi.index') }}" id="form-filter-keluar">
            <div class="filter-box">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_keluar_dari" id="tanggal_keluar_dari" value="{{ request('tanggal_keluar_dari') }}" class="form-control">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_keluar_sampai" id="tanggal_keluar_sampai" value="{{ request('tanggal_keluar_sampai') }}" class="form-control">
                </div>
                <div class="flex-gap">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="{{ route('tps-produksi.index') }}" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
                </div>
                <div>
                    <button type="button" onclick="exportKeluarExcel()" class="btn btn-primary" style="width:100%"><i class="fas fa-file-excel"></i> Export Excel</button>
                </div>
            </div>
        </form>
    </div>

    <div id="content-keluar" class="card hidden">
        <div class="card-header">
            <h3 class="card-title">Data Sampah Keluar</h3>
            <button onclick="openTambahKeluar()" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama TPS</th>
                        <th>No. Sampah</th>
                        <th>Tanggal</th>
                        <th>Ekspedisi</th>
                        <th>No. Polisi</th>
                        <th>Berat Bersih (kg)</th>
                        <th>Jenis</th>
                        <th>Penerima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataKeluar as $item)
                    <tr>
                        <td>{{ $item->tps->nama_tps ?? '-' }}</td>
                        <td>{{ $item->no_sampah_keluar }}</td>
                        <td>{{ $item->tanggal_pengangkutan ? $item->tanggal_pengangkutan->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->ekspedisi->nama_ekspedisi ?? '-' }}</td>
                        <td>{{ $item->no_kendaraan }}</td>
                        <td style="color: #16a34a; font-weight:bold;">{{ number_format($item->berat_isi_kg - $item->berat_kosong_kg, 2, ',', '.') }}</td>
                        <td>{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>
                        <td>{{ $item->penerima->nama_penerima ?? '-' }}</td>
                        <td>
                            <div class="flex-gap">
                                <a href="{{ route('tps-produksi.export.single.pdf', $item->id) }}" class="btn-icon text-red" target="_blank" title="PDF"><i class="fas fa-file-pdf"></i></a>
                                <button onclick="openEditKeluar('{{ $item->id }}')" class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('tps-produksi.keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-gray">Belum ada data sampah keluar</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('components.modals.form-tps-produksi-masuk')

@include('components.modals.form-tps-produksi-keluar')

@push('scripts')
<script>
    // Logic Tab
    function switchTabProduksi(tab) {
        ['masuk', 'keluar'].forEach(t => {
            document.getElementById('tab-' + t).classList.remove('active');
            document.getElementById('content-' + t).classList.add('hidden');
            document.getElementById('filter-' + t).classList.add('hidden');
        });

        document.getElementById('tab-' + tab).classList.add('active');
        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('filter-' + tab).classList.remove('hidden');
    }

    // Logic Export
    function exportMasukExcel() {
        const dari = document.getElementById('tanggal_masuk_dari').value;
        const sampai = document.getElementById('tanggal_masuk_sampai').value;
        let url = '{{ route("tps-produksi.export.masuk.excel") }}';
        const params = new URLSearchParams();
        if (dari) params.append('tanggal_masuk_dari', dari);
        if (sampai) params.append('tanggal_masuk_sampai', sampai);
        if (params.toString()) url += '?' + params.toString();
        window.location.href = url;
    }

    function exportKeluarExcel() {
        const dari = document.getElementById('tanggal_keluar_dari').value;
        const sampai = document.getElementById('tanggal_keluar_sampai').value;
        let url = '{{ route("tps-produksi.export.keluar.excel") }}';
        const params = new URLSearchParams();
        if (dari) params.append('tanggal_keluar_dari', dari);
        if (sampai) params.append('tanggal_keluar_sampai', sampai);
        if (params.toString()) url += '?' + params.toString();
        window.location.href = url;
    }

    // Logic Modal (Global)
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
    }
</script>
@endpush
@endsection