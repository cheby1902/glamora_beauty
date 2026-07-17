const Checkout = (() => {

  const ONGKIR = {
    reguler : {
      label: 'Reguler (3–5 hari)',
      harga: 15000
    },

    express : {
      label: 'Express (1–2 hari)',
      harga: 30000
    },

    sameday : {
      label: 'Same Day',
      harga: 50000
    },
  };

  /* =========================================================
     INIT
  ========================================================= */

  function init() {

    const cart = Storage.getCart();

    // Redirect jika keranjang kosong
    if (!cart || cart.length === 0) {
      window.location.href = '/keranjang';
      return;
    }

    // Render item checkout
    document.getElementById('checkout-items').innerHTML =
      cart.map(item => `

        <div class="checkout-item">

          <div class="checkout-item-img">
            ${item.icon}
          </div>

          <div class="checkout-item-info">

            <div class="checkout-item-name">
              ${item.name}
            </div>

            <div class="checkout-item-detail">
              ×${item.qty}
            </div>

          </div>

          <div class="checkout-item-price">
            Rp ${(item.price * item.qty).toLocaleString('id-ID')}
          </div>

        </div>

      `).join('');

    // Hitung total pertama kali
    updateTotal();

    // Update total saat shipping berubah
    document.querySelectorAll('input[name="shipping"]')
      .forEach(radio => {

        radio.addEventListener('change', updateTotal);

      });

    // Tombol checkout
    document.getElementById('btn-checkout')
      .addEventListener('click', function(e) {

        e.preventDefault();

        submit();

      });

    // Isi otomatis nama user
    const user = Storage.getUser();

    if (user) {
      document.getElementById('nama-penerima').value =
        user.nama;
    }
  }

  /* =========================================================
     UPDATE TOTAL
  ========================================================= */

  function updateTotal() {

    const subtotal = Cart.getTotal();

    const metode =
      document.querySelector(
        'input[name="shipping"]:checked'
      ).value;

    const ongkir =
      ONGKIR[metode].harga;

    const total =
      subtotal + ongkir;

    // Subtotal
    document.getElementById('co-subtotal').textContent =
      'Rp ' + subtotal.toLocaleString('id-ID');

    // Ongkir
    document.getElementById('co-ongkir').textContent =
      'Rp ' + ongkir.toLocaleString('id-ID');

    // Total
    document.getElementById('co-total').textContent =
      'Rp ' + total.toLocaleString('id-ID');
  }

  /* =========================================================
     SUBMIT CHECKOUT
  ========================================================= */

  function submit() {

    // Ambil input form
    const nama =
      document.getElementById('nama-penerima')
      .value.trim();

    const noHp =
      document.getElementById('no-hp')
      .value.trim();

    const alamat =
      document.getElementById('alamat')
      .value.trim();

    const kota =
      document.getElementById('kota')
      .value.trim();

    const kodepos =
      document.getElementById('kodepos')
      .value.trim();

    const errEl =
      document.getElementById('checkout-error');

    // Validasi
    if (
      !nama ||
      !noHp ||
      !alamat ||
      !kota ||
      !kodepos
    ) {
      errEl.textContent =
        'Semua field wajib diisi.';
      return;
    }

    errEl.textContent = '';

    // Shipping
    const metodeKey =
      document.querySelector(
        'input[name="shipping"]:checked'
      ).value;

    const ongkir =
      ONGKIR[metodeKey].harga;

    // Data cart
    const cart =
      Storage.getCart();

    // Subtotal
    const subtotal =
      Cart.getTotal();

    // Buat struk
    const struk = {

      strukNo:
        'GLM-' +
        Date.now().toString().slice(-8),

      tgl:
        new Date().toLocaleDateString(
          'id-ID',
          {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          }
        ),

      penerima: {
        nama,
        noHp,
        alamat,
        kota,
        kodepos
      },

      items: cart,

      subtotal: subtotal,

      ongkir: ongkir,

      metodePengiriman:
        ONGKIR[metodeKey].label,

      total:
        subtotal + ongkir
    };

    // Simpan struk
    Storage.saveStruk(struk);

    // Hapus cart
    Storage.clearCart();

    // Redirect
    window.location.href = '/struk';
  }

  return {
    init,
    submit
  };

})();