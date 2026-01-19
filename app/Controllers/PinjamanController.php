<?php

namespace App\Controllers;

use App\Models\PinjamanModel;
use App\Models\AnggotaModel;

class PinjamanController extends BaseController
{
    protected $pinjamanModel;
    protected $anggotaModel;

    public function __construct() {
        $this->pinjamanModel = new PinjamanModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index() {
        $data = [
            'pinjaman'     => $this->pinjamanModel->getAllPinjaman(),
            'anggota_list' => $this->anggotaModel->findAll()
        ];
        return view('pinjaman', $data);
    }

    public function save() {
        $jumlah = $this->request->getPost('jumlah_pinjaman');
        $tenor  = $this->request->getPost('tenor');
        $bunga  = $this->request->getPost('bunga');

        $total_bunga = ($jumlah * $bunga / 100) * $tenor;
        
        $this->pinjamanModel->insert([
            'nik_anggota'     => $this->request->getPost('id_anggota'),
            'jumlah_pinjaman' => $jumlah,
            'tenor'           => $tenor,
            'bunga'           => $bunga,
            'status'          => 'Belum Lunas',
            'sisa_pinjaman'   => $jumlah + $total_bunga,
        ]);

        return redirect()->to('/pinjaman')->with('success', 'Data pinjaman berhasil ditambahkan!');
    }

    public function update()
    {
        $id = $this->request->getPost('id_pinjaman');
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID Pinjaman tidak ditemukan.');
        }

        // Ambil semua data dari input Modal Edit
        $status = $this->request->getPost('status');
        $sisa   = $this->request->getPost('sisa_pinjaman');

        $data = [
            'nik_anggota'     => $this->request->getPost('id_anggota'),
            'jumlah_pinjaman' => $this->request->getPost('jumlah_pinjaman'),
            'tenor'           => $this->request->getPost('tenor'),
            'bunga'           => $this->request->getPost('bunga'),
            'sisa_pinjaman'   => ($status === 'Lunas') ? 0 : $sisa,
            'status'          => $status,
        ];

        // Eksekusi update berdasarkan ID
        if ($this->pinjamanModel->update($id, $data)) {
            return redirect()->to('/pinjaman')->with('success', 'Data pinjaman berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function delete($id) {
        $this->pinjamanModel->delete($id);
        return redirect()->to('/pinjaman')->with('success', 'Data dihapus!');
    }

    // METHOD SEARCH TANPA FILE VIEW TAMBAHAN
    public function search() {
        $keyword  = $this->request->getGet('keyword');
        $pinjaman = $this->pinjamanModel->searchPinjaman($keyword);
        
        if (empty($pinjaman)) {
            return '<tr><td colspan="8" class="text-center p-4">Data tidak ditemukan.</td></tr>';
        }

        $output = '';
        foreach ($pinjaman as $row) {
            $id_formated = str_pad($row['id_pinjaman'], 3, '0', STR_PAD_LEFT);
            $jumlah      = number_format($row['jumlah_pinjaman'], 0, ',', '.');
            $sisa        = number_format($row['sisa_pinjaman'], 0, ',', '.');
            $badgeColor  = $row['status'] == 'Lunas' ? 'bg-success' : 'bg-warning text-dark';
            $nama        = esc($row['nama']);
            $urlDelete   = base_url('pinjaman/delete/' . $row['id_pinjaman']);

            // Menggunakan sintaks string yang lebih bersih
            $output .= "
            <tr>
                <td>PJN-{$id_formated}</td>
                <td>{$nama}</td>
                <td>Rp {$jumlah}</td>
                <td>{$row['tenor']} Bulan</td>
                <td>{$row['bunga']}%</td>
                <td>Rp {$sisa}</td>
                <td><span class='badge {$badgeColor}'>{$row['status']}</span></td>
                <td class='text-center'>
                    <button class='btn btn-primary btn-sm btn-edit' 
                        data-bs-toggle='modal' data-bs-target='#modalEditPinjaman'
                        data-id='{$row['id_pinjaman']}' 
                        data-status='{$row['status']}'>
                        Edit
                    </button>
                    <a href='{$urlDelete}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus?\")'>Hapus</a>
                </td>
            </tr>";
        }
        return $output;
    }
}