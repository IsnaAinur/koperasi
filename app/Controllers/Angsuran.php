<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AngsuranModel; // Tambahkan ini

class Angsuran extends BaseController
{
    protected $db;
    protected $angsuranModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->angsuranModel = new AngsuranModel(); // Inisialisasi Model
    }

    public function index()
    {
        // Menggunakan Model untuk mengambil riwayat
        $data['angsuran'] = $this->angsuranModel->getRiwayatAngsuran();

        // Mengambil daftar pinjaman untuk Modal (Tetap pakai Query Builder agar aman)
        $data['daftar_pinjaman'] = $this->db->table('pinjaman p')
            ->select('p.*, a.nama, (SELECT COUNT(*) FROM angsuran WHERE id_pinjam = p.id_pinjaman) as angsuran_ke_skrg')
            ->join('anggota a', 'a.nik_anggota = p.nik_anggota')
            ->where('p.status', 'Belum Lunas')
            ->get()->getResultArray();

        return view('angsuran', $data);
    }

    public function save()
    {
        $id_pinjam   = $this->request->getPost('id_pinjam');
        $bayar_pokok = $this->request->getPost('bayar_pokok');
        $bayar_bunga = $this->request->getPost('bayar_bunga');
        $total_bayar = $bayar_pokok + $bayar_bunga;

        // 1. Simpan menggunakan Model (Lebih aman)
        $this->angsuranModel->save([
            'id_pinjam'    => $id_pinjam,
            'angsuran_ke'  => $this->request->getPost('angsuran_ke'),
            'tgl_bayar'    => $this->request->getPost('tgl_bayar'),
            'bayar_pokok'  => $bayar_pokok,
            'bayar_bunga'  => $bayar_bunga,
            'total_bayar'  => $total_bayar,
        ]);

        // 2. Update sisa_pinjaman (Logika lama Anda tetap dipertahankan)
        $this->db->query("UPDATE pinjaman SET sisa_pinjaman = sisa_pinjaman - $bayar_pokok WHERE id_pinjaman = $id_pinjam");

        // 3. Cek Status Lunas
        $pinjam = $this->db->table('pinjaman')->where('id_pinjaman', $id_pinjam)->get()->getRow();
        if ($pinjam->sisa_pinjaman <= 0) {
            $this->db->table('pinjaman')->where('id_pinjaman', $id_pinjam)->update(['status' => 'Lunas', 'sisa_pinjaman' => 0]);
        }

        return redirect()->to(base_url('angsuran'))->with('success', 'Pembayaran angsuran berhasil disimpan!');
    }

    public function delete($id)
    {
        $angsuran = $this->angsuranModel->find($id);

        if ($angsuran) {
            // Logika lama Anda untuk kembalikan saldo
            $this->db->query("UPDATE pinjaman SET sisa_pinjaman = sisa_pinjaman + " . $angsuran['bayar_pokok'] . ", status = 'Belum Lunas' WHERE id_pinjaman = " . $angsuran['id_pinjam']);

            // Hapus via Model
            $this->angsuranModel->delete($id);

            return redirect()->to(base_url('angsuran'))->with('success', 'Data angsuran dihapus.');
        }

        return redirect()->to(base_url('angsuran'))->with('error', 'Data tidak ditemukan.');
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $angsuran = $this->angsuranModel->searchAngsuran($keyword);

        // Bagian Echo HTML tetap dipertahankan sesuai kode asli Anda
        if (!empty($angsuran)) {
            $no = 1;
            foreach ($angsuran as $row) {
                echo "<tr>
                    <td>" . $no++ . "</td>
                    <td><span class='fw-bold text-primary'>INV-" . str_pad($row['id_angsuran'], 3, '0', STR_PAD_LEFT) . "</span></td>
                    <td class='text-center'>P" . str_pad($row['id_pinjam'], 3, '0', STR_PAD_LEFT) . "</td>
                    <td>" . $row['nama'] . "</td>
                    <td class='text-center'><span class='badge bg-info text-dark'>" . $row['angsuran_ke'] . "</span></td>
                    <td>" . date('d/m/Y', strtotime($row['tgl_bayar'])) . "</td>
                    <td>Rp " . number_format($row['bayar_pokok'], 0, ',', '.') . "</td>
                    <td>Rp " . number_format($row['bayar_bunga'], 0, ',', '.') . "</td>
                    <td class='fw-bold text-success'>Rp " . number_format($row['total_bayar'], 0, ',', '.') . "</td>
                    <td class='text-center'>
                        <a href='" . base_url('angsuran/delete/' . $row['id_angsuran']) . "' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Hapus?\")'>
                            <i class='bi bi-trash'></i>
                        </a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='10' class='text-center p-4'>Data tidak ditemukan.</td></tr>";
        }
    }
}