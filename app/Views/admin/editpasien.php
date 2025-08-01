<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Pasien</title>
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
            <h3>Edit Data Pasien</h3>

            <form action="<?= base_url('/admin/updatepasien/' . $pasien['id_pasien']) ?>" method="post">
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" id="nik" value="<?= $pasien['nik'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="no_RM" class="form-label">No RM</label>
                    <input type="text" name="no_RM" class="form-control" id="no_RM" value="<?= $pasien['no_RM'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pasien</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $pasien['nama'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                        <option value="Laki-laki" <?= $pasien['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $pasien['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?= $pasien['tanggal_lahir'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" id="no_hp" value="<?= $pasien['no_hp'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" required><?= $pasien['alamat'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="alergi" class="form-label">Alergi</label>
                    <input type="text" name="alergi" class="form-control" id="alergi" value="<?= $pasien['alergi'] ?>">
                </div>

                <div class="mb-3">
                    <label for="golongan_darah" class="form-label">Golongan Darah</label>
                    <input type="text" name="golongan_darah" class="form-control" id="golongan_darah" value="<?= $pasien['golongan_darah'] ?>">
                </div>

                <div class="mb-3">
                    <label for="penyakit_jantung" class="form-label">Penyakit Jantung</label>
                    <input type="text" name="penyakit_jantung" class="form-control" id="penyakit_jantung" value="<?= $pasien['penyakit_jantung'] ?>">
                </div>

                <div class="mb-3">
                    <label for="diabetes" class="form-label">Diabetes</label>
                    <input type="text" name="diabetes" class="form-control" id="diabetes" value="<?= $pasien['diabetes'] ?>">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username (opsional)</label>
                    <input type="text" name="username" class="form-control" id="username" value="<?= $pasien['username'] ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password (opsional)</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Isi jika ingin mengganti password">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('/admin/kelolapasien') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</body>

</html>