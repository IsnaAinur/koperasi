<?php

namespace App\Controllers;

use App\Models\PinjamanModel;
use App\Models\AnggotaModel;

class PinjamanController extends BaseController
{
    // Properti model
    protected $pinjamanModel;
    protected $anggotaModel;

    public function __construct()
    {
        // Inisialisasi Model
        $this->pinjamanModel = new PinjamanModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $data = [
            'pinjaman'     => $this->pinjamanModel->select('pinjaman.*, anggota.nama')
                                                  ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
                                                  ->findAll(),
            'anggota_list' => $this->anggotaModel->findAll()
        ];

        return view('pinjaman', $data);
    }

    public function save()
    {
        $jumlah = $this->request->getPost('jumlah_pinjaman');
        $tenor  = $this->request->getPost('tenor');
        $bunga  = $this->request->getPost('bunga');

        // Tambahkan hitungan bunga saat simpan baru agar sisa_pinjaman benar dari awal
        $total_bunga = ($jumlah * $bunga / 100) * $tenor;
        $sisa_awal   = $jumlah + $total_bunga;

        $this->pinjamanModel->insert([
            'nik_anggota'     => $this->request->getPost('id_anggota'),
            'jumlah_pinjaman' => $jumlah,
            'tenor'           => $tenor,
            'bunga'           => $bunga,
            'status'          => 'Belum Lunas',
            'sisa_pinjaman'   => $sisa_awal, // Sisa otomatis menyertakan bunga
        ]);

        return redirect()->to(base_url('pinjaman'))->with('success', 'Data pinjaman berhasil ditambahkan!');
    }

    public function update()
    {
        $id     = $this->request->getPost('id_pinjaman');
        $jumlah = $this->request->getPost('jumlah_pinjaman');
        $tenor  = $this->request->getPost('tenor');
        $bunga  = $this->request->getPost('bunga');
        $status = $this->request->getPost('status');

        // Logika Hitung Sisa Otomatis
        if ($status === 'Lunas') {
            $sisa_pinjaman = 0;
        } else {
            $total_bunga = ($jumlah * $bunga / 100) * $tenor;
            $sisa_pinjaman = $jumlah + $total_bunga;
        }

        $data = [
            'jumlah_pinjaman' => $jumlah,
            'tenor'           => $tenor,
            'bunga'           => $bunga,
            'sisa_pinjaman'   => $sisa_pinjaman,
            'status'          => $status,
        ];

        // REVISI: Menggunakan pinjamanModel (Bukan $this->db) untuk menghindari error null
        $this->pinjamanModel->update($id, $data);

        return redirect()->back()->with('success', 'Data pinjaman dan sisa saldo berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->pinjamanModel->delete($id);
        return redirect()->to(base_url('pinjaman'))->with('success', 'Data pinjaman berhasil dihapus!');
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->pinjamanModel->select('pinjaman.*, anggota.nama')
                                       ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota');

        if ($keyword) {
            $builder->groupStart() // Mengelompokkan LIKE agar join tidak berantakan
                    ->like('anggota.nama', $keyword)
                    ->orLike('pinjaman.id_pinjaman', $keyword)
                    ->groupEnd();
        }

        $pinjaman = $builder->findAll();
        
        if (empty($pinjaman)) {
            return '<tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>';
        }

        $output = '';
        foreach ($pinjaman as $row) {
            $statusBadge = $row['status'] == 'Lunas' ? 'bg-success' : 'bg-warning text-dark';
            $id_formatted = str_pad($row['id_pinjaman'], 3, '0', STR_PAD_LEFT);
            
            $output .= '<tr>
                <td>PJN-' . $id_formatted . '</td>
                <td>' . $row['nama'] . '</td>
                <td>Rp ' . number_format($row['jumlah_pinjaman'], 0, ',', '.') . '</td>
                <td>' . $row['tenor'] . ' Bulan</td>
                <td>' . $row['bunga'] . '%</td>
                <td>Rp ' . number_format($row['sisa_pinjaman'], 0, ',', '.') . '</td>
                <td><span class="badge ' . $statusBadge . '">' . $row['status'] . '</span></td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm btn-edit" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalEditPinjaman"
                        data-id="' . $row['id_pinjaman'] . '" 
                        data-id_anggota="' . $row['nik_anggota'] . '"
                        data-jumlah="' . $row['jumlah_pinjaman'] . '" 
                        data-tenor="' . $row['tenor'] . '"
                        data-bunga="' . $row['bunga'] . '" 
                        data-status="' . $row['status'] . '"
                        data-sisa="' . $row['sisa_pinjaman'] . '">
                        Edit
                    </button>
                    <a href="' . base_url('pinjaman/delete/' . $row['id_pinjaman']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus?\')">Hapus</a>
                </td>
            </tr>';
        }
        return $output;
    }
}