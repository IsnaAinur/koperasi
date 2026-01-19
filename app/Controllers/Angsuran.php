<?php

namespace App\Controllers;

use App\Models\AngsuranModel;

class Angsuran extends BaseController
{
    protected $angsuranModel;

    public function __construct()
    {
        $this->angsuranModel = new AngsuranModel();
    }

    public function index()
    {
        $data = [
            'angsuran'         => $this->angsuranModel->getRiwayatAngsuran(),
            'daftar_pinjaman'  => $this->angsuranModel->getPinjamanAktif()
        ];
        return view('angsuran', $data);
    }

    public function save()
    {
        $payload = [
            'id_pinjam'   => $this->request->getPost('id_pinjam'),
            'angsuran_ke' => $this->request->getPost('angsuran_ke'),
            'tgl_bayar'   => $this->request->getPost('tgl_bayar'),
            'bayar_pokok' => $this->request->getPost('bayar_pokok'),
            'bayar_bunga' => $this->request->getPost('bayar_bunga'),
            'total_bayar' => $this->request->getPost('bayar_pokok') + $this->request->getPost('bayar_bunga'),
        ];

        if ($this->angsuranModel->prosesBayar($payload)) {
            return redirect()->to('/angsuran')->with('success', 'Pembayaran berhasil disimpan!');
        }
        return redirect()->back()->with('error', 'Gagal memproses pembayaran.');
    }

    public function delete($id)
    {
        if ($this->angsuranModel->hapusAngsuran($id)) {
            return redirect()->to('/angsuran')->with('success', 'Data berhasil dihapus.');
        }
        return redirect()->to('/angsuran')->with('error', 'Gagal menghapus data.');
    }

    public function search()
{
    $keyword = $this->request->getGet('keyword');
    $angsuran = $this->angsuranModel->searchAngsuran($keyword);

    if (!empty($angsuran)) {
        $no = 1;
        $html = "";
        foreach ($angsuran as $row) {
            $id_angsuran = str_pad($row['id_angsuran'], 3, '0', STR_PAD_LEFT);
            $id_pinjam   = str_pad($row['id_pinjam'], 3, '0', STR_PAD_LEFT);
            $tgl_bayar   = date('d/m/Y', strtotime($row['tgl_bayar']));
            $pokok       = number_format($row['bayar_pokok'], 0, ',', '.');
            $bunga       = number_format($row['bayar_bunga'], 0, ',', '.');
            $total       = number_format($row['total_bayar'], 0, ',', '.');
            $nama        = esc($row['nama']);
            $url_delete  = base_url('angsuran/delete/' . $row['id_angsuran']);

            $html .= "<tr>
                <td>" . $no++ . "</td>
                <td><span class='fw-bold text-primary'>INV-{$id_angsuran}</span></td>
                <td class='text-center'>P{$id_pinjam}</td>
                <td>{$nama}</td>
                <td class='text-center'><span class='badge bg-info text-dark'>{$row['angsuran_ke']}</span></td>
                <td>{$tgl_bayar}</td>
                <td>Rp {$pokok}</td>
                <td>Rp {$bunga}</td>
                <td class='fw-bold text-success'>Rp {$total}</td>
                <td class='text-center'>
                    <a href='{$url_delete}' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Hapus?\")'>
                        <i class='bi bi-trash'></i>
                    </a>
                </td>
            </tr>";
        }
        echo $html;
    } else {
        echo "<tr><td colspan='10' class='text-center p-4'>Data tidak ditemukan.</td></tr>";
    }
}
}