function doLogin(){

  const username =
    document.getElementById('login-user').value;

  const password =
    document.getElementById('login-pass').value;

  if(
    username === 'admin'
    &&
    password === 'admin123'
  ){

    document
      .getElementById('page-login')
      .classList.remove('active');

    document
      .getElementById('page-app')
      .classList.add('active');

  }else{

    document
      .getElementById('login-err')
      .textContent =
      'Username atau password salah';

  }

}