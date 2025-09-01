<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Profil Dokter
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
    <p class="mt-1 text-gray-500">Berikut adalah detail informasi Anda yang terdaftar di sistem.</p>
</div>

<div class="max-w-xl mx-auto">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-md border border-gray-200">

        <div class="border-b pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="bi bi-person-circle text-sea-blue-600 mr-3 text-2xl"></i>
                Data Pribadi
            </h2>
        </div>

        <dl class="space-y-6 text-sm">
            <div>
                <dt class="font-medium text-gray-500">Nama Lengkap</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900"><?= esc($dokter['nama']) ?></dd>
            </div>
            <div>
                <dt class="font-medium text-gray-500">Nomor Telepon</dt>
                <dd class="mt-1 text-lg text-gray-900"><?= esc($dokter['no_hp']) ?></dd>
            </div>
        </dl>

        <div class="flex justify-end items-center mt-8 pt-6 border-t border-gray-200">
            <a href="<?= base_url('/dokter/dashboard') ?>" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg mr-3 transition-colors">
                <i class="bi bi-arrow-left mr-2"></i>
                Kembali
            </a>
            <a href="<?= base_url('/logout') ?>" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                <i class="bi bi-box-arrow-right mr-2"></i>
                Logout
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>