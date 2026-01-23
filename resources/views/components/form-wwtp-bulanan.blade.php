<!-- Modal Tambah/Edit Data Bulanan -->
<div id="modalTambahBulanan" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalBulananTitle" class="modal-title">Tambah Data Bulanan WWTP</h3>
            <button onclick="closeModal('modalTambahBulanan')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="formDataBulanan" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="bulananMethod" name="_method" value="POST">
            
            <div class="modal-body">
                <!-- Informasi Dasar -->
                <div class="form-section">
                    <h4 class="form-section-title">Informasi Dasar</h4>
                    
                    @php
                        $wwtps = \App\Models\LokasiWwtp::all();
                    @endphp
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Lokasi WWTP <span class="required-mark">*</span></label>
                            <select id="bulanan_wwtp_id" name="wwtp_id" required class="form-select">
                                <option value="">Pilih Lokasi WWTP</option>
                                @foreach($wwtps as $wwtp)
                                <option value="{{ $wwtp->id }}">{{ $wwtp->nama_wwtp }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Bulan <span class="required-mark">*</span></label>
                            <select id="bulanan_bulan" name="bulan" required class="form-select">
                                <option value="">Pilih Bulan</option>
                                @php
                                    $bulanList = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                @endphp
                                @foreach($bulanList as $key => $bulan)
                                <option value="{{ $key }}" {{ $key == date('n') ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tahun <span class="required-mark">*</span></label>
                            <input type="number" id="bulanan_tahun" name="tahun" required 
                                   min="2000" max="{{ date('Y') + 1 }}"
                                   value="{{ date('Y') }}" class="form-input">
                        </div>
                    </div>
                </div>
                
                <!-- TSS -->
                <div class="form-section">
                    <h4 class="form-section-title">TSS (mg/L)</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">TSS Inlet</label>
                            <input type="number" step="0.01" id="bulanan_tss_inlet" name="tss_inlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">TSS Outlet</label>
                            <input type="number" step="0.01" id="bulanan_tss_outlet" name="tss_outlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <!-- TDS -->
                <div class="form-section">
                    <h4 class="form-section-title">TDS (mg/L)</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">TDS Inlet</label>
                            <input type="number" step="0.01" id="bulanan_tds_inlet" name="tds_inlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">TDS Outlet</label>
                            <input type="number" step="0.01" id="bulanan_tds_outlet" name="tds_outlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <!-- BOD -->
                <div class="form-section">
                    <h4 class="form-section-title">BOD (mg/L)</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">BOD Inlet</label>
                            <input type="number" step="0.01" id="bulanan_bod_inlet" name="bod_inlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">BOD Outlet</label>
                            <input type="number" step="0.01" id="bulanan_bod_outlet" name="bod_outlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <!-- COD -->
                <div class="form-section">
                    <h4 class="form-section-title">COD (mg/L)</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">COD Inlet</label>
                            <input type="number" step="0.01" id="bulanan_cod_inlet" name="cod_inlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">COD Outlet</label>
                            <input type="number" step="0.01" id="bulanan_cod_outlet" name="cod_outlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <!-- Minyak Lemak -->
                <div class="form-section">
                    <h4 class="form-section-title">Minyak Lemak (mg/L)</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Minyak Lemak Inlet</label>
                            <input type="number" step="0.01" id="bulanan_minyak_lemak_inlet" name="minyak_lemak_inlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Minyak Lemak Outlet</label>
                            <input type="number" step="0.01" id="bulanan_minyak_lemak_outlet" name="minyak_lemak_outlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTambahBulanan')" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <span id="btnTextBulanan">Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>