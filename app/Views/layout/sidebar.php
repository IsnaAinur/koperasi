<style>
    #sidebar-wrapper {
        background: white;
        position: relative;
        overflow: hidden;
    }
    
    #sidebar-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-10%, -10%); }
    }
    
    .nav-link {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        margin: 4px 12px;
        padding: 14px 16px !important;
        position: relative;
        overflow: hidden;
        color: #64748b !important;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .nav-link:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        color: #667eea !important;
        transform: translateX(4px);
    }
    
    .nav-link:hover::before,
    .nav-link.active::before {
        transform: scaleY(1);
    }
    
    .nav-link.active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.12) 100%);
        color: #667eea !important;
        font-weight: 700;
    }
    
    .nav-link i {
        width: 24px;
        text-align: center;
        font-size: 1.1rem;
    }
    
    .submenu-list {
        list-style: none;
        padding-left: 0;
        margin-top: 8px;
    }
    
    .submenu-list .nav-link {
        padding: 10px 16px 10px 52px !important;
        font-size: 0.9rem;
        color: #94a3b8 !important;
    }
    
    .submenu-list .nav-link:hover {
        color: #667eea !important;
    }
    
    .dropdown-toggle-custom {
        position: relative;
    }
    
    .dropdown-toggle-custom .transition-icon {
        transition: transform 0.3s ease;
    }
    
    .dropdown-toggle-custom[aria-expanded="true"] .transition-icon {
        transform: rotate(180deg);
    }
    
    .sidebar-footer {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        padding: 16px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        border-radius: 12px;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }
    
    .sidebar-footer-text {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
    }
</style>

<div id="wrapper">
    <div id="sidebar-wrapper">      
        <ul class="nav flex-column position-relative" style="z-index: 1;">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/') ?>">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/anggota') ?>">
                    <i class="bi bi-people-fill me-2"></i> Data Anggota
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center dropdown-toggle-custom"
                   data-bs-toggle="collapse"
                   href="#servicesMenu"
                   role="button"
                   aria-expanded="true">
                    <span>
                        <i class="bi bi-briefcase-fill me-2"></i> Services
                    </span>
                    <i class="bi bi-chevron-down transition-icon"></i>
                </a>
                
                <div class="collapse show" id="servicesMenu">
                    <ul class="submenu-list nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('simpanan') ?>">
                                <i class="bi bi-piggy-bank-fill me-2"></i> Simpanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pinjaman') ?>">
                                <i class="bi bi-wallet2 me-2"></i> Pinjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('angsuran') ?>">
                                <i class="bi bi-credit-card-2-front-fill me-2"></i> Angsuran
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    
    <div id="main-content">
        
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const menuToggle = document.body.querySelector('#menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', event => {
                event.preventDefault();
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }
    });
</script>