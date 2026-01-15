<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Koperasi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .login-card { width: 100%; max-width: 400px; padding: 2rem; background: white; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #edf2f7; }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .brand-icon { width: 60px; height: 60px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.8rem; box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3); }
        .form-label { font-weight: 600; color: #64748b; font-size: 0.9rem; }
        .form-control { padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; transition: all 0.3s ease; }
        .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1); }
        .btn-login { background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 12px; border-radius: 12px; font-weight: 700; color: white; width: 100%; margin-top: 1rem; transition: transform 0.2s; }
        .btn-login:hover { transform: translateY(-2px); opacity: 0.9; color: white; }
        .login-footer { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #94a3b8; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h4 class="fw-bold text-dark">Admin Login</h4>
        <p class="text-muted small">Masukkan kredensial Anda untuk akses panel</p>
    </div>

    <?php if(session()->getFlashdata('msg')):?>
        <div class="alert alert-danger py-2 small border-0 mb-3" style="border-radius: 10px;">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif;?>
    <form action="<?= base_url('auth/login') ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                    <i class="bi bi-person text-muted"></i>
                </span>
                <input type="text" name="username" class="form-control border-start-0 rounded-end-3" placeholder="Masukkan username" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                    <i class="bi bi-key text-muted"></i>
                </span>
                <input type="password" name="password" class="form-control border-start-0 rounded-end-3" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-login">
            Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </form>

    <div class="login-footer">
        &copy; 2026 Koperasi Digital Management System
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>