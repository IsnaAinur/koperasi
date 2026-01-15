<?= view('layout/header'); ?>
<?= view('layout/navigasi'); ?>

<style>
    /* CSS Ringkas tanpa Icon */
    .stats-card {
        background: white; 
        border-radius: 16px; 
        padding: 25px;
        margin-bottom: 20px;
        border: 1px solid #eee;
        transition: 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .stats-card:hover { 
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .stats-label { 
        color: #888; 
        font-size: 0.85rem; 
        font-weight: 600; 
        text-transform: uppercase; 
        margin-bottom: 5px; 
    }

    .stats-value { 
        color: #222; 
        font-size: 2.2rem; 
        font-weight: 700; 
        margin: 0; 
    }

    .stats-desc { 
        color: #999; 
        font-size: 0.85rem; 
        margin-top: 8px; 
    }

    @keyframes fadeInUp { 
        from { opacity: 0; transform: translateY(15px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    .animate-card { animation: fadeInUp 0.4s ease-out backwards; }
</style>

<div id="wrapper">
    <?= view('layout/sidebar'); ?>
    <div id="main-content">
        <?= view('layout/hero'); ?>
        <div class="container-fluid px-4 mt-4">
            <div class="row">
                <?php 
                $cards = [
                    ['label' => 'Total Anggota Aktif', 'val' => number_format($total_anggota, 0, ',', '.'), 'desc' => 'Jumlah anggota terdaftar aktif saat ini.'],
                    ['label' => 'Total Kas Simpanan', 'val' => 'Rp ' . number_format($total_simpanan, 0, ',', '.'), 'desc' => 'Total saldo seluruh jenis simpanan anggota.'],
                    ['label' => 'Total Pinjaman', 'val' => 'Rp ' . number_format($total_pinjaman, 0, ',', '.'), 'desc' => 'Sisa pinjaman yang masih dalam proses cicilan.']
                ];
                
                $delay = 0.1;
                foreach ($cards as $c): ?>
                <div class="col-12 animate-card" style="animation-delay: <?= $delay ?>s">
                    <div class="stats-card text-center text-md-start">
                        <p class="stats-label"><?= $c['label'] ?></p>
                        <h2 class="stats-value"><?= $c['val'] ?></h2>
                        <p class="stats-desc mb-0"><?= $c['desc'] ?></p>
                    </div>
                </div>
                <?php $delay += 0.1; endforeach; ?>
            </div>
        </div>
        <?= view('layout/cta'); ?>
    </div>
</div>
<?= view('layout/footer'); ?>