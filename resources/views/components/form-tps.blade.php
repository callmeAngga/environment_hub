<div id="modalTPS" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTPSTitle" class="card-title">Tambah TPS</h3>
            <button onclick="closeModal('modalTPS')" class="alert-close" style="position:static;">&times;</button>
        </div>
        
        <form id="formTPS" method="POST">
            @csrf
            <input type="hidden" id="tps_method" name="_method" value="POST">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama TPS <span class="text-red">*</span></label>
                    <input type="text" name="nama_tps" id="nama_tps" required class="form-control" placeholder="Masukkan nama TPS">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat_tps" rows="3" class="form-control" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
                
                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Latitude</label>
                        <input type="number" name="koordinat_lat" id="koordinat_lat_tps" step="0.00000001" class="form-control" placeholder="-6.2088">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Longitude</label>
                        <input type="number" name="koordinat_lng" id="koordinat_lng_tps" step="0.00000001" class="form-control" placeholder="106.8456">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kapasitas Maksimum (m³)</label>
                    <input type="number" name="kapasitas_max" id="kapasitas_max" step="0.01" class="form-control" placeholder="Masukkan kapasitas">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTPS')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitTPS" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>