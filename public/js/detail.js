let qty = 1;

function changeQty(n) {

    qty += n;

    if (qty < 1) qty = 1;

    document.getElementById('qty-num').textContent = qty;

    document.getElementById('qty-input').value = qty;

    const checkoutQty =
        document.getElementById('checkout-qty');

    if (checkoutQty) {

        checkoutQty.value = qty;

    }

    console.log(document.getElementById('qty-input').value);

}

function checkoutLangsung() {

    const produkId =
        document.querySelector('input[name="produk_id"]').value;

    const varianId =
        document.querySelector('input[name="id_produk_varian"]').value;

    const qty =
        document.getElementById('qty-input').value;

    window.location.href =
    `/checkout?id_produk=${produkId}&id_produk_varian=${varianId}&qty=${qty}`;
}

document.addEventListener('DOMContentLoaded', () => {

    const shadeSelect =
        document.getElementById('shade-select');

    if (!shadeSelect) return;

    shadeSelect.addEventListener('change', function () {

        const selected =
            this.options[this.selectedIndex];

        const harga =
            selected.dataset.harga;

        const stock =
            selected.dataset.stock;

        const idVarian =
            selected.value;

        document.getElementById('harga-produk')
            .innerText =
            'Rp ' + Number(harga).toLocaleString('id-ID');

        document.getElementById('stok-produk')
            .innerText =
            'Stok: ' + stock;

        document.getElementById('varian-input')
            .value = idVarian;

        document.getElementById('checkout-varian')
            .value = idVarian;
    });

});