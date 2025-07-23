<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>


        <div class="container mt-5">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-dark text-white rounded-top-4">
                    <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profil Pasien</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm p-3 h-100">
                                <h5 class="text-primary border-bottom pb-2 mb-3">Data Pasien</h5>
                                <p><strong>No RM:</strong> <?= esc($pasien['no_RM']) ?></p>
                                <p><strong>Nama:</strong> <?= esc($pasien['nama']) ?></p>
                                <p><strong>Tanggal Lahir:</strong> <?= esc($pasien['tanggal_lahir']) ?>, <?= date('d F Y', strtotime($pasien['tanggal_lahir'])) ?> / <?= esc($pasien['jenis_kelamin']) ?></p>
                                <p><strong>No Telepon:</strong> <?= esc($pasien['no_hp']) ?></p>
                                <p><strong>Alamat:</strong> <?= esc($pasien['alamat']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm p-3 h-100">
                                <h5 class="text-primary border-bottom pb-2 mb-3">Data Medik</h5>
                                <p><strong>Golongan Darah:</strong> <?= esc($pasien['golongan_darah']) ?></p>
                                <p><strong>Alergi:</strong> <?= esc($pasien['alergi']) ?></p>
                                <p><strong>Diabetes:</strong> <?= esc($pasien['diabetes']) ?></p>
                                <p><strong>Penyakit Jantung:</strong> <?= esc($pasien['penyakit_jantung']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="<?= base_url('/logout') ?>" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>



    </body>

    </html>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>