<div id="modalLokasiWWTP" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalLokasiWWTPTitle" class="card-title">Tambah WWTP</h3>
            <button onclick="closeModal('modalLokasiWWTP')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formWWTP" method="POST">
            @csrf
            <input type="hidden" id="wwtp_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama WWTP <span class="text-red">*</span></label>
                    <input type="text" name="nama_wwtp" id="nama_wwtp" required class="form-control" placeholder="Masukkan nama WWTP">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Alamat <span class="text-red">*</span></label>
                    <textarea name="alamat" id="alamat_wwtp" required rows="3" class="form-control" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
                
                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Latitude <span class="text-red">*</span></label>
                        <input type="number" name="koordinat_lat" id="koordinat_lat_wwtp" step="0.00000001" required class="form-control" placeholder="-6.2088">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Longitude <span class="text-red">*</span></label>
                        <input type="number" name="koordinat_lng" id="koordinat_lng_wwtp" step="0.00000001" required class="form-control" placeholder="106.8456">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kapasitas Debit (m³) <span class="text-red">*</span></label>
                    <input type="number" name="kapasitas_debit" id="kapasitas_debit" step="0.01" required class="form-control" placeholder="Masukkan kapasitas">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalLokasiWWTP')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitWWTP" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>