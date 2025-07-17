<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
        <h2 class="text-center mb-4">Registrasi Pasien</h2>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>

        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">
            <div class="mb-3">
                <label for="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" value="<?= old('nik') ?>" required>
            </div>
            <div class="mb-3">
                <label for="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
            </div>
            <div class="mb-3">
                <label for="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>" required>
            </div>
            <div class="mb-3">
                <label for="form-label">Nomor Telepon</label>
                <input type="text" name="no_hp" class="form-control" value="<?= old('no_hp') ?>" required>
            </div>
            <div class="mb-3">
                <label for="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?= old('alamat') ?>" required>
            </div>
            <div class="mb-3">
                <label for="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="">--Pilih--</option>
                    <option value="laki-laki" <?= old('laki-laki') == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="perempuan" <?= old('perempuan') == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="md-3">
                <label for="form-label">Golongan Darah</label>
                <input type="text" name="golongan_darah" class="form-control" value="<?= old('golongan_darah') ?>" required>
            </div>
            <div class="md-3">
                <label for="form-label">Alergi</label>
                <input type="text" name="alergi" class="form-control" value="<?= old('alergi') ?>" required>
            </div>
            <div class="md-3">
                <label for="form-label">Diabetes</label>
                <select name="diabetes" class="form-control" required>
                    <option value="">--Pilih--</option>
                    <option value="ya" <?= old('diabetes') == 'ya' ? 'selected' : '' ?>>Ya</option>
                    <option value="tidak" <?= old('diabetes') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>
            <div class="md-3">
                <label for="form-label">Penyakit Jantung</label>
                <select name="penyakit_jantung" class="form-control" required>
                    <option value="">--Pilih--</option>
                    <option value="ya" <?= old('penyakit_jantung') == 'ya' ? 'selected' : '' ?>>Ya</option>
                    <option value="tidak" <?= old('penyakit_jantung') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>
            <div class="md-3">
                <label for="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
            </div>
            <div class="md-3">
                <label for="form-label">Password</label>
                <input type="text" name="password" class="form-control" value="<?= old('password') ?>" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-success">Daftar</button>
            </div>
        </form>

        <div class="text-center">
            <a href="<?= base_url('login') ?>">Sudah punya akun?Login</a>
        </div>

    </div>

</body>

</html>