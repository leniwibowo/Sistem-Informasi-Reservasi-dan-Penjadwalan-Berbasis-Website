<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2;
        }

        .sidebar {
            background-color: #ffffff;
            min-height: 100vh;
        }

        .sidebar a {
            display: block;
            padding: 1rem;
            color: #000;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #f2f2f2;
            border-radius: 8px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <div class="sidebar">
                    <a href="<?= base_url('/admin/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                    <a href="<?= base_url('/admin/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
                    <a href="<?= base_url('/admin/kelolapasien') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Pasien</a>
                    <a href="<?= base_url('/admin/keloladokter') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Dokter</a>
                    <a href="<?= base_url('/admin/pasienterjadwal') ?>"><i class="bi-calendar-event-fill"></i> Pasien Terjadwal</a>

                </div>
            </nav>

            <!-- Content -->
            <div class="col-md-10 p-4">
                <h2 class="mb-4 text-center">Edit Data Dokter</h2>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('/admin/updatedokter/' . $dokter['id_dokter']); ?>">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Dokter</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="<?= esc($dokter['nama']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= esc($dokter['no_hp']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= esc($dokter['username']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('/admin/keloladokter'); ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>