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
                <a href="<?= base_url('/admin/dashboard'); ?>">Dashboard</a>
                <a href="<?= base_url('/admin/antrian'); ?>">Antrian Pasien</a>
                <a href="<?= base_url('/admin/kelolapasien'); ?>">kelola Data Pasien</a>
                <a href="<?= base_url('/admin/kekoldokter'); ?>">Kelola Dokter</a>
                <a href="<?= base_url('/admin/pasienterjadwal'); ?>">Pasien Terjadwal</a>
            </nav>
            <div class="col md-10">
                <div class="topbar">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                </div>
                <div class="container mt-5">
                    <h3 class="mb-4 text-center">Daftar Antrian Pasien Hari Ini</h3>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">



                                <tr class="text-center">
                                    <td>No</td>
                                    <td>Nomor Antrian</td>
                                    <td>Nama Pasien</td>
                                    <td>Hari, Tanggal</td>
                                    <td>Status</td>
                                    <td>Aksi</td>

                                </tr>

                            </thead>
                            <tbody>
                                <?php if (!empty($antrian)) : ?>
                                    <?php $no = 1;
                                    foreach ($pasienTerdaftar as $pasien) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= esc($pasien['id_antrian']) ?></td>
                                            <td><?= esc($pasien['nama_pasien']) ?></td>
                                            <td><?= date('l, d F Y', strtotime($pasien['tanggal_pemeriksaan'])); ?></td>
                                            <td class="text-center">
                                                <?php if ($pasien['status'] === 'Menunggu') : ?>
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                <?php else : ?>
                                                    <span class="badge bg-success">Sudah Diperiksa</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/updatepasien/' . $a['id_jadwal']) ?>"
                                                    class="btn btn-sm btn-info me-1"
                                                    title="Pemeriksaan Pasien">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="<?= base_url('admin/riwayat/' . $a['id_pasien']) ?>"
                                                    class="btn btn-sm btn-warning"
                                                    title="Riwayat Pemeriksaan">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/profil/' . $a['id_pasien']) ?>"
                                                    class="btn btn-sm btn-primary"
                                                    title="Data Pasien">
                                                    <i class="bi bi-person"></i>
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