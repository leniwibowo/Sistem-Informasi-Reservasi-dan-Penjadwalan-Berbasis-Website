<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pemeriksaan Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
            margin-bottom: 10px;
            border-radius: 8px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <a href="<?= base_url('dokter/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                <a href="<?= base_url('dokter/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
                <a href="<?= base_url('dokter/datapasien') ?>"><i class="bi bi-person-lines-fill"></i> Data Pasien</a>
                <a href="<?= base_url('dokter/pasienterjadwal') ?>"><i class="bi bi-easel2-fill"></i> Pasien Terjadwal</a>
            </nav>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="topbar">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                </div>

                <!-- Header -->
                <h3 class="text-center">Pemeriksaan Pasien</h3>

                <!-- Data Pasien -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <!-- Kiri -->
                            <div class="col-md-6">
                                <h5>Data Diri Pasien</h5>
                                <p><strong>No RM:</strong> <?= esc($pasien['no_RM']) ?></p>
                                <p><strong>Nama:</strong> <?= esc($pasien['nama']) ?></p>
                                <p><strong>Tanggal Lahir:</strong> <?= date('d M Y', strtotime($pasien['tanggal_lahir'])) ?></p>
                                <p><strong>Jenis Kelamin:</strong> <?= esc($pasien['jenis_kelamin']) ?></p>
                                <p><strong>No Telepon:</strong> <?= esc($pasien['no_hp']) ?></p>
                            </div>

                            <!-- Kanan -->
                            <div class="col-md-6">
                                <h5>Data Medis Pasien</h5>
                                <p><strong>Golongan Darah:</strong> <?= esc($pasien['golongan_darah']) ?></p>
                                <p><strong>Alergi:</strong> <?= esc($pasien['alergi']) ?></p>
                                <p><strong>Penyakit Jantung:</strong> <?= esc($pasien['penyakit_jantung']) ?></p>
                                <p><strong>Diabetes:</strong> <?= esc($pasien['diabetes']) ?></p>
                                <p><strong><?= date('l, d F Y', strtotime($jadwal['tanggal_pemeriksaan'])) ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Pemeriksaan -->
                <form action="<?= base_url('dokter/pemeriksaan/' . $jadwal['id_jadwal']) ?>" method="post">
                    <input type="hidden" name="keluhan" value="<?= esc($jadwal['keluhan']) ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="keluhan" class="form-label">Keluhan</label>
                            <textarea name="keluhan" id="keluhan" class="form-control" rows="3"><?= esc($jadwal['keluhan']) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="resep" class="form-label">Resep</label>
                            <textarea name="resep" id="resep" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="tindakan" class="form-label">Tindakan</label>
                            <textarea name="tindakan" id="tindakan" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('dokter/jadwal/' . $jadwal['id_jadwal']) ?>"></a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>