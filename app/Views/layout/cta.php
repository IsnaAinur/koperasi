<style>
    .cta-slim-card {
        /* MENGUBAH JADI MELAYANG */
        position: fixed;
        bottom: 25px; /* Jarak dari bawah */
        right: 25px;  /* Jarak dari kanan */
        z-index: 9999; /* Agar selalu di atas elemen lain */
        
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px; /* Lebih membulat agar kesan mengambang lebih kuat */
        padding: 15px 25px;
        width: 100%;
        max-width: 450px; /* Batasi lebar agar tidak menutupi seluruh layar */
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); /* Shadow lebih tebal */
        border: 2px solid rgba(255, 255, 255, 0.1);
        color: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Efek saat card di-hover */
    .cta-slim-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.5);
    }

    .cta-slim-card .icon-box {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cta-slim-card .btn-white {
        background: white;
        color: #667eea;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 8px 15px;
        border-radius: 10px;
        white-space: nowrap;
        transition: all 0.3s ease;
        border: none;
    }

    .cta-slim-card .btn-white:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        color: #764ba2;
    }

    .cta-text-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0;
    }

    .cta-text-sub {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0;
        line-height: 1.2;
    }

    /* Sembunyikan di layar HP kecil agar tidak menutupi konten utama */
    @media (max-width: 576px) {
        .cta-slim-card {
            right: 15px;
            left: 15px;
            bottom: 15px;
            max-width: none;
        }
        .cta-text-sub {
            display: none; /* Sembunyikan teks detail di HP */
        }
    }
</style>

<div class="cta-slim-card animate__animated animate__fadeInUp">
    <div class="d-flex align-items-center justify-content-between gap-3">
        
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box">
                <i class="bi bi-info-circle-fill fs-5 text-white"></i>
            </div>
            <div>
                <h5 class="cta-text-title">Pusat Bantuan</h5>
                <p class="cta-text-sub">Buka panduan untuk mengoperasikan web atau kirim pertanyaan/saran ke teknisi IT mengenai web ini</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= base_url('dashboard/panduan'); ?>" class="btn btn-white shadow-sm">
                <i class="bi bi-journal-text"></i>
            </a>
            <a href="https://wa.me/6285640898081" target="_blank" class="btn btn-white shadow-sm">
                <i class="bi bi-whatsapp"></i>
            </a>
        </div>

    </div>
</div>