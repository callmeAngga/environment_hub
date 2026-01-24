<div id="modalOperatorWwtp" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalOperatorWwtpTitle" class="modal-title">Form Operator</h3>
            <button type="button" onclick="closeModal('modalOperatorWwtp')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formOperator" method="POST">
            @csrf
            <input type="hidden" id="operator_method" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Operator <span class="required-mark">*</span></label>
                    <input type="text" name="nama_operator" id="nama_operator" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalOperatorWwtp')" class="btn-modern btn-reset">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" id="btnSubmitOperator" class="btn-modern btn-add">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>