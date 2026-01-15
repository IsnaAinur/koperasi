<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Angsuran extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Mengambil riwayat angsuran untuk tabel
        $builder = $this->db->table('angsuran');
        $builder->select('angsuran.*, anggota.nama, pinjaman.sisa_pinjaman');
        $builder->join('pinjaman', 'pinjaman.id_pinjaman = angsuran.id_pinjam');
        $builder->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota');
        $builder->orderBy('angsuran.id_angsuran', 'DESC');
        $data['angsuran'] = $builder->get()->getResultArray();

        // Mengambil daftar pinjaman untuk Modal (Hanya yang belum lunas)
        // Kita tambahkan subquery untuk menghitung angsuran ke-berapa secara otomatis
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

        // 1. Simpan ke tabel angsuran
        $this->db->table('angsuran')->insert([
            'id_pinjam'    => $id_pinjam,
            'angsuran_ke'  => $this->request->getPost('angsuran_ke'),
            'tgl_bayar'    => $this->request->getPost('tgl_bayar'),
            'bayar_pokok'  => $bayar_pokok,
            'bayar_bunga'  => $bayar_bunga,
            'total_bayar'  => $total_bayar,
        ]);

        // 2. Update sisa_pinjaman di tabel pinjaman
        $this->db->query("UPDATE pinjaman SET sisa_pinjaman = sisa_pinjaman - $bayar_pokok WHERE id_pinjaman = $id_pinjam");

        // 3. Jika sisa pinjaman <= 0, ubah status jadi Lunas
        $pinjam = $this->db->table('pinjaman')->where('id_pinjaman', $id_pinjam)->get()->getRow();
        if ($pinjam->sisa_pinjaman <= 0) {
            $this->db->table('pinjaman')->where('id_pinjaman', $id_pinjam)->update(['status' => 'Lunas', 'sisa_pinjaman' => 0]);
        }

        return redirect()->to(base_url('angsuran'))->with('success', 'Pembayaran angsuran berhasil disimpan!');
    }

    public function delete($id)
    {
        // 1. Ambil data angsuran yang mau dihapus untuk tahu jumlah pokoknya
        $angsuran = $this->db->table('angsuran')->where('id_angsuran', $id)->get()->getRow();

        if ($angsuran) {
            // 2. Kembalikan saldo sisa_pinjaman (Tambah lagi karena batal bayar)
            $this->db->query("UPDATE pinjaman SET sisa_pinjaman = sisa_pinjaman + $angsuran->bayar_pokok, status = 'Belum Lunas' WHERE id_pinjaman = $angsuran->id_pinjam");

            // 3. Hapus data angsuran
            $this->db->table('angsuran')->where('id_angsuran', $id)->delete();

            return redirect()->to(base_url('angsuran'))->with('success', 'Data angsuran berhasil dihapus dan saldo pinjaman dikembalikan.');
        }

        return redirect()->to(base_url('angsuran'))->with('error', 'Data tidak ditemukan.');
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        $db = \Config\Database::connect();
        $builder = $db->table('angsuran');
        $builder->select('angsuran.*, anggota.nama');
        $builder->join('pinjaman', 'pinjaman.id_pinjaman = angsuran.id_pinjam');
        $builder->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota');

        if ($keyword) {
            $builder->groupStart()
                    ->like('anggota.nama', $keyword)
                    ->orLike('angsuran.id_pinjam', str_replace('P', '', strtoupper($keyword)))
                    ->groupEnd();
        }

        $angsuran = $builder->get()->getResultArray();

        // Kuncinya di sini: Kita tulis HTML-nya langsung supaya tidak error 'file not found'
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