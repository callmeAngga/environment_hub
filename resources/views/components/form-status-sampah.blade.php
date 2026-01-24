<div id="modalStatusSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalStatusSampahTitle" class="modal-title">Form Status Sampah</h3>
            <button type="button" onclick="closeModal('modalStatusSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formStatusSampah" method="POST">
            @csrf
            <input type="hidden" id="status_sampah_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Status <span class="required-mark">*</span></label>
                    <input type="text" name="nama_status" id="nama_status" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalStatusSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitStatusSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>