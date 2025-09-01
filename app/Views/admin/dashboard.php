<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('title') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- dashboard admin -->
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-500 mt-1">Ringkasan aktivitas dan data dari seluruh sistem Klinik DL Dental.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <!-- card untuk menampilkan total seluruh pasien -->
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pasien</p>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-1"><?= esc($total_pasien) ?></p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-lg"><i class="bi bi-people-fill text-xl text-indigo-600"></i></div>
        </div>
    </div>
    <!-- untuk menampilkan seluruh total dokter  -->
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Dokter</p>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-1"><?= esc($total_dokter) ?></p>
            </div>
            <div class="p-3 bg-sky-100 rounded-lg"><i class="bi bi-person-workspace text-xl text-sky-600"></i></div>
        </div>
    </div>
    <!-- untuk menampilkaan seluruh totoal admin -->
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Admin</p>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-1"><?= esc($total_admin) ?></p>
            </div>
            <div class="p-3 bg-rose-100 rounded-lg"><i class="bi bi-person-gear text-xl text-rose-600"></i></div>
        </div>
    </div>
    <!-- untuk menampilkan total antrian hari ini -->
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Antrian Hari Ini</p>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mt-1"><?= esc($antrian_hari_ini) ?></p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg"><i class="bi bi-card-list text-xl text-blue-600"></i></div>
        </div>
    </div>
</div>


<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- menampilkan pasien baru yang telah mendaftar -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-5 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Pasien Baru Terdaftar</h3>
            <a href="<?= base_url('/admin/kelolapasien') ?>" class="text-sm font-medium text-sky-600 hover:underline">Lihat Semua</a>
        </div>
        <!-- jika tidak ada pasien -->
        <div class="p-3">
            <ul class="space-y-2">
                <?php if (!empty($pasien_terbaru)): ?>
                    <?php foreach ($pasien_terbaru as $pasien): ?>
                        <li class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800"><?= esc($pasien['nama']) ?></p>
                                <p class="text-xs text-gray-500">No. RM: <?= esc($pasien['no_RM']) ?></p>
                            </div>
                            <span class="text-xs text-gray-400"><?= date('d M Y', strtotime($pasien['created_at'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-center py-4 text-gray-500 text-sm">Tidak ada pasien baru.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- jadwal kunjungan -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-5 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Jadwal Kunjungan Hari Ini</h3>
            <a href="<?= base_url('/admin/antrian') ?>" class="text-sm font-medium text-sky-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="p-3">
            <ul class="space-y-2">
                <?php if (!empty($jadwal_hari_ini)): ?>
                    <?php foreach ($jadwal_hari_ini as $jadwal): ?>
                        <li class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800"><?= esc($jadwal['nama_pasien']) ?></p>
                                <p class="text-xs text-gray-500">No. Antrian <?= esc($jadwal['no_antrian']) ?> - Dr. <?= esc($jadwal['nama_dokter']) ?></p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Terjadwal</span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-center py-4 text-gray-500 text-sm">Tidak ada jadwal hari ini.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>