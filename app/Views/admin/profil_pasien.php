<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Profil Pasien
    </h1>
    <a href="javascript:history.back()" class="inline-flex items-center text-sm font-semibold text-gray-600 bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        Kembali
    </a>
</div>
<!-- profile pasien -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-sea-blue-500 p-6 md:p-8 text-white relative">
        <div class="flex flex-col md:flex-row items-center">
            <img class="h-28 w-28 md:h-32 md:w-32 rounded-full border-4 border-sea-blue-200 object-cover shadow-md"
                src="https://ui-avatars.com/api/?name=<?= urlencode(esc($pasien['nama'])) ?>&background=e0f2fe&color=075985&size=128&font-size=0.33&bold=true"
                alt="Foto Profil <?= esc($pasien['nama']) ?>">
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <h2 class="text-3xl font-bold"><?= esc($pasien['nama']) ?></h2>
                <p class="text-lg text-sea-blue-200 font-medium">No. Rekam Medis: <?= esc($pasien['no_RM']) ?></p>
            </div>
        </div>
    </div>

    <div class="p-6 md:p-8">

        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-sea-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Data Diri
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 text-base">
                <div>
                    <label class="text-sm font-medium text-gray-500">Nomor Induk Kependudukan (NIK)</label>
                    <p class="text-gray-900 font-semibold"><?= esc($pasien['nik']) ?></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                    <p class="text-gray-900 font-semibold"><?= esc($pasien['jenis_kelamin']) ?></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Tanggal Lahir</label>
                    <p class="text-gray-900 font-semibold"><?= date('d F Y', strtotime(esc($pasien['tanggal_lahir']))) ?></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Nomor Handphone</label>
                    <p class="text-gray-900 font-semibold"><?= esc($pasien['no_hp']) ?></p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-500">Alamat</label>
                    <p class="text-gray-900 font-semibold"><?= esc($pasien['alamat']) ?></p>
                </div>
            </div>
        </div>

        <hr class="my-8 border-t border-gray-200">

        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-sea-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                Informasi Medis
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 text-base">
                <div>
                    <label class="text-sm font-medium text-gray-500">Golongan Darah</label>
                    <p class="text-2xl font-bold text-red-600"><?= esc($pasien['golongan_darah']) ?></p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-500">Riwayat Alergi</label>
                    <p class="text-gray-900 font-semibold"><?= !empty($pasien['alergi']) ? esc($pasien['alergi']) : 'Tidak ada riwayat alergi' ?></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Riwayat Diabetes</label>
                    <div class="mt-1">
                        <?php if ($pasien['diabetes'] === 'Ya') : ?>
                            <span class="inline-flex items-center bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">Ada</span>
                        <?php else : ?>
                            <span class="inline-flex items-center bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">Tidak Ada</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Riwayat Penyakit Jantung</label>
                    <div class="mt-1">
                        <?php if ($pasien['penyakit_jantung'] === 'Ya') : ?>
                            <span class="inline-flex items-center bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">Ada</span>
                        <?php else : ?>
                            <span class="inline-flex items-center bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">Tidak Ada</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-gray-500 text-sm mt-8">
    <p>Data terakhir diperbarui pada: <?= date('d F Y H:i', strtotime(esc($pasien['updated_at']))) ?></p>
</footer>

<?= $this->endSection() ?>