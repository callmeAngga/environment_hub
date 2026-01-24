// Profile Page Tab Switching dengan SessionStorage
function switchTabProfile(tab) {
    const tabs = ['wwtp', 'tps-produksi', 'tps-domestik', 'pengguna'];

    tabs.forEach(t => {
        const btn = document.getElementById('tab-' + t + '-profile');
        const content = document.getElementById('content-' + t + '-profile');

        if (btn && content) {
            btn.classList.remove('active');
            content.classList.add('hidden');
        }
    });

    const activeBtn = document.getElementById('tab-' + tab + '-profile');
    const activeContent = document.getElementById('content-' + tab + '-profile');

    if (activeBtn && activeContent) {
        activeBtn.classList.add('active');
        activeContent.classList.remove('hidden');
    }

    // Simpan tab aktif ke sessionStorage
    sessionStorage.setItem('activeProfileTab', tab);
}

// Load tab yang aktif saat halaman dimuat
window.addEventListener('DOMContentLoaded', function () {
    // Jika ada search_user, tampilkan tab pengguna
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search_user')) {
        switchTabProfile('pengguna');
    } else {
        // Gunakan tab dari sessionStorage atau default ke 'wwtp'
        const activeTab = sessionStorage.getItem('activeProfileTab') || 'wwtp';
        switchTabProfile(activeTab);
    }
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
    }
}

// WWTP Modal Functions
function openWWTPModal(id = null, nama = '', alamat = '', lat = '', lng = '', kapasitas = '') {
    if (id) {
        document.getElementById('modalLokasiWWTPTitle').textContent = 'Edit WWTP';
        document.getElementById('btnSubmitWWTP').textContent = 'Update';
        document.getElementById('wwtp_method').value = 'PUT';
        document.getElementById('formWWTP').action = '/profile/wwtp/' + id;
        document.getElementById('nama_wwtp').value = nama;
        document.getElementById('alamat_wwtp').value = alamat;
        document.getElementById('koordinat_lat_wwtp').value = lat;
        document.getElementById('koordinat_lng_wwtp').value = lng;
        document.getElementById('kapasitas_debit').value = kapasitas;
    } else {
        document.getElementById('modalLokasiWWTPTitle').textContent = 'Tambah WWTP';
        document.getElementById('btnSubmitWWTP').textContent = 'Simpan';
        document.getElementById('wwtp_method').value = 'POST';
        document.getElementById('formWWTP').action = '/profile/wwtp';
        document.getElementById('formWWTP').reset();
    }
    openModal('modalLokasiWWTP');
}

// Operator Modal Functions
function openOperatorModal(id = null, nama = '') {
    if (id) {
        document.getElementById('modalOperatorWwtpTitle').textContent = 'Edit Operator';
        document.getElementById('btnSubmitOperator').textContent = 'Update';
        document.getElementById('operator_method').value = 'PUT';
        document.getElementById('formOperator').action = '/profile/operator/' + id;
        document.getElementById('nama_operator').value = nama;
    } else {
        document.getElementById('modalOperatorWwtpTitle').textContent = 'Tambah Operator';
        document.getElementById('btnSubmitOperator').textContent = 'Simpan';
        document.getElementById('operator_method').value = 'POST';
        document.getElementById('formOperator').action = '/profile/operator';
        document.getElementById('formOperator').reset();
    }
    openModal('modalOperatorWwtp');
}

// Lab Modal Functions
function openLabModal(id = null, nama = '', lokasi = '') {
    if (id) {
        document.getElementById('modalLabTitle').textContent = 'Edit Lab';
        document.getElementById('btnSubmitLab').textContent = 'Update';
        document.getElementById('lab_method').value = 'PUT';
        document.getElementById('formLab').action = '/profile/lab/' + id;
        document.getElementById('nama_lab').value = nama;
        document.getElementById('lokasi').value = lokasi;
    } else {
        document.getElementById('modalLabTitle').textContent = 'Tambah Lab';
        document.getElementById('btnSubmitLab').textContent = 'Simpan';
        document.getElementById('lab_method').value = 'POST';
        document.getElementById('formLab').action = '/profile/lab';
        document.getElementById('formLab').reset();
    }
    openModal('modalLab');
}

// TPS Modal Functions
function openTPSModal(id = null, nama = '', alamat = '', lat = '', lng = '', kapasitas = '', tipe = '') {
    document.getElementById('tps_tipe').value = tipe;
    if (id) {
        document.getElementById('modalTPSTitle').textContent = 'Edit TPS';
        document.getElementById('btnSubmitTPS').textContent = 'Update';
        document.getElementById('tps_method').value = 'PUT';
        document.getElementById('formTPS').action = '/profile/tps/' + id;
        document.getElementById('nama_tps').value = nama;
        document.getElementById('alamat_tps').value = alamat;
        document.getElementById('koordinat_lat_tps').value = lat;
        document.getElementById('koordinat_lng_tps').value = lng;
        document.getElementById('kapasitas_max').value = kapasitas;
    } else {
        document.getElementById('modalTPSTitle').textContent = 'Tambah TPS';
        document.getElementById('btnSubmitTPS').textContent = 'Simpan';
        document.getElementById('tps_method').value = 'POST';
        document.getElementById('formTPS').action = '/profile/tps';
        document.getElementById('formTPS').reset();

        document.getElementById('tps_tipe').value = tipe;
    }
    openModal('modalTPS');
}

// Satuan Sampah Modal Functions
function openSatuanSampahModal(id = null, nama = '') {
    if (id) {
        document.getElementById('modalSatuanSampahTitle').textContent = 'Edit Satuan';
        document.getElementById('btnSubmitSatuanSampah').textContent = 'Update';
        document.getElementById('satuan_sampah_method').value = 'PUT';
        document.getElementById('formSatuanSampah').action = '/profile/satuan-sampah/' + id;
        document.getElementById('nama_satuan').value = nama;
    } else {
        document.getElementById('modalSatuanSampahTitle').textContent = 'Tambah Satuan';
        document.getElementById('btnSubmitSatuanSampah').textContent = 'Simpan';
        document.getElementById('satuan_sampah_method').value = 'POST';
        document.getElementById('formSatuanSampah').action = '/profile/satuan-sampah';
        document.getElementById('formSatuanSampah').reset();
    }
    openModal('modalSatuanSampah');
}

// Jenis Sampah Modal Functions
function openJenisSampahModal(id = null, nama = '') {
    if (id) {
        document.getElementById('modalJenisSampahTitle').textContent = 'Edit Jenis';
        document.getElementById('btnSubmitJenisSampah').textContent = 'Update';
        document.getElementById('jenis_sampah_method').value = 'PUT';
        document.getElementById('formJenisSampah').action = '/profile/jenis-sampah/' + id;
        document.getElementById('nama_jenis').value = nama;
    } else {
        document.getElementById('modalJenisSampahTitle').textContent = 'Tambah Jenis';
        document.getElementById('btnSubmitJenisSampah').textContent = 'Simpan';
        document.getElementById('jenis_sampah_method').value = 'POST';
        document.getElementById('formJenisSampah').action = '/profile/jenis-sampah';
        document.getElementById('formJenisSampah').reset();
    }
    openModal('modalJenisSampah');
}

// Penerima Modal Functions
function openPenerimaModal(id = null, nama = '', alamat = '', tipe = '') {
    document.getElementById('penerima_tipe').value = tipe;
    if (id) {
        document.getElementById('modalPenerimaSampahTitle').textContent = 'Edit Penerima';
        document.getElementById('btnSubmitPenerimaSampah').textContent = 'Update';
        document.getElementById('penerima_sampah_method').value = 'PUT';
        document.getElementById('formPenerimaSampah').action = '/profile/daftar-penerima/' + id;
        document.getElementById('nama_penerima').value = nama;
        document.getElementById('alamat_penerima_sampah').value = alamat;
    } else {
        document.getElementById('modalPenerimaSampahTitle').textContent = 'Tambah Penerima';
        document.getElementById('btnSubmitPenerimaSampah').textContent = 'Simpan';
        document.getElementById('penerima_sampah_method').value = 'POST';
        document.getElementById('formPenerimaSampah').action = '/profile/daftar-penerima';
        document.getElementById('formPenerimaSampah').reset();

        document.getElementById('penerima_tipe').value = tipe;
    }
    openModal('modalPenerimaSampah');
}

// Ekspedisi Modal Functions
function openEkspedisiModal(id = null, nama = '', alamat = '', tipe = '') {
    document.getElementById('ekspedisi_tipe').value = tipe;
    if (id) {
        document.getElementById('modalEkspedisiTitle').textContent = 'Edit Ekspedisi';
        document.getElementById('btnSubmitEkspedisi').textContent = 'Update';
        document.getElementById('ekspedisi_method').value = 'PUT';
        document.getElementById('formEkspedisi').action = '/profile/daftar-ekspedisi/' + id;
        document.getElementById('nama_ekspedisi').value = nama;
        document.getElementById('alamat_ekspedisi').value = alamat;
    } else {
        document.getElementById('modalEkspedisiTitle').textContent = 'Tambah Ekspedisi';
        document.getElementById('btnSubmitEkspedisi').textContent = 'Simpan';
        document.getElementById('ekspedisi_method').value = 'POST';
        document.getElementById('formEkspedisi').action = '/profile/daftar-ekspedisi';
        document.getElementById('formEkspedisi').reset();

        document.getElementById('ekspedisi_tipe').value = tipe;
    }
    openModal('modalEkspedisi');
}

// Close modal when clicking outside
window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.classList.remove('show');
    }
});