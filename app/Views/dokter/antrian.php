<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Antrian Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Daftar Antrian Pasien</h1>
        <p class="mt-1 text-gray-500">
            Daftar pasien yang menunggu untuk diperiksa hari ini.
        </p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm">

    <!-- Tabel Desktop -->
    <div class="overflow-x-auto hidden lg:block">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No. Antrian</th>
                    <th scope="col" class="px-6 py-3">Nama Pasien</th>
                    <th scope="col" class="px-6 py-3">Keluhan Utama</th>
                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($antrian)) : ?>
                    <?php foreach ($antrian as $a) : ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-bold text-gray-900 text-center">
                                <?= esc($a['no_antrian']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <?= esc($a['nama_pasien']) ?>
                            </td>
                            <td class="px-6 py-4"><?= esc($a['keluhan']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php
                                $status = $a['status'] ?? 'Menunggu';
                                $badgeClass = match ($status) {
                                    'Sudah Diperiksa' => 'bg-green-100 text-green-800',
                                    'Sedang Diperiksa' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-amber-100 text-amber-800'
                                };
                                ?>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full <?= $badgeClass ?>">
                                    <?= esc($status) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="<?= base_url('dokter/pemeriksaan/' . $a['id_jadwal']) ?>" class="font-medium text-sea-blue-600 hover:underline">Periksa</a>
                                <a href="<?= base_url('dokter/riwayatpemeriksaan/' . $a['id_pasien']) ?>" class="ml-4 font-medium text-gray-500 hover:underline">Riwayat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">
                            <div class="text-center py-16 text-gray-500">
                                <i class="bi bi-info-circle-fill text-4xl mb-3"></i>
                                <h3 class="text-xl font-semibold">Tidak Ada Antrian</h3>
                                <p class="mt-1">Belum ada pasien yang mendaftar untuk hari ini.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Tampilan Mobile -->
    <div class="block lg:hidden p-4 space-y-4">
        <?php if (!empty($antrian)) : ?>
            <?php foreach ($antrian as $a) : ?>
                <?php
                $status = $a['status'] ?? 'Menunggu';
                $badgeClass = match ($status) {
                    'Sudah Diperiksa' => 'bg-green-100 text-green-800',
                    'Sedang Diperiksa' => 'bg-blue-100 text-blue-800',
                    default => 'bg-amber-100 text-amber-800'
                };
                ?>
                <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-gray-50">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold text-gray-900">No: <?= esc($a['no_antrian']) ?></span>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full <?= $badgeClass ?>">
                            <?= esc($status) ?>
                        </span>
                    </div>
                    <p class="font-semibold text-gray-800"><?= esc($a['nama_pasien']) ?></p>
                    <p class="text-sm text-gray-600 mt-1">Keluhan: <?= esc($a['keluhan']) ?></p>
                    <div class="flex gap-4 mt-3">
                        <a href="<?= base_url('dokter/pemeriksaan/' . $a['id_jadwal']) ?>" class="text-sea-blue-600 font-medium hover:underline">Periksa</a>
                        <a href="<?= base_url('dokter/riwayatpemeriksaan/' . $a['id_pasien']) ?>" class="text-gray-500 font-medium hover:underline">Riwayat</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="text-center py-16 text-gray-500">
                <i class="bi bi-info-circle-fill text-4xl mb-3"></i>
                <h3 class="text-xl font-semibold">Tidak Ada Antrian</h3>
                <p class="mt-1">Belum ada pasien yang mendaftar untuk hari ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <nav class="p-4 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500">
            Menampilkan <span class="font-semibold text-gray-900">1-10</span> dari <span class="font-semibold text-gray-900">100</span>
        </span>
        <ul class="inline-flex items-center -space-x-px">
            <li>
                <a href="#" class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
            </li>
            <li>
                <a href="#" aria-current="page" class="z-10 px-3 py-2 leading-tight text-sea-blue-600 border border-sea-blue-300 bg-sea-blue-50 hover:bg-sea-blue-100 hover:text-sea-blue-700">1</a>
            </li>
            <li>
                <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
            </li>
            <li>
                <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
            </li>
        </ul>
    </nav>
</div>

<?= $this->endSection() ?>