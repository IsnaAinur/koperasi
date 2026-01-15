<?= view('layout/header'); ?>
<?= view('layout/navigasi'); ?>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>

    <div class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Data Angsuran Anggota</h4>
            <div class="d-flex gap-2">
                <input type="text" id="keywordAngsuran" class="form-control" placeholder="Cari Nama...">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahAngsuran">
                    <i class="bi bi-plus-lg"></i> Bayar Angsuran
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
                            <th>No</th>
                            <th>No. Bukti</th>
                            <th>ID Pinjam</th>
                            <th>Nama Anggota</th>
                            <th class="text-center">Jumlah Angsuran</th>
                            <th>Tgl Bayar</th>
                            <th>Pokok</th>
                            <th>Bunga</th>
                            <th>Total Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tabel-angsuran">
                        <?php if (!empty($angsuran)) : $no = 1; ?>
                            <?php foreach ($angsuran as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-primary">
                                            INV-<?= str_pad($row['id_angsuran'], 3, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        P<?= str_pad($row['id_pinjam'], 3, '0', STR_PAD_LEFT) ?>
                                    </td>

                                    <td><?= $row['nama'] ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark"><?= $row['angsuran_ke'] ?></span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($row['tgl_bayar'])) ?></td>
                                    <td>Rp <?= number_format($row['bayar_pokok'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($row['bayar_bunga'], 0, ',', '.') ?></td>
                                    <td class="fw-bold text-success">Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('angsuran/delete/' . $row['id_angsuran']) ?>" 
                                        class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Hapus data angsuran ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="10" class="text-center p-4">Belum ada data angsuran.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAngsuran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Form Bayar Angsuran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('angsuran/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Pilih Pinjaman Aktif</label>
                        <select name="id_pinjam" id="select_pinjam" class="form-select" required>
                            <option value="">-- Pilih Pinjaman --</option>
                            <?php foreach ($daftar_pinjaman as $p) : ?>
                                <option value="<?= $p['id_pinjaman'] ?>" 
                                        data-pokok="<?= $p['jumlah_pinjaman'] / $p['tenor'] ?>" 
                                        data-bunga="<?= ($p['jumlah_pinjaman'] * $p['bunga']) / 100 ?>"
                                        data-ke="<?= $p['angsuran_ke_skrg'] + 1 ?>"
                                        data-tenor="<?= $p['tenor'] ?>">
                                    <?= $p['nama'] ?> (PJN-<?= str_pad($p['id_pinjaman'], 3, '0', STR_PAD_LEFT) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Angsuran Ke-</label>
                            <input type="text" id="disp_ke" class="form-control bg-light" placeholder="Pilih pinjaman..." readonly>
                            <input type="hidden" name="angsuran_ke" id="val_ke">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tanggal Bayar</label>
                            <input type="date" name="tgl_bayar" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-primary">Bayar Pokok (Rp)</label>
                        <input type="number" name="bayar_pokok" id="input_pokok" class="form-control fw-bold" readonly required>
                        <small class="text-muted text-italic">*Dihitung otomatis (Total Pinjam / Tenor)</small>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-danger">Bayar Bunga (Rp)</label>
                        <input type="number" name="bayar_bunga" id="input_bunga" class="form-control fw-bold" readonly required>
                        <small class="text-muted">*Dihitung otomatis (Bunga % x Total Pinjam)</small>
                    </div>

                    <div class="alert alert-info border-0 mb-0">
                        <small>Total yang harus dibayar: <strong id="total_teks">Rp 0</strong></small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-success w-100 fw-bold">SIMPAN PEMBAYARAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. LOGIKA PERHITUNGAN OTOMATIS
    document.getElementById('select_pinjam').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        
        if (selected.value !== "") {
            // Ambil data dari atribut data- di dropdown
            const pokok = Math.round(selected.getAttribute('data-pokok'));
            const bunga = Math.round(selected.getAttribute('data-bunga'));
            const ke    = selected.getAttribute('data-ke');
            const tenor = selected.getAttribute('data-tenor');

            // Set nilai ke input form
            document.getElementById('input_pokok').value = pokok;
            document.getElementById('input_bunga').value = bunga;
            document.getElementById('val_ke').value      = ke;
            
            // Set tampilan visual
            document.getElementById('disp_ke').value     = ke + " dari " + tenor;
            document.getElementById('total_teks').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(pokok + bunga);
        } else {
            // Reset jika tidak ada yang dipilih
            document.getElementById('input_pokok').value = "";
            document.getElementById('input_bunga').value = "";
            document.getElementById('disp_ke').value     = "";
            document.getElementById('total_teks').innerText = "Rp 0";
        }
    });

    // 2. LIVE SEARCH
    const keyword = document.getElementById('keywordAngsuran');
    const tbody = document.getElementById('tabel-angsuran');

    keyword.addEventListener('keyup', function() {
        fetch('<?= base_url('angsuran/search'); ?>?keyword=' + encodeURIComponent(keyword.value))
            .then(response => response.text())
            .then(data => {
                tbody.innerHTML = data;
            });
    });
</script>

<?= view('layout/cta'); ?>
<?= view('layout/footer') ?>