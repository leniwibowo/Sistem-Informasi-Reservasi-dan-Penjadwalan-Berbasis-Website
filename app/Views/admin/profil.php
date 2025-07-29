<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profil Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <a href="<?= base_url('/admin/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                <a href="<?= base_url('/admin/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
                <a href="<?= base_url('/admin/kelolapasien') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Pasien</a>
                <a href="<?= base_url('/admin/keloladokter') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Dokter</a>
                <a href="<?= base_url('/admin/pasienterjadwal') ?>"><i class="bi bi-calendar-event-fill"></i> Pasien Terjadwal</a>
                <a href="<?= base_url('/admin/profil') ?>" class="fw-bold"><i class="bi bi-person-circle"></i> Profil</a>
            </nav>

            <!-- Content -->
            <div class="col-md-10 p-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-dark text-white rounded-top-4">
                        <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profil Admin</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm p-3 h-100">
                                    <h5 class="text-primary border-bottom pb-2 mb-3">Data Admin</h5>
                                    <p><strong>Nama:</strong> <?= esc($admin['nama']) ?></p>
                                    <p><strong>Username:</strong> <?= esc($admin['username']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <a href="<?= base_url('/logout') ?>" class="btn btn-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>