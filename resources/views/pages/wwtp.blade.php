@extends('layouts.app')

@section('title', 'WWTP - Sistem Manajemen Data Lingkungan')

@section('content')

<div class="container">
    {{-- Alert Messages --}}
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

    {{-- Page Header --}}
    <div class="page-header-modern">
        <div class="header-top compact">
            <div class="header-icon wwtp">
                <i class="fas fa-tint"></i>
            </div>

            <div class="header-text">
                <h2 class="page-title-main">Waste Water Treatment Plant (WWTP)</h2>
                <p class="page-subtitle-main">
                    Kelola data monitoring pengolahan air limbah dengan sistem tracking harian dan bulanan
                </p>
            </div>
        </div>
    </div>


    {{-- Tabs Navigation --}}
    <div class="page-tabs">
        <button onclick="switchTabWWTP('harian')" id="tab-harian" class="page-tab-btn active">
            <i class="fas fa-calendar-day"></i>
            <span>Data Harian</span>
        </button>
        <button onclick="switchTabWWTP('bulanan')" id="tab-bulanan" class="page-tab-btn">
            <i class="fas fa-calendar-alt"></i>
            <span>Data Bulanan</span>
        </button>
    </div>

    {{-- DATA HARIAN SECTION --}}
    <div id="content-harian" class="data-section">
        <div class="filter-actions-bar">
            <form method="GET" action="{{ route('wwtp.index') }}" class="filter-inputs" id="filter-harian">
                <input type="hidden" name="sort_harian" id="input-sort-harian" value="{{ request('sort_harian', 'asc') }}">

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
                <button type="submit" form="filter-harian" class="btn-modern btn-filter">
                    <i class="fas fa-filter"></i> <span>Filter</span>
                </button>
                <form action="{{ route('wwtp.index') }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn-modern btn-reset">
                        <i class="fas fa-redo"></i> <span>Reset</span>
                    </button>
                </form>
                <!-- <button onclick="toggleSortHarian()" class="btn-modern btn-sort" id="btn-sort-harian">
                    <i class="fas fa-sort-amount-{{ request('sort_harian', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                    <span>{{ request('sort_harian', 'asc') === 'asc' ? 'Terlama' : 'Terbaru' }}</span>
                </button> -->
                <button onclick="exportHarianExcel()" class="btn-modern btn-export">
                    <i class="fas fa-file-excel"></i> <span>Export</span>
                </button>
                <button onclick="openModalTambahHarian()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Data</span>
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table-modern">
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
                            <div class="action-buttons-stacked">
                                <button onclick="editDataHarian('{{ $harian->id }}')" class="btn-table btn-table-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button
                                    class="btn-table btn-table-delete"
                                    data-type="harian"
                                    data-id="{{ $harian->id }}"
                                    data-label="{{ ($harian->wwtp->nama_wwtp ?? 'Data') . ' - ' . $harian->tanggal->format('d/m/Y') }}"
                                    onclick="confirmDeleteWWTP(this)">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="19" class="table-empty-modern">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data harian</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DATA BULANAN SECTION --}}
    <div id="content-bulanan" class="data-section hidden">
        <div class="filter-actions-bar">
            <form method="GET" action="{{ route('wwtp.index') }}" class="filter-inputs" id="filter-bulanan">
                <input type="hidden" name="sort_bulanan" id="input-sort-bulanan" value="{{ request('sort_bulanan', 'asc') }}">

                <div class="filter-group-inline">
                    <label class="filter-label-inline">Bulan Dari</label>
                    <select name="bulan_dari" id="bulan_dari" class="filter-select-inline">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan_dari') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                            @endfor
                    </select>
                </div>
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tahun Dari</label>
                    <select name="tahun_dari" id="tahun_dari" class="filter-select-inline">
                        <option value="">Pilih Tahun</option>
                        @for($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request('tahun_dari') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Bulan Sampai</label>
                    <select name="bulan_sampai" id="bulan_sampai" class="filter-select-inline">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan_sampai') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                            @endfor
                    </select>
                </div>
                <div class="filter-group-inline">
                    <label class="filter-label-inline">Tahun Sampai</label>
                    <select name="tahun_sampai" id="tahun_sampai" class="filter-select-inline">
                        <option value="">Pilih Tahun</option>
                        @for($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request('tahun_sampai') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </form>
            <div class="action-buttons-group">
                <button type="submit" form="filter-bulanan" class="btn-modern btn-filter">
                    <i class="fas fa-filter"></i> <span>Filter</span>
                </button>
                <form action="{{ route('wwtp.index') }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn-modern btn-reset">
                        <i class="fas fa-redo"></i> <span>Reset</span>
                    </button>
                </form>
                <!-- <button onclick="toggleSortBulanan()" class="btn-modern btn-sort" id="btn-sort-bulanan">
                    <i class="fas fa-sort-amount-{{ request('sort_bulanan', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                    <span>{{ request('sort_bulanan', 'asc') === 'asc' ? 'Terlama' : 'Terbaru' }}</span>
                </button> -->
                <button onclick="exportBulananExcel()" class="btn-modern btn-export">
                    <i class="fas fa-file-excel"></i> <span>Export</span>
                </button>
                <button onclick="openModalTambahBulanan()" class="btn-modern btn-add">
                    <i class="fas fa-plus"></i> <span>Tambah Data</span>
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Lokasi</th>
                        <th>Lab</th>
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
                        <td>{{ $bulanan->lab->nama_lab ?? '-' }}</td>
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
                            <div class="action-buttons-stacked">
                                <button onclick="editDataBulanan('{{ $bulanan->id }}')" class="btn-table btn-table-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button
                                    class="btn-table btn-table-delete"
                                    data-type="bulanan"
                                    data-id="{{ $bulanan->id }}"
                                    data-label="{{ ($bulanan->wwtp->nama_wwtp ?? 'Data') . ' - ' . $bulanan->bulan_tahun }}"
                                    onclick="confirmDeleteWWTP(this)">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="table-empty-modern">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data bulanan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('components.form-wwtp-harian')
@include('components.form-wwtp-bulanan')
@include('components.delete-confirmation')

@endsection

@push('scripts')
<script src="{{ asset('js/data-pages-common.js') }}"></script>
<script src="{{ asset('js/wwtp.js') }}"></script>
@endpush