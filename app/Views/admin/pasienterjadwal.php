<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pasien Terjadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2;
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
            background-color: #f2f2f2;
            border-radius: 8px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <a href="<?= base_url('/admin/dashboard'); ?>">Dashboard</a>
                <a href="<?= base_url('/admin/antrian'); ?>">Antrian Pasien</a>
                <a href="<?= base_url('/admin/kelolapasien'); ?>">Kelola Data Pasien</a>
                <a href="<?= base_url('/admin/keloladokter'); ?>">Kelola Dokter</a>
                <a href="<?= base_url('/admin/pasienterjadwal'); ?>">Pasien Terjadwal</a>
            </nav>

            <div class="col-md-10 p-4">
                <h2 class="mb-4">Cari Pasien untuk Penjadwalan</h2>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif;  ?>

                <form method="get" class="d-flex mb-4">
                    <input type="text" name="keyword" class="form-control me-2" placeholder="Masukkan nama atau No RM">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>

                <?php if (!empty($pasien)) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No RM</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No Hp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($pasien as $p) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($p['no_RM']) ?></td>
                                        <td><?= esc($p['nama']) ?></td>
                                        <td><?= esc($p['jenis_kelamin']) ?></td>
                                        <td><?= esc($p['no_hp']) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/tambahjadwalpasien/' . $p['id_pasien']); ?>" class="btn btn-sm btn-success">
                                                Jadwalkan
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php elseif (isset($_GET['keyword'])) : ?>
                    <div class="alert alert-warning">Pasien tidak ditemukan</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>