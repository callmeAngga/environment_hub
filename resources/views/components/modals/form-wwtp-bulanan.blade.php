<div id="modalTambahBulanan" class="modal-overlay">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3 id="modalBulananTitle" class="card-title">Tambah Data Bulanan WWTP</h3>
            <button onclick="closeModal('modalTambahBulanan')" class="alert-close" style="position:static;">&times;</button>
        </div>

        <form id="formDataBulanan" method="POST">
            @csrf
            <input type="hidden" id="bulananMethod" name="_method" value="POST">

            <div class="modal-body">
                <div class="flex-gap mb-4">
                    <div class="form-group" style="flex:2">
                        <label class="form-label">Lokasi WWTP</label>
                        <select id="bulanan_wwtp_id" name="wwtp_id" required class="form-control">
                            <option value="">Pilih Lokasi</option>
                            @foreach($wwtps as $wwtp)
                            <option value="{{ $wwtp->id }}">{{ $wwtp->nama_wwtp }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Bulan</label>
                        <select id="bulanan_bulan" name="bulan" required class="form-control">
                            @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Tahun</label>
                        <input type="number" id="bulanan_tahun" name="tahun" required value="{{ date('Y') }}" class="form-control">
                    </div>
                </div>

                <div class="grid-container" style="grid-template-columns: 1fr 1fr;">
                    <div class="grid-item">
                        <h4 class="form-label">TSS (mg/L)</h4>
                        <div class="flex-gap">
                            <input type="number" step="0.01" id="bulanan_tss_inlet" name="tss_inlet" placeholder="Inlet" class="form-control">
                            <input type="number" step="0.01" id="bulanan_tss_outlet" name="tss_outlet" placeholder="Outlet" class="form-control">
                        </div>
                    </div>
                    <div class="grid-item">
                        <h4 class="form-label">TDS (mg/L)</h4>
                        <div class="flex-gap">
                            <input type="number" step="0.01" id="bulanan_tds_inlet" name="tds_inlet" placeholder="Inlet" class="form-control">
                            <input type="number" step="0.01" id="bulanan_tds_outlet" name="tds_outlet" placeholder="Outlet" class="form-control">
                        </div>
                    </div>
                    <div class="grid-item">
                        <h4 class="form-label">BOD (mg/L)</h4>
                        <div class="flex-gap">
                            <input type="number" step="0.01" id="bulanan_bod_inlet" name="bod_inlet" placeholder="Inlet" class="form-control">
                            <input type="number" step="0.01" id="bulanan_bod_outlet" name="bod_outlet" placeholder="Outlet" class="form-control">
                        </div>
                    </div>
                    <div class="grid-item">
                        <h4 class="form-label">COD (mg/L)</h4>
                        <div class="flex-gap">
                            <input type="number" step="0.01" id="bulanan_cod_inlet" name="cod_inlet" placeholder="Inlet" class="form-control">
                            <input type="number" step="0.01" id="bulanan_cod_outlet" name="cod_outlet" placeholder="Outlet" class="form-control">
                        </div>
                    </div>
                    <div class="grid-item" style="grid-column: 1/-1;">
                        <h4 class="form-label">Minyak Lemak (mg/L)</h4>
                        <div class="flex-gap">
                            <input type="number" step="0.01" id="bulanan_minyak_lemak_inlet" name="minyak_lemak_inlet" placeholder="Inlet" class="form-control">
                            <input type="number" step="0.01" id="bulanan_minyak_lemak_outlet" name="minyak_lemak_outlet" placeholder="Outlet" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTambahBulanan')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <span id="btnTextBulanan">Simpan Data</span></button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalTambahBulanan() {
        document.getElementById('modalBulananTitle').textContent = 'Tambah Data Bulanan';
        document.getElementById('btnTextBulanan').textContent = 'Simpan Data';
        document.getElementById('bulananMethod').value = 'POST';
        document.getElementById('formDataBulanan').action = '{{ route("wwtp.bulanan.store") }}';
        document.getElementById('formDataBulanan').reset();
        openModal('modalTambahBulanan');
    }

    async function editDataBulanan(id) {
        try {
            const response = await fetch(`/wwtp/data/bulanan/${id}`);
            const data = await response.json();

            document.getElementById('modalBulananTitle').textContent = 'Edit Data Bulanan';
            document.getElementById('btnTextBulanan').textContent = 'Update Data';
            document.getElementById('bulananMethod').value = 'PUT';
            document.getElementById('formDataBulanan').action = `/wwtp/bulanan/${id}`;

            document.getElementById('bulanan_wwtp_id').value = data.wwtp_id;
            document.getElementById('bulanan_bulan').value = data.bulan;
            document.getElementById('bulanan_tahun').value = data.tahun;
            document.getElementById('bulanan_tss_inlet').value = data.tss_inlet || '';
            document.getElementById('bulanan_tss_outlet').value = data.tss_outlet || '';
            document.getElementById('bulanan_tds_inlet').value = data.tds_inlet || '';
            document.getElementById('bulanan_tds_outlet').value = data.tds_outlet || '';
            document.getElementById('bulanan_bod_inlet').value = data.bod_inlet || '';
            document.getElementById('bulanan_bod_outlet').value = data.bod_outlet || '';
            document.getElementById('bulanan_cod_inlet').value = data.cod_inlet || '';
            document.getElementById('bulanan_cod_outlet').value = data.cod_outlet || '';
            document.getElementById('bulanan_minyak_lemak_inlet').value = data.minyak_lemak_inlet || '';
            document.getElementById('bulanan_minyak_lemak_outlet').value = data.minyak_lemak_outlet || '';

            openModal('modalTambahBulanan');
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data');
        }
    }
</script>