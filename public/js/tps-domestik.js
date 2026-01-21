// TPS Domestik - JavaScript Functions

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Open Tambah Domestik Modal
function openTambahDomestik() {
    document.getElementById('modalDomestikTitle').textContent = 'Tambah Sampah Domestik Keluar';

    const form = document.getElementById('formSampahDomestik');
    const baseUrl = window.location.origin;
    form.action = baseUrl + "/tps-domestik";

    document.getElementById('domestikMethod').value = 'POST';
    document.getElementById('formSampahDomestik').reset();
    document.getElementById('domestikId').value = '';

    // Set tanggal hari ini
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('domestikTanggal').value = today;

    // Clear nomor sampah field
    document.getElementById('domestikNomor').value = '';

    openModal('modalSampahDomestik');
}

// Open Edit Domestik Modal
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

// Confirm Delete
function confirmDelete(id, nama) {
    const baseUrl = window.location.origin;
    const form = document.getElementById('formDeleteConfirm');
    form.action = baseUrl + `/tps-domestik/${id}`;

    document.getElementById('deleteItemName').textContent = nama;

    openModal('modalDeleteConfirm');
}

// Export Excel with current filter
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

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert-success, .alert-danger');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Close modal when clicking outside
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                const modalId = modal.id;
                closeModal(modalId);
            }
        });
    });
});