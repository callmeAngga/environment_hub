<div id="modalLab" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalLabTitle" class="modal-title">Form Lab</h3>
            <button type="button" onclick="closeModal('modalLab')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formLab" method="POST">
            @csrf
            <input type="hidden" id="lab_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lab <span class="required-mark">*</span></label>
                    <input type="text" name="nama_lab" id="nama_lab" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi <span class="required-mark">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLab')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitLab" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>