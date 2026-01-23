<div id="modalLab" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalLabTitle" class="card-title">Tambah Lab</h3>
            <button onclick="closeModal('modalLab')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formLab" method="POST">
            @csrf
            <input type="hidden" id="lab_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lab <span class="text-red">*</span></label>
                    <input type="text" name="nama_lab" id="nama_lab" required class="form-control" placeholder="Masukkan nama lab">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Lokasi</label>
                    <textarea name="lokasi" id="lokasi" rows="3" class="form-control" placeholder="Masukkan lokasi lab"></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLab')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitLab" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>