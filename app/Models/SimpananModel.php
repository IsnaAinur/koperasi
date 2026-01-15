<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpananModel extends Model
{
    protected $table            = 'simpanan';
    protected $primaryKey       = 'id_simpanan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Sangat penting untuk keamanan data
    protected $allowedFields    = ['nik_anggota', 'jenis_simpanan', 'jumlah', 'tgl_setor'];
}