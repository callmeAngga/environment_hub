<div id="modalSampahMasuk" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalMasukTitle" class="card-title">Tambah Sampah Masuk</h3>
            <button onclick="closeModal('modalSampahMasuk')" class="alert-close"
                style="position:static;">&times;</button>
        </div>

        <form id="formSampahMasuk" method="POST">
            @csrf
            <input type="hidden" id="masukMethod" name="_method" value="POST">
            <input type="hidden" id="masukId" name="id">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama TPS <span class="text-red">*</span></label>
                    <select name="tps_id" id="masukTps" required class="form-control">
                        <option value="">Pilih TPS</option>
                        @foreach($tpsList as $tps)
                        <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Tanggal <span class="text-red">*</span></label>
                        <input type="date" name="tanggal" id="masukTanggal" required value="{{ date('Y-m-d') }}"
                            class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Jumlah <span class="text-red">*</span></label>
                        <input type="number" step="1" name="jumlah_sampah" id="masukJumlah" required min="1"
                            class="form-control" placeholder="0">
                    </div>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Satuan <span class="text-red">*</span></label>
                        <select name="satuan_sampah_id" id="masukSatuan" required class="form-control">
                            <option value="">Pilih Satuan</option>
                            @foreach($satuanList as $satuan)
                            <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Jenis Sampah <span class="text-red">*</span></label>
                        <select name="jenis_sampah_id" id="masukJenis" required class="form-control">
                            <option value="">Pilih Jenis</option>
                            @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSampahMasuk')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
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
            console.error('Error:', error);
            alert('Gagal mengambil data');
        }
    }
</script>