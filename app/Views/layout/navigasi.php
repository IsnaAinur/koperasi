

<nav class="nav-bar-custom">
    <div class="nav-container">
        <div class="d-flex align-items-center justify-content-between">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('/') ?>">
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/anggota') ?>">
                        <i class="bi bi-people-fill"></i> Data Anggota
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-briefcase-fill"></i> Services
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/simpanan') ?>">
                                <i class="bi bi-piggy-bank-fill"></i> Simpanan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/pinjaman') ?>">
                                <i class="bi bi-wallet2"></i> Pinjaman
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/angsuran') ?>">
                                <i class="bi bi-wallet2"></i> Angsuran
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>