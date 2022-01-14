<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3|5");
    }

    public function index()
    {
        provideAccessTo("1|2");
        $data = [
            'title' => 'Data Pelanggan',
            'pelanggans' => $this->Pelanggan->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pelanggan/index', $data);
    }

    public function piutang()
    {
        $all_pelanggan = $this->Pelanggan->all();
        $pelanggan = [];
        $totalPiutangLama = 0;
        $totalPiutang = 0;
        $totalRetur = 0;
        $totalBayar = 0;
        $totalLainLain = 0;
        $totalSisa = 0;

        $i = 0;
        $currentYear = date('Y');

        foreach ($all_pelanggan as $plg) {
            $id_pelanggan = $plg->id_pelanggan;
            $pelanggan[$i] = $plg;

            //total piutang dari nota penjualan
            $piutang = $this->Notapenjualan->getSumTotalNota([
                'id_pelanggan' => $id_pelanggan,
                'YEAR(tanggal)' => $currentYear
            ])->total;

            //total retur dari retur penjualan
            $retur = $this->Returpenjualan->getSumTotalRetur(['id_pelanggan' => $id_pelanggan])->total;

            //total bayar dari detail pembayaran piutang
            $bayar = 0;

            //Get all pembayaran piutang pelanggan
            $pembayaran_pelanggan = $this->Pembayaranpiutang->getPembayaranPelanggan($id_pelanggan);
            $index = 0;
            foreach ($pembayaran_pelanggan as $pb) {
                $bayar += $pembayaran_pelanggan[$index]->jumlah;
                $index++;
            }

            $lain_lain = $this->Pembayaranpiutang->getTotalLainLain(['id_pelanggan' => $id_pelanggan])->potongan_lain_lain;

            $piutang_lama = $this->Notapenjualan->getSumTotalNotaLama($id_pelanggan)->total;

            $sisa = $piutang_lama + $piutang - $retur - $bayar - $lain_lain;

            $pelanggan[$i]->piutang = $piutang;
            $pelanggan[$i]->piutang_lama = $piutang_lama;
            $pelanggan[$i]->retur = $retur;
            $pelanggan[$i]->bayar = $bayar;
            $pelanggan[$i]->lain_lain = $lain_lain;
            $pelanggan[$i]->sisa = $sisa;

            //Add total
            $totalPiutangLama += $piutang_lama;
            $totalPiutang += $piutang;
            $totalRetur += $retur;
            $totalBayar += $bayar;
            $totalLainLain += $lain_lain;
            $totalSisa += $sisa;

            $i++;
        }

        $data = [
            'title' => 'Data Pelanggan',
            'pelanggans' => $pelanggan,
            'total_piutang_lama' => $totalPiutangLama,
            'total_piutang' => $totalPiutang,
            'total_retur' => $totalRetur,
            'total_bayar' => $totalBayar,
            'total_lain_lain' => $totalLainLain,
            'total_sisa' => $totalSisa,
            'no' => 1
        ];
        $this->main_lib->getTemplate('pelanggan/piutang', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pelanggan',
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pelanggan/form-create', $data);
            } else {
                $pelanggan_data = $this->getPostData();

                $insert = $this->Pelanggan->insert($pelanggan_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pelanggan berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Pelanggan baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pelanggan/form-create', $data);
        }
    }

    public function edit($id_pelanggan)
    {
        if (empty(trim($id_pelanggan))) {
            redirect(base_url('pelanggan'));
        }

        $pelanggan = $this->Pelanggan->findById(['id_pelanggan' => $id_pelanggan]);
        $data = [
            'title' => 'Edit Pelanggan',
            'pelanggan' => $pelanggan,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pelanggan/form-update', $data);
            } else {
                $pelanggan_data = $this->getPostData();

                $update = $this->Pelanggan->update($pelanggan_data, ['id_pelanggan' => $id_pelanggan]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pelanggan berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Pelanggan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pelanggan/form-update', $data);
        }
    }

    private function getPostData()
    {
        return [
            'nama_pelanggan' => strtoupper($this->main_lib->getPost('nama_pelanggan')),
            'kota' => strtoupper($this->main_lib->getPost('kota')),
            'alamat' => strtoupper($this->main_lib->getPost('alamat')),
            'kontak' => $this->main_lib->getPost('kontak'),
        ];
    }

    public function delete($id_pelanggan)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_pelanggan && $data_type === 'pelanggan') {
                $delete = $this->Pelanggan->delete(['id_pelanggan' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pelanggan berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Pelanggan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'nama_pelanggan',
                'name' => 'nama_pelanggan',
                'rules' => 'required'
            ],
            [
                'field' => 'kota',
                'name' => 'kota',
                'rules' => 'required'
            ],
            [
                'field' => 'alamat',
                'name' => 'alamat',
                'rules' => 'required'
            ],
            [
                'field' => 'kontak',
                'name' => 'kontak',
                'rules' => 'required'
            ]
        ];
    }

    public function get_nota_penjualan($id_pelanggan)
    {
        if (!empty(trim($id_pelanggan))) {
            if ($this->input->is_ajax_request()) {
                $notaPelanggan = [];
                $notaPenjualanPelanggan = $this->Notapenjualan->getByIdPelanggan($id_pelanggan);

                $i = 0;
                foreach ($notaPenjualanPelanggan as $nota) {
                    $noNota = $nota->no_nota;
                    $totalNota = $nota->total;
                    //Get total bayar from detail pembayaran piutang
                    $nominalBayar = $this->Detailpembayaranpiutang->getPembayaranNotaPenjualan($noNota);
                    if($totalNota != $nominalBayar) {
                        $notaPelanggan[$i] = $nota;
                        $i++;
                    }
                }

                echo json_encode($notaPelanggan);
            }
        }
    }

    public function get_retur_penjualan($id_pelanggan)
    {
        if (!empty(trim($id_pelanggan))) {
            if ($this->input->is_ajax_request()) {
                $returPenjualanPelanggan = $this->Returpenjualan->getByIdPelanggan($id_pelanggan);
                $returPenjualan = [];

                $i = 0;
                foreach ($returPenjualanPelanggan as $retur) {
                    $noRetur = $retur->no_retur;
                    $totalRetur = $retur->total;
                    //Get total bayar from detail pembayaran piutang
                    $potongRetur = $this->Detailpembayaranpiutang->getSumPotonganReturByNoRetur($noRetur);
                    if($totalRetur != $potongRetur) {
                        $returPenjualan[$i] = $retur;
                        $i++;
                    }
                }

                echo json_encode($returPenjualan);
            }
        }
    }

    public function get_detail($jenis_data, $id_pelanggan)
    {
        $arr_jenis_data = ['piutang', 'piutang-lama', 'retur', 'bayar', 'lain-lain', 'sisa'];
        if (in_array($jenis_data, $arr_jenis_data) && $id_pelanggan !== '') {
            $response = [];
            if ($this->input->is_ajax_request()) {
                if ($jenis_data === 'piutang' || $jenis_data === 'piutang-lama') {
                    $nama_pelanggan = $this->Pelanggan->findById(['id_pelanggan' => $id_pelanggan])->nama_pelanggan;
                    $nota_pejualan = [];
                    $currentYear = date('Y');

                    $all_nota_penjualan = $this->Notapenjualan->getBy([
                        'id_pelanggan' => $id_pelanggan,
                        'YEAR(tanggal)' => $currentYear
                    ], true);
                    $i = 0;

                    if ($jenis_data == "piutang-lama") {
                        $all_nota_penjualan = $this->Notapenjualan->getBy([
                            'id_pelanggan' => $id_pelanggan,
                            'YEAR(tanggal) < ' => $currentYear
                        ], true);
                    }

                    foreach ($all_nota_penjualan as $nota) {
                        //store temp variable
                        $no_nota = $nota->no_nota;
                        $total_nota = $nota->total;

                        //Get total bayar from detail pembayaran piutang
                        $nominal_bayar = $this->Detailpembayaranpiutang->getPembayaranNotaPenjualan($no_nota);

                        //Assign object to array
                        $nota_pejualan[$i] = $nota;
                        $nota_pejualan[$i]->nama_pelanggan = $nama_pelanggan;
                        $nota_pejualan[$i]->bayar = $nominal_bayar;
                        $nota_pejualan[$i]->is_lunas = getStatus($total_nota === $nominal_bayar, 'pelunasan');
                        $i++;
                    }

                    $response = [
                        'status' => 'success',
                        'year' => $currentYear,
                        'data' => $nota_pejualan
                    ];
                } elseif ($jenis_data === 'bayar' || $jenis_data === 'lain-lain') {
                    $pembayaran = $this->Pembayaranpiutang->getPembayaranPelanggan($id_pelanggan);
                    $response = [
                        'status' => 'success',
                        'data' => $pembayaran
                    ];
                } elseif ($jenis_data === 'retur') {
                    $retur = [];
                    $allReturPenjualan = $this->Returpenjualan->findById(['id_pelanggan' => $id_pelanggan], true);

                    $index = 0;
                    foreach ($allReturPenjualan as $returItem) {
                        $retur[$index] = $returItem;

                        $potong = $this->Detailpembayaranpiutang->getSumPotonganReturByNoRetur($returItem->no_retur);
                        $retur[$index]->total_potong = $potong;

                        $isLunas = ($potong === $returItem->total);

                        $retur[$index]->is_lunas = getStatus($isLunas, 'pelunasan');
                        $index++;
                    }

                    $response = [
                        'status' => 'success',
                        'data' => $retur
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Unable to proccess the request.'
                ];
            }

            echo json_encode($response);
        }
    }

    public function get_pelanggan()
    {
        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            $jsonResult = $this->Pelanggan->getJsonResult();
            echo $jsonResult;
        } else {
            redirect(base_url('error'));
        }
    }
}

/* End of file Pelanggan.php */
