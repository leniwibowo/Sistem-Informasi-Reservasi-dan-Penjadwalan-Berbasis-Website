<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Data Dokter</h2>

    <!-- pesan -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5 rounded-lg" role="alert">
            <p class="font-bold">Sukses</p>
            <p><?= session()->getFlashdata('success'); ?></p>
        </div>
    <?php endif; ?>

    <!-- tombol tambah dokter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <a href="<?= base_url('/admin/tambahdokter'); ?>" class="w-full md:w-auto px-5 py-2.5 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200 text-center">
            <i class="bi bi-plus-lg mr-2"></i>Tambah Dokter
        </a>

        <form method="get" class="w-full md:w-auto flex" action="<?= base_url('/admin/keloladokter'); ?>">
            <input type="text" name="keyword" class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Cari nama dokter...">
            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-r-lg hover:bg-gray-300 transition-colors duration-200">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- desktop -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-sky-700 text-white">
                <tr>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">No</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">No HP</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($dokter)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($dokter as $d) : ?>
                        <tr class="border-b hover:bg-sky-50">
                            <td class="text-center py-3 px-4"><?= $no++ ?></td>
                            <td class="py-3 px-4 font-medium"><?= esc($d['nama']) ?></td>
                            <td class="py-3 px-4"><?= esc($d['no_hp']) ?></td>
                            <td class="text-center py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/editdokter/' . $d['id_dokter']) ?>" class="p-2 rounded-md text-blue-500 hover:text-blue-700 hover:bg-blue-100 transition-colors duration-200" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <a href="<?= base_url('admin/hapusdokter/' . $d['id_dokter']) ?>" class="p-2 rounded-md text-red-500 hover:text-red-700 hover:bg-red-100 transition-colors duration-200" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash-fill text-lg"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-6">Tidak ada data dokter ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!--  mobile -->
    <div class="block md:hidden space-y-4">
        <?php if (!empty($dokter)) : ?>
            <?php $no = 1; ?>
            <?php foreach ($dokter as $d) : ?>
                <div class="border rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-500">No: <?= $no++ ?></p>
                    <p class="font-semibold">Nama: <?= esc($d['nama']) ?></p>
                    <p>No HP: <?= esc($d['no_hp']) ?></p>
                    <div class="mt-2 flex gap-2">
                        <a href="<?= base_url('admin/editdokter/' . $d['id_dokter']) ?>" class="p-2 rounded-md text-blue-500 hover:text-blue-700 hover:bg-blue-100 transition-colors duration-200" title="Edit">
                            <i class="bi bi-pencil-square text-lg"></i>
                        </a>
                        <a href="<?= base_url('admin/hapusdokter/' . $d['id_dokter']) ?>" class="p-2 rounded-md text-red-500 hover:text-red-700 hover:bg-red-100 transition-colors duration-200" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="bi bi-trash-fill text-lg"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="text-center text-gray-500 py-6">Tidak ada data dokter ditemukan.</div>
        <?php endif; ?>
    </div>
</div>


<?= $this->endSection() ?>