
  Auth.requireLogin();
  document.getElementById('nav-nama').textContent = Storage.getUser().nama;

  const params    = new URLSearchParams(window.location.search);
  const katId     = params.get('kat');
  const kategori  = Data.getKategori().find(k => k.id === katId);

  if (!kategori) {
    window.location.href = 'katalog.html';
  } else {
    document.getElementById('kat-title').textContent = kategori.name;
    document.getElementById('kat-desc').textContent  = kategori.desc;
    document.title = kategori.name + ' — Glamora Beauty';
    Filter.init(katId);
  }