<?php
session_start();
include 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SISURAT KELURAHAN OEBA</title>
    <!-- Link ke Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" />

</head>
<style>
body {
    background: linear-gradient(to bottom right, #87a2ff, #4b6cb7);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}
</style>

<body>
    <div class="container d-flex flex-column h-100 justify-content-center align-items-center">
        <div class="header text-center mb-5">
            <h2>SELAMAT DATANG DI SISTEM INFORMASI<br>SURAT MASUK & SURAT KELUAR<br>KELURAHAN OEBA</h2>
        </div>

        <div class="login-box p-7">
            <h4 class="text-center mb-4">Login</h4>
            <form id="loginForm" method="post" action="proses_login.php">
                <div class="mb-3 d-flex align-items-center">
                    <label for="username" class="form-label me-2">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required
                        placeholder="Masukkan username Anda">
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <label for="password" class="form-label me-2">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required
                            placeholder="Masukkan password Anda">
                        <button class="btn  btn-primary" type="button" onclick="togglePasswordVisibility()">
                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
            </form>

            <?php
            if (isset($_SESSION['login_failed'])) {
                echo '<div class="alert alert-danger mt-3" role="alert">
                        ' . $_SESSION['login_failed'] . '
                      </div>';
                unset($_SESSION['login_failed']);
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("togglePasswordIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        }
    }
    </script>
</body>

</html>