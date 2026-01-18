<div id="modalSampahDomestik" class="modal-overlay">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 id="modalDomestikTitle" class="card-title">Tambah Sampah Domestik</h3>
            <button onclick="closeModal('modalSampahDomestik')" class="alert-close" style="position:static;">&times;</button>
        </div>

        <form id="formSampahDomestik" method="POST">
            @csrf
            <input type="hidden" id="domestikMethod" name="_method" value="POST">
            <input type="hidden" id="domestikId" name="id">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama TPS <span class="text-red">*</span></label>
                    <select name="tps_id" id="domestikTps" required class="form-control">
                        <option value="">Pilih TPS</option>
                        @foreach($tpsList as $tps)
                        <option value="{{ $tps->id }}">{{ $tps->nama_tps }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">No. Sampah Keluar</label>
                        <input type="text" name="no_sampah_keluar" id="domestikNomor" required readonly class="form-control" style="background-color:#f3f4f6;" placeholder="Auto Generate">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Tanggal Angkut</label>
                        <input type="date" name="tanggal_pengangkutan" id="domestikTanggal" required value="{{ date('Y-m-d') }}" class="form-control">
                    </div>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Ekspedisi</label>
                        <select name="ekspedisi_id" id="domestikEkspedisi" required class="form-control">
                            <option value="">Pilih Ekspedisi</option>
                            @foreach($ekspedisiList as $ekspedisi)
                            <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->nama_ekspedisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">No. Kendaraan</label>
                        <input type="text" name="no_kendaraan" id="domestikKendaraan" required class="form-control" placeholder="B 1234 XYZ">
                    </div>
                </div>

                <div class="flex-gap">
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Berat Bersih (kg)</label>
                        <input type="number" step="0.01" name="berat_bersih_kg" id="domestikBerat" required min="0" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label class="form-label">Jenis Sampah</label>
                        <select name="jenis_sampah_id" id="domestikJenis" required class="form-control">
                            <option value="">Pilih Jenis</option>
                            @foreach($jenisSampahList as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Penerima</label>
                    <select name="penerima_id" id="domestikPenerima" required class="form-control">
                        <option value="">Pilih Penerima</option>
                        @foreach($penerimaList as $penerima)
                        <option value="{{ $penerima->id }}">{{ $penerima->nama_penerima }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeModal('modalSampahDomestik')" class="btn btn-secondary">Batal</button>
                <button type="submit" id="btnSubmitDomestik" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
            </div>
        </form>
    </div>
</div>