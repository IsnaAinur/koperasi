<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Simpan Pinjam</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --primary-grad: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        * { font-family: 'Inter', sans-serif; }
        
        body { 
            background: #f5f7fa; 
            min-height: 100vh; 
        }
        
        /* ===== HEADER ===== */
        .top-header { 
            background: var(--primary-grad);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
            color: white;
        }
        
        .top-header .brand-title { font-weight: 700; font-size: 1.2rem; }
        
        #menu-toggle, .user-dropdown {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white !important;
            backdrop-filter: blur(5px);
            transition: 0.3s;
        }
        
        .user-dropdown { padding: 6px 16px; border-radius: 50px; }
        
        #menu-toggle:hover, .user-dropdown:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }
        
        /* ===== LAYOUT & SIDEBAR ===== */
        #wrapper { display: flex; transition: 0.4s ease; width: 100%; }
        
        #sidebar-wrapper {
            width: 280px; min-height: 100vh; background: white;
            border-right: 1px solid #e2e8f0; transition: 0.4s ease;
        }
        
        #wrapper.toggled #sidebar-wrapper { margin-left: -280px; }
        #main-content { flex: 1; min-width: 0; }
        
        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            border: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 12px;
        }
        
        .dropdown-item {
            border-radius: 8px; padding: 10px 16px; transition: 0.2s;
        }
        
        .dropdown-item:hover {
            background: #f8faff; color: #667eea; transform: translateX(4px);
        }
    </style>
</head>
<body>

<div class="top-header py-3 px-4 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <button class="btn me-3" id="menu-toggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="d-flex align-items-center">
            <div 
                style="width: 48px; height: 48px; padding: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1.5px solid rgba(255,255,255,0.3);">
                
                <img src="<?= base_url('assets/icon.png') ?>" 
                    alt="Logo" 
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            
            <span class="brand-title ms-3" style="letter-spacing: 0.5px;">Koperasi Simpan Pinjam</span>
        </div>
    </div>
    
    <div class="d-flex align-items-center gap-3">
        
        <div class="dropdown">
            <a class="user-dropdown text-decoration-none dropdown-toggle d-flex align-items-center"
               href="#" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name=Admin+Koperasi&background=fff&color=667eea&bold=true"
                     width="32" height="32" class="rounded-circle me-2">
                <span class="fw-semibold">Admin Koperasi</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 mt-2">
                <li>
                    <a class="dropdown-item" href="<?= base_url('/profil') ?>">
                        <i class="bi bi-person-circle me-2"></i> Profil Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="<?= base_url('/logout') ?>">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>