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


                <!-- konten -->
                <div class="content mt-6">

                    <div class="form-container">
                        <h4 class="text-center mb-4">PENDAFTARAN</h4>
                        <p><strong>No RM: </strong><?= esc($pasien['no_RM']) ?></p>
                        <p><strong>Nama: </strong><?= esc($pasien['nama']) ?></p>


                        <form action="<?= base_url('antrian/simpan') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="keluhan" class="form-label">Keluhan</label>
                                <textarea name="keluhan" class="form-control" rows="5" placeholder="Catat keluhan..."></textarea>

                            </div>

                            <div class="md-3">
                                <label for="jadwal" class="form-label">Hari, tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    min="<?= date('Y-m-d'); ?>"
                                    max="<?= date('Y-m-d', strtotime('+2 days')); ?>"
                                    required>
                            </div>
                            <br>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Daftar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>