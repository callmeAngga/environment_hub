<div id="modalPenerimaSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalPenerimaSampahTitle" class="modal-title">Form Penerima Sampah</h3>
            <button type="button" onclick="closeModal('modalPenerimaSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formPenerimaSampah" method="POST">
            @csrf
            <input type="hidden" id="penerima_sampah_method" name="_method" value="POST">
            <input type="hidden" name="tipe" id="penerima_tipe" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Penerima Sampah <span class="required-mark">*</span></label>
                    <input type="text" name="nama_penerima" id="nama_penerima" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_penerima_sampah" class="form-input" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalPenerimaSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitPenerimaSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>