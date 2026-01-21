<!-- Modal Tambah/Edit Data Harian -->
<div id="modalTambahHarian" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalHarianTitle" class="modal-title">Tambah Data Harian WWTP</h3>
            <button onclick="closeModal('modalTambahHarian')" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="formDataHarian" method="POST">
            @csrf
            <input type="hidden" id="harianMethod" name="_method" value="POST">
            <input type="hidden" id="harianId" name="id">
            
            <div class="modal-body">
                <!-- Informasi Dasar -->
                <div class="form-section">
                    <h4 class="form-section-title">Informasi Dasar</h4>
                    
                    @php
                        $wwtps = \App\Models\LokasiWwtp::all();
                        $operators = \App\Models\OperatorWwtp::all();
                    @endphp
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Lokasi WWTP <span class="required-mark">*</span></label>
                            <select id="harian_wwtp_id" name="wwtp_id" required class="form-select">
                                <option value="">Pilih Lokasi WWTP</option>
                                @foreach($wwtps as $wwtp)
                                <option value="{{ $wwtp->id }}">{{ $wwtp->nama_wwtp }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nama Operator <span class="required-mark">*</span></label>
                            <select id="harian_operator_id" name="operator_id" required class="form-select">
                                <option value="">Pilih Operator</option>
                                @foreach($operators as $operator)
                                <option value="{{ $operator->id }}">{{ $operator->nama_operator }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tanggal <span class="required-mark">*</span></label>
                            <input type="date" id="harian_tanggal" name="tanggal" required class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Waktu <span class="required-mark">*</span></label>
                            <input type="time" id="harian_waktu" name="waktu" required class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Debit Inlet (m³)</label>
                            <input type="number" step="0.01" id="harian_debit_inlet" name="debit_inlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Debit Outlet (m³)</label>
                            <input type="number" step="0.01" id="harian_debit_outlet" name="debit_outlet"
                                   class="form-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <!-- Parameter Ekualisasi -->
                <div class="form-section">
                    <h4 class="form-section-title">Parameter Ekualisasi</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">pH Ekualisasi 1</label>
                            <input type="number" step="0.1" id="harian_ph_ekualisasi_1" name="ph_ekualisasi_1" 
                                   min="0" max="14" class="form-input" placeholder="0.0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">pH Ekualisasi 2</label>
                            <input type="number" step="0.1" id="harian_ph_ekualisasi_2" name="ph_ekualisasi_2" 
                                   min="0" max="14" class="form-input" placeholder="0.0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Suhu Ekualisasi 1 (°C)</label>
                            <input type="number" step="0.1" id="harian_suhu_ekualisasi_1" name="suhu_ekualisasi_1"
                                   class="form-input" placeholder="0.0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Suhu Ekualisasi 2 (°C)</label>
                            <input type="number" step="0.1" id="harian_suhu_ekualisasi_2" name="suhu_ekualisasi_2"
                                   class="form-input" placeholder="0.0">
                        </div>
                    </div>
                </div>
                
                <!-- Parameter Aerasi -->
                <div class="form-section">
                    <h4 class="form-section-title">Parameter Aerasi</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">pH Aerasi 1</label>
                            <input type="number" step="0.1" id="harian_ph_aerasi_1" name="ph_aerasi_1" 
                                   min="0" max="14" class="form-input" placeholder="0.0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">pH Aerasi 2</label>
                            <input type="number" step="0.1" id="harian_ph_aerasi_2" name="ph_aerasi_2" 
                                   min="0" max="14" class="form-input" placeholder="0.0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">SV30 Aerasi 1 (%)</label>
                            <input type="number" step="1" id="harian_sv30_aerasi_1" name="sv30_aerasi_1"
                                   class="form-input" placeholder="0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">SV30 Aerasi 2 (%)</label>
                            <input type="number" step="1" id="harian_sv30_aerasi_2" name="sv30_aerasi_2"
                                   class="form-input" placeholder="0">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">DO Aerasi 1 (mg/L)</label>
                            <input type="number" step="0.001" id="harian_do_aerasi_1" name="do_aerasi_1"
                                   class="form-input" placeholder="0.000">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">DO Aerasi 2 (mg/L)</label>
                            <input type="number" step="0.001" id="harian_do_aerasi_2" name="do_aerasi_2"
                                   class="form-input" placeholder="0.000">
                        </div>
                    </div>
                </div>
                
                <!-- Parameter Outlet -->
                <div class="form-section">
                    <h4 class="form-section-title">Parameter Outlet</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">pH Outlet</label>
                            <input type="number" step="0.1" id="harian_ph_outlet" name="ph_outlet" 
                                   min="0" max="14" class="form-input" placeholder="0.0">
                        </div>
                    </div>
                </div>
                
                <!-- Keterangan -->
                <div class="form-section">
                    <h4 class="form-section-title">Keterangan</h4>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea id="harian_keterangan" name="keterangan" rows="3"
                                  class="form-input" placeholder="Masukkan keterangan..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalTambahHarian')" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> <span id="btnTextHarian">Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>