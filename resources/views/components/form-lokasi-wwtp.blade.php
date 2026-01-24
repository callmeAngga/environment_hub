<div id="modalLokasiWWTP" class="modal-overlay">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 id="modalLokasiWWTPTitle" class="modal-title">Form WWTP</h3>
            <button type="button" onclick="closeModal('modalLokasiWWTP')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formWWTP" method="POST">
            @csrf
            <input type="hidden" id="wwtp_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-section">
                    <h4 class="form-section-title">Informasi WWTP</h4>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Nama WWTP <span class="required-mark">*</span></label>
                            <input type="text" name="nama_wwtp" id="nama_wwtp" class="form-input" required>
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Alamat <span class="required-mark">*</span></label>
                            <textarea name="alamat" id="alamat_wwtp" class="form-input" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="koordinat_lat" id="koordinat_lat_wwtp" class="form-input" placeholder="-6.9175">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="koordinat_lng" id="koordinat_lng_wwtp" class="form-input" placeholder="107.6191">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Kapasitas Debit (m³)</label>
                            <input type="number" step="0.01" name="kapasitas_debit" id="kapasitas_debit" class="form-input">
                            <span class="form-help">Masukkan kapasitas dalam meter kubik</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLokasiWWTP')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitWWTP" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>