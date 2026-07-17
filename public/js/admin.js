function showAdminTab(tabName, element) {

    localStorage.setItem('activeAdminTab', tabName);

    document.querySelectorAll('.admin-tab-content').forEach(section => {
        section.classList.remove('active');
    });

    document.querySelectorAll('.admin-menu-item').forEach(menu => {
        menu.classList.remove('active');
    });

    const target = document.getElementById('tab-' + tabName);

    if (target) {
        target.classList.add('active');
    }

    if (element) {
        element.classList.add('active');
    }
}

function doLogout() {
    window.location.href = "/";
}

/* ===== Modal Kategori ===== */

function openTambahKategoriModal() {
    const modal = document.getElementById('modal-kategori');
    const form = document.getElementById('kategori-form');
    const title = document.getElementById('kategori-modal-title');
    const method = document.getElementById('kategori-method');
    const inputNama = document.getElementById('nama_katalog');
    const inputGambar = document.getElementById('gambar_katalog');

    title.textContent = 'Tambah Kategori';
    form.action = "/admin/kategori/store";
    method.innerHTML = '';

    inputNama.value = '';
    inputGambar.value = '';

    modal.style.display = 'flex';
}

function openEditKategoriModal(button) {

    const id = button.dataset.id;
    const nama = button.dataset.nama;
    const gambar = button.dataset.gambar;

    const modal = document.getElementById('modal-kategori');
    const form = document.getElementById('kategori-form');
    const title = document.getElementById('kategori-modal-title');
    const method = document.getElementById('kategori-method');
    const inputNama = document.getElementById('nama_katalog');
    const inputGambar = document.getElementById('gambar_katalog');

    title.textContent = 'Edit Kategori';
    form.action = "/admin/kategori/update/" + id;
    method.innerHTML = '<input type="hidden" name="_method" value="PUT">';

    inputNama.value = nama;
    inputGambar.value = gambar;

    modal.style.display = 'flex';
}
function closeKategoriModal(event) {
    const modal = document.getElementById('modal-kategori');

    if (!event || event.target.id === 'modal-kategori') {
        modal.style.display = 'none';
    }
}

window.addEventListener('load', function () {

    const hash = window.location.hash;

    if (!hash) return;

    document.querySelectorAll('.admin-tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    document.querySelectorAll('.admin-menu-item').forEach(menu => {
        menu.classList.remove('active');
    });

    if (hash === '#produk') {
        document.getElementById('tab-produk').classList.add('active');
        document.querySelectorAll('.admin-menu-item')[1].classList.add('active');
    }

    if (hash === '#kategori') {
        document.getElementById('tab-kategori').classList.add('active');
        document.querySelectorAll('.admin-menu-item')[2].classList.add('active');
    }

    if (hash === '#review') {
        document.getElementById('tab-review').classList.add('active');
        document.querySelectorAll('.admin-menu-item')[3].classList.add('active');
    }

    if (hash === '#user') {
        document.getElementById('tab-user').classList.add('active');
        document.querySelectorAll('.admin-menu-item')[4].classList.add('active');
    }

});

/* ===== MODAL PRODUK ===== */

  function openTambahProdukModal() {

    const modal = document.getElementById('modal-produk');
    const form = document.getElementById('produk-form');
    const title = document.getElementById('produk-modal-title');
    const method = document.getElementById('produk-method');

    title.textContent = 'Tambah Produk';
    form.action = "/admin/produk/store";
    method.innerHTML = '';

    form.reset(); // <-- INI YANG PENTING

    document.getElementById('gambar_produk').value = '';

    modal.style.display = 'flex';
}

function openEditProdukModal(button) {

    const id = button.dataset.id;

    fetch('/admin/produk/edit/' + id)
        .then(response => response.json())
        .then(data => {

            const modal = document.getElementById('modal-produk');
            const form = document.getElementById('produk-form');
            const title = document.getElementById('produk-modal-title');
            const method = document.getElementById('produk-method');

            title.textContent = 'Edit Produk';

            form.action = "/admin/produk/update/" + id;

            method.innerHTML =
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nama_produk').value =
    data.nama_produk ?? '';

document.getElementById('brand').value =
    data.brand ?? '';

document.getElementById('deskripsi_produk').value =
    data.deskripsi_produk ?? '';

document.getElementById('gambar_produk').value =
    data.gambar_produk ?? '';

document.querySelector('[name="id_katalog"]').value =
    data.id_katalog ?? '';

document.querySelector('[name="id_jenis_kulit"]').value =
    data.id_jenis_kulit ?? '';

document.querySelector('[name="id_masalah_kulit"]').value =
    data.id_masalah_kulit ?? '';

if (data.produk_varian.length > 0) {

    document.querySelector('[name="nama_varian"]').value =
        data.produk_varian[0].nama_varian ?? '';

    document.querySelector('[name="id_warna_kulit"]').value =
        data.produk_varian[0].id_warna_kulit ?? '';

    document.getElementById('harga').value =
        data.produk_varian[0].harga ?? '';

    document.getElementById('stock').value =
        data.produk_varian[0].stock ?? '';
}

            modal.style.display = 'flex';
        });
}

function closeProdukModal(event) {

    const modal = document.getElementById('modal-produk');

    if (!event || event.target.id === 'modal-produk') {
        modal.style.display = 'none';
    }
}

/* ===== MODAL EDIT PESANAN ===== */
function openStatusModal(button)
{
    const id = button.dataset.id;
    const status = button.dataset.status;

    document.getElementById('status_pesanan').value =
        status;

    document.getElementById('status-form').action =
        '/admin/pesanan/update-status/' + id;

    document.getElementById('modal-status').style.display =
        'flex';
}

function closeStatusModal(event)
{
    if (
        !event ||
        event.target.id === 'modal-status'
    ) {
        document.getElementById('modal-status').style.display =
            'none';
    }
}