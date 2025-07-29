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
                <a href="<?= base_url('dokter/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                <a href="<?= base_url('dokter/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
                <a href="<?= base_url('dokter/datapasien') ?>"><i class="bi bi-person-lines-fill"></i> Data Pasien</a>
                <a href="<?= base_url('dokter/pasienterjadwal') ?>"><i class="bi bi-easel2-fill"></i> Pasien Terjadwal</a>
            </nav>
            <div class="col md-10">
                <div class="topbar">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                </div>
                <div class="container mt-4">
                    <h3 class="mb-4 text-center">Data Pasien</h3>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">



                                <tr class="text-center">
                                    <td>No</td>
                                    <td>no_RM</td>
                                    <td>Nama Pasien</td>
                                    <td>Alamat</td>
                                    <td>No Hp</td>
                                    <td>Jenis Kelamin</td>
                                    <td>Tanggal Lahir</td>
                                    <td>Aksi</td>

                                </tr>

                            </thead>
                            <tbody>
                                <?php if (!empty($pasien)) : ?>
                                    <?php $no = 1;
                                    foreach ($pasien as $p) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= esc($p['no_RM']); ?></td>
                                            <td class="text-center"><?= esc($p['nama']); ?></td>
                                            <td class="text-center"><?= esc($p['alamat']); ?></td>
                                            <td class="text-center"><?= esc($p['no_hp']); ?></td>
                                            <td class="text-center"><?= esc($p['Jenis_kelamin']); ?></td>
                                            <td class="text-center"><?= date('d-m-y', strtotime($p['tanggal_lahir'])); ?></td>

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
                                            <i class="bi bi-info-circle"></i> Belum ada pasien yang melakukan pemeriksaan.
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