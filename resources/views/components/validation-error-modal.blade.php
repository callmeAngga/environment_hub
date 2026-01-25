<!-- Modal Validasi Error -->
<div id="modalValidationError" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3 class="modal-title">Peringatan</h3>
            <button onclick="closeModal('modalValidationError')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="modal-body">
            <div style="text-align: center; padding: 1rem 0;">
                <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                <p style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem;">
                    Filter Tidak Valid
                </p>
                <p id="validationErrorMessage" style="color: #6b7280; margin-bottom: 0;"></p>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" onclick="closeModal('modalValidationError')" class="btn btn-primary">
                <i class="fas fa-check"></i> Mengerti
            </button>
        </div>
    </div>
</div>