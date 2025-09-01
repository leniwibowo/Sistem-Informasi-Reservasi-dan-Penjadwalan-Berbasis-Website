<?= $this->extend('templates/pasien_layout') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Profil Pasien</h1>
    <p class="mt-1 text-gray-500">Berikut adalah detail data diri dan data medik Anda yang terdaftar di sistem.</p>
</div>

<!-- profil pasien -->
<div class="bg-white p-6 sm:p-8 rounded-xl shadow-md border border-gray-200">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="p-5 bg-gray-50 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold text-sky-700 border-b pb-3 mb-4 flex items-center">
                <i class="bi bi-person-vcard-fill mr-3"></i>
                Data Diri
            </h3>
            <dl class="space-y-4 text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">No. RM</dt>
                    <dd class="sm:col-span-2 font-semibold text-gray-900 font-mono"><?= esc($pasien['no_RM']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">Nama Lengkap</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= esc($pasien['nama']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">TTL / Gender</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= date('d F Y', strtotime($pasien['tanggal_lahir'])) ?> / <?= esc($pasien['jenis_kelamin']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">No. Telepon</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= esc($pasien['no_hp']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">Alamat</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= esc($pasien['alamat']) ?></dd>
                </div>
            </dl>
        </div>

        <div class="p-5 bg-gray-50 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold text-sky-700 border-b pb-3 mb-4 flex items-center">
                <i class="bi bi-file-earmark-medical-fill mr-3"></i>
                Data Medik
            </h3>
            <dl class="space-y-4 text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">Gol. Darah</dt>
                    <dd class="sm:col-span-2 font-semibold text-gray-900"><?= esc($pasien['golongan_darah']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">Alergi</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= esc($pasien['alergi']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">Diabetes</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= esc($pasien['diabetes']) ?></dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1">
                    <dt class="font-medium text-gray-500">Penyakit Jantung</dt>
                    <dd class="sm:col-span-2 text-gray-800"><?= esc($pasien['penyakit_jantung']) ?></dd>
                </div>
            </dl>
        </div>

    </div>

    <div class="flex justify-end items-center mt-8 pt-6 border-t">
        <a href="<?= base_url('/dashboard') ?>" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg mr-3 transition-colors">
            <i class="bi bi-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
        <a href="<?= base_url('/logout') ?>" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
            <i class="bi bi-box-arrow-right mr-2"></i>
            Logout
        </a>
    </div>

</div>

<?= $this->endSection() ?>