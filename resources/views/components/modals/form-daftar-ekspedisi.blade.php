<div id="modalEkspedisi" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalEkspedisiTitle" class="card-title">Tambah Ekspedisi</h3>
            <button onclick="closeModal('modalEkspedisi')" class="alert-close" style="position:static;">&times;</button>
        </div>

        <form id="formEkspedisi" method="POST">
            @csrf
            <input type="hidden" id="ekspedisi_method" name="_method" value="POST">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Ekspedisi <span class="text-red">*</span></label>
                    <input type="text" name="nama_ekspedisi" id="nama_ekspedisi" required class="form-control"
                        placeholder="Masukkan nama ekspedisi">
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_ekspedisi" rows="3" class="form-control"
                        placeholder="Masukkan alamat ekspedisi"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalEkspedisi')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitEkspedisi" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- <script>
    function openEkspedisiModal(id = null, nama = '', alamat = '') {
        if (id) {
            document.getElementById('modalEkspedisiTitle').textContent = 'Edit Ekspedisi';
            document.getElementById('btnSubmitEkspedisi').textContent = 'Update';
            document.getElementById('ekspedisi_method').value = 'PUT';
            document.getElementById('formEkspedisi').action = '/profile/daftar-ekspedisi/' + id;
            document.getElementById('nama_ekspedisi').value = nama;
            document.getElementById('alamat_ekspedisi').value = alamat;
        } else {
            document.getElementById('modalEkspedisiTitle').textContent = 'Tambah Ekspedisi';
            document.getElementById('btnSubmitEkspedisi').textContent = 'Simpan';
            document.getElementById('ekspedisi_method').value = 'POST';
            document.getElementById('formEkspedisi').action = '{{ route("daftar-ekspedisi.store") }}';
            document.getElementById('formEkspedisi').reset();
        }
        openModal('modalEkspedisi');
    }
</script> -->