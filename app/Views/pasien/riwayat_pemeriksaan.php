<?= $this->extend('templates/pasien_layout') ?>

<?= $this->section('title') ?>
Riwayat Pemeriksaan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- halaman riwayat pemeriksaan pasien -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Riwayat Pemeriksaan</h1>
    <p class="mt-1 text-gray-500">Berikut adalah pemeriksaan yang telah Anda lakukan.</p>
</div>

<div class="w-full">

    <?php if (empty($riwayat)): ?>
        <div class="text-center py-16 px-6 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="inline-block p-4 bg-sky-100 rounded-full">
                <i class="bi bi-file-earmark-medical-fill text-4xl text-sky-600"></i>
            </div>
            <h3 class="mt-4 text-xl font-semibold text-gray-800">Belum Ada Riwayat Pemeriksaan</h3>
            <p class="mt-2 text-gray-500">Riwayat kunjungan Anda akan tercatat di sini setelah Anda menyelesaikan pemeriksaan pertama.</p>
        </div>

    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($riwayat as $r): ?>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="bi bi-calendar3 mr-2"></i>
                            <?= date('l, d F Y', strtotime($r['waktu'])) ?>
                        </p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <div class="flex items-start">
                                <i class="bi bi-chat-left-text-fill text-sky-600 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Keluhan</p>
                                    <p class="text-gray-800"><?= esc($r['keluhan']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-start">
                                <i class="bi bi-clipboard2-pulse-fill text-sky-600 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Diagnosis Dokter</p>
                                    <p class="text-gray-800"><?= esc($r['diagnosis']) ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-start">
                                <i class="bi bi-person-fill-gear text-sky-600 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Tindakan</p>
                                    <p class="text-gray-800">Dokter <?= esc($r['nama_dokter']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-start">
                                <i class="bi bi-person-fill-gear text-sky-600 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Tindakan</p>
                                    <p class="text-gray-800"><?= esc($r['tindakan']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-start">
                                <i class="bi bi-capsule text-sky-600 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Resep Obat</p>
                                    <p class="text-gray-800 font-mono text-sm whitespace-pre-wrap"><?= $r['resep'] ? esc($r['resep']) : '-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-start">
                                <i class="bi bi-clipboard2-pulse-fill text-sky-600 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Catatan</p>
                                    <p class="text-gray-800  text-sm whitespace-pre-wrap"><?= $r['catatan'] ? esc($r['catatan']) : '-' ?></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>