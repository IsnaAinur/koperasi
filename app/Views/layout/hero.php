<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 24px;
        padding: 60px 50px;
        margin: 25px;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    }

    /* Ornamen Latar Belakang Ringkas */
    .hero-section::before {
        content: ''; position: absolute; width: 500px; height: 500px; 
        top: -50%; right: -10%; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
        animation: float 15s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(20px) scale(1.05); }
    }

    .hero-content { position: relative; z-index: 1; animation: fadeInUp 0.8s ease-out; }
    .hero-title { font-weight: 800; font-size: 3rem; line-height: 1.2; margin-bottom: 20px; }
    .hero-subtitle { opacity: 0.9; font-size: 1.2rem; margin-bottom: 35px; max-width: 600px; }

    /* Tombol */
    .btn-hero {
        padding: 14px 35px; border-radius: 50px; font-weight: 600;
        transition: 0.3s; border: none; display: inline-flex; align-items: center;
    }
    .btn-hero:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    .btn-hero-primary { background: white; color: #667eea; }
    .btn-hero-outline { background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="hero-section">
    <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="hero-title">Kelola Data Koperasi<br>Mudah, Aman & Terintegrasi</h1>
                <p class="hero-subtitle">Solusi manajemen modern untuk efisiensi administrasi simpan pinjam anggota dalam satu platform.</p>
                
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?= base_url('angsuran') ?>" class="btn-hero btn-hero-outline text-decoration-none">
                        <i class="bi bi-cash-stack me-2"></i> Input Angsuran
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 d-none d-lg-block text-end">
                <img src="<?= base_url('assets/pic.png'); ?>" 
                    class="img-fluid" 
                    alt="Hero Koperasi"
                    style="max-height: 280px; animation: float 6s infinite alternate;">
            </div>
        </div>
    </div>
</div>