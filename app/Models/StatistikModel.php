<?php

namespace App\Models;

use CodeIgniter\Model;

class StatistikModel extends Model
{
    public function get_total_anggota() {
        return $this->db->table('anggota')->countAllResults();
    }

    public function get_total_simpanan() {
        $query = $this->db->table('simpanan')->selectSum('jumlah')->get()->getRow();
        return $query->jumlah ?? 0; // Memberikan 0 jika data kosong
    }

    public function get_total_pinjaman() {
        $query = $this->db->table('pinjaman')->selectSum('jumlah_pinjaman')->get()->getRow();
        return $query->jumlah_pinjaman ?? 0;
    }
}