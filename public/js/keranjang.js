const Cart = (() => {

  // ---- Tambah produk ke keranjang ----
  function add(produk, qty = 1) {
    const cart    = Storage.getCart();
    const idx     = cart.findIndex(item => item.id === produk.id);
    if (idx > -1) {
      cart[idx].qty += qty;
    } else {
      cart.push({
        id    : produk.id,
        name  : produk.name,
        brand : produk.brand,
        icon  : produk.icon,
        price : produk.price,
        qty   : qty,
      });
    }
    Storage.saveCart(cart);
    UI.updateCartBadge();
    UI.showToast(`${produk.name} ditambahkan ke keranjang 🛒`);
  }

  // ---- Update qty item ----
  function updateQty(id, newQty) {
    const cart = Storage.getCart();
    const idx  = cart.findIndex(item => item.id === id);
    if (idx === -1) return;
    if (newQty < 1) {
      remove(id);
      return;
    }
    cart[idx].qty = newQty;
    Storage.saveCart(cart);
    UI.updateCartBadge();
  }

  // ---- Hapus item dari keranjang ----
  function remove(id) {
    const cart = Storage.getCart().filter(item => item.id !== id);
    Storage.saveCart(cart);
    UI.updateCartBadge();
    renderPage(); // refresh tampilan
  }

  // ---- Hitung total ----
  function getTotal() {
    return Storage.getCart().reduce((sum, item) => sum + item.price * item.qty, 0);
  }

  function getCount() {
    return Storage.getCart().reduce((sum, item) => sum + item.qty, 0);
  }

  // ---- Render halaman keranjang (keranjang.html) ----
  function renderPage() {
    const cart         = Storage.getCart();
    const emptyEl      = document.getElementById('empty-cart');
    const contentEl    = document.getElementById('cart-content');

    if (!emptyEl || !contentEl) return;

    if (cart.length === 0) {
      emptyEl.style.display   = 'block';
      contentEl.style.display = 'none';
      return;
    }

    emptyEl.style.display   = 'none';
    contentEl.style.display = 'block';

    // Render item
    document.getElementById('cart-items').innerHTML = cart.map(item => `
      <div class="cart-item" id="cart-item-${item.id}">
        <div class="cart-item-img">${item.icon}</div>
        <div class="cart-item-info">
          <div class="cart-item-brand">${item.brand}</div>
          <div class="cart-item-name">${item.name}</div>
          <div class="cart-item-price">Rp ${item.price.toLocaleString('id')}</div>
        </div>
        <div class="cart-item-actions">
          <button class="qty-btn" onclick="Cart.updateQty(${item.id}, ${item.qty - 1})">−</button>
          <span class="qty-num">${item.qty}</span>
          <button class="qty-btn" onclick="Cart.updateQty(${item.id}, ${item.qty + 1})">+</button>
          <button class="btn-remove" onclick="Cart.remove(${item.id})" title="Hapus">✕</button>
        </div>
      </div>`).join('');

    // Render ringkasan
    const total = getTotal();
    document.getElementById('summary-rows').innerHTML = cart.map(item => `
      <div class="summary-row">
        <span>${item.name} ×${item.qty}</span>
        <span>Rp ${(item.price * item.qty).toLocaleString('id')}</span>
      </div>`).join('');

    document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id');
  }

  return { add, updateQty, remove, getTotal, getCount, renderPage };

})();