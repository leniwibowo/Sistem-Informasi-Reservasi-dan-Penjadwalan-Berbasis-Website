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
            padding: 20px;
            background-color: f0f0f0;
            border-radius: 8px;
        }

        .font-label {
            font-weight: bold;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
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
                <a href="<?= base_url('/riwayat') ?>"><i class="bi bi-easel2-fill"></i> Riwayat</a>
            </nav>

            <!-- main content -->
            <div class="col-10">
                <!-- topbar -->
                <div class="topbar">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                </div>
                <!-- riwayat sesction -->
                <?php if (empty($riwayat)): ?>
                    <div class="alert alert-info mt-4">Belum ada riwayat pemeriksaan.</div>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header d-flex justify-content-between">
                                <strong><?= strtoupper($r['nama_pasien']) ?></strong>
                                <small><?= date('l, d F Y', strtotime($r['waktu'])) ?></small>
                            </div>

                            <div class="card-body">
                                <p><i class="bi bi-pencil me-2"></i><strong>Keluhan:</strong><?= esc($r['keluhan']) ?></p>
                                <p><i class="bi bi-clipboard2 me-2"></i><strong>Diagnosis: </strong><?= esc($r['diagnosis']) ?></p>
                                <p><i class="bi bi-person-bunding-box me-2"></i><strong>Tindakan: </strong></p> Dokter <?= esc($r['nama_dokter']) ?>
                                <p><i class="bi bi-capsule me-2"></i><strong>Resep: </strong><?= $r['resep'] ? esc($r['resep']) : '_' ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>