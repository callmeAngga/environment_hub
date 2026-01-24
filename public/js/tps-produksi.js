function switchTabProduksi(tab) {
    switchTab(tab, ['masuk', 'keluar'], 'activeProduksiTab');
}

window.addEventListener('DOMContentLoaded', function () {
    const activeTab = sessionStorage.getItem('activeProduksiTab') || 'masuk';
    switchTabProduksi(activeTab);
});

function exportMasukExcel() {
    const dari = document.getElementById('tanggal_masuk_dari').value;
    const sampai = document.getElementById('tanggal_masuk_sampai').value;
    let url = '/tps-produksi/export/masuk';
    const params = new URLSearchParams();
    if (dari) params.append('tanggal_masuk_dari', dari);
    if (sampai) params.append('tanggal_masuk_sampai', sampai);
    if (params.toString()) url += '?' + params.toString();
    window.location.href = url;
}

function exportKeluarExcel() {
    const dari = document.getElementById('tanggal_keluar_dari').value;
    const sampai = document.getElementById('tanggal_keluar_sampai').value;
    let url = '/tps-produksi/export/keluar';
    const params = new URLSearchParams();
    if (dari) params.append('tanggal_keluar_dari', dari);
    if (sampai) params.append('tanggal_keluar_sampai', sampai);
    if (params.toString()) url += '?' + params.toString();
    window.location.href = url;
}

function openTambahMasuk() {
    document.getElementById('modalMasukTitle').textContent = 'Tambah Sampah Masuk';
    document.getElementById('masukMethod').value = 'POST';
    document.getElementById('formSampahMasuk').action = '/tps-produksi/masuk';
    document.getElementById('formSampahMasuk').reset();
    
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('masukTanggal').value = today;
    
    openModal('modalSampahMasuk');
}

async function openEditMasuk(id) {
    try {        
        const response = await fetch(`/tps-produksi/data/masuk/${id}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const item = await response.json();
        
        if (item && item.id) {
            document.getElementById('modalMasukTitle').textContent = 'Edit Sampah Masuk';
            document.getElementById('masukMethod').value = 'PUT';
            document.getElementById('formSampahMasuk').action = `/tps-produksi/masuk/${item.id}`;
            
            let tanggal = '';
            if (item.tanggal) {
                if (typeof item.tanggal === 'string') {
                    tanggal = item.tanggal.split('T')[0];
                }
            }

            document.getElementById('masukTps').value = item.tps_id || '';
            document.getElementById('masukTanggal').value = tanggal || '';
            document.getElementById('masukJumlah').value = item.jumlah_sampah || '';
            document.getElementById('masukSatuan').value = item.satuan_sampah_id || '';
            document.getElementById('masukJenis').value = item.jenis_sampah_id || '';

            openModal('modalSampahMasuk');
        } else {
            alert('Data tidak ditemukan');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        alert('Gagal mengambil data untuk edit: ' + error.message);
    }
}

function openTambahKeluar() {
    document.getElementById('modalKeluarTitle').textContent = 'Tambah Sampah Keluar';
    document.getElementById('keluarMethod').value = 'POST';
    document.getElementById('formSampahKeluar').action = '/tps-produksi/keluar';
    document.getElementById('formSampahKeluar').reset();
    
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('keluarTanggal').value = today;
    
    openModal('modalSampahKeluar');
}

async function openEditKeluar(id) {
        try {
            
            const response = await fetch(`/tps-produksi/data/keluar/${id}`);
            
            if (!response.ok) {
                throw new Error('Data tidak ditemukan');
            }

            const data = await response.json();

            document.getElementById('modalKeluarTitle').textContent = 'Edit Sampah Keluar';
            document.getElementById('formSampahKeluar').action = `/tps-produksi/keluar/${id}`;
            document.getElementById('keluarMethod').value = 'PUT'; 
            document.getElementById('keluarId').value = id;
            document.getElementById('keluarTps').value = data.tps_id;
            document.getElementById('keluarNomor').value = data.no_sampah_keluar;

            let formattedDate = '';
            if (data.tanggal_pengangkutan) {
                formattedDate = data.tanggal_pengangkutan.split('T')[0];
            }
            document.getElementById('keluarTanggal').value = formattedDate;
            document.getElementById('keluarEkspedisi').value = data.ekspedisi_id;
            document.getElementById('keluarKendaraan').value = data.no_kendaraan;
            document.getElementById('keluarBeratKosong').value = data.berat_kosong_kg;
            document.getElementById('keluarBeratIsi').value = data.berat_isi_kg;
            document.getElementById('keluarTotalUnit').value = data.total_unit;
            document.getElementById('keluarJenisSampah').value = data.jenis_sampah_id; 
            document.getElementById('keluarPenerima').value = data.penerima_id;
            document.getElementById('keluarStatusSampah').value = data.status_sampah_id;

            hitungBeratBersihKeluar();
            
            openModal('modalSampahKeluar');

        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengambil data: ' + error.message);
        }
    }
function confirmDeleteProduksi(type, id, label) {
    let route = '';
    if (type === 'masuk') {
        route = `/tps-produksi/masuk/${id}`;
    } else if (type === 'keluar') {
        route = `/tps-produksi/keluar/${id}`;
    }

    confirmDelete({
        type: type,
        id: id,
        label: label,
        route: route
    });
}