<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class C_excel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function struktur1($keyword)
    {
        // Membuat instance Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Mengatur header utama
        $sheet->setCellValue('A1', 'STRUKTUR PRODUK');
        $sheet->setCellValue('A2', 'Dicetak Tanggal : ' . date('j F Y h:i:s A'));

        // Styling untuk header utama
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Mengatur header tabel
        $sheet->setCellValue('A4', 'Series');
        $sheet->setCellValue('B4', 'Produk');

        // Mendapatkan data dari database
        $series = $this->db->query("SELECT Series, Nama_Produk FROM pro_struktur_lvl1 WHERE ID = ? GROUP BY Series, Nama_Produk", [$keyword])->row();

        $sheet->setCellValue('A5', $series->Series);
        $sheet->setCellValue('B5', $series->Nama_Produk);

        $sheet->setCellValue('A7', 'Kode Komp');
        $sheet->setCellValue('B7', 'Nama Komp');

        $bom_head = $this->db->query("SELECT Kode_Komp, Nama_Komp FROM pro_struktur_lvl1 WHERE ID = ? GROUP BY Kode_Komp, Nama_Komp", [$keyword])->result();

        $row = 8; // Start row for BOM data
        $no = 1;

        foreach ($bom_head as $data) {
            $sheet->setCellValue('A' . $row, $no . '. ' . $data->Nama_Komp . ' (' . $data->Kode_Komp . ')');
            $row++;

            $bom = $this->db->query("SELECT Kode_Preparasi, nama_preparasi, Satuan, Jumlah, Nama_Divisi, Kode_Tahap, Deskripsi FROM pro_struktur_lvl2 WHERE ID_Bom_Komp = ?", [$data->Kode_Komp])->result();

            foreach ($bom as $bom) {
                $sheet->setCellValue('A' . $row, '  ' . $bom->Kode_Preparasi . ' - ' . $bom->nama_preparasi);
                $row++;

                $tahap = $this->db->query("SELECT GRUP, Nama_Proses, durasi_dtk, workstation, Nama_Divisi, TAHAP FROM pro_master_tahap WHERE GRUP = ?", [$bom->Kode_Tahap])->result();

                if (!empty($tahap)) {
                    $sheet->setCellValue('A' . $row, 'Proses Produksi:');
                    $row++;

                    $sheet->setCellValue('A' . $row, 'Urutan');
                    $sheet->setCellValue('B' . $row, 'Nama Proses');
                    $sheet->setCellValue('C' . $row, 'Durasi(Detik)');
                    $sheet->setCellValue('D' . $row, 'Workstation');
                    $sheet->setCellValue('E' . $row, 'Divisi Proses');
                    $sheet->setCellValue('F' . $row, 'Keterangan');
                    $row++;

                    foreach ($tahap as $tahap) {
                        $sheet->setCellValue('A' . $row, $tahap->TAHAP);
                        $sheet->setCellValue('B' . $row, $tahap->Nama_Proses);
                        $sheet->setCellValue('C' . $row, $tahap->durasi_dtk);
                        $sheet->setCellValue('D' . $row, $tahap->workstation);
                        $sheet->setCellValue('E' . $row, $tahap->Nama_Divisi);
                        $row++;
                    }
                }

                $bahan = $this->db->query("SELECT bom_material.ID AS ID, bom_material.Kode_Prep as Kode_Prep, bom_material.Kode_Material as Kode_Material, `inventory`.`Item Name` as Nama_Material, inventory.Unit as Satuan, bom_material.Jumlah as Ukuran, inventory.Measure as Measure FROM bom_material LEFT JOIN inventory ON bom_material.Kode_Material = inventory.ID WHERE bom_material.Kode_Prep = ? AND bom_material.Status = 2", [$bom->Kode_Preparasi])->result();

                if (!empty($bahan)) {
                    $sheet->setCellValue('A' . $row, 'Bahan Baku:');
                    $row++;

                    $sheet->setCellValue('A' . $row, 'Kode');
                    $sheet->setCellValue('B' . $row, 'Nama Bahan Baku');
                    $sheet->setCellValue('C' . $row, 'Satuan');
                    $sheet->setCellValue('D' . $row, 'Ukuran(mm)');
                    $sheet->setCellValue('E' . $row, 'Kebutuhan');
                    $sheet->setCellValue('F' . $row, 'Jumlah Potong');
                    $sheet->setCellValue('G' . $row, 'Sisa Potong(mm)');
                    $row++;

                    foreach ($bahan as $bahan) {
                        $measure = $bahan->Measure;
                        $ukuran = $bahan->Ukuran;
                        $jumlah_pot = floor($measure/$ukuran);
                        $sisa = $measure - ($jumlah_pot * $ukuran);

                        $sheet->setCellValue('A' . $row, $bahan->Kode_Material);
                        $sheet->setCellValue('B' . $row, $bahan->Nama_Material);
                        $sheet->setCellValue('C' . $row, $bahan->Satuan);
                        $sheet->setCellValue('D' . $row, $bahan->Measure);
                        $sheet->setCellValue('E' . $row, $bahan->Ukuran);
                        $sheet->setCellValue('F' . $row, $jumlah_pot);
                        $sheet->setCellValue('G' . $row, $sisa);
                        $row++;
                    }
                }
            }
            $no++;
        }

        // Styling untuk header tabel
        $sheet->getStyle('A4:B4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Border untuk tabel
        $sheet->getStyle('A7:G' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Menyimpan file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'struktur_produksi.xlsx';

        // Menetapkan header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Output ke browser
        $writer->save('php://output');
    }

}