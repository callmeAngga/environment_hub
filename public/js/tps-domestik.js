function exportExcel() {
    const tanggalDari = document.getElementById('tanggal_dari').value;
    const tanggalSampai = document.getElementById('tanggal_sampai').value;
    const baseUrl = window.location.origin;

    let url = baseUrl + '/tps-domestik/export/excel';
    const params = new URLSearchParams();

    if (tanggalDari) params.append('tanggal_dari', tanggalDari);
    if (tanggalSampai) params.append('tanggal_sampai', tanggalSampai);

    if (params.toString()) {
        url += '?' + params.toString();
    }

    window.location.href = url;
}

function openTambahDomestik() {
    document.getElementById('modalDomestikTitle').textContent = 'Tambah Sampah Domestik Keluar';

    const form = document.getElementById('formSampahDomestik');
    const baseUrl = window.location.origin;
    form.action = baseUrl + "/tps-domestik";

    document.getElementById('domestikMethod').value = 'POST';
    document.getElementById('formSampahDomestik').reset();
    document.getElementById('domestikId').value = '';

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('domestikTanggal').value = today;

    document.getElementById('domestikNomor').value = '';

    openModal('modalSampahDomestik');
}

async function openEditDomestik(id) {
    if (!id) {
        alert('Data tidak ditemukan');
        return;
    }

    const baseUrl = window.location.origin;

    try {
        const response = await fetch(baseUrl + `/tps-domestik/${id}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            const item = result.data;

            document.getElementById('modalDomestikTitle').textContent = 'Edit Sampah Domestik Keluar';

            const form = document.getElementById('formSampahDomestik');
            form.action = baseUrl + `/tps-domestik/${item.id}`;

            document.getElementById('domestikMethod').value = 'PUT';
            document.getElementById('domestikId').value = item.id;

            // Handle tanggal - support multiple formats
            let tanggal = '';
            if (item.tanggal_pengangkutan) {
                if (typeof item.tanggal_pengangkutan === 'string') {
                    // Extract date part only (YYYY-MM-DD)
                    tanggal = item.tanggal_pengangkutan.split('T')[0];
                } else if (item.tanggal_pengangkutan instanceof Date) {
                    tanggal = item.tanggal_pengangkutan.toISOString().split('T')[0];
                }
            }

            document.getElementById('domestikTps').value = item.tps_id || '';
            document.getElementById('domestikNomor').value = item.no_sampah_keluar || '';
            document.getElementById('domestikTanggal').value = tanggal || '';
            document.getElementById('domestikEkspedisi').value = item.ekspedisi_id || '';
            document.getElementById('domestikKendaraan').value = item.no_kendaraan || '';
            document.getElementById('domestikBerat').value = item.berat_bersih_kg || '';
            document.getElementById('domestikJenis').value = item.jenis_sampah_id || '';
            document.getElementById('domestikPenerima').value = item.penerima_id || '';

            openModal('modalSampahDomestik');
        } else {
            alert('Data tidak ditemukan');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        alert('Gagal mengambil data untuk edit: ' + error.message);
    }
}

function confirmDeleteDomestik(id, nama) {
    const baseUrl = window.location.origin;
    const route = baseUrl + `/tps-domestik/${id}`;

    confirmDelete({
        type: 'domestik',
        id: id,
        label: nama,
        route: route
    });
}