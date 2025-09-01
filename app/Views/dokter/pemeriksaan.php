<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Pemeriksaan Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">

    <!-- Informasi Pasien -->
    <div class="p-6 mb-8 bg-white border border-gray-200 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 gap-x-8 gap-y-4 md:grid-cols-2">
            <!-- Kolom Data Diri -->
            <div>
                <h4 class="pb-2 mb-3 text-lg font-semibold border-b text-sky-800">Data Diri Pasien</h4>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>No. RM:</strong> <span class="px-2 py-1 font-mono bg-gray-100 rounded"><?= esc($pasien['no_RM']) ?></span></p>
                    <p><strong>Nama:</strong> <?= esc($pasien['nama']) ?></p>
                    <p><strong>Tanggal Lahir:</strong> <?= date('d F Y', strtotime($pasien['tanggal_lahir'])) ?></p>
                    <p><strong>Jenis Kelamin:</strong> <span class="capitalize"><?= esc($pasien['jenis_kelamin']) ?></span></p>
                </div>
            </div>
            <!-- Kolom Data Medis -->
            <div>
                <h4 class="pb-2 mb-3 text-lg font-semibold border-b text-sky-800">Data Medis Pasien</h4>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Golongan Darah:</strong> <?= esc($pasien['golongan_darah']) ?></p>
                    <p><strong>Alergi:</strong> <?= esc($pasien['alergi']) ?: '-' ?></p>
                    <p><strong>Penyakit Jantung:</strong> <span class="capitalize"><?= esc($pasien['penyakit_jantung']) ?></span></p>
                    <p><strong>Diabetes:</strong> <span class="capitalize"><?= esc($pasien['diabetes']) ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Pemeriksaan -->
    <div class="p-6 bg-white rounded-xl shadow-lg">
        <form action="<?= base_url('dokter/pemeriksaan/' . $jadwal['id_jadwal']) ?>" method="post">
            <?= csrf_field(); ?>

            <input type="hidden" name="keluhan" value="<?= esc($jadwal['keluhan']) ?>">

            <!-- KELUHAN PASIEN (Teks Statis) -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Keluhan Utama Pasien</label>
                <div class="w-full p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-gray-800"><?= esc($jadwal['keluhan']) ?? 'Tidak ada keluhan awal yang dicatat.' ?></p>
                </div>
            </div>

            <!-- Form Isian Dokter -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="diagnosis" class="block mb-2 text-sm font-semibold text-gray-700">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" rows="4" placeholder="Tuliskan diagnosis..."></textarea>
                </div>
                <div>
                    <label for="tindakan" class="block mb-2 text-sm font-semibold text-gray-700">Tindakan</label>
                    <textarea name="tindakan" id="tindakan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" rows="4" placeholder="Tindakan yang diberikan..."></textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="resep" class="block mb-2 text-sm font-semibold text-gray-700">Resep Obat</label>
                    <textarea name="resep" id="resep" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" rows="4" placeholder="Tuliskan resep obat..."></textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="catatan" class="block mb-2 text-sm font-semibold text-gray-700">Catatan</label>
                    <textarea name="catatan" id="catatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" rows="4" placeholder="Tuliskan catatan utuk pasien"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-8">
                <a href="<?= base_url('/dokter/antrian'); ?>" class="px-6 py-2 font-bold text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Kembali ke Antrian
                </a>
                <button type="submit" class="px-6 py-2 font-bold text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-200">
                    Simpan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>