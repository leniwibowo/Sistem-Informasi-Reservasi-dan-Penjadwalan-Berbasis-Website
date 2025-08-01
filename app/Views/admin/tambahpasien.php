<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .form-wrapper {
            max-width: 700px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="<?= base_url('/admin/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
        <a href="<?= base_url('/admin/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
        <a href="<?= base_url('/admin/kelolapasien') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Pasien</a>
        <a href="<?= base_url('/admin/keloladokter') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Dokter</a>
        <a href="<?= base_url('/admin/kelolaadmin') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Admin</a>
        <a href="<?= base_url('/admin/pasienterjadwal') ?>"><i class="bi-calendar-event-fill"></i> Pasien Terjadwal</a>

    </div>

    <!-- Content -->
    <div class="content">
        <div class="container mt-4">
            <div class="form-wrapper">
                <h4 class="mb-4 text-center">Tambah Data Pasien</h4>

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
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?= old('nik') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= old('no_hp') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="<?= old('alamat') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">--Pilih--</option>
                            <option value="laki-laki" <?= old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="perempuan" <?= old('jenis_kelamin') == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Golongan Darah</label>
                        <input type="text" name="golongan_darah" class="form-control" value="<?= old('golongan_darah') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alergi</label>
                        <input type="text" name="alergi" class="form-control" value="<?= old('alergi') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diabetes</label>
                        <select name="diabetes" class="form-control" required>
                            <option value="">--Pilih--</option>
                            <option value="ya" <?= old('diabetes') == 'ya' ? 'selected' : '' ?>>Ya</option>
                            <option value="tidak" <?= old('diabetes') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyakit Jantung</label>
                        <select name="penyakit_jantung" class="form-control" required>
                            <option value="">--Pilih--</option>
                            <option value="ya" <?= old('penyakit_jantung') == 'ya' ? 'selected' : '' ?>>Ya</option>
                            <option value="tidak" <?= old('penyakit_jantung') == 'tidak' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" value="<?= old('password') ?>" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success">Tambah Pasien</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>