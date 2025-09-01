<?= $this->extend('templates/dokter_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row justify-between items-start mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-gray-500">Selamat datang kembali, <?= esc($nama_dokter) ?>! Berikut ringkasan aktivitas klinik hari ini.</p>
    </div>
    <a href="<?= base_url('/dokter/antrian') ?>" class="mt-4 sm:mt-0 px-5 py-2.5 text-sm font-medium text-white bg-sea-blue-600 rounded-lg shadow-md hover:bg-sea-blue-700 focus:ring-4 focus:ring-sea-blue-200">
        <i class="bi bi-people-fill mr-2"></i> Lihat Semua Antrian
    </a>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-1 lg:grid-cols-2">
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-500">Total Antrian Hari Ini</p>
                <p class="text-4xl font-bold text-gray-900 mt-1"><?= esc($total_antrian) ?></p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="bi bi-people-fill text-xl text-blue-600"></i>
            </div>
        </div>
    </div>
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-500">Sisa Antrian</p>
                <p class="text-4xl font-bold text-gray-900 mt-1"><?= esc($sisa_antrian) ?></p>
            </div>
            <div class="p-3 bg-amber-100 rounded-lg">
                <i class="bi bi-person-rolodex text-xl text-amber-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-5 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Antrian Pasien Berikutnya</h3>
        </div>

        <!-- Tabel untuk desktop -->
        <div class="overflow-x-auto hidden lg:block">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No. Antrian</th>
                        <th scope="col" class="px-6 py-3">Nama Pasien</th>
                        <th scope="col" class="px-6 py-3">Keluhan</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($antrian_berikutnya)): ?>
                        <?php foreach ($antrian_berikutnya as $antrian): ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900"><?= esc($antrian['no_antrian']) ?></td>
                                <td class="px-6 py-4"><?= esc($antrian['nama_pasien']) ?></td>
                                <td class="px-6 py-4 truncate max-w-xs"><?= esc($antrian['keluhan']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full"><?= esc($antrian['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada pasien dalam antrian saat ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tampilan card list untuk mobile -->
        <div class="block lg:hidden p-4 space-y-4">
            <?php if (!empty($antrian_berikutnya)): ?>
                <?php foreach ($antrian_berikutnya as $antrian): ?>
                    <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-gray-50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-gray-900">No: <?= esc($antrian['no_antrian']) ?></span>
                            <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full"><?= esc($antrian['status']) ?></span>
                        </div>
                        <p class="font-semibold text-gray-800"><?= esc($antrian['nama_pasien']) ?></p>
                        <p class="text-sm text-gray-600 mt-1">Keluhan: <?= esc($antrian['keluhan']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-6 text-gray-500">
                    Tidak ada pasien dalam antrian saat ini.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-5 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Jadwal Janji Temu Hari Ini</h3>
        </div>
        <div class="p-5 space-y-4">
            <?php if (!empty($jadwal_janji_temu)): ?>
                <?php foreach ($jadwal_janji_temu as $jadwal): ?>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 border border-gray-100 rounded-lg p-3">
                        <div class="flex-shrink-0 w-full sm:w-16 h-12 flex items-center justify-center bg-sea-blue-100 text-sea-blue-600 font-bold rounded-lg mb-2 sm:mb-0">
                            <span>No: <?= esc($jadwal['no_antrian']) ?></span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800"><?= esc($jadwal['nama_pasien']) ?></p>
                            <p class="text-xs text-gray-500">Keluhan: <?= esc($jadwal['keluhan']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-6 text-gray-500">
                    <p>Tidak ada janji temu hari ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>