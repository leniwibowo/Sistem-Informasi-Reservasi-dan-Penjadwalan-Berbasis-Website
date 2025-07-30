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
            margin: 0;
            padding: 0;
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
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="<?= base_url('dokter/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
        <a href="<?= base_url('dokter/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
        <a href="<?= base_url('dokter/datapasien') ?>"><i class="bi bi-person-lines-fill"></i> Data Pasien</a>
        <a href="<?= base_url('dokter/pasienterjadwal') ?>"><i class="bi bi-easel2-fill"></i> Pasien Terjadwal</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h3 class="text-center">Riwayat Pemeriksaaan Pasien</h3>

        <!-- Header Identitas Pasien -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <!-- Data Diri Pasien -->
                    <div class="col-md-6">
                        <h4>Data Diri Pasien</h4>
                        <p class="mb-1"><strong>No RM:</strong> <?= esc($pasien['no_RM']) ?></p>
                        <p class="mb-1"><strong>Nama:</strong> <?= esc($pasien['nama']) ?></p>
                        <p class="mb-1"><strong>Tanggal Lahir:</strong> <?= date('d M Y', strtotime($pasien['tanggal_lahir'])) ?></p>
                        <p class="mb-1"><strong>Jenis Kelamin:</strong> <?= esc($pasien['jenis_kelamin']) ?></p>
                        <p class="mb-1"><strong>No Telepon:</strong> <?= esc($pasien['no_hp']) ?></p>
                    </div>
                    <!-- Data Medis Pasien -->
                    <div class="col-md-6">
                        <h4>Data Medis Pasien</h4>
                        <p class="mb-1"><strong>Golongan Darah:</strong> <?= esc($pasien['golongan_darah']) ?></p>
                        <p class="mb-1"><strong>Alergi:</strong> <?= esc($pasien['alergi']) ?></p>
                        <p class="mb-1"><strong>Penyakit Jantung:</strong> <?= esc($pasien['penyakit_jantung']) ?></p>
                        <p class="mb-1"><strong>Diabetes:</strong> <?= esc($pasien['diabetes']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">Riwayat Pemeriksaan</h5>
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
                <a href="<?= base_url('/dokter/antrian') ?>"></a>
            </div>
        </div>
    </div>

</body>

</html>