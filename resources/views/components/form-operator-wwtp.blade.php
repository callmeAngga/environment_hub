<div id="modalOperatorWwtp" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalOperatorWwtpTitle" class="card-title">Tambah Operator</h3>
            <button onclick="closeModal('modalOperatorWwtp')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formOperator" method="POST">
            @csrf
            <input type="hidden" id="operator_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Operator <span class="text-red">*</span></label>
                    <input type="text" name="nama_operator" id="nama_operator" required class="form-control" placeholder="Masukkan nama operator">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalOperatorWwtp')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitOperator" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>