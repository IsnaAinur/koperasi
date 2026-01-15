<?= view('layout/header'); ?>
<?= view('layout/navigasi'); ?>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>

<div class="col-md-10 p-4">
    <h4>Data Anggota</h4>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between mb-3">
        <input type="text" id="keyword" class="form-control w-25" placeholder="Cari anggota..." autocomplete="off">
        
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota">
            <i class="fas fa-user-plus"></i> + Tambah Anggota
        </button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Tgl Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="daftar-anggota">
            <?php if (!empty($anggota) && is_array($anggota)) : ?>
                <?php $no = 1; foreach ($anggota as $row) : ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $row['nik_anggota'] ?></td> 
                        
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= $row['no_hp'] ?></td>
                        <td><?= $row['tgl_bergabung'] ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditAnggota"
                                    data-id="<?= $row['nik_anggota'] ?>"
                                    data-nama="<?= $row['nama'] ?>"
                                    data-alamat="<?= $row['alamat'] ?>"
                                    data-no_hp="<?= $row['no_hp'] ?>"
                                    data-tgl="<?= $row['tgl_bergabung'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <a href="<?= base_url('anggota/delete/' . $row['nik_anggota']) ?>" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Apakah Anda yakin?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="7" class="text-center">Data kosong.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambahAnggota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Tambah Anggota Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('anggota/save'); ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>NIK Anggota</label>
                        <input type="text" name="nik" class="form-control" placeholder="Contoh: 3201..." required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Nomor HP</label>
                        <input type="number" name="no_hp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Bergabung</label>
                        <input type="date" name="tgl_bergabung" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAnggota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">Edit Data Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('anggota/update'); ?>" method="POST">
                <?= csrf_field(); ?>
                
                <input type="hidden" name="id_original" id="edit_id">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIK</label>
                            <input type="text" name="nik_baru" id="edit_nik" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="number" name="no_hp" id="edit_no_hp" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" id="edit_alamat" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tgl Bergabung</label>
                        <input type="date" name="tgl_bergabung" id="edit_tgl" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inputPencarian = document.getElementById('keyword');
    const isiTabel = document.getElementById('daftar-anggota');

    inputPencarian.addEventListener('keyup', function() {
        // Ambil teks yang diketik
        let cari = inputPencarian.value;

        // Kirim permintaan ke Controller secara diam-diam
        fetch('<?= base_url('anggota/search'); ?>?keyword=' + cari)
            .then(response => response.text())
            .then(data => {
                // Ganti isi <tbody> dengan hasil dari Controller
                isiTabel.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });

    // JS untuk modal edit (Data Binding)
    // JS untuk modal edit (Data Binding)
    const modalEdit = document.getElementById('modalEditAnggota');
if(modalEdit) {
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        
        // Ambil data dari atribut data-id, data-nama, dll
        const nik = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const alamat = button.getAttribute('data-alamat');
        const no_hp = button.getAttribute('data-no_hp');
        const tgl = button.getAttribute('data-tgl');

        // Isi ke dalam form modal
        document.getElementById('edit_id').value = nik;    // Untuk id_original (hidden)
        document.getElementById('edit_nik').value = nik;   // Untuk nik_baru
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_no_hp').value = no_hp;
        document.getElementById('edit_tgl').value = tgl;
    });
}
</script>
<?= view('layout/cta'); ?>
<?= $this->include('layout/footer') ?>