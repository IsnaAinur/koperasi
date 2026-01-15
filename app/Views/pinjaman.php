<?= view('layout/header'); ?>
<?= view('layout/navigasi'); ?>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>

<div class="col-md-10 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Pinjaman Anggota</h4>
        <div class="d-flex gap-2">
            <input type="text" id="keywordPinjaman" class="form-control" placeholder="Cari Nama Peminjam...">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPinjaman">
                <i class="bi bi-plus-lg"></i> Tambah Pinjaman
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
           <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID Pinjaman</th>
                        <th>NIK Anggota</th> <th>Nama Anggota</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Tenor</th>
                        <th>Sisa Pinjaman</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-pinjaman">
                    <?php if (!empty($pinjaman)) : ?>
                        <?php foreach ($pinjaman as $row) : ?>
                            <tr>
                                <td>PJN-<?= str_pad($row['id_pinjaman'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td><?= $row['nik_anggota'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td>Rp <?= number_format($row['jumlah_pinjaman'], 0, ',', '.') ?></td>
                                <td><?= $row['tenor'] ?> Bln</td>
                                <td>Rp <?= number_format($row['sisa_pinjaman'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge <?= $row['status'] == 'Lunas' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm btn-edit" 
                                            data-bs-toggle="modal" data-bs-target="#modalEditPinjaman"
                                            data-id="<?= $row['id_pinjaman'] ?>"
                                            data-id_anggota="<?= $row['nik_anggota'] ?>" 
                                            data-jumlah="<?= $row['jumlah_pinjaman'] ?>"
                                            data-tenor="<?= $row['tenor'] ?>"
                                            data-bunga="<?= $row['bunga'] ?>"
                                            data-status="<?= $row['status'] ?>"
                                            data-sisa="<?= $row['sisa_pinjaman'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('pinjaman/delete/' . $row['id_pinjaman']) ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Hapus data pinjaman ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="8" class="text-center p-4">Belum ada data pinjaman.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table> 
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahPinjaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Form Tambah Pinjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('pinjaman/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php foreach ($anggota_list as $a) : ?>
                                <option value="<?= $a['nik_anggota'] ?>"><?= $a['nama'] ?> (<?= $a['nik_anggota'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Pinjaman (Rp)</label>
                        <input type="number" name="jumlah_pinjaman" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tenor (Bulan)</label>
                            <input type="number" name="tenor" class="form-control" placeholder="12" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Bunga (%)</label>
                            <input type="number" step="0.01" name="bunga" class="form-control" placeholder="1.5" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Simpan Pinjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPinjaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Pinjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('pinjaman/update') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id_pinjaman" id="edit_id_pinjaman">
                    
                    <div class="mb-3">
                        <label>NIK Anggota (Read-only)</label>
                        <input type="text" id="edit_nik_display" class="form-control bg-light" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Nama Anggota</label>
                        <select name="id_anggota" id="edit_id_anggota" class="form-select" required>
                            <?php foreach ($anggota_list as $a) : ?>
                                <option value="<?= $a['nik_anggota'] ?>"><?= $a['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Pinjaman (Rp)</label>
                        <input type="number" name="jumlah_pinjaman" id="edit_jumlah" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tenor (Bulan)</label>
                            <input type="number" name="tenor" id="edit_tenor" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Bunga (%)</label>
                            <input type="number" step="0.01" name="bunga" id="edit_bunga" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Sisa Pinjaman (Rp)</label>
                        <input type="number" name="sisa_pinjaman" id="edit_sisa" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Logika Live Search
    const keyword = document.getElementById('keywordPinjaman');
    const tbody = document.getElementById('tabel-pinjaman');

    if(keyword) {
        keyword.addEventListener('keyup', function() {
            fetch('<?= base_url('pinjaman/search'); ?>?keyword=' + encodeURIComponent(keyword.value))
                .then(response => response.text())
                .then(data => {
                    tbody.innerHTML = data;
                });
        });
    }

    // --- FUNGSI BARU: Hitung Sisa Pinjaman Otomatis ---
    function hitungSisaOtomatis() {
        const jumlah = parseFloat(document.getElementById('edit_jumlah').value) || 0;
        const tenor  = parseInt(document.getElementById('edit_tenor').value) || 0;
        const bunga  = parseFloat(document.getElementById('edit_bunga').value) || 0;
        const status = document.getElementById('edit_status').value;

        // Jika status Lunas, sisa selalu 0
        if (status === 'Lunas') {
            document.getElementById('edit_sisa').value = 0;
            return;
        }

        // Rumus: Sisa = Pokok + (Bunga per bulan * Tenor)
        // Contoh: 1.000.000 + (1% dari 1.000.000 * 12 bulan)
        const totalBunga = (jumlah * bunga / 100) * tenor;
        const totalSisa  = jumlah + totalBunga;

        document.getElementById('edit_sisa').value = Math.round(totalSisa);
    }

    // 2. Logika Modal Edit
    const modalEdit = document.getElementById('modalEditPinjaman');
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nik = button.getAttribute('data-id_anggota');
            
            document.getElementById('edit_id_pinjaman').value = button.getAttribute('data-id');
            document.getElementById('edit_nik_display').value = nik;
            document.getElementById('edit_id_anggota').value = nik;
            document.getElementById('edit_jumlah').value = button.getAttribute('data-jumlah');
            document.getElementById('edit_tenor').value = button.getAttribute('data-tenor');
            document.getElementById('edit_bunga').value = button.getAttribute('data-bunga');
            document.getElementById('edit_status').value = button.getAttribute('data-status');
            document.getElementById('edit_sisa').value = button.getAttribute('data-sisa');
        });
    }

    // 3. Event Listeners untuk Perubahan Data (Otomatisasi)
    const inputsToWatch = ['edit_jumlah', 'edit_tenor', 'edit_bunga', 'edit_status'];
    
    inputsToWatch.forEach(id => {
        const el = document.getElementById(id);
        if(el) {
            el.addEventListener('input', hitungSisaOtomatis);
            // Tambahkan 'change' khusus untuk dropdown status
            if(id === 'edit_status') {
                el.addEventListener('change', hitungSisaOtomatis);
            }
        }
    });
</script>

<?= view('layout/cta'); ?>
<?= $this->include('layout/footer') ?>