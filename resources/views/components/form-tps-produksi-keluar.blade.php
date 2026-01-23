<div id="modalSampahKeluar" class="modal-overlay">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3 id="modalKeluarTitle" class="card-title">Tambah Sampah Keluar</h3>
            <button onclick="closeModal('modalSampahKeluar')" class="alert-close"
                style="position:static;">&times;</button>
        </div>

        <form id="formSampahKeluar" method="POST">
            @csrf
            <input type="hidden" id="keluarMethod" name="_method" value="POST">
            <input type="hidden" id="keluarId" name="id">

            <div class="modal-body">
                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Nama TPS <span class="text-red">*</span></label>
                        <select name="tps_id" id="keluarTps" required class="form-control">
                            <option value="">Pilih TPS</option>
                            @foreach($tpsList as $tps)
                            <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">No. Sampah Keluar <span class="text-red">*</span></label>
                        <input type="text" name="no_sampah_keluar" id="keluarNomor" required class="form-control">
                    </div>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Tanggal Angkut <span class="text-red">*</span></label>
                        <input type="date" name="tanggal_pengangkutan" id="keluarTanggal" required
                            value="{{ date('Y-m-d') }}" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Ekspedisi <span class="text-red">*</span></label>
                        <select name="ekspedisi_id" id="keluarEkspedisi" required class="form-control">
                            <option value="">Pilih Ekspedisi</option>
                            @foreach($ekspedisiList as $ekspedisi)
                            <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->nama_ekspedisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">No. Kendaraan <span class="text-red">*</span></label>
                    <input type="text" name="no_kendaraan" id="keluarKendaraan" required class="form-control"
                        placeholder="B 1234 XYZ">
                </div>

                <h4 class="mt-4 mb-4" style="border-bottom:1px solid #eee; padding-bottom:5px; color:#555;">Berat (kg)
                </h4>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Berat Kosong</label>
                        <input type="number" step="0.01" name="berat_kosong_kg" id="keluarBeratKosong" required min="0"
                            oninput="hitungBeratBersihKeluar()" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Berat Isi</label>
                        <input type="number" step="0.01" name="berat_isi_kg" id="keluarBeratIsi" required min="0"
                            oninput="hitungBeratBersihKeluar()" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Berat Bersih</label>
                        <input type="text" id="keluarBeratBersih" readonly class="form-control"
                            style="background-color:#f3f4f6; font-weight:bold; color:#16a34a;">
                    </div>
                </div>

                <h4 class="mt-4 mb-4" style="border-bottom:1px solid #eee; padding-bottom:5px; color:#555;">Info Lain
                </h4>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Jenis Sampah <span class="text-red">*</span></label>
                        <select name="jenis_sampah_id" id="keluarJenisSampah" required class="form-control">
                            <option value="">Pilih Jenis</option>
                            @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Penerima <span class="text-red">*</span></label>
                        <select name="penerima_id" id="keluarPenerima" required class="form-control">
                            <option value="">Pilih Penerima</option>
                            @foreach($penerimaList as $penerima)
                            <option value="{{ $penerima->id }}">{{ $penerima->nama_penerima }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSampahKeluar')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
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
            alert('Gagal mengambil data');
        }
    }
</script>