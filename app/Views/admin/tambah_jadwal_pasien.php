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
                <h2 class="mb-4 text-center">Tambahkan Jadwal Pasien</h2>

                <div class="row g-3 mb-4 align-items-stretch">
                    <div class="col md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card body">
                                <h5 class="class-title">Data Pasien</h5>
                                <p><strong>No RM:</strong> <?= esc($pasien['no_RM']); ?></p>
                                <p><strong>Nama:</strong> <?= esc($pasien['nama']); ?></p>
                                <p><strong>Jenis Kelamin:</strong> <?= esc($pasien['jenis_kelamin']); ?></p>
                                <p><strong>No Telepon:</strong> <?= esc($pasien['no_hp']); ?></p>
                                <p><strong>Alamat:</strong> <?= esc($pasien['alamat']); ?></p>
                            </div>

                        </div>
                    </div>
                    <div class="col md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card body">
                                <h5 class="class-title">Data Medis</h5>
                                <p><strong>Alergi:</strong> <?= esc($pasien['alergi']); ?></p>
                                <p><strong>Golongan Darah</strong> <?= esc($pasien['golongan_darah']); ?></p>
                                <p><strong>Penyakit Jantung:</strong> <?= esc($pasien['penyakit_jantung']); ?></p>
                                <p><strong>Diabetes:</strong> <?= esc($pasien['diabetes']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Form Penjadwalan -->
                <form method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                        <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_dokter" class="form-label">Pilih Dokter</label>
                        <select name="id_dokter" id="id_dokter" class="form-select" required>
                            <option value="">-- Pilih Dokter --</option>
                            <?php if (!empty($dokter)) : ?>
                                <?php foreach ($dokter as $d) : ?>
                                    <option value="<?= $d['id_dokter']; ?>"><?= esc($d['nama']); ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option disabled>Silakan pilih tanggal dulu untuk memunculkan dokter sesuai jadwal.</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pemeriksaan" class="form-label">Pemeriksaan</label>
                        <textarea name="pemeriksaan" id="pemeriksaan" rows="4" class="form-control" placeholder="Catatan pemeriksaan"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Jadwal</button>
                    <a href="<?= base_url('/admin/pasienterjadwal'); ?>" class="btn btn-secondary">Batal</a>
                </form>

            </div>



        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>