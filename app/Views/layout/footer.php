</div>
    </div>
</div>

<style>
    .modern-footer {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: white;
        margin-top: 60px;
        padding: 40px 0 20px;
    }
    
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .footer-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .footer-title {
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0;
    }
    
    .footer-desc {
        color: rgba(255,255,255,0.6);
        font-size: 0.9rem;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .social-text {
        color: rgba(255,255,255,0.7);
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .social-text i {
        color: rgba(255,255,255,0.5);
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #667eea;
        display: inline-block;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 10px;
    }
    
    .footer-links a {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .footer-links a:hover {
        color: white;
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 20px;
        margin-top: 30px;
        text-align: center;
    }
    
    .footer-bottom p {
        color: rgba(255,255,255,0.5);
        font-size: 0.85rem;
        margin: 0;
    }
    
    .footer-stats {
        display: flex;
        gap: 30px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        display: block;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.6);
    }
</style>

<footer class="modern-footer">
    <div class="container-fluid px-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <div class="footer-icon">
                        <i class="bi bi-buildings fs-4 text-white"></i>
                    </div>
                    <h5 class="footer-title">Koperasi</h5>
                </div>
                
                <p class="footer-desc">
                    Sistem manajemen koperasi simpan pinjam modern yang membantu mengelola data anggota, simpanan, pinjaman, dan angsuran dengan mudah dan efisien.
                </p>
                
                <div class="mb-3">
                    <div class="social-text">
                        <i class="bi bi-facebook"></i>
                        <span>Koperasi Official</span>
                    </div>
                    <div class="social-text">
                        <i class="bi bi-instagram"></i>
                        <span>@koperasi_sp</span>
                    </div>
                    <div class="social-text">
                        <i class="bi bi-envelope-fill"></i>
                        <span>info.koperasi@gmail.com</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <h6 class="section-title">Layanan</h6>
                <ul class="footer-links">
                    <li><a href="<?= base_url('/anggota') ?>"> Kelola Anggota</a></li>
                    <li><a href="<?= base_url('simpanan') ?>"> Transaksi Simpanan</a></li>
                    <li><a href="<?= base_url('pinjaman') ?>"> Proses Pinjaman</a></li>
                    <li><a href="<?= base_url('angsuran') ?>"> Proses Angsuran</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <h6 class="section-title text-white fw-bold mb-3">Lokasi</h6>
                <div class="footer-text text-white-50">
                    <p class="mb-2">
                        Jl. Mawar No. 123, Surakarta
                    </p>
                    <p class="mb-0">
                        Senin - Jumat: 08.00 - 16.00 WIB
                    </p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>
                © 2025 <strong>Koperasi Simpan Pinjam</strong>. Semua hak dilindungi.
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>