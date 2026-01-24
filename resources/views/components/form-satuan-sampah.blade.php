<div id="modalSatuanSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalSatuanSampahTitle" class="modal-title">Satuan Sampah</h3>
            <button type="button" onclick="closeModal('modalSatuanSampah')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formSatuanSampah" method="POST">
            @csrf
            <input type="hidden" id="satuan_sampah_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Satuan <span class="required-mark">*</span></label>
                    <input type="text" name="nama_satuan" id="nama_satuan" class="form-input" required placeholder="Contoh: kg, ton, m³">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSatuanSampah')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitSatuanSampah" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>