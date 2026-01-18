<div id="modalTambahHarian" class="modal-overlay">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3 id="modalHarianTitle" class="card-title">Tambah Data Harian WWTP</h3>
            <button onclick="closeModal('modalTambahHarian')" class="alert-close" style="position:static;">&times;</button>
        </div>

        <form id="formDataHarian" method="POST">
            @csrf
            <input type="hidden" id="harianMethod" name="_method" value="POST">
            <input type="hidden" id="harianId" name="id">

            <div class="modal-body">
                <h4 class="form-label text-gray" style="border-bottom:1px solid #eee; margin-bottom:10px;">Informasi Dasar</h4>
                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Lokasi WWTP</label>
                        <select id="harian_wwtp_id" name="wwtp_id" required class="form-control">
                            <option value="">Pilih Lokasi</option>
                            @foreach($wwtps as $wwtp)
                            <option value="{{ $wwtp->id }}">{{ $wwtp->nama_wwtp }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Operator</label>
                        <select id="harian_operator_id" name="operator_id" required class="form-control">
                            <option value="">Pilih Operator</option>
                            @foreach($operators as $operator)
                            <option value="{{ $operator->id }}">{{ $operator->nama_operator }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Tanggal</label>
                        <input type="date" id="harian_tanggal" name="tanggal" required class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Waktu</label>
                        <input type="time" id="harian_waktu" name="waktu" required class="form-control">
                    </div>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Debit Inlet (m³)</label>
                        <input type="number" step="0.01" id="harian_debit_inlet" name="debit_inlet" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Debit Outlet (m³)</label>
                        <input type="number" step="0.01" id="harian_debit_outlet" name="debit_outlet" class="form-control">
                    </div>
                </div>

                <h4 class="form-label text-gray" style="border-bottom:1px solid #eee; margin-bottom:10px; margin-top:20px;">Ekualisasi</h4>
                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">pH 1</label>
                        <input type="number" step="0.1" id="harian_ph_ekualisasi_1" name="ph_ekualisasi_1" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">pH 2</label>
                        <input type="number" step="0.1" id="harian_ph_ekualisasi_2" name="ph_ekualisasi_2" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Suhu 1 (°C)</label>
                        <input type="number" step="0.1" id="harian_suhu_ekualisasi_1" name="suhu_ekualisasi_1" class="form-control">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Suhu 2 (°C)</label>
                        <input type="number" step="0.1" id="harian_suhu_ekualisasi_2" name="suhu_ekualisasi_2" class="form-control">
                    </div>
                </div>

                <h4 class="form-label text-gray" style="border-bottom:1px solid #eee; margin-bottom:10px; margin-top:20px;">Aerasi</h4>
                <div class="flex-gap">
                    <div class="form-group" style="flex:1"><label class="form-label">pH A1</label><input type="number" step="0.1" id="harian_ph_aerasi_1" name="ph_aerasi_1" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">pH A2</label><input type="number" step="0.1" id="harian_ph_aerasi_2" name="ph_aerasi_2" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">SV30 A1</label><input type="number" step="1" id="harian_sv30_aerasi_1" name="sv30_aerasi_1" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">SV30 A2</label><input type="number" step="1" id="harian_sv30_aerasi_2" name="sv30_aerasi_2" class="form-control"></div>
                </div>
                <div class="flex-gap">
                    <div class="form-group" style="flex:1"><label class="form-label">DO A1</label><input type="number" step="0.001" id="harian_do_aerasi_1" name="do_aerasi_1" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">DO A2</label><input type="number" step="0.001" id="harian_do_aerasi_2" name="do_aerasi_2" class="form-control"></div>
                    <div class="form-group" style="flex:1"><label class="form-label">pH Outlet</label><input type="number" step="0.1" id="harian_ph_outlet" name="ph_outlet" class="form-control"></div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label">Catatan</label>
                    <textarea id="harian_keterangan" name="keterangan" rows="2" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTambahHarian')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <span id="btnTextHarian">Simpan Data</span></button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalTambahHarian() {
        document.getElementById('modalHarianTitle').textContent = 'Tambah Data Harian WWTP';
        document.getElementById('btnTextHarian').textContent = 'Simpan Data';
        document.getElementById('harianMethod').value = 'POST';
        document.getElementById('formDataHarian').action = '{{ route("wwtp.harian.store") }}';
        document.getElementById('formDataHarian').reset();
        document.getElementById('harianId').value = '';
        
        const today = new Date().toISOString().split('T')[0];
        const now = new Date().toTimeString().slice(0, 5);
        document.getElementById('harian_tanggal').value = today;
        document.getElementById('harian_waktu').value = now;
        
        openModal('modalTambahHarian');
    }

    async function editDataHarian(id) {
        try {
            const response = await fetch(`/wwtp/data/harian/${id}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            document.getElementById('modalHarianTitle').textContent = 'Edit Data Harian WWTP';
            document.getElementById('btnTextHarian').textContent = 'Update Data';
            document.getElementById('harianMethod').value = 'PUT';
            document.getElementById('formDataHarian').action = `/wwtp/harian/${id}`;
            document.getElementById('harianId').value = id;

            let tanggal = '';
            if (data.tanggal) {
                if (typeof data.tanggal === 'string') tanggal = data.tanggal.split('T')[0];
                else if (data.tanggal instanceof Date) tanggal = data.tanggal.toISOString().split('T')[0];
            }

            document.getElementById('harian_wwtp_id').value = data.wwtp_id || '';
            document.getElementById('harian_operator_id').value = data.operator_id || '';
            document.getElementById('harian_tanggal').value = tanggal || '';
            document.getElementById('harian_waktu').value = data.waktu || '';
            document.getElementById('harian_debit_inlet').value = data.debit_inlet || '';
            document.getElementById('harian_debit_outlet').value = data.debit_outlet || '';
            document.getElementById('harian_ph_ekualisasi_1').value = data.ph_ekualisasi_1 || '';
            document.getElementById('harian_ph_ekualisasi_2').value = data.ph_ekualisasi_2 || '';
            document.getElementById('harian_suhu_ekualisasi_1').value = data.suhu_ekualisasi_1 || '';
            document.getElementById('harian_suhu_ekualisasi_2').value = data.suhu_ekualisasi_2 || '';
            document.getElementById('harian_ph_aerasi_1').value = data.ph_aerasi_1 || '';
            document.getElementById('harian_ph_aerasi_2').value = data.ph_aerasi_2 || '';
            document.getElementById('harian_sv30_aerasi_1').value = data.sv30_aerasi_1 || '';
            document.getElementById('harian_sv30_aerasi_2').value = data.sv30_aerasi_2 || '';
            document.getElementById('harian_do_aerasi_1').value = data.do_aerasi_1 || '';
            document.getElementById('harian_do_aerasi_2').value = data.do_aerasi_2 || '';
            document.getElementById('harian_ph_outlet').value = data.ph_outlet || '';
            document.getElementById('harian_keterangan').value = data.keterangan || '';

            openModal('modalTambahHarian');
        } catch (error) {
            console.error('Error fetching data:', error);
            alert('Gagal mengambil data untuk edit: ' + error.message);
        }
    }
</script>