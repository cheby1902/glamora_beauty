async function doLogin() {

    const username = document.getElementById('login-user').value;
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-pass').value;

   const response = await fetch('/login', {
    method: 'POST',

    credentials: 'same-origin',

    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
    },

    body: JSON.stringify({
        username: username,
        email: email,
        password: password
    })
});

    const result = await response.json();

   if (result.success) {

    if (result.role === 'admin') {

        window.location.href = '/admin-dashboard';

    } else {

        window.location.href = '/welcome';

    }

} else {

        document.getElementById('login-err').innerText =
            result.message;
    }
}

async function doRegister() {

    const nama_user = document.getElementById('reg-nama').value;
    const username = document.getElementById('reg-user').value;
    const email = document.getElementById('reg-email').value;
    const password = document.getElementById('reg-pass').value;

    const response = await fetch('/register', {
        method: 'POST',

        credentials: 'same-origin',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({
            nama_user: nama_user,
            username: username,
            email: email,
            password: password
        })
    });

    const result = await response.json();

    if (result.success) {

        alert('Registrasi berhasil! Silakan login menggunakan akun yang baru dibuat.');
        window.location.href = '/login';

    } else {

        document.getElementById('reg-err').innerText =
            result.message;
    }
}