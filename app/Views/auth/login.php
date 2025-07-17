<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<!-- <style>
    /* style.css */

    body {
        font-family: Arial, sans-serif;
        background-color: #f97979;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 400;
        margin: 50px auto;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 9px;
        background-color: white;
        text-align: center;
    }

    input[type="text"],
    input[type="password"] {
        width: 90%;
        padding: 6px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #333;
    }

    button {
        padding: 10px 30px;
        border: 1px solid #333;
        border-radius: 8px;
        background-color: white;
        cursor: pointer;
    }

    a {
        text-decoration: none;
        color: #333;
        margin-left: 10px;
        font-size: 14px;
    }
</style> -->

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStTTZUrtEDMUqe8T-pAy7jLiPVWf7cjv3SjA&s" alt="Logo" class="img-fluid" style="width: 150px; height: 150px;">
            <h2 class="mt-3">Login Pasien</h2>
        </div>
        <?php if (session()->getFlashdata('error')) : ?>
            <p style="color:red"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>
        <form action="<?= base_url('login') ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <div class="text-center">
            <a href="<?= base_url('register') ?>">Belum punya akun? Daftar</a>
        </div>
        <div class="text-center">
            <a href="<?= base_url('auth/lupa-password') ?>">Lupa Password?</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>