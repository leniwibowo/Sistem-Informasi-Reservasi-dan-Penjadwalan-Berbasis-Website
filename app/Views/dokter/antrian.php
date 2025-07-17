<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Antrian Pasien</title>
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
            margin-top: 10px;
            border-radius: 8px;
        }

        .card-icon {
            font-size: 2rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 sidebar py-4">
                <a href="<?= base_url('/dokter/dashboard'); ?>">Dashboard</a>
                <a href="<?= base_url('/dokter/antrian'); ?>">Antrian Pasien</a>
                <a href="<?= base_url('/jadwal'); ?>">Data Pasien</a>
                <a href="<?= base_url('/riwayat'); ?>">Pasien Terjadwal</a>
            </nav>
            <div class="col md-10">
                <div class="topbar">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                </div>
                <div class="container mt-5">
                    <h3 class="mb-4 text-center">Daftar Antrian Pasien Hari Ini</h3>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nomor Antrian</th>
                                    <th>Nama Pasien</th>
                                    <th>Keluhan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($antrian)) : ?>
                                    <?php $no = 1;
                                    foreach ($antrian as $a) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= esc($a['id_antrian']) ?></td>
                                            <td><?= esc($a['nama_lengkap']) ?></td>
                                            <td><?= esc($a['keluhan']) ?></td>
                                            <td class="text-center">
                                                <?php if ($a['status'] === 'belum_hadir') : ?>
                                                    <span class="badge bg-warning text-dark">Belum Hadir</span>
                                                <?php else : ?>
                                                    <span class="badge bg-success">Sudah Diperiksa</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('dokter/periksa/' . $a['id_jadwal']) ?>"
                                                    class="btn btn-sm btn-primary me-1"
                                                    title="Pemeriksaan Pasien">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="<?= base_url('dokter/riwayat/' . $a['id_pasien']) ?>"
                                                    class="btn btn-sm btn-secondary"
                                                    title="Riwayat Pemeriksaan">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="bi bi-info-circle"></i> Tidak ada antrian hari ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>



        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.js"></script>
</body>

</html>