<?= $this->extend('templates/pasien_layout') ?>

<?= $this->section('title') ?>
Pendaftaran Kunjungan Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- pendaftaran pasien -->
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-md border border-gray-200">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Kunjungan</h1>
            <p class="text-gray-500 mt-1">Silakan isi detail keluhan dan pilih tanggal kunjungan.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
                <i class="bi bi-exclamation-triangle-fill mr-3"></i>
                <div>
                    <span class="font-medium">Gagal!</span> <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
                <i class="bi bi-check-circle-fill mr-3"></i>
                <div>
                    <span class="font-medium">Berhasil!</span> <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="p-4 mb-6 border border-gray-200 bg-gray-50 rounded-lg space-y-2">
            <div class="flex justify-between text-sm">
                <span class="font-medium text-gray-600">No. Rekam Medis</span>
                <span class="font-mono font-semibold text-gray-800"><?= esc($pasien['no_RM']) ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="font-medium text-gray-600">Nama Pasien</span>
                <span class="font-semibold text-gray-800"><?= esc($pasien['nama']) ?></span>
            </div>
        </div>

        <form action="<?= base_url('antrian/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="space-y-6">
                <div>
                    <label for="keluhan" class="block mb-2 text-sm font-medium text-gray-900">
                        Keluhan Utama <span class="text-red-600">*</span>
                    </label>
                    <textarea name="keluhan" id="keluhan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-sky-500 focus:border-sky-500" placeholder="Tuliskan keluhan yang Anda rasakan secara detail..." required></textarea>
                </div>

                <div>
                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">
                        Pilih Tanggal Kunjungan <span class="text-red-600">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5"
                        min="<?= date('Y-m-d'); ?>"
                        max="<?= date('Y-m-d', strtotime('+2 days')); ?>"
                        required>
                    <p class="mt-1 text-xs text-gray-500">
                        Anda hanya dapat memilih jadwal untuk hari ini hingga 2 hari ke depan.
                    </p>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>