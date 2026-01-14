<div id="modalSampahMasuk" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 my-8">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 id="modalMasukTitle" class="text-xl font-bold text-gray-800">Tambah Sampah Masuk</h3>
            <button onclick="closeModal('modalSampahMasuk')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="formSampahMasuk" method="POST" class="p-6">
            @csrf
            <input type="hidden" id="masukMethod" name="_method" value="POST">
            <input type="hidden" id="masukId" name="id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama TPS *</label>
                    <select name="tps_id" id="masukTps" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Pilih TPS</option>
                        @foreach($tpsList as $tps)
                        <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                    <input type="date" name="tanggal" id="masukTanggal" required
                        value="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Sampah *</label>
                    <input type="number" step="1" name="jumlah_sampah" id="masukJumlah" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Satuan Sampah *</label>
                    <select name="satuan_sampah_id" id="masukSatuan" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Pilih Satuan</option>
                        @foreach($satuanList as $satuan)
                        <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Sampah *</label>
                    <select name="jenis_sampah_id" id="masukJenis" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Pilih Jenis Sampah</option>
                        @foreach($jenisList as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                <button type="button" onclick="closeModal('modalSampahMasuk')"
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
    function openTambahMasuk() {
        document.getElementById('modalMasukTitle').textContent = 'Tambah Sampah Masuk';
        document.getElementById('formSampahMasuk').action = "{{ route('tps-produksi.masuk.store') }}";
        document.getElementById('masukMethod').value = 'POST';
        document.getElementById('formSampahMasuk').reset();
        document.getElementById('masukId').value = '';
        document.getElementById('masukTanggal').value = "{{ date('Y-m-d') }}";

        openModal('modalSampahMasuk');
    }

    async function openEditMasuk(id) {
        try {
            const response = await fetch(`/tps-produksi/data/masuk/${id}`);
            const data = await response.json();

            document.getElementById('modalMasukTitle').textContent = 'Edit Sampah Masuk';
            document.getElementById('formSampahMasuk').action = `/tps-produksi/masuk/${id}`;
            document.getElementById('masukMethod').value = 'PUT';
            document.getElementById('masukId').value = id;

            document.getElementById('masukTps').value = data.tps_id;
            document.getElementById('masukTanggal').value = data.tanggal;
            document.getElementById('masukJumlah').value = data.jumlah_sampah;
            document.getElementById('masukSatuan').value = data.satuan_sampah_id;
            document.getElementById('masukJenis').value = data.jenis_sampah_id;

            openModal('modalSampahMasuk');
        } catch (error) {
            console.error('Error detail:', error);
            alert('Gagal mengambil data untuk edit: ' + error.message);
        }
    }
</script>