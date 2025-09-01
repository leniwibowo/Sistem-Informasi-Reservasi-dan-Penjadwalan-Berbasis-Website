<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

        <div class="bg-gray-800 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-x-3">
                <i class="bi bi-person-circle"></i>
                <span>Profil Admin</span>
            </h2>
        </div>

        <div class="p-6 md:p-8">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-5">Informasi Akun</h3>

            <div class="space-y-5">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Nama Lengkap</p>
                    <p class="text-lg text-gray-900 font-semibold"><?= esc($admin['nama']) ?></p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Username</p>
                    <p class="text-lg text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded-md inline-block"><?= esc($admin['username']) ?></p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end items-center gap-x-3">
            <a href="<?= base_url('/admin/dashboard') ?>" class="inline-flex items-center gap-x-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
            <a href="<?= base_url('/logout') ?>" class="inline-flex items-center gap-x-2 px-4 py-2 bg-red-600 border border-transparent text-white font-semibold text-sm rounded-lg hover:bg-red-700 transition-colors duration-200">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>