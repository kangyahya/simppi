<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportExcel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        redirect(base_url('dashboard'));
    }

    public function biaya()
    {
        $spreadsheet = new Spreadsheet();
        $dateTime = date('Y_m_d_H_i_s');
        $filename = "Data_Biaya_exported_at_" . $dateTime;
        $sheet = $spreadsheet->getActiveSheet();

        /* Header */
        //Merge cells
        $sheet->mergeCells('C1:G1');
        $sheet->mergeCells('C2:G2');
        $sheet->mergeCells('C3:G3');
        $sheet->mergeCells('C4:G4');
        $sheet->mergeCells('C5:G5');

        //Company Data
        $profil = $this->Profilperusahaan->first();

        $sheet->setCellValue('C1', strtoupper($profil->nama_perusahaan));
        $sheet->setCellValue('C2', "No. Telpon : " . $profil->telpon . " Fax : " . $profil->fax);
        $sheet->setCellValue('C3', "Website : " . $profil->website . " Email : " . $profil->email);
        $sheet->setCellValue('C4', $profil->alamat);

        if($profil !== null && $profil->logo !== '' && file_exists($profil->logo)) {
            //Image
            $drawing = new Drawing();
            $drawing->setName('Company Logo');
            $drawing->setPath($profil->logo);
            $drawing->setWidthAndHeight(100, 70);
            $drawing->setResizeProportional(true);
            $drawing->setCoordinates('A1');
            $drawing->setWorksheet($sheet);

        }

        //Styling font
        $sheet->getStyle('C1')->getFont()
            ->setSize('18')
            ->setBold(true);
        $sheet->getStyle('C2')->getFont()
            ->setSize('14')
            ->setBold(true);
        $sheet->getStyle('C3')->getFont()
            ->setSize('12')
            ->setBold(true);
        $sheet->getStyle('C4')->getFont()
            ->setSize('13')
            ->setBold(true);

        $sheet->getStyle('A7')->getFont()
            ->setSize('14')
            ->setBold(true);

        //Alignment
        $sheet->getStyle('C1:C4')
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C1:C4')
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A7:A8')
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:A8')
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //Border
        $sheet->getStyle('A5:G5')->getBorders()
            ->getBottom()
            ->setBorderStyle(Border::BORDER_THICK);
        /* End Header */

        $sheet->mergeCells('A7:G7');
        $sheet->mergeCells('A8:G8');

        $date = date('Y-m-d');
        $sheet->setCellValue('A7', 'DATA BIAYA');
        $sheet->setCellValue('A8', 'Di cetak pada tanggal ' . IdFormatDate($date) . " pukul " . date('H:i:s'));

        $headerColumn = [
            'A' => 'No.',
            'B' => 'Tanggal',
            'C' => 'Keterangan',
            'D' => 'Jenis Biaya',
            'E' => 'Jumlah',
            'F' => 'Saldo',
            'G' => 'Status',
       ];

        //Table header
        foreach ($headerColumn as $key => $val) {
            $sheet->mergeCells($key."10:".$key."11");
            $sheet->setCellValue($key."10", $val);

            //width
            $sheet->getColumnDimension($key)->setAutoSize(true);

            //Bold
            $sheet->getStyle($key."10:".$key."11")
                ->getFont()
                ->setBold(true);

            //Align center
            $sheet->getStyle($key."10:".$key."11")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($key."10:".$key."11")
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);
        }

        $startIndex = 12;
        $nomor = 1;
        $biaya = $this->Biaya->all();
        $saldo = 0;
        foreach ($biaya as $b) {

            $status = ($b->status === 1) ? "YES" : "NO";
            $jenis = $b->jenis_biaya;
            $nominal = $b->nominal;

            if($jenis == "MASUK") {
                $saldo += $nominal;
            } else {
                $saldo -= $nominal;
            }

            $sheet->setCellValue("A" . $startIndex, $nomor);
            $sheet->setCellValue("B" . $startIndex, $b->tanggal);
            $sheet->setCellValue("C" . $startIndex, trim($b->keterangan));
            $sheet->setCellValue("D" . $startIndex, $jenis);
            $sheet->setCellValue("E" . $startIndex, $nominal);
            $sheet->setCellValue("F" . $startIndex, $saldo);
            $sheet->setCellValue("G" . $startIndex, $status);

            $startIndex++;
            $nomor++;
        }

        //Set border
        $lastRow = $startIndex - 1;
        $sheet->getStyle('A10:G' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        //Format cell - Number
        $sheet->getStyle('E12:F' . $lastRow)
            ->getNumberFormat()
            ->setFormatCode('Rp #,##0;-Rp #,##0');


        $writer = new Xlsx($spreadsheet);
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT+7");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header("Content-Disposition: attachment;filename=".$filename.".xlsx");
        //unduh file
        $writer->save('php://output');
    }

}

/* End of file ExportExcel.php */