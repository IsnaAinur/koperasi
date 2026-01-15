<?php

namespace App\Controllers;

use App\Models\AnggotaModel; // Import Model di sini

class AnggotaController extends BaseController
{
    protected $anggotaModel; // Deklarasikan properti global

    public function __construct()
    {
        // Inisialisasi model di construct agar bisa dipakai semua fungsi dengan $this->anggotaModel
        $this->anggotaModel = new AnggotaModel();
    }

    // Fungsi utama menampilkan halaman daftar anggota
    public function anggota()
    {
        $data = [
            'anggota' => $this->anggotaModel->findAll()
        ];
        return view('anggota', $data);
    }

    // Mencari nama anggota (AJAX Search)
    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $anggota = $this->anggotaModel->like('nama', $keyword)
                                        ->orLike('alamat', $keyword)
                                        ->findAll();
        } else {
            $anggota = $this->anggotaModel->findAll();
        }

        $output = '';
        if (!empty($anggota)) {
            $no = 1;
            foreach ($anggota as $row) {
                $output .= '<tr>
                    <td class="text-center">' . $no++ . '</td>
                    <td>' . $row['nik_anggota'] . '</td> 
                    <td>' . $row['nama'] . '</td>
                    <td>' . $row['alamat'] . '</td>
                    <td>' . $row['no_hp'] . '</td>
                    <td>' . $row['tgl_bergabung'] . '</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditAnggota" 
                                data-id="' . $row['nik_anggota'] . '" data-nama="' . $row['nama'] . '" 
                                data-alamat="' . $row['alamat'] . '" data-no_hp="' . $row['no_hp'] . '" 
                                data-tgl="' . $row['tgl_bergabung'] . '">Edit</button>
                        <a href="' . base_url('anggota/delete/' . $row['nik_anggota']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin?\')">Hapus</a>
                    </td>
                </tr>';
            }
        } else {
            $output .= '<tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>';
        }

        return $output;
    }

    // Fungsi menyimpan data baru
    public function save()
    {
        $data = [
            'nik_anggota'   => $this->request->getPost('nik'),
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'tgl_bergabung' => $this->request->getPost('tgl_bergabung'),
        ];

        $this->anggotaModel->insert($data); 
        return redirect()->to(base_url('anggota'))->with('success', 'Data anggota berhasil ditambahkan!');
    }

    // Fungsi update data
    public function update()
    {
        $nik_lama = $this->request->getPost('id_original'); 
        
        $data = [
            'nik_anggota'   => $this->request->getPost('nik_baru'),
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'tgl_bergabung' => $this->request->getPost('tgl_bergabung'),
        ];

        // Sekarang $this->anggotaModel sudah aman digunakan karena ada di __construct
        $this->anggotaModel->update($nik_lama, $data);

        return redirect()->to(base_url('anggota'))->with('success', 'Data anggota berhasil diperbarui!');
    }

    // Fungsi menghapus data
    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        return redirect()->to(base_url('anggota'))->with('success', 'Data anggota berhasil dihapus!');
    }
}