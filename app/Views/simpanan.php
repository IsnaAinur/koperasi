<?= view('layout/header'); ?>
<?= view('layout/navigasi'); ?>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>

    <div class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Data Simpanan Anggota</h4>
            <div class="d-flex gap-2">
                <input type="text" id="keywordSimpanan" class="form-control" placeholder="Cari NIK / Nama Anggota...">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahSimpanan">
                    <i class="fas fa-plus"></i> Tambah Simpanan
                </button>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Simpanan</th>
                            <th>NIK Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Tanggal Setor</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-simpanan">
                        <?php if (!empty($simpanan)) : ?>
                            <?php foreach ($simpanan as $row) : ?>
                                <tr>
                                    <td>SMA-<?= str_pad($row['id_simpanan'], 3, '0', STR_PAD_LEFT) ?></td>
                                    <td><?= $row['nik_anggota'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><span class="badge bg-info text-dark"><?= $row['jenis_simpanan'] ?></span></td>
                                    <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tgl_setor'])) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm btn-edit" 
                                                data-bs-toggle="modal" data-bs-target="#modalEditSimpanan"
                                                data-id="<?= $row['id_simpanan'] ?>"
                                                data-id_anggota="<?= $row['nik_anggota'] ?>"
                                                data-jenis="<?= $row['jenis_simpanan'] ?>"
                                                data-jumlah="<?= $row['jumlah'] ?>"
                                                data-tgl="<?= $row['tgl_setor'] ?>">
                                            Edit
                                        </button>
                                        <a href="<?= base_url('simpanan/delete/' . $row['id_simpanan']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Hapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" class="text-center p-4">Belum ada data simpanan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahSimpanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Form Tambah Simpanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('simpanan/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php foreach ($anggota_list as $a) : ?>
                                <option value="<?= $a['nik_anggota'] ?>">
                                    <?= $a['nik_anggota'] ?> - <?= $a['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Simpanan</label>
                        <select name="jenis_simpanan" class="form-select" required>
                            <option value="Pokok">Pokok</option>
                            <option value="Wajib">Wajib</option>
                            <option value="Sukarela">Sukarela</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Setor</label>
                        <input type="date" name="tgl_setor" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Simpan Data Simpanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSimpanan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Form Edit Simpanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('simpanan/update') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id_simpanan" id="edit_id_simpanan">
                    <div class="mb-3">
                        <label>NIK Anggota</label>
                        <input type="text" id="edit_nik_display" class="form-control" readonly disabled>
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
                        <label>Jenis Simpanan</label>
                        <select name="jenis_simpanan" id="edit_jenis_simpanan" class="form-select" required>
                            <option value="Pokok">Pokok</option>
                            <option value="Wajib">Wajib</option>
                            <option value="Sukarela">Sukarela</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah (Rp)</label>
                        <input type="number" name="jumlah" id="edit_jumlah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Setor</label>
                        <input type="date" name="tgl_setor" id="edit_tgl_setor" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div> 
</div>

<script>
    // 1. Live Search
    const keyword = document.getElementById('keywordSimpanan');
    const tbody = document.getElementById('tabel-simpanan');

    keyword.addEventListener('keyup', function() {
        fetch('<?= base_url('simpanan/search'); ?>?keyword=' + keyword.value)
            .then(response => response.text())
            .then(data => {
                tbody.innerHTML = data;
            });
    });

    // 2. Logika Modal Edit
    const modalEdit = document.getElementById('modalEditSimpanan');
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const id = button.getAttribute('data-id');
            const nik = button.getAttribute('data-id_anggota');
            const jenis = button.getAttribute('data-jenis');
            const jumlah = button.getAttribute('data-jumlah');
            const tgl = button.getAttribute('data-tgl');

            document.getElementById('edit_id_simpanan').value = id;
            document.getElementById('edit_nik_display').value = nik; // Tampil NIK
            document.getElementById('edit_id_anggota').value = nik;   // Select NIK
            document.getElementById('edit_jenis_simpanan').value = jenis;
            document.getElementById('edit_jumlah').value = jumlah;
            document.getElementById('edit_tgl_setor').value = tgl;
        });
    }
</script>

<?= view('layout/cta'); ?>
<?= $this->include('layout/footer') ?>