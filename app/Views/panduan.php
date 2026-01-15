<?= view('layout/header'); ?>
<?= view('layout/navigasi'); ?>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>

    <div id="main-content">
        <div class="container-fluid px-4 py-4">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                    <i class="bi bi-book fs-3 text-primary"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">Panduan Penggunaan Sistem</h3>
                    <p class="text-muted">Instruksi lengkap operasional Koperasi Simpan Pinjam</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="accordion" id="accordionPanduan">
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <i class="bi bi-people me-2"></i> 1. Alur Keanggotaan
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body text-muted">
                                    <ul>
                                        <li class="list-group-item border-0">
                                            <strong>Pendaftaran:</strong> Pastikan NIK anggota belum terdaftar.
                                        </li>
                                        <li class="list-group-item border-0">
                                            <strong>Nama & Alamat:</strong> Pastikan nama dan alamat sesuai KTP untuk mempermudah penagihan.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    <i class="bi bi-wallet2 me-2"></i> 2. Manajemen Simpanan
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body text-muted">
                                    <div class="mb-3">
                                        <strong>Simpanan Pokok:</strong>Biasanya dibayarkan satu kali saat pertama kali mendaftar sebagai anggota
                                    </div>                              
                                    <div>
                                        <strong>Simpanan Wajib:</strong>Dibayarkan secara rutin (bulanan). Gunakan fitur "Tambah Simpanan" setiap kali anggota menyetorkan uang
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    <i class="bi bi-cash-stack me-2"></i> 3. Prosedur Pinjaman (Kredit)
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body text-muted">
                                    <p>Alur peminjaman harus mengikuti urutan berikut agar sistem tetap akurat:</p>
                                    <div class="bg-light p-3 rounded mb-3">
                                        <ol class="mb-0">
                                            <li><strong>Pengajuan:</strong> Masukkan jumlah pinjaman, tenor (jangka waktu), dan persentase bunga.</li>
                                            <li><strong>Perhitungan Otomatis:</strong> Sistem akan membagi Pokok dan Bunga:
                                                <ul class="list-unstyled mt-2">
                                                    <li class="mb-2">
                                                        <i class="bi bi-calculator me-2 text-primary"></i>
                                                        <strong>Rumus Pokok:</strong> 
                                                        <code>Total Pinjaman / Tenor</code>
                                                    </li>
                                                    <li>
                                                        <i class="bi bi-percent me-2 text-danger"></i>
                                                        <strong>Rumus Bunga:</strong> 
                                                        <code>(Total Pinjaman x % Bunga) / 100</code>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><strong>Status:</strong> Pinjaman akan ditandai <b>Lunas</b> otomatis oleh sistem jika total angsuran telah terpenuhi.</li>
                                        </ol>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    <i class="bi bi-receipt me-2"></i> 4. Manajemen Angsuran (Pembayaran)
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body text-muted">
                                    <ul class="list-unstyled">
                                        <li class="mb-3">
                                            <div class="d-flex align-items-start">
                                                <div>
                                                    <strong>Pilih Nama/ID Peminjam:</strong>
                                                    Sistem otomatis menarik data "Angsuran Ke-n" yang aktif.
                                                </div>
                                            </div>
                                        </li>
                                        
                                        <li>
                                            <div class="d-flex align-items-start">
                                                <div>
                                                    <strong>Tgl Bayar:</strong>
                                                    Input sesuai tanggal uang fisik diterima di kas koperasi.
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer'); ?>