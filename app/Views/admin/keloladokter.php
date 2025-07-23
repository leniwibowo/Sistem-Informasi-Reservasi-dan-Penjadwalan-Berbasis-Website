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
                <a href="<?= base_url('/admin/dashboard'); ?>">Dashboard</a>
                <a href="<?= base_url('/admin/antrian'); ?>">Antrian Pasien</a>
                <a href="<?= base_url('/admin/kelolapasien'); ?>">Kelola Data Pasien</a>
                <a href="<?= base_url('/admin/keloladokter'); ?>">Kelola Dokter</a>
                <a href="<?= base_url('/admin/pasienterjadwal'); ?>">Pasien Terjadwal</a>
            </nav>

            <!-- Konten -->
            <div class="col-md-10 p-4">
                <h3 class="mb-4 text-center">Kelola Data Dokter</h3>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mb-3">
                    <a href="<?= base_url('/admin/tambahdoktern'); ?>" class="btn btn-primary">Tambah Dokter</a>
                    <form method="get" class="d-flex" action="<?= base_url('/admin/keloladokter'); ?>">
                        <input type="text" name="keyword" class="form-control me-2" placeholder="Cari nama">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>

                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dokter)) : ?>
                                <?php $no = 1;
                                foreach ($dokter as $d) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= esc($d['nama']) ?></td>
                                        <td><?= esc($d['no_hp']) ?></td>

                                        <td class="text-center">
                                            <a href="<?= base_url('admin/editdokter/' . $d['id_dokter']) ?>"
                                                class="btn btn-sm btn-info me-1"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="<?= base_url('admin/hapusdokter/' . $d['id_dokter']) ?>"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
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