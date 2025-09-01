<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Data Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-start mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Data Pasien</h1>
        <p class="mt-1 text-gray-500">Cari, lihat, dan kelola semua data pasien yang terdaftar di klinik.</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

    <!-- Tabel untuk desktop -->
    <div class="overflow-x-auto hidden lg:block">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4">Nama Pasien</th>
                    <th scope="col" class="px-6 py-4">Alamat</th>
                    <th scope="col" class="px-6 py-4">Kontak</th>
                    <th scope="col" class="px-6 py-4">Tanggal Lahir</th>
                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pasien)) : ?>
                    <?php foreach ($pasien as $p) : ?>
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img class="object-cover w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($p['nama']) ?>&background=e0f2fe&color=0369a1" alt="Avatar">
                                    <div>
                                        <p class="font-semibold text-gray-900"><?= esc($p['nama']); ?></p>
                                        <p class="text-xs text-gray-500">No. RM: <?= esc($p['no_RM']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><?= esc($p['alamat']); ?></td>
                            <td class="px-6 py-4"><?= esc($p['no_hp']); ?></td>
                            <td class="px-6 py-4"><?= date('d F Y', strtotime($p['tanggal_lahir'])); ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="<?= base_url('dokter/riwayatpemeriksaan/' . $p['id_pasien']) ?>" class="inline-flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                                    <i class="bi bi-eye-fill w-5 mr-2"></i> Lihat Riwayat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center py-12 px-6 text-gray-500">
                            <i class="bi bi-person-x-fill text-5xl text-gray-400"></i>
                            <h3 class="mt-4 text-lg font-semibold text-gray-700">Belum Ada Data Pasien</h3>
                            <p class="text-gray-500 mt-1">Silakan tambahkan data pasien baru untuk menampilkannya di sini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Card list untuk mobile -->
    <div class="block lg:hidden p-4 space-y-4">
        <?php if (!empty($pasien)) : ?>
            <?php foreach ($pasien as $p) : ?>
                <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-gray-50">
                    <div class="flex items-center space-x-3 mb-3">
                        <img class="object-cover w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($p['nama']) ?>&background=e0f2fe&color=0369a1" alt="Avatar">
                        <div>
                            <p class="font-semibold text-gray-900"><?= esc($p['nama']); ?></p>
                            <p class="text-xs text-gray-500">No. RM: <?= esc($p['no_RM']); ?></p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700"><span class="font-medium">Alamat:</span> <?= esc($p['alamat']); ?></p>
                    <p class="text-sm text-gray-700"><span class="font-medium">Kontak:</span> <?= esc($p['no_hp']); ?></p>
                    <p class="text-sm text-gray-700"><span class="font-medium">Tanggal Lahir:</span> <?= date('d F Y', strtotime($p['tanggal_lahir'])); ?></p>
                    <div class="mt-3">
                        <a href="<?= base_url('dokter/riwayatpemeriksaan/' . $p['id_pasien']) ?>" class="inline-flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg border border-gray-300">
                            <i class="bi bi-eye-fill w-5 mr-2"></i> Lihat Riwayat
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="text-center py-12 px-6 text-gray-500">
                <i class="bi bi-person-x-fill text-5xl text-gray-400"></i>
                <h3 class="mt-4 text-lg font-semibold text-gray-700">Belum Ada Data Pasien</h3>
                <p class="text-gray-500 mt-1">Silakan tambahkan data pasien baru untuk menampilkannya di sini.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600">
        <p class="mb-2 sm:mb-0">Menampilkan <span class="font-semibold">1</span>-10 dari <span class="font-semibold">100</span> hasil</p>
        <div class="flex items-center space-x-1">
            <a href="#" class="px-3 py-1 border rounded-lg hover:bg-gray-100"><i class="bi bi-chevron-left"></i></a>
            <a href="#" class="px-3 py-1 border rounded-lg bg-sea-blue-500 text-white">1</a>
            <a href="#" class="px-3 py-1 border rounded-lg hover:bg-gray-100">2</a>
            <a href="#" class="px-3 py-1 border rounded-lg hover:bg-gray-100">3</a>
            <span>...</span>
            <a href="#" class="px-3 py-1 border rounded-lg hover:bg-gray-100">10</a>
            <a href="#" class="px-3 py-1 border rounded-lg hover:bg-gray-100"><i class="bi bi-chevron-right"></i></a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>