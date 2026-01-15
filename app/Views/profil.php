<?= view('layout/navigasi'); ?>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>

<div id="main-content" class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
                        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                            <img src="<?= base_url('assets/profile.png'); ?>" 
                                class="rounded-circle shadow-sm border border-4 border-white" 
                                alt="Profile Admin"
                                style="width: 128px; height: 128px; object-fit: cover;">
                            
                            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle" 
                                style="width: 20px; height: 20px; transform: translate(-10%, -10%);"></span>
                        </div>
                            <h4 class="fw-bold mt-3 mb-1"><?= $admin['username'] ?></h4>
                            <p class="text-muted small">Administrator Sistem</p>
                        </div>

                        <hr class="opacity-50 mb-4">

                        <form action="<?= base_url('profil/update') ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-600 text-secondary small">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="username" class="form-control bg-light border-0" 
                                           value="<?= $admin['username'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-600 text-secondary small">Ganti Password (Kosongkan jika tidak diubah)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-key text-muted"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-0" 
                                           placeholder="Masukkan password baru">
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 py-3 fw-bold text-white shadow-sm" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; border: none;">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?= view('layout/cta'); ?>
    </div>
</div>