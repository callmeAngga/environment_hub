<!-- Modal Export Excel -->
<div id="modalExportDomestik" class="modal-overlay">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3 class="modal-title">Export Data TPS Domestik</h3>
            <button onclick="closeModal('modalExportDomestik')" type="button" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('tps-domestik.export.excel') }}" method="GET">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date"
                        name="tanggal_dari"
                        id="exportTanggalDari"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date"
                        name="tanggal_sampai"
                        id="exportTanggalSampai"
                        class="form-control">
                </div>

                <div class="alert alert-info" style="margin-top: 1rem;">
                    <i class="fas fa-info-circle"></i>
                    <span>Kosongkan tanggal untuk export semua data</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalExportDomestik')" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </form>
    </div>
</div>