<div id="modalPenerima" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalPenerimaTitle" class="card-title">Tambah Penerima</h3>
            <button onclick="closeModal('modalPenerima')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formPenerima" method="POST">
            @csrf
            <input type="hidden" id="penerima_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Penerima <span class="text-red">*</span></label>
                    <input type="text" name="nama_penerima" id="nama_penerima" required class="form-control" placeholder="Masukkan nama penerima">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_penerima" rows="3" class="form-control" placeholder="Masukkan alamat penerima"></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalPenerima')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitPenerima" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>