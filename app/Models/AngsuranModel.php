<?php

namespace App\Models;

use CodeIgniter\Model;

class AngsuranModel extends Model
{
    protected $table      = 'angsuran';
    protected $primaryKey = 'id_angsuran';
    protected $allowedFields = [
        'id_pinjam', 
        'angsuran_ke', 
        'tgl_bayar', 
        'bayar_pokok', 
        'bayar_bunga', 
        'total_bayar'
    ];

    //Menampilkan riwayat angsuran
    public function getRiwayatAngsuran()
    {
        return $this->select('angsuran.*, anggota.nama, pinjaman.sisa_pinjaman')
            ->join('pinjaman', 'pinjaman.id_pinjaman = angsuran.id_pinjam')
            ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
            ->orderBy('angsuran.id_angsuran', 'DESC')
            ->findAll();
    }

    //Menampilkan daftar pinjaman yang belum lunas
    public function getPinjamanAktif()
    {
        return $this->db->table('pinjaman p')
            ->select('p.*, a.nama, (SELECT COUNT(*) FROM angsuran WHERE id_pinjam = p.id_pinjaman) as angsuran_ke_skrg')
            ->join('anggota a', 'a.nik_anggota = p.nik_anggota')
            ->where('p.status', 'Belum Lunas')
            ->get()->getResultArray();
    }

    //Fungsi pencarian
    public function searchAngsuran($keyword)
    {
        return $this->select('angsuran.*, anggota.nama')
            ->join('pinjaman', 'pinjaman.id_pinjaman = angsuran.id_pinjam')
            ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
            ->groupStart()
                ->like('anggota.nama', $keyword)
                ->orLike('angsuran.id_pinjam', str_replace('P', '', strtoupper($keyword)))
            ->groupEnd()
            ->findAll();
    }

    // simpan angsuran sekaligus update tabel pinjaman
    public function prosesBayar($data)
    {
        $this->db->transStart();

        $this->insert($data);

        $this->db->table('pinjaman')
            ->where('id_pinjaman', $data['id_pinjam'])
            ->set('sisa_pinjaman', "sisa_pinjaman - " . (float)$data['bayar_pokok'], false)
            ->update();

        $pinjam = $this->db->table('pinjaman')->where('id_pinjaman', $data['id_pinjam'])->get()->getRow();
        if ($pinjam && $pinjam->sisa_pinjaman <= 0) {
            $this->db->table('pinjaman')
                ->where('id_pinjaman', $data['id_pinjam'])
                ->update(['status' => 'Lunas', 'sisa_pinjaman' => 0]);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    //hapus angsuran dan mengembalikan saldo pinjaman
    public function hapusAngsuran($id)
    {
        $angsuran = $this->find($id);
        if (!$angsuran) return false;

        $this->db->transStart();
        
        $this->db->table('pinjaman')
            ->where('id_pinjaman', $angsuran['id_pinjam'])
            ->set('sisa_pinjaman', "sisa_pinjaman + " . (float)$angsuran['bayar_pokok'], false)
            ->set('status', 'Belum Lunas')
            ->update();

        $this->delete($id);

        $this->db->transComplete();
        return $this->db->transStatus();
    }
}