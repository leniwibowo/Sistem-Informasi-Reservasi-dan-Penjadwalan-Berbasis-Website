<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Data Admin</h2>

    <!-- Pesan Sukses -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5 rounded-lg" role="alert">
            <p class="font-bold">Sukses</p>
            <p><?= session()->getFlashdata('success'); ?></p>
        </div>
    <?php endif; ?>

    <!--  tombol tmbah dan form pencarian -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <!-- tombol tambah admin -->
        <a href="<?= base_url('/admin/tambahadmin'); ?>" class="w-full md:w-auto px-5 py-2.5 bg-sky-600 text-white font-semibold rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-opacity-50 transition-colors duration-200 text-center">
            <i class="bi bi-plus-lg mr-2"></i>Tambah Admin
        </a>

        <!-- form pencarian -->
        <form method="get" class="w-full md:w-auto flex" action="<?= base_url('/admin/kelolaadmin'); ?>">
            <input type="text" name="keyword" class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Cari nama admin...">
            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-r-lg hover:bg-gray-300 transition-colors duration-200">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- tabel data ddmin -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-sky-700 text-white">
                <tr>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">No</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($admin)) : ?>
                    <?php $no = 1; // Penomoran  dari 1 
                    ?>
                    <?php foreach ($admin as $a) : ?>
                        <tr class="border-b hover:bg-sky-50">
                            <td class="text-center py-3 px-4"><?= $no++ ?></td>
                            <td class="py-3 px-4 font-medium"><?= esc($a['nama']) ?></td>
                            <td class="text-center py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- tmbol edit -->
                                    <a href="<?= base_url('admin/editadmin/' . $a['id_admin']) ?>" class="p-2 rounded-md text-blue-500 hover:text-blue-700 hover:bg-blue-100 transition-colors duration-200" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <!-- tombol hapus -->
                                    <a href="<?= base_url('admin/hapusadmin/' . $a['id_admin']) ?>" class="p-2 rounded-md text-red-500 hover:text-red-700 hover:bg-red-100 transition-colors duration-200" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data admin ini?')">
                                        <i class="bi bi-trash-fill text-lg"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center text-gray-500 py-6">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-person-x text-4xl mb-2"></i>
                                <span>Tidak ada data admin ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>