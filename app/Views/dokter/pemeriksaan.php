<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pemeriksaan Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar py-4">
            <a href="<?= base_url('dokter/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <a href="<?= base_url('dokter/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
            <a href="<?= base_url('dokter/datapasien') ?>"><i class="bi bi-person-lines-fill"></i> Data Pasien</a>
            <a href="<?= base_url('dokter/pasienterjadwal') ?>"><i class="bi bi-easel2-fill"></i> Pasien Terjadwal</a>
        </nav>

        <div class="col-md-10">
            <div class="topbar">
                <i class="bi bi-person" style="font-size: 1.5rem;"></i>
            </div>
            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <!-- Header Identitas Pasien -->
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">No RM: <?= esc($pasien['id_pasien']) ?></p>
                            <p class="mb-1">Nama: <?= esc($pasien['nama_lengkap']) ?></p>
                            <p class="mb-1">Tanggal Lahir: <?= esc($pasien['alamat']) ?>, <?= date('d M Y', strtotime($pasien['tanggal_lahir'])) ?></p>
                        </div>
                        <div class="text-end">
                            <p class="mb-1">Jenis Kelamin: <?= esc($pasien['jenis_kelamin']) ?></p>
                            <p class="mb-1">No Telepon: <?= esc($pasien['no_hp']) ?></p>
                            <p class="mb-1"><?= date('l, d F Y', strtotime($jadwal['tanggal_pemeriksaan'])) ?></p>

                        </div>
                    </div>
                </div>

                <!-- Form Pemeriksaan -->
                <form action="<?= base_url('dokter/simpan_pemeriksaan/' . $jadwal['id_jadwal']) ?>" method="post">
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
                        <a href="<?= base_url('dokter/jadwal_kontrol/' . $jadwal['id_jadwal']) ?>" class="btn btn-secondary">Jadwalkan</a>
                    </div>
                </form>
            </div>
        </div>


    </div>

</body>

</html>