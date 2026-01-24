<div id="modalTPS" class="modal-overlay">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 id="modalTPSTitle" class="modal-title">Form TPS</h3>
            <button type="button" onclick="closeModal('modalTPS')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formTPS" method="POST">
            @csrf
            <input type="hidden" id="tps_method" name="_method" value="POST">
            <input type="hidden" name="tipe" id="tps_tipe" value="">
            <div class="modal-body">
                <div class="form-section">
                    <h4 class="form-section-title">Informasi TPS</h4>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Nama TPS <span class="required-mark">*</span></label>
                            <input type="text" name="nama_tps" id="nama_tps" class="form-input" required>
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat_tps" class="form-input" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="koordinat_lat" id="koordinat_lat_tps" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="koordinat_lng" id="koordinat_lng_tps" class="form-input">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Kapasitas Maximum (m³)</label>
                            <input type="number" step="0.01" name="kapasitas_max" id="kapasitas_max" class="form-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTPS')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitTPS" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>