<!-- Modal Tambah/Edit TPS Domestik -->
<div id="modalSampahDomestik" class="modal-overlay">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 id="modalDomestikTitle" class="modal-title">Tambah Sampah Domestik Keluar</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalSampahDomestik')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formSampahDomestik" method="POST">
            @csrf
            <input type="hidden" id="domestikMethod" name="_method" value="POST">
            <input type="hidden" id="domestikId" name="id" value="">
            
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama TPS <span style="color: #dc2626;">*</span></label>
                        <select name="tps_id" id="domestikTps" class="form-control" required>
                            <option value="">Pilih TPS</option>
                            @foreach($tpsList as $tps)
                            <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Sampah Keluar <span style="color: #dc2626;">*</span></label>
                        <input type="text" 
                            name="no_sampah_keluar" 
                            id="domestikNomor" 
                            class="form-control" 
                            placeholder="Contoh: 2025010001" 
                            maxlength="10"
                            pattern="\d{10}"
                            title="Format: YYYYMMXXXX (10 digit angka)"
                            required>
                        <small class="form-help">Format: YYYYMMXXXX (contoh: 2025010001)</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Pengangkutan <span style="color: #dc2626;">*</span></label>
                        <input type="date" 
                            name="tanggal_pengangkutan" 
                            id="domestikTanggal" 
                            class="form-control" 
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ekspedisi <span style="color: #dc2626;">*</span></label>
                        <select name="ekspedisi_id" id="domestikEkspedisi" class="form-control" required>
                            <option value="">Pilih Ekspedisi</option>
                            @foreach($ekspedisiList as $ekspedisi)
                            <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->nama_ekspedisi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Kendaraan <span style="color: #dc2626;">*</span></label>
                        <input type="text" 
                            name="no_kendaraan" 
                            id="domestikKendaraan" 
                            class="form-control" 
                            placeholder="Contoh: B 1234 XYZ"
                            maxlength="20" 
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Berat Bersih (kg) <span style="color: #dc2626;">*</span></label>
                        <input type="number" 
                            name="berat_bersih_kg" 
                            id="domestikBerat" 
                            class="form-control" 
                            step="0.01" 
                            min="0"
                            placeholder="0.00"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Sampah <span style="color: #dc2626;">*</span></label>
                        <select name="jenis_sampah_id" id="domestikJenis" class="form-control" required>
                            <option value="">Pilih Jenis Sampah</option>
                            @foreach($jenisSampahList as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Penerima <span style="color: #dc2626;">*</span></label>
                        <select name="penerima_id" id="domestikPenerima" class="form-control" required>
                            <option value="">Pilih Penerima</option>
                            @foreach($penerimaList as $penerima)
                            <option value="{{ $penerima->id }}">{{ $penerima->nama_penerima }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSampahDomestik')" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>