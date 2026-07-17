<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - Glamora Beauty</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
<div style="display:flex;align-items:center;justify-content:center;min-height:100vh;">
  <div class="auth-box">
    <div class="auth-logo">Glamora</div>
    <div class="auth-sub">
      BEAUTY
    </div>

  @if(request('pesan') == 'login')
    <div class="login-alert">
        Silakan login terlebih dahulu untuk melihat produk.
    </div>
@endif

<form onsubmit="event.preventDefault(); doLogin();">
    <div class="form-group">
      <label>USERNAME</label>
      <input type="text" id="login-user" placeholder="Masukkan username">
    </div>

    <div class="form-group">
      <label>EMAIL</label>
      <input type="email" id="login-email" placeholder="Masukkan email">
    </div>

    <div class="form-group">
      <label>PASSWORD</label>
      <input type="password" id="login-pass" placeholder="Masukkan password">
    </div>

    <div class="form-err" id="login-err"></div>
    <button type="submit" class="btn-primary w-full mt-1">
    Masuk
</button>
</form>

    <div class="auth-hint">
      Belum Punya Akun?
      <a href="/register">Daftar di sini</a>
    </div>
  </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/auth.js') }}"></script>

</body>
</html>