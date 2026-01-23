<div id="modalJenisSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalJenisSampahTitle" class="card-title">Tambah Jenis Sampah</h3>
            <button onclick="closeModal('modalJenisSampah')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formJenisSampah" method="POST">
            @csrf
            <input type="hidden" id="jenis_sampah_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Jenis Sampah <span class="text-red">*</span></label>
                    <input type="text" name="nama_jenis" id="nama_jenis" required class="form-control" placeholder="Contoh: Organik, Anorganik">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalJenisSampah')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitJenisSampah" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>