<div id="modalJenisSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalJenisSampahTitle" class="modal-title">Jenis Sampah</h3>
            <button type="button" onclick="closeModal('modalJenisSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formJenisSampah" method="POST">
            @csrf
            <input type="hidden" id="jenis_sampah_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Jenis <span class="required-mark">*</span></label>
                    <input type="text" name="nama_jenis" id="nama_jenis" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalJenisSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitJenisSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>