function switchTabWWTP(tab) {
    switchTab(tab, ['harian', 'bulanan'], 'activeWwtpTab');
}

window.addEventListener('DOMContentLoaded', function () {
    const activeTab = sessionStorage.getItem('activeWwtpTab') || 'harian';
    switchTabWWTP(activeTab);
});

function exportHarianExcel() {
    const tanggalDari = document.getElementById('tanggal_dari').value;
    const tanggalSampai = document.getElementById('tanggal_sampai').value;

    let url = '/wwtp/export/harian/excel';
    const params = new URLSearchParams();

    if (tanggalDari) params.append('tanggal_dari', tanggalDari);
    if (tanggalSampai) params.append('tanggal_sampai', tanggalSampai);

    if (params.toString()) {
        url += '?' + params.toString();
    }

    window.location.href = url;
}

function exportBulananExcel() {
    const bulanDari = document.getElementById('bulan_dari').value;
    const tahunDari = document.getElementById('tahun_dari').value;
    const bulanSampai = document.getElementById('bulan_sampai').value;
    const tahunSampai = document.getElementById('tahun_sampai').value;

    let url = '/wwtp/export/bulanan/excel';
    const params = new URLSearchParams();

    if (bulanDari) params.append('bulan_dari', bulanDari);
    if (tahunDari) params.append('tahun_dari', tahunDari);
    if (bulanSampai) params.append('bulan_sampai', bulanSampai);
    if (tahunSampai) params.append('tahun_sampai', tahunSampai);

    if (params.toString()) {
        url += '?' + params.toString();
    }

    window.location.href = url;
}

function openModalTambahHarian() {
    document.getElementById('modalHarianTitle').textContent = 'Tambah Data Harian WWTP';
    document.getElementById('btnTextHarian').textContent = 'Simpan Data';
    document.getElementById('harianMethod').value = 'POST';
    document.getElementById('formDataHarian').action = '/wwtp/harian';
    document.getElementById('formDataHarian').reset();
    document.getElementById('harianId').value = '';

    const today = new Date().toISOString().split('T')[0];
    const now = new Date().toTimeString().slice(0, 5);

    document.getElementById('harian_tanggal').value = today;
    document.getElementById('harian_waktu').value = now;

    openModal('modalTambahHarian');
}

async function editDataHarian(id) {
    try {
        const response = await fetch(`/wwtp/data/harian/${id}`);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        document.getElementById('modalHarianTitle').textContent = 'Edit Data Harian WWTP';
        document.getElementById('btnTextHarian').textContent = 'Update Data';
        document.getElementById('harianMethod').value = 'PUT';

        document.getElementById('formDataHarian').action = `/wwtp/harian/${id}`;
        document.getElementById('harianId').value = id;

        let tanggal = '';
        if (data.tanggal) {
            if (typeof data.tanggal === 'string') {
                tanggal = data.tanggal.split('T')[0];
            } else if (data.tanggal instanceof Date) {
                tanggal = data.tanggal.toISOString().split('T')[0];
            }
        }

        document.getElementById('harian_wwtp_id').value = data.wwtp_id || '';
        document.getElementById('harian_operator_id').value = data.operator_id || '';
        document.getElementById('harian_tanggal').value = tanggal || '';
        document.getElementById('harian_waktu').value = data.waktu || '';
        document.getElementById('harian_debit_inlet').value = data.debit_inlet || '';
        document.getElementById('harian_debit_outlet').value = data.debit_outlet || '';
        document.getElementById('harian_ph_ekualisasi_1').value = data.ph_ekualisasi_1 || '';
        document.getElementById('harian_ph_ekualisasi_2').value = data.ph_ekualisasi_2 || '';
        document.getElementById('harian_suhu_ekualisasi_1').value = data.suhu_ekualisasi_1 || '';
        document.getElementById('harian_suhu_ekualisasi_2').value = data.suhu_ekualisasi_2 || '';
        document.getElementById('harian_ph_aerasi_1').value = data.ph_aerasi_1 || '';
        document.getElementById('harian_ph_aerasi_2').value = data.ph_aerasi_2 || '';
        document.getElementById('harian_sv30_aerasi_1').value = data.sv30_aerasi_1 || '';
        document.getElementById('harian_sv30_aerasi_2').value = data.sv30_aerasi_2 || '';
        document.getElementById('harian_do_aerasi_1').value = data.do_aerasi_1 || '';
        document.getElementById('harian_do_aerasi_2').value = data.do_aerasi_2 || '';
        document.getElementById('harian_ph_outlet').value = data.ph_outlet || '';
        document.getElementById('harian_keterangan').value = data.keterangan || '';

        openModal('modalTambahHarian');
    } catch (error) {
        console.error('Error fetching data:', error);
        alert('Gagal mengambil data untuk edit: ' + error.message);
    }
}

function openModalTambahBulanan() {
    document.getElementById('modalBulananTitle').textContent = 'Tambah Data Bulanan WWTP';
    document.getElementById('btnTextBulanan').textContent = 'Simpan Data';
    document.getElementById('bulananMethod').value = 'POST';

    const form = document.getElementById('formDataBulanan');
    form.reset();
    form.action = '/wwtp/bulanan';

    const currentMonth = new Date().getMonth() + 1;
    const currentYear = new Date().getFullYear();

    document.getElementById('bulanan_bulan').value = currentMonth;
    document.getElementById('bulanan_tahun').value = currentYear;

    openModal('modalTambahBulanan');
}

async function editDataBulanan(id) {
    try {
        const response = await fetch(`/wwtp/data/bulanan/${id}`);
        const data = await response.json();

        document.getElementById('modalBulananTitle').textContent = 'Edit Data Bulanan WWTP';
        document.getElementById('btnTextBulanan').textContent = 'Update Data';
        document.getElementById('bulananMethod').value = 'PUT';
        document.getElementById('formDataBulanan').action = `/wwtp/bulanan/${id}`;

        document.getElementById('bulanan_wwtp_id').value = data.wwtp_id;
        document.getElementById('bulanan_lab_id').value = data.lab_id;
        document.getElementById('bulanan_bulan').value = data.bulan;
        document.getElementById('bulanan_tahun').value = data.tahun;
        document.getElementById('bulanan_tss_inlet').value = data.tss_inlet || '';
        document.getElementById('bulanan_tss_outlet').value = data.tss_outlet || '';
        document.getElementById('bulanan_tds_inlet').value = data.tds_inlet || '';
        document.getElementById('bulanan_tds_outlet').value = data.tds_outlet || '';
        document.getElementById('bulanan_bod_inlet').value = data.bod_inlet || '';
        document.getElementById('bulanan_bod_outlet').value = data.bod_outlet || '';
        document.getElementById('bulanan_cod_inlet').value = data.cod_inlet || '';
        document.getElementById('bulanan_cod_outlet').value = data.cod_outlet || '';
        document.getElementById('bulanan_minyak_lemak_inlet').value = data.minyak_lemak_inlet || '';
        document.getElementById('bulanan_minyak_lemak_outlet').value = data.minyak_lemak_outlet || '';

        openModal('modalTambahBulanan');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mengambil data untuk edit');
    }
}

function confirmDeleteWWTP(el) {
    const type = el.dataset.type;
    const id = el.dataset.id;
    const label = el.dataset.label;

    let route = '';
    if (type === 'harian') {
        route = `/wwtp/harian/${id}`;
    } else if (type === 'bulanan') {
        route = `/wwtp/bulanan/${id}`;
    }

    confirmDelete({
        type: type,
        id: id,
        label: label,
        route: route
    });
}

// Function untuk toggle sorting data harian
function toggleSortHarian() {
    const sortInput = document.getElementById('input-sort-harian');
    
    const currentSort = sortInput.value;
    const newSort = currentSort === 'asc' ? 'desc' : 'asc';
    
    sortInput.value = newSort;
    
    const form = document.getElementById('filter-harian');
    if (form) {
        form.submit();
    }
}

function toggleSortBulanan() {
    const sortInput = document.getElementById('input-sort-bulanan');
    
    const currentSort = sortInput.value;
    const newSort = currentSort === 'asc' ? 'desc' : 'asc';
    
    sortInput.value = newSort;
    
    const form = document.getElementById('filter-bulanan');
    if (form) {
        form.submit();
    }
}