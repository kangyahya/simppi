<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        $this->load->library('PDFlib');
    }

    public function index()
    {
        redirect(base_url('dashboard'));
    }

    //Cetak Pelanggan
    public function pelanggan()
    {
        $data = [
            'pelanggan' => $this->Pelanggan->all(),
            'no' => 1
        ];
        $this->pdflib->setFileName('Data_Pelanggan_' . date('Y_m_d_H_i_is') . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('pelanggan/cetak-pelanggan', $data);
    }

    //Cetak Supplier
    public function supplier()
    {
        $data = [
            'supplier' => $this->Supplier->all(),
            'no' => 1
        ];
        $this->pdflib->setFileName('Data_Supplier_' . date('Y_m_d_H_i_is') . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('supplier/cetak-supplier', $data);
    }

    //Cetak nota penjualan
    public function nota_penjualan()
    {
        $nota_pejualan = [];
        $all_nota_penjualan = $this->Notapenjualan->all();
        $pelanggan = $this->Pelanggan->all();
        $sales = $this->Sales->all();

        if (isset($_GET['id_pelanggan']) || isset($_GET['id_sales']) || isset($_GET['bulan'])) {
            $id_pelanggan = $this->input->get('id_pelanggan', true);
            $id_sales = $this->input->get('id_sales', true);
            $index_bulan = $this->input->get('bulan', true);

            $filter = [];

            //Filter only by pelanggan
            if (!empty(trim($id_pelanggan))) {
                $filter = ['nota_penjualan.id_pelanggan' => $id_pelanggan];
            }

            //Filter only by sales
            if (!empty(trim($id_sales))) {
                $filter = ['nota_penjualan.id_sales' => $id_sales];
            }

            //Filter only by month
            if (!empty(trim($index_bulan))) {
                $filter = ['MONTH(nota_penjualan.tanggal)' => $index_bulan];
            }

            //Filter only by pelanggan and sales
            if (!empty(trim($id_pelanggan)) && !empty(trim($id_sales))) {
                $filter = [
                    'nota_penjualan.id_pelanggan' => $id_pelanggan,
                    'nota_penjualan.id_sales' => $id_sales,
                ];
            }

            //Filter only by pelanggan and month
            if (!empty(trim($id_pelanggan)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_penjualan.id_pelanggan' => $id_pelanggan,
                    'MONTH(nota_penjualan.tanggal)' => $index_bulan
                ];
            }

            //Filter only by sales and month
            if (!empty(trim($id_sales)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_penjualan.id_sales' => $id_sales,
                    'MONTH(nota_penjualan.tanggal)' => $index_bulan
                ];
            }

            //Filter only by pelanggan and sales
            if (!empty(trim($id_pelanggan)) && !empty(trim($id_sales)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_penjualan.id_pelanggan' => $id_pelanggan,
                    'nota_penjualan.id_sales' => $id_sales,
                    'MONTH(nota_penjualan.tanggal)' => $index_bulan
                ];
            }

            if ($filter !== '') {
                $all_nota_penjualan = $this->Notapenjualan->filterBy($filter);
            }
        }

        $i = 0;
        $totalBayar = 0;
        $grandTotal = 0;
        foreach ($all_nota_penjualan as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranpiutang->getPembayaranNotaPenjualan($no_nota);

            //Assign object to array
            $nota_pejualan[$i] = $nota;
            $nota_pejualan[$i]->bayar = $nominal_bayar;
            $nota_pejualan[$i]->is_lunas = $total_nota === $nominal_bayar;

            $totalBayar += $nominal_bayar;
            $grandTotal += $total_nota;
            $i++;
        }

        $data = [
            'nota_penjualan' => $nota_pejualan,
            'pelanggan' => $pelanggan,
            'sales' => $sales,
            'total_bayar' => $totalBayar,
            'grand_total' => $grandTotal,
            'no' => 1
        ];

        $this->pdflib->setFileName('Data_Penjualan_' . date('Y_m_d_H_i_is') . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('nota-penjualan/cetak-nota-penjualan', $data);
        //$this->load->view('nota-penjualan/cetak-nota-penjualan', $data);
    }

    public function nota_supplier()
    {
        $nota_supplier = [];
        $all_nota_supplier = $this->Notasupplier->all();
        $pelanggan = $this->Pelanggan->all();
        $supplier = $this->Supplier->all();

        if (isset($_GET['pelanggan']) || isset($_GET['supplier']) || isset($_GET['bulan'])) {
            $id_pelanggan = $this->input->get('pelanggan', true);
            $id_supplier = $this->input->get('supplier', true);
            $index_bulan = $this->input->get('bulan', true);

            $filter = [];

            //Filter only by pelanggan
            if (!empty(trim($id_pelanggan))) {
                $filter = ['nota_pembelian.id_pelanggan' => $id_pelanggan];
            }

            //Filter only by supplier
            if (!empty(trim($id_supplier))) {
                $filter = ['nota_pembelian.id_supplier' => $id_supplier];
            }

            //Filter only by month
            if (!empty(trim($index_bulan))) {
                $filter = ['MONTH(nota_pembelian.tanggal)' => $index_bulan];
            }

            //Filter only by pelanggan and supplier
            if (!empty(trim($id_pelanggan)) && !empty(trim($id_supplier))) {
                $filter = [
                    'nota_pembelian.id_pelanggan' => $id_pelanggan,
                    'nota_pembelian.id_supplier' => $id_supplier,
                ];
            }

            //Filter only by pelanggan and month
            if (!empty(trim($id_pelanggan)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_pembelian.id_pelanggan' => $id_pelanggan,
                    'MONTH(nota_pembelian.tanggal)' => $index_bulan
                ];
            }

            //Filter only by supplier and month
            if (!empty(trim($id_supplier)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_pembelian.id_supplier' => $id_supplier,
                    'MONTH(nota_pembelian.tanggal)' => $index_bulan
                ];
            }

            if (!empty(trim($id_pelanggan)) && !empty(trim($id_supplier)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_pembelian.id_pelanggan' => $id_pelanggan,
                    'nota_pembelian.id_supplier' => $id_supplier,
                    'MONTH(nota_pembelian.tanggal)' => $index_bulan
                ];
            }

            if ($filter !== '') {
                $all_nota_supplier = $this->Notasupplier->filterBy($filter);
            }
        }

        $i = 0;
        foreach ($all_nota_supplier as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranhutang->getPembayaranNotaSupplier($no_nota);

            //Assign object to array
            $nota_supplier[$i] = $nota;
            $nota_supplier[$i]->bayar = $nominal_bayar;
            $nota_supplier[$i]->is_lunas = ($total_nota === $nominal_bayar) ? true : false;
            $i++;
        }

        $data = [
            'nota_supplier' => $nota_supplier,
            'pelanggan' => $pelanggan,
            'supplier' => $supplier,
            'no' => 1
        ];
        $this->pdflib->setFileName('Data_Pembelian_' . date('Y_m_d_H_i_is') . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('nota-supplier/cetak-nota-supplier', $data);
    }

    public function retur_supplier()
    {
        $retur = $this->Retursupplier->getAll('supplier', 'supplier.id_supplier = retur_supplier.id_supplier');

        if (isset($_GET['supplier']) || isset($_GET['bulan'])) {
            $id_supplier = $this->input->get('supplier', true);
            $index_bulan = $this->input->get('bulan', true);

            if (!empty(trim($id_supplier))) {
                $retur = $this->Retursupplier->filterBy([
                    'retur_supplier.id_supplier' => $id_supplier,
                ]);
            }

            if (!empty(trim($index_bulan))) {
                $retur = $this->Retursupplier->filterBy([
                    'MONTH(retur_supplier.tanggal)' => $index_bulan
                ]);
            }

            if (!empty(trim($id_supplier)) && !empty(trim($index_bulan))) {
                $retur = $this->Retursupplier->filterBy([
                    'retur_supplier.id_supplier' => $id_supplier,
                    'MONTH(retur_supplier.tanggal)' => $index_bulan
                ]);
            }
        }
        $data = [
            'retur_supplier' => $retur,
            'no' => 1
        ];
        $this->pdflib->setFileName('Data_Retur_Supplier_' . date('Y_m_d_H_i_is') . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('retur-supplier/cetak', $data);
    }

    public function retur_penjualan()
    {

        $all_retur_penjualan = $this->Returpenjualan->all();

        if (isset($_GET['id_pelanggan']) || isset($_GET['bulan'])) {
            $id_pelanggan = $this->input->get('id_pelanggan', true);
            $index_bulan = $this->input->get('bulan', true);

            $filter = [];

            //Filter only by pelanggan
            if (!empty(trim($id_pelanggan))) {
                $filter = ['retur_penjualan.id_pelanggan' => $id_pelanggan];
            }

            //Filter only by month
            if (!empty(trim($index_bulan))) {
                $filter = ['MONTH(retur_penjualan.tanggal)' => $index_bulan];
            }

            //Filter only by supplier and month
            if (!empty(trim($id_pelanggan)) && !empty(trim($index_bulan))) {
                $filter = [
                    'retur_penjualan.id_pelanggan' => $id_pelanggan,
                    'MONTH(retur_penjualan.tanggal)' => $index_bulan
                ];
            }

            if ($filter !== '') {
                $all_retur_penjualan = $this->Returpenjualan->filterBy($filter);
            }
        }
        $data = [
            'retur_penjualan' => $all_retur_penjualan,
            'no' => 1,
        ];

        $this->pdflib->setFileName('Data_Retur_Penjualan_' . date('Y_m_d_H_i_is') . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('retur-penjualan/cetak', $data);
    }

    public function biaya($kode_transaksi)
    {
        if (!empty(trim($kode_transaksi))) {
            $kode_transaksi = base64_decode($kode_transaksi);
            $biaya = $this->Biaya->getBy('kode_transaksi', $kode_transaksi, true);

            $detail = $biaya[0];

            $data = [
                'biaya' => $biaya,
                'no' => 1,
                'kode_transaksi' => $kode_transaksi,
                'detail' => $detail,
                'no' => 1
            ];

            $this->pdflib->setFileName('Biaya_' . base64_decode($kode_transaksi) . "-" . $kode_transaksi . '.pdf');
            $this->pdflib->setPaper(array(0, 0, 595.3, 421), 'Potrait');
            $this->pdflib->loadView('biaya/cetak', $data);
        } else {
            redirect(base_url('errorpage'));
        }
    }

    public function rekening_koran($no_bukti, $bankString = '')
    {
        if (!empty(trim($no_bukti))) {
            if (!empty(trim($bankString)) && $bankString == 'bank') {
                $idBank = $no_bukti;
                $bank = $this->Bank->findById(['id_bank' => $idBank]);
                $rekening = $this->Rekeningkoran->getBy('id_bank', $idBank, true);
                $viewFile = "bank/cetak-rekening-koran";
                $data = ['bank' => $bank];

                if (isset($_GET['first_date']) || isset($_GET['last_date'])) {
                    $firstDate = $this->main_lib->getParam('first_date');
                    $lastDate = $this->main_lib->getParam('last_date');

                    $where = ['id_bank' => $idBank];
                    if (!empty(trim($firstDate)) && $lastDate == '') {
                        $where['tanggal'] = $firstDate;
                    }

                    if (!empty(trim($lastDate)) && $firstDate == '') {
                        $where['tanggal'] = $lastDate;
                    }

                    $rekening = $this->Rekeningkoran->filterByDate($where);

                    if (!empty(trim($firstDate)) && !empty(trim($lastDate))) {
                        $where = [
                            'id_bank' => $idBank,
                            'first_date' => $firstDate,
                            'last_date' => $lastDate
                        ];

                        $rekening = $this->Rekeningkoran->filterByDate($where, true);
                    }
                }
            } else {
                $no_bukti = base64_decode($no_bukti);
                $rekening = $this->Rekeningkoran->getBy('no_bukti', $no_bukti, true);
                $viewFile = "rekening-koran/cetak";
            }

            $detail = $rekening[0];


            $data['rekening'] = $rekening;
            $data['no_bukti'] = $no_bukti;
            $data['detail'] = $detail;
            $data['no'] = 1;

            $this->pdflib->setFileName('Rekening_Koran_' . base64_decode($no_bukti) . "-" . $no_bukti . '.pdf');
            $this->pdflib->setPaper(array(0, 0, 595.3, 421), 'Potrait');
            $this->pdflib->loadView($viewFile, $data);
        } else {
            redirect(base_url('errorpage'));
        }
    }

    public function perhitungan($type = 'cetak')
    {
        $allPembayaran = $this->Pembayaranpiutang->getKomisiOrCashback();

        //Filter
        $firstDate = $this->main_lib->getParam('from');
        $lastDate = $this->main_lib->getParam('to');
        $getParameter = "";

        if (!empty(trim($firstDate)) && !empty(trim($lastDate))) {
            $allPembayaran = $this->Pembayaranpiutang->getKomisiOrCashback([
                'first_date' => $firstDate,
                'last_date' => $lastDate
            ]);
            $getParameter = "?from=$firstDate&to=$lastDate";
        }

        $data = [
            'title' => 'Data Komisi',
            'pembayaran' => $allPembayaran,
            'first_date' => $firstDate,
            'last_date' => $lastDate,
            'get_parameter' => $getParameter,
            'no' => 1
        ];

        $this->pdflib->setFileName("Data_" . ucwords(strtolower($type)) . '.pdf');
        $this->pdflib->setPaper('A4', 'Landscape');
        $this->pdflib->loadView('perhitungan/cetak-' . $type, $data);
    }
}

/* End of file Cetak.php */
