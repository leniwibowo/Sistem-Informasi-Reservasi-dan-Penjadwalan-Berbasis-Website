<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar py-4">
                <a href="<?= base_url('/admin/dashboard') ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                <a href="<?= base_url('/admin/antrian') ?>"><i class="bi bi-person-badge-fill"></i> Antrian Pasien</a>
                <a href="<?= base_url('/admin/kelolapasien') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Pasien</a>
                <a href="<?= base_url('/admin/keloladokter') ?>"><i class="bi bi-person-lines-fill"></i> Kelola Dokter</a>
                <a href="<?= base_url('/admin/pasienterjadwal') ?>"><i class="bi-calendar-event-fill"></i> Pasien Terjadwal</a>


            </nav>

            <!-- Konten -->
            <div class="col-md-10 p-4">
                <h3 class="mb-4 text-center">Kelola Data Pasien</h3>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mb-3">
                    <a href="<?= base_url('/admin/tambahpasien'); ?>" class="btn btn-primary">Tambah Pasien</a>
                    <form method="get" class="d-flex" action="<?= base_url('/admin/kelolapasien'); ?>">
                        <input type="text" name="keyword" class="form-control me-2" placeholder="Cari nama atau No RM">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>No RM</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pasien)) : ?>
                                <?php $no = 1;
                                foreach ($pasien as $p) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= esc($p['no_RM']) ?></td>
                                        <td><?= esc($p['nama']) ?></td>
                                        <td><?= esc($p['jenis_kelamin']) ?></td>
                                        <td><?= esc($p['no_hp']) ?></td>
                                        <td><?= esc($p['alamat']) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/editpasien/' . $p['id_pasien']) ?>"
                                                class="btn btn-sm btn-info me-1"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="<?= base_url('admin/riwayatpemeriksaan/' . $p['id_pasien']) ?>"
                                                class="btn btn-sm btn-warning"
                                                title="Riwayat Pemeriksaan">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/hapuspasien/' . $p['id_pasien']) ?>"
                                                class="btn btn-sm btn-danger"
                                                title="Edit">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle"></i> Tidak ada data pasien.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>