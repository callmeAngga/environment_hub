@extends('layouts.app')

@section('title', 'TPS Produksi')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tempat Penampungan Sementara Produksi</h2>
            <p class="text-gray-600 text-sm mt-1">Kelola data sampah produksi masuk dan keluar</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-8">
            <button onclick="switchTabProduksi('masuk')" id="tab-masuk" class="py-3 px-1 border-b-2 border-green-600 text-green-600 font-medium">
                Sampah Masuk
            </button>
            <button onclick="switchTabProduksi('keluar')" id="tab-keluar" class="py-3 px-1 border-b-2 border-transparent text-gray-600 hover:text-green-600">
                Sampah Keluar
            </button>
        </nav>
    </div>

    <!-- Filter & Export untuk Sampah Masuk -->
    <div id="filter-masuk" class="bg-white rounded-lg shadow p-4 mb-4">
        <form method="GET" action="{{ route('tps-produksi.index') }}" id="form-filter-masuk">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                    <input type="date" name="tanggal_masuk_dari" id="tanggal_masuk_dari" 
                           value="{{ request('tanggal_masuk_dari') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                    <input type="date" name="tanggal_masuk_sampai" id="tanggal_masuk_sampai" 
                           value="{{ request('tanggal_masuk_sampai') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('tps-produksi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
                <div>
                    <button type="button" onclick="exportMasukExcel()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Filter & Export untuk Sampah Keluar -->
    <div id="filter-keluar" class="bg-white rounded-lg shadow p-4 mb-4 hidden">
        <form method="GET" action="{{ route('tps-produksi.index') }}" id="form-filter-keluar">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                    <input type="date" name="tanggal_keluar_dari" id="tanggal_keluar_dari" 
                           value="{{ request('tanggal_keluar_dari') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                    <input type="date" name="tanggal_keluar_sampai" id="tanggal_keluar_sampai" 
                           value="{{ request('tanggal_keluar_sampai') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('tps-produksi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
                <div>
                    <button type="button" onclick="exportKeluarExcel()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sampah Masuk -->
    <div id="content-masuk" class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Data Sampah Masuk</h3>
            <button onclick="openTambahMasuk()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Nama TPS</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Tanggal</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Jumlah Sampah</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Satuan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Jenis Sampah</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataMasuk as $index => $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $item->tps->nama_tps ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3">{{ number_format($item->jumlah_sampah, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $item->satuanSampah->nama_satuan ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <button onclick="openEditMasuk('{{ $item->id }}')" class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('tps-produksi.masuk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Belum ada data sampah masuk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sampah Keluar -->
    <div id="content-keluar" class="bg-white rounded-lg shadow overflow-hidden hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Data Sampah Keluar</h3>
            <button onclick="openTambahKeluar()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Nama TPS</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">No. Sampah Keluar</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Tanggal</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Ekspedisi</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">No. Kendaraan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Berat Kosong (kg)</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Berat Isi (kg)</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Berat Bersih (kg)</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Jenis Sampah</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Penerima</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataKeluar as $index => $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $item->tps->nama_tps ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->no_sampah_keluar }}</td>
                        <td class="px-4 py-3">{{ $item->tanggal_pengangkutan ? $item->tanggal_pengangkutan->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3">{{ $item->ekspedisi->nama_ekspedisi ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->no_kendaraan }}</td>
                        <td class="px-4 py-3">{{ number_format($item->berat_kosong_kg, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ number_format($item->berat_isi_kg, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 font-semibold text-green-600">{{ number_format($item->berat_isi_kg - $item->berat_kosong_kg, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $item->jenisSampah->nama_jenis ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->penerima->nama_penerima ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('tps-produksi.export.single.pdf', $item->id) }}" 
                                   class="text-red-600 hover:text-red-800" 
                                   title="Download Surat Pengiriman (PDF)"
                                   target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <button onclick="openEditKeluar('{{ $item->id }}')" class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('tps-produksi.keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Belum ada data sampah keluar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Sampah Produksi Masuk -->
@include('components.modals.form-tps-produksi-masuk')

<!-- Modal Sampah Produksi Keluar -->
@include('components.modals.form-tps-produksi-keluar')

@push('scripts')
<script>
    function switchTabProduksi(tab) {
        ['masuk', 'keluar'].forEach(t => {
            document.getElementById('tab-' + t).classList.remove('border-green-600', 'text-green-600');
            document.getElementById('tab-' + t).classList.add('border-transparent', 'text-gray-600');
            document.getElementById('content-' + t).classList.add('hidden');
            document.getElementById('filter-' + t).classList.add('hidden');
        });

        document.getElementById('tab-' + tab).classList.add('border-green-600', 'text-green-600');
        document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-600');
        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('filter-' + tab).classList.remove('hidden');
    }

    function exportMasukExcel() {
        const tanggalDari = document.getElementById('tanggal_masuk_dari').value;
        const tanggalSampai = document.getElementById('tanggal_masuk_sampai').value;
        
        let url = '{{ route("tps-produksi.export.masuk.excel") }}';
        const params = new URLSearchParams();
        
        if (tanggalDari) params.append('tanggal_masuk_dari', tanggalDari);
        if (tanggalSampai) params.append('tanggal_masuk_sampai', tanggalSampai);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.location.href = url;
    }

    function exportKeluarExcel() {
        const tanggalDari = document.getElementById('tanggal_keluar_dari').value;
        const tanggalSampai = document.getElementById('tanggal_keluar_sampai').value;
        
        let url = '{{ route("tps-produksi.export.keluar.excel") }}';
        const params = new URLSearchParams();
        
        if (tanggalDari) params.append('tanggal_keluar_dari', tanggalDari);
        if (tanggalSampai) params.append('tanggal_keluar_sampai', tanggalSampai);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.location.href = url;
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.add('flex');
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    });
</script>
@endpush
@endsection