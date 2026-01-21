<!-- Modal Delete Confirmation -->
<div id="modalDeleteConfirm" class="modal-overlay">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Hapus</h3>
            <button onclick="closeModal('modalDeleteConfirm')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="formDeleteConfirm" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="modal-body">
                <div style="text-align: center; padding: 1rem 0;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #dc2626; margin-bottom: 1rem;"></i>
                    <p style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem;">
                        Apakah Anda yakin ingin menghapus data ini?
                    </p>
                    <p style="color: #6b7280; margin-bottom: 0;">
                        <strong id="deleteItemName"></strong>
                    </p>
                    <p style="color: #dc2626; font-size: 0.875rem; margin-top: 1rem;">
                        Tindakan ini tidak dapat dibatalkan!
                    </p>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalDeleteConfirm')" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn" style="background-color: #dc2626; color: white;">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>