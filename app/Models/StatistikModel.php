<?php

namespace App\Models;

use CodeIgniter\Model;

class StatistikModel extends Model
{
    public function get_total_anggota() {
        return $this->db->table('anggota')->countAllResults();
    }

    public function get_total_simpanan() {
        // Menghitung jumlah kolom 'jumlah' di tabel simpanan
        return $this->db->table('simpanan')->selectSum('jumlah')->get()->getRow()->jumlah;
    }

    public function get_total_pinjaman() {
        // Menghitung jumlah kolom 'jumlah_pinjaman' di tabel pinjaman
        return $this->db->table('pinjaman')->selectSum('jumlah_pinjaman')->get()->getRow()->jumlah_pinjaman;
    }
}