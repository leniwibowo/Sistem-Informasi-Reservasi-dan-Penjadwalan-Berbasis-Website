<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pemeriksaan</title>
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
        <a href="<?= base_url('/admin/pasienterjadwal') ?>"><i class="bi-calendar-event-fill"></i> Pasien Terjadwal</a>

    </div>

    <!-- Content -->
    <div class="content">
        <div class="container mt-4">
            <h3>Riwayat Pemeriksaan Pasien</h3>

            <!-- Biodata Pasien -->
            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>Nama:</strong> <?= $pasien['nama'] ?? '-' ?></p>
                    <p><strong>NIK:</strong> <?= $pasien['nik'] ?? '-' ?></p>
                    <p><strong>No. RM:</strong> <?= $pasien['no_RM'] ?? '-' ?></p>
                    <p><strong>Jenis Kelamin:</strong> <?= $pasien['jenis_kelamin'] ?? '-' ?></p>
                    <p><strong>Tanggal Lahir:</strong> <?= $pasien['tanggal_lahir'] ?? '-' ?></p>
                    <p><strong>No HP:</strong> <?= $pasien['no_hp'] ?? '-' ?></p>
                    <p><strong>Alamat:</strong> <?= $pasien['alamat'] ?? '-' ?></p>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Pemeriksaan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Keluhan</th>
                                    <th>Diagnosis</th>
                                    <th>Tindakan</th>
                                    <th>Resep</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($riwayat)): ?>
                                    <?php $no = 1;
                                    foreach ($riwayat as $row): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d-m-Y', strtotime($row['waktu'])) ?></td>
                                            <td><?= $row['nama_dokter'] ?></td>
                                            <td><?= $row['keluhan'] ?></td>
                                            <td><?= $row['diagnosis'] ?></td>
                                            <td><?= $row['pemeriksaan'] ?></td>
                                            <td><?= $row['resep'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada riwayat pemeriksaan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?= base_url('/admin/kelolapasien') ?>" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>