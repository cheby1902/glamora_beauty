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

const errorBox = document.getElementById('login-err');
errorBox.innerText = "";

if (response.ok) {

    if (result.role === 'admin') {

        window.location.href = '/admin-dashboard';

    } else {

        window.location.href = '/welcome';

    }

} else {

    if (result.errors) {

        errorBox.innerText =
            Object.values(result.errors)[0][0];

    } else {

        errorBox.innerText = result.message;

    }
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
            nama_user,
            username,
            email,
            password
        })
    });

   const result = await response.json();

document.getElementById("user-msg").innerText = "";
document.getElementById("email-msg").innerText = "";
document.getElementById("pass-msg").innerText = "";

if (response.ok) {

        alert('Registrasi berhasil! Selamat datang di Glamora Beauty dan selamat berbelanja!');

        window.location.href = '/welcome';

    } else {

    if (result.errors) {

        if (result.errors.username) {
            document.getElementById("user-msg").innerText =
                result.errors.username[0];
        }

        if (result.errors.email) {
            document.getElementById("email-msg").innerText =
                result.errors.email[0];
        }

        if (result.errors.password) {
            document.getElementById("pass-msg").innerText =
                result.errors.password[0];
        }

        if (result.errors.nama_user) {
            alert(result.errors.nama_user[0]);
        }

    }

}
}

const passwordInput = document.getElementById("reg-pass");

if(passwordInput){

passwordInput.addEventListener("input",function(){

const msg=document.getElementById("pass-msg");

if (this.value.length == 0) {

    msg.innerText = "";

}

else if (this.value.length < 8) {

    msg.innerText = "Password minimal 8 karakter.";

}

else if (this.value.length > 50) {

    msg.innerText = "Password maksimal 50 karakter.";

}

else {

    msg.innerText = "";

}

});

}

const emailInput = document.getElementById("reg-email");

if (emailInput) {

    emailInput.addEventListener("input", async function () {

        const msg = document.getElementById("email-msg");

        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (this.value == "") {

            msg.innerText = "";
            return;

        }

        if (!regex.test(this.value)) {

            msg.innerText = "Format email tidak valid.";
            return;

        }

        const response = await fetch("/cek-email", {

            method: "POST",

            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            },

            body: JSON.stringify({
                email: this.value
            })

        });

        const result = await response.json();

        if (result.exists) {

            msg.innerText = "Email sudah terdaftar.";

        } else {

            msg.innerText = "";

        }

    });

}

const usernameInput = document.getElementById("reg-user");

if (usernameInput) {

    usernameInput.addEventListener("input", async function () {

        const msg = document.getElementById("user-msg");

        // kalau kurang dari 4 karakter jangan cek database
        if (this.value.length < 4) {

            msg.innerText = "";
            return;

        }

        const response = await fetch("/cek-username", {

            method: "POST",

            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            },

            body: JSON.stringify({
                username: this.value
            })

        });

        const result = await response.json();

        if (result.exists) {

            msg.innerText = "Username sudah digunakan.";

        } else {

            msg.innerText = "";

        }

    });

}