<!-- Modal Sampah Produksi Keluar -->
<div id="modalSampahKeluar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4 my-8">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 id="modalKeluarTitle" class="text-xl font-bold text-gray-800">Tambah Sampah Keluar</h3>
            <button onclick="closeModal('modalSampahKeluar')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="formSampahKeluar" method="POST" class="p-6">
            @csrf
            <input type="hidden" id="keluarMethod" name="_method" value="POST">
            <input type="hidden" id="keluarId" name="id">

            <div class="max-h-[65vh] overflow-y-auto pr-2">

                <!-- ===== BAGIAN AWAL (TANPA TITLE) ===== -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama TPS *</label>
                            <select name="tps_id" id="keluarTps" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih TPS</option>
                                @foreach($tpsList as $tps)
                                <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Sampah Keluar *</label>
                            <input type="text" name="no_sampah_keluar" id="keluarNomor" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan nomor sampah keluar">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengangkutan *</label>
                            <input type="date" name="tanggal_pengangkutan" id="keluarTanggal" required
                                value="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ekspedisi *</label>
                            <select name="ekspedisi_id" id="keluarEkspedisi" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih Ekspedisi</option>
                                @foreach($ekspedisiList as $ekspedisi)
                                <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->nama_ekspedisi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kendaraan *</label>
                            <input type="text" name="no_kendaraan" id="keluarKendaraan" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="B 1234 XYZ">
                        </div>

                    </div>
                </div>

                <!-- ===== BERAT ===== -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Berat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berat Kosong (kg) *</label>
                            <input type="number" step="0.01" name="berat_kosong_kg" id="keluarBeratKosong" required min="0"
                                oninput="hitungBeratBersihKeluar()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berat Isi (kg) *</label>
                            <input type="number" step="0.01" name="berat_isi_kg" id="keluarBeratIsi" required min="0"
                                oninput="hitungBeratBersihKeluar()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="0.00">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berat Bersih (kg)</label>
                            <input type="text" id="keluarBeratBersih" readonly
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">Otomatis: Berat Isi - Berat Kosong</p>
                        </div>

                    </div>
                </div>

                <!-- ===== INFORMASI SAMPAH & PENERIMA ===== -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">
                        Informasi Sampah & Penerima
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Sampah *</label>
                            <select name="jenis_sampah_id" id="keluarJenisSampah" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih Jenis Sampah</option>
                                @foreach($jenisList as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima *</label>
                            <select name="penerima_id" id="keluarPenerima" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih Penerima</option>
                                @foreach($penerimaList as $penerima)
                                <option value="{{ $penerima->id }}">{{ $penerima->nama_penerima }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

            </div>


            <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                <button type="button" onclick="closeModal('modalSampahKeluar')"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function hitungBeratBersihKeluar() {
        const kosong = parseFloat(document.getElementById('keluarBeratKosong').value) || 0;
        const isi = parseFloat(document.getElementById('keluarBeratIsi').value) || 0;
        const bersih = isi - kosong;
        document.getElementById('keluarBeratBersih').value = bersih >= 0 ? bersih.toFixed(2) : '0.00';
    }

    function openTambahKeluar() {
        document.getElementById('modalKeluarTitle').textContent = 'Tambah Sampah Keluar';
        document.getElementById('formSampahKeluar').action = "{{ route('tps-produksi.keluar.store') }}";
        document.getElementById('keluarMethod').value = 'POST';
        document.getElementById('formSampahKeluar').reset();
        document.getElementById('keluarId').value = '';
        document.getElementById('keluarTanggal').value = "{{ date('Y-m-d') }}";
        document.getElementById('keluarBeratBersih').value = '0.00';

        openModal('modalSampahKeluar');
    }

    async function openEditKeluar(id) {
        try {
            const response = await fetch(`/tps-produksi/data/keluar/${id}`);
            const data = await response.json();
            
            document.getElementById('modalKeluarTitle').textContent = 'Edit Sampah Keluar';
            document.getElementById('formSampahKeluar').action = `/tps-produksi/keluar/${id}`;
            document.getElementById('keluarMethod').value = 'PUT';
            document.getElementById('keluarId').value = id;

            document.getElementById('keluarTps').value = data.tps_id;
            document.getElementById('keluarNomor').value = data.no_sampah_keluar;
            document.getElementById('keluarTanggal').value = data.tanggal_pengangkutan;
            document.getElementById('keluarEkspedisi').value = data.ekspedisi_id;
            document.getElementById('keluarKendaraan').value = data.no_kendaraan;
            document.getElementById('keluarBeratKosong').value = data.berat_kosong_kg;
            document.getElementById('keluarBeratIsi').value = data.berat_isi_kg;
            document.getElementById('keluarJenisSampah').value = data.jenis_sampah_id;
            document.getElementById('keluarPenerima').value = data.penerima_id;

            hitungBeratBersihKeluar();

            openModal('modalSampahKeluar');
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data untuk edit');
        }
    }
</script>