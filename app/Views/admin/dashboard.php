<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #F2F2F2;
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
            background-color: #F2F2F2;
            border-radius: 8px;
        }

        .topbar {
            height: 60px;
            background-color: #ffffff;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 20px;
            margin-top: 10px;
            border-radius: 8px;
        }

        .card-icon {
            font-size: 2rem;
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card p {
            margin: 0;
        }

        .number-box {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000;
        }

        .card-title i {
            margin-left: 8px;
        }

        .sidebar a.active {
            background-color: #ffffff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <div class="sidebar">
                    <a href="<?= base_url('/admin/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                    <a href="<?= base_url('/admin/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
                    <a href="<?= base_url('/admin/kelolapasien') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Pasien</a>
                    <a href="<?= base_url('/admin/keloladokter') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Dokter</a>
                    <a href="<?= base_url('/admin/kelolaadmin') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Admin</a>
                    <a href="<?= base_url('/admin/pasienterjadwal') ?>"><i class="bi-calendar-event-fill"></i> Pasien Terjadwal</a>

                </div>
            </nav>

            <!-- Main Content -->
            <div class="col-md-10">
                <!-- Topbar -->
                <div class="topbar dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfile">
                        <li><a class="dropdown-item" href="<?= base_url('/profil') ?>">Lihat Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('/logout') ?>">Logout</a></li>
                    </ul>
                </div>

                <!-- Dashboard Content -->
                <div class="p-4">
                    <div class="dashboard-title mb-4">DASHBORD</div>

                    <div class="row g-3">
                        <!-- Antrian -->
                        <div class="col-md-4">
                            <div class="card bg-primary text-white shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between align-items-center">
                                        Antrian
                                        <i class="bi bi-people card-icon"></i>
                                    </h5>
                                    <p class="text-muted mt-3">
                                        <?= $antrian ? "$antrian pasien" : "Tidak ada daftar antrian" ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Sisa Antrian -->
                        <div class="col-md-4">
                            <div class="card bg-warning text-white shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between align-items-center">
                                        Sisa Antrian
                                        <i class="bi bi-people card-icon"></i>
                                    </h5>
                                    <p class="text-muted mt-3">
                                        <?= $sisa_antrian ? "$sisa_antrian pasien" : "Tidak ada daftar antrian" ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between align-items-center">
                                        Sisa Antrian
                                        <i class="bi bi-people card-icon"></i>
                                    </h5>
                                    <p class="text-muted mt-3">
                                        <?= $sisa_antrian ? "$sisa_antrian pasien" : "Tidak ada daftar antrian" ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal -->

                    </div>
                </div> <!-- end dashboard content -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>