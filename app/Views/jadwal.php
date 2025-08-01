<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #F2F2F2;
        }

        .sidebar {
            background-color: #ffff;
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


        .content {
            background-color: #d9d9d9;
            padding: 2rem;
            min-height: 100vh;
        }

        .card-costom {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
        }

        .btn-reschadule {
            background-color: white;
            color: red;
            border: 1px solid red;
        }

        .btn-hadir {
            background-color: white;
            color: black;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- ini adalah sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <a href="<?= base_url('/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                <a href="<?= base_url('/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Pendaftaran Pasien</a>
                <a href="<?= base_url('/jadwal') ?>"><i class="bi bi-person-lines-fill"></i> Jadwal</a>
                <a href="<?= base_url('/riwayat_pemeriksaan') ?>"><i class="bi bi-easel2-fill"></i> Riwayat</a>
            </nav>

            <!-- main content -->
            <div class="col-10">
                <!-- topbar -->
                <div class="topbar">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                </div>

                <h4 class="text-center mb-4">PENDAFTARAN</h4>

                <div class="card-costom">
                    <div class="row fw-bold border-bottom pb-2 mb-3">
                        <div class="col">Hari/Tanggal</div>
                        <div class="col">Nomor Antrian</div>
                        <div class="col">Jam</div>
                        <div class="col">Dokter</div>
                        <div class="col">Keluhan</div>
                        <div class="col">Pemeriksaan</div>
                    </div>

                    <?php if (isset($jadwal_pasien) && $jadwal_pasien): ?>
                        <div class="row mb-4">
                            <div class="col"><?= date('l,d F Y', strtotime($jadwal_pasien['tanggal'])) ?></div>
                            <div class="col"><?= esc($jadwal_pasien['no_antrian']) ?></div>
                            <div class="col"><?= esc($jadwal_pasien['jam'] ?? '-') ?></div>
                            <div class="col"><?= esc($jadwal_pasien['nama_dokter'] ?? '_') ?></div>
                            <div class="col"><?= esc($jadwal_pasien['keluhan'] ?? '_') ?></div>
                            <div class="col"><?= esc($jadwal_pasien['pemeriksaan'] ?? '-') ?></div>
                        </div>

                        <div class="text-center">
                            <a href="/jadwal/reschedule/<?= $jadwal_pasien['id_antrian'] ?>" class="btn btn-rescedule me-3">Reschedule</a>
                            <a href="/jadwal/hadir/<?= $jadwal_pasien['id_antrian'] ?>" class="btn btn-hadir">Hadir</a>
                        </div>

                    <?php else: ?>
                        <p class="text-center">Belum ada jadwal.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>



    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>