<?php

namespace App\Controllers;

use App\Models\SimpananModel;
use App\Models\AnggotaModel;

class SimpananController extends BaseController
{
    protected $simpananModel;

    public function __construct()
    {
        $this->simpananModel = new SimpananModel();
    }

    public function index()
    {
        $data = [
            // Perbaikan: Pastikan JOIN menggunakan nik_anggota
            'simpanan'     => $this->simpananModel->select('simpanan.*, anggota.nama')
                                                  ->join('anggota', 'anggota.nik_anggota = simpanan.nik_anggota')
                                                  ->findAll(),
            'anggota_list' => (new AnggotaModel())->findAll() 
        ];

        return view('simpanan', $data);
    }

    public function save()
    {
        $this->simpananModel->insert([
            'nik_anggota'    => $this->request->getPost('id_anggota'), // name di view adalah id_anggota
            'jenis_simpanan' => $this->request->getPost('jenis_simpanan'),
            'jumlah'         => $this->request->getPost('jumlah'),
            'tgl_setor'      => $this->request->getPost('tgl_setor'),
        ]);

        return redirect()->to(base_url('simpanan'))->with('success', 'Data simpanan berhasil ditambahkan!');
    }

    public function update()
    {
        $id = $this->request->getPost('id_simpanan');
        
        $this->simpananModel->update($id, [
            // Perbaikan: Ganti id_anggota menjadi nik_anggota sesuai kolom database
            'nik_anggota'    => $this->request->getPost('id_anggota'), 
            'jenis_simpanan' => $this->request->getPost('jenis_simpanan'),
            'jumlah'         => $this->request->getPost('jumlah'),
            'tgl_setor'      => $this->request->getPost('tgl_setor'),
        ]);

        return redirect()->to(base_url('simpanan'))->with('success', 'Data simpanan berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->simpananModel->delete($id);
        return redirect()->to(base_url('simpanan'))->with('success', 'Data simpanan berhasil dihapus!');
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        // Perbaikan: Samakan logika JOIN dengan fungsi index
        $builder = $this->simpananModel->select('simpanan.*, anggota.nama')
                                       ->join('anggota', 'anggota.nik_anggota = simpanan.nik_anggota');

        if ($keyword) {
            $simpanan = $builder->like('anggota.nama', $keyword)
                                ->orLike('simpanan.nik_anggota', $keyword)
                                ->findAll();
        } else {
            $simpanan = $builder->findAll();
        }

        $output = '';
        if (!empty($simpanan)) {
            foreach ($simpanan as $row) {
                $id_formatted = 'SMA-' . str_pad($row['id_simpanan'], 3, '0', STR_PAD_LEFT);
                
                $output .= '<tr>
                    <td>' . $id_formatted . '</td>
                    <td>' . $row['nik_anggota'] . '</td> <td>' . $row['nama'] . '</td>
                    <td><span class="badge bg-info text-dark">' . $row['jenis_simpanan'] . '</span></td>
                    <td>Rp ' . number_format($row['jumlah'], 0, ',', '.') . '</td>
                    <td>' . date('d-m-Y', strtotime($row['tgl_setor'])) . '</td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm btn-edit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditSimpanan"
                                data-id="' . $row['id_simpanan'] . '" 
                                data-id_anggota="' . $row['nik_anggota'] . '"
                                data-jenis="' . $row['jenis_simpanan'] . '" 
                                data-jumlah="' . $row['jumlah'] . '"
                                data-tgl="' . $row['tgl_setor'] . '">
                            Edit
                        </button>
                        <a href="' . base_url('simpanan/delete/' . $row['id_simpanan']) . '" 
                        class="btn btn-danger btn-sm" 
                        onclick="return confirm(\'Hapus?\')">
                            Hapus
                        </a>
                    </td>
                </tr>';
            }
        } else {
            $output .= '<tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>';
        }

        return $output;
    }
}