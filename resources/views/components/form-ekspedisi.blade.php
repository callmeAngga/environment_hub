<div id="modalEkspedisi" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalEkspedisiTitle" class="modal-title">Form Ekspedisi</h3>
            <button type="button" onclick="closeModal('modalEkspedisi')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEkspedisi" method="POST">
            @csrf
            <input type="hidden" id="ekspedisi_method" name="_method" value="POST">
            <input type="hidden" name="tipe" id="ekspedisi_tipe" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Ekspedisi <span class="required-mark">*</span></label>
                    <input type="text" name="nama_ekspedisi" id="nama_ekspedisi" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_ekspedisi" class="form-input" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalEkspedisi')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitEkspedisi" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>