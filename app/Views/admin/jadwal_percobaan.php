<?= $this->extend('templates/layout_admin') ?>

<?= $this->section('title') ?>
Form Penjadwalan Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- form untuk menambahkan penjadwalan untuk pasien -->
<div class="container mx-auto max-w-3xl">
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">

        <div class="border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Buat Jadwal Pemeriksaan</h1>
            <p class="text-gray-500 mt-1">Isi detail di bawah untuk membuat janji temu baru untuk pasien.</p>
        </div>

        <div id="message-container" class="mb-6"></div>

        <form id="jadwal-form" method="post" action="<?= base_url('admin/simpan_jadwal_percobaan') ?>">
            <?= csrf_field() ?>

            <div class="space-y-6">
                <div>
                    <label for="id_pasien" class="block mb-2 text-sm font-medium text-gray-700">
                        Pilih Pasien (Cari berdasarkan Nama atau No. RM) <span class="text-red-500">*</span>
                    </label>
                    <select name="id_pasien" id="id_pasien" class="block w-full" required>
                        <option value="">Memuat daftar pasien...</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_pemeriksaan" class="block mb-2 text-sm font-medium text-gray-700">
                        Tanggal Pemeriksaan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" min="<?= date('Y-m-d') ?>" class="block w-full mt-1 px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" required>
                </div>

                <div>
                    <label for="id_dokter" class="block mb-2 text-sm font-medium text-gray-700">
                        Pilih Dokter <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="id_dokter" id="id_dokter" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition disabled:bg-gray-200 disabled:cursor-not-allowed" required disabled>
                            <option value="">Pilih tanggal terlebih dahulu</option>
                        </select>
                        <div id="dokter-loader" class="loader absolute right-10 top-1/2 -translate-y-1/2 hidden" style="height: 20px; width: 20px;"></div>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                            <i class="bi bi-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="pemeriksaan" class="block mb-2 text-sm font-medium text-gray-700">
                        Keluhan / Catatan Awal
                    </label>
                    <textarea name="pemeriksaan" id="pemeriksaan" rows="4" class="block w-full mt-1 px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" placeholder="Opsional: Tuliskan keluhan utama pasien..."></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-200 mt-8">
                <button type="submit" id="submit-button" class="w-full sm:w-auto flex items-center justify-center gap-x-2 text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg px-6 py-3 text-center transition-all disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Buat Jadwal</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- java script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- elemen-elemen Form ---
        const pasienSelect = document.getElementById('id_pasien');
        const tanggalInput = document.getElementById('tanggal_pemeriksaan');
        const dokterSelect = document.getElementById('id_dokter');
        const submitButton = document.getElementById('submit-button');
        const dokterLoader = document.getElementById('dokter-loader');

        // --- url untuk api (Pastikan base_url() menghasilkan URL yang benar) ---
        const URL_GET_PASIEN = '<?= base_url('admin/api/get_all_pasien') ?>';
        const URL_GET_DOKTER = '<?= base_url('admin/api/dokter_by_jadwal') ?>';


        $('#id_pasien').select2({
            placeholder: "-- Pilih atau Cari Pasien --",
            allowClear: true
        });

        // --- fungsi untuk mengambil data pasien ---
        async function fetchPasien() {
            try {
                const response = await fetch(URL_GET_PASIEN);
                if (!response.ok) throw new Error('Gagal mengambil data pasien.');

                const data = await response.json();
                // opsi default sekarang diatur oleh placeholder Select2
                pasienSelect.innerHTML = '<option value=""></option>';

                if (data && data.length > 0) {
                    // Select2 punya fitur search
                    data.forEach(pasien => {
                        const option = document.createElement('option');
                        option.value = pasien.id_pasien;
                        // format teks yang akan dicari oleh Select2
                        option.textContent = `${pasien.nama} (RM: ${pasien.no_RM})`;
                        pasienSelect.appendChild(option);
                    });
                } else {
                    pasienSelect.innerHTML = '<option value="" disabled>Tidak ada data pasien.</option>';
                }
                // trigger Select2 untuk memperbarui tampilan setelah data dimuat
                $('#id_pasien').trigger('change');

            } catch (error) {
                console.error('Error fetching pasien:', error);
                pasienSelect.innerHTML = '<option value="" disabled>Gagal memuat pasien.</option>';
                $('#id_pasien').trigger('change');
            }
        }

        // --- fungsi untuk mengambil data dokter berdasarkan tanggal ---
        async function fetchDokter(tanggal) {
            dokterSelect.disabled = true;
            dokterLoader.classList.remove('hidden');
            dokterSelect.innerHTML = '<option value="">Memuat dokter...</option>';

            if (!tanggal) {
                dokterSelect.innerHTML = '<option value="">Pilih tanggal terlebih dahulu</option>';
                dokterLoader.classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`${URL_GET_DOKTER}?tanggal=${tanggal}`);
                if (!response.ok) throw new Error('Gagal mengambil data dokter.');

                const data = await response.json();
                dokterSelect.innerHTML = ''; // Kosongkan pilihan

                if (data && data.length > 0) {
                    dokterSelect.innerHTML = '<option value="" disabled selected>-- Pilih Dokter --</option>';
                    data.forEach(dokter => {
                        const option = document.createElement('option');
                        option.value = dokter.id_dokter;
                        option.textContent = `Dr. ${dokter.nama}`;
                        dokterSelect.appendChild(option);
                    });
                    dokterSelect.disabled = false;
                } else {
                    dokterSelect.innerHTML = '<option value="" disabled>Tidak ada dokter praktik pada tanggal ini.</option>';
                }
            } catch (error) {
                console.error('Error fetching dokter:', error);
                dokterSelect.innerHTML = '<option value="" disabled>Gagal memuat dokter.</option>';
            } finally {
                dokterLoader.classList.add('hidden');
            }
        }

        // --- event listener untuk input tanggal ---
        tanggalInput.addEventListener('change', function() {
            fetchDokter(this.value);
        });

        // --- Panggil fungsi untuk memuat data awal ---
        fetchPasien();
    });
</script>

<?= $this->endSection() ?>