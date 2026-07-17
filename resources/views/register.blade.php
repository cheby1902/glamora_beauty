<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register - Glamora Beauty</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>

<div style="display:flex;align-items:center;justify-content:center;min-height:100vh;">
  <div class="auth-box">
    <div class="auth-logo">Glamora </div>
    <div class="auth-sub">
      BEAUTY
    </div>

    <div class="auth-sub" style="margin-bottom:1.5rem">
      DAFTAR AKUN BARU
    </div>

    
<form onsubmit="event.preventDefault(); doRegister();">
    <div class="form-group">
      <label>NAMA LENGKAP</label>
      <input type="text" id="reg-nama" placeholder="Nama lengkapmu">
    </div>


    <div class="form-group">
      <label>USERNAME</label>
      <input type="text" id="reg-user" placeholder="Buat username">
    </div>

    <div class="form-group">
      <label>EMAIL</label>
      <input type="email" id="reg-email" placeholder="Masukkan email">
    </div>

    <div class="form-group">
      <label>PASSWORD</label>
      <input type="password" id="reg-pass" placeholder="Buat password">
    </div>

    <div class="form-err" id="reg-err"></div>

    <button type="submit" class="btn-primary w-full mt-1">
  Daftar
</button>
</form>

    <div class="auth-hint">
      Sudah Punya Akun?
      <a href="/login">Login di sini</a>
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/auth.js') }}"></script>

</body>
</html>