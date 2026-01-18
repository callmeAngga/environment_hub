<div id="modalSatuanSampah" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalSatuanSampahTitle" class="card-title">Tambah Satuan</h3>
            <button onclick="closeModal('modalSatuanSampah')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formSatuanSampah" method="POST">
            @csrf
            <input type="hidden" id="satuan_sampah_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Satuan <span class="text-red">*</span></label>
                    <input type="text" name="nama_satuan" id="nama_satuan" required class="form-control" placeholder="Contoh: Kg, Ton">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSatuanSampah')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitSatuanSampah" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>