<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_form extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
        date_default_timezone_set('Asia/Jakarta');
    }

	function BOM($keyword)
	{
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('P', 'mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,7,'BILL OF MATERIAL',0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $tanggal = date('j F Y h:i:s A');
        $pdf->Cell(0,6,'Dicetak Tanggal : '.$tanggal,0,1,'C');
        $pdf->Cell(0,6,'',0,1);
        $pdf->SetFont('Arial','B',10);

        $series = $this->db->query("SELECT Series, Nama_Produk FROM pro_bom_lvl1 WHERE ID = $keyword GROUP BY Series, Nama_Produk")->row();

        $pdf->Cell(20,6,'Series',0,0,'L');
        $pdf->Cell(5,6,':',0,0,'L');
        $pdf->Cell(85,6,$series->Series,0,1,'L');
        $pdf->Cell(20,6,'Produk',0,0,'L');
        $pdf->Cell(5,6,':',0,0,'L');
        $pdf->Cell(85,6,$series->Nama_Produk,0,1,'L');

        $pdf->Cell(20,6,'Kode',1,0,'C');
        $pdf->Cell(75,6,'Nama Barang',1,0,'C');
        $pdf->Cell(15,6,'Satuan',1,0,'C');
        $pdf->Cell(20,6,'Jumlah',1,0,'C');
        $pdf->Cell(20,6,'Status',1,0,'C');
        $pdf->Cell(40,6,'Koreksi',1,1,'C');
        $no=0;

        //$bom = $this->db->get_where('pro_bom_lvl1',["ID"=>$keyword])->result();
        $bom_head = $this->db->query("SELECT Kategori FROM pro_bom_lvl1 WHERE ID = $keyword GROUP BY Kategori")->result();

        foreach ($bom_head as $data){
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,6,$data->Kategori,0,1,'L');
            $bom = $this->db->query("SELECT kode_part, nama_part, Unit, Bom1 FROM pro_bom_lvl1 WHERE ID = $keyword AND Kategori = '$data->Kategori'")->result();

            foreach ($bom as $bom) {
            
                $cellWidth=75; //lebar sel
                $cellHeight=6; //tinggi sel satu baris normal
                
                //periksa apakah teksnya melibihi kolom?
                if($pdf->GetStringWidth($bom->nama_part) < $cellWidth){
                    //jika tidak, maka tidak melakukan apa-apa
                    $line=1;
                }else{
                    //jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
                    //dengan memisahkan teks agar sesuai dengan lebar sel
                    //lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
                    
                    $textLength=strlen($bom->nama_part);	//total panjang teks
                    $errMargin=6;		//margin kesalahan lebar sel, untuk jaga-jaga
                    $startChar=0;		//posisi awal karakter untuk setiap baris
                    $maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
                    $textArray=array();	//untuk menampung data untuk setiap baris
                    $tmpString="";		//untuk menampung teks untuk setiap baris (sementara)
                    
                    while($startChar < $textLength){ //perulangan sampai akhir teks
                        //perulangan sampai karakter maksimum tercapai
                        while( 
                        $pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
                        ($startChar+$maxChar) < $textLength ) {
                            $maxChar++;
                            $tmpString=substr($bom->nama_part,$startChar,$maxChar);
                        }
                        //pindahkan ke baris berikutnya
                        $startChar=$startChar+$maxChar;
                        //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
                        array_push($textArray,$tmpString);
                        //reset variabel penampung
                        $maxChar=0;
                        $tmpString='';
                        
                    }
                    //dapatkan jumlah baris
                    $line=count($textArray);
                }

            $pdf->SetFont('Arial','',10);
            $no++;
            $pdf->Cell(20,($line * $cellHeight),$bom->kode_part,1,0, 'C');
            $xPos=$pdf->GetX();
            $yPos=$pdf->GetY();
            $pdf->MultiCell($cellWidth,$cellHeight,$bom->nama_part,1,0);
            $pdf->SetXY($xPos + $cellWidth , $yPos);
            $pdf->Cell(15,($line * $cellHeight),$bom->Unit,1,0);
            $pdf->Cell(20,($line * $cellHeight),$bom->BOM1,1,0,'C');
            $pdf->Cell(20,($line * $cellHeight),'Aktif',1,0);
            $pdf->Cell(40,($line * $cellHeight),'',1,1);
            }
        }

        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(110,10,'* Data yang tampilkan menggunakan Nomenklatur yang berlaku di Warehouse',0,1,'L');
        $pdf->Cell(110,6,'',0,0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'Diinput',1,0,'C');
        $pdf->Cell(20,6,'Diperiksa',1,0,'C');
        $pdf->Cell(20,6,'Disetujui',1,0,'C');
        $pdf->Cell(20,6,'Disahkan',1,1,'C');
        $pdf->Cell(110,6,'',0,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,1,'C');
        $pdf->Cell(110,6,'',0,0,'C');
        $pdf->Cell(20,6,'IT',1,0,'C');
        $pdf->Cell(20,6,'RIK',1,0,'C');
        $pdf->Cell(20,6,'MMS',1,0,'C');
        $pdf->Cell(20,6,'Direktur O.',1,1,'C');

        $pdf->Output();
	}

    function struktur($keyword)
	{
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('L', 'mm','A4');
        $tanggal = date('j F Y h:i:s A');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,7,'Bill Of Component (BOC)',0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(0,6,'Dicetak Tanggal : '.$tanggal,0,1,'C');
        $pdf->SetFont('Arial','B',10);

        $series = $this->db->query("SELECT Series, Nama_Produk FROM pro_struktur_lvl1 WHERE ID = $keyword GROUP BY Series, Nama_Produk")->row();

        $pdf->Cell(20,6,'Series',0,0,'L');
        $pdf->Cell(5,6,':',0,0,'L');
        $pdf->Cell(85,6,$series->Series,0,1,'L');
        $pdf->Cell(20,6,'Produk',0,0,'L');
        $pdf->Cell(5,6,':',0,0,'L');
        $pdf->Cell(85,6,$series->Nama_Produk,0,1,'L');

        $no=0;

        //$bom = $this->db->get_where('pro_bom_lvl1',["ID"=>$keyword])->result();
        $bom_head = $this->db->query("SELECT Kode_Komp, Nama_Komp FROM pro_struktur_lvl1 WHERE ID = $keyword GROUP BY Kode_Komp, Nama_Komp")->result();

        foreach ($bom_head as $data){
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(0,6,'Struktur Level 1 : '.$data->Kode_Komp.' - '.$data->Nama_Komp,0,1,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,6,'Struktur Level 2 : ',0,1,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,6,'Pro ID',1,0,'C');
            $pdf->Cell(75,6,'Nama Barang',1,0,'C');
            $pdf->Cell(15,6,'Satuan',1,0,'C');
            $pdf->Cell(10,6,'Jml',1,0,'C');
            $pdf->Cell(30,6,'Kode Tahap',1,0,'C');
            $pdf->Cell(40,6,'Divisi Proses',1,0,'C');
            $pdf->Cell(80,6,'Deskripsi',1,1,'C');

            $bom = $this->db->query("SELECT Kode_Preparasi, nama_preparasi, Satuan, Jumlah, Nama_Divisi, Kode_Tahap, Deskripsi FROM pro_struktur_lvl2 WHERE ID_Bom_Komp = $data->Kode_Komp")->result();

            foreach ($bom as $bom) {
            
                $cellWidth=75; //lebar sel
                $cellHeight=6; //tinggi sel satu baris normal
                
                //periksa apakah teksnya melibihi kolom?
                if($pdf->GetStringWidth($bom->nama_preparasi) < $cellWidth){
                    //jika tidak, maka tidak melakukan apa-apa
                    $line=1;
                }else{
                    //jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
                    //dengan memisahkan teks agar sesuai dengan lebar sel
                    //lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
                    
                    $textLength=strlen($bom->nama_preparasi);	//total panjang teks
                    $errMargin=6;		//margin kesalahan lebar sel, untuk jaga-jaga
                    $startChar=0;		//posisi awal karakter untuk setiap baris
                    $maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
                    $textArray=array();	//untuk menampung data untuk setiap baris
                    $tmpString="";		//untuk menampung teks untuk setiap baris (sementara)
                    
                    while($startChar < $textLength){ //perulangan sampai akhir teks
                        //perulangan sampai karakter maksimum tercapai
                        while( 
                        $pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
                        ($startChar+$maxChar) < $textLength ) {
                            $maxChar++;
                            $tmpString=substr($bom->nama_preparasi,$startChar,$maxChar);
                        }
                        //pindahkan ke baris berikutnya
                        $startChar=$startChar+$maxChar;
                        //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
                        array_push($textArray,$tmpString);
                        //reset variabel penampung
                        $maxChar=0;
                        $tmpString='';
                        
                    }
                    //dapatkan jumlah baris
                    $line=count($textArray);
                }

            $pdf->SetFont('Arial','',10);
            $no++;
            $pdf->Cell(20,($line * $cellHeight),$bom->Kode_Preparasi,1,0, 'C');
            $xPos=$pdf->GetX();
            $yPos=$pdf->GetY();
            $pdf->MultiCell($cellWidth,$cellHeight,$bom->nama_preparasi,1,0);
            $pdf->SetXY($xPos + $cellWidth , $yPos);
            $pdf->Cell(15,($line * $cellHeight),$bom->Satuan,1,0);
            $pdf->Cell(10,($line * $cellHeight),$bom->Jumlah,1,0,'C');
            $pdf->Cell(30,($line * $cellHeight),$bom->Kode_Tahap,1,0,'C');
            $pdf->Cell(40,($line * $cellHeight),$bom->Nama_Divisi,1,0);
            $pdf->Cell(80,($line * $cellHeight),$bom->Deskripsi,1,1);
            }
        }

        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(190,10,'',0,1,'L');
        $pdf->Cell(190,6,'',0,0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'Diinput',1,0,'C');
        $pdf->Cell(20,6,'Diperiksa',1,0,'C');
        $pdf->Cell(20,6,'Disetujui',1,0,'C');
        $pdf->Cell(20,6,'Disahkan',1,1,'C');
        $pdf->Cell(190,6,'',0,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,1,'C');
        $pdf->Cell(190,6,'',0,0,'C');
        $pdf->Cell(20,6,'EDP',1,0,'C');
        $pdf->Cell(20,6,'RIK',1,0,'C');
        $pdf->Cell(20,6,'MMS',1,0,'C');
        $pdf->Cell(20,6,'GM',1,1,'C');

        $pdf->Output();
	}

    function struktur1($keyword)
	{
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('L', 'mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,7,'STRUKTUR PRODUK',0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $tanggal = date('j F Y h:i:s A');
        $pdf->Cell(0,6,'Dicetak Tanggal : '.$tanggal,0,1,'C');
        $pdf->SetFont('Arial','B',10);

        $series = $this->db->query("SELECT Series, Nama_Produk FROM pro_struktur_lvl1 WHERE ID = $keyword GROUP BY Series, Nama_Produk")->row();

        $pdf->Cell(20,6,'Series',0,0,'L');
        $pdf->Cell(5,6,':',0,0,'L');
        $pdf->Cell(85,6,$series->Series,0,1,'L');
        $pdf->Cell(20,6,'Produk',0,0,'L');
        $pdf->Cell(5,6,':',0,0,'L');
        $pdf->Cell(85,6,$series->Nama_Produk,0,1,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(0,5,'',0,1,'C');

        //$bom = $this->db->get_where('pro_bom_lvl1',["ID"=>$keyword])->result();
        $bom_head = $this->db->query("SELECT Kode_Komp, Nama_Komp FROM pro_struktur_lvl1 WHERE ID = $keyword GROUP BY Kode_Komp, Nama_Komp")->result();

        $no=0;
        
        foreach ($bom_head as $data){

            //$pdf->Cell(1,5,'Level 1 :',0,1,'C');
            $no++;
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(1,5,$no.'. ',0,0,'C');
            $pdf->Cell(0,5,$data->Nama_Komp.' ('.$data->Kode_Komp.')',0,1,'L');

            $bom = $this->db->query("SELECT Kode_Preparasi, nama_preparasi, Satuan, Jumlah, Nama_Divisi, Kode_Tahap, Deskripsi FROM pro_struktur_lvl2 WHERE ID_Bom_Komp = $data->Kode_Komp")->result();

            foreach ($bom as $bom) {

                $pdf->SetFont('Arial','B',8);
                //$pdf->Cell(0,5,'Level 2 :','L',1,'L');
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(0,5,$bom->Kode_Preparasi.' - '.$bom->nama_preparasi,'L',1,'L');

                $tahap = $this->db->query("SELECT GRUP, Nama_Proses, durasi_dtk, workstation, Nama_Divisi, TAHAP FROM pro_master_tahap WHERE GRUP = '$bom->Kode_Tahap'")->result();

                if (!empty($tahap)) {

                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(0,5,'Proses Produksi : ',0,1,'L');
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(15,5,'Urutan',1,0,'C');
                $pdf->Cell(75,5,'Nama Proses',1,0,'C');
                $pdf->Cell(25,5,'Durasi(Detik)',1,0,'C');
                $pdf->Cell(35,5,'Workstation',1,0,'C');
                $pdf->Cell(30,5,'Divisi Proses',1,0,'C');
                $pdf->Cell(80,5,'Keterangan',1,1,'C');


                    foreach ($tahap as $tahap) {
                    $pdf->SetFont('Arial','',8);
                    $pdf->Cell(5,5,' ','L',0,'L');
                    $pdf->Cell(5,5,' ','L',0,'L');
                    $pdf->Cell(15,5,$tahap->TAHAP,1,0, 'C');
                    $pdf->Cell(75,5,$tahap->Nama_Proses,1,0);
                    $pdf->Cell(25,5,$tahap->durasi_dtk,1,0,'C');
                    $pdf->Cell(35,5,$tahap->workstation,1,0);
                    $pdf->Cell(30,5,$tahap->Nama_Divisi,1,0);
                    $pdf->Cell(80,5,'',1,1,'C');
                    }
                }

                $bahan = $this->db->query("SELECT bom_material.ID AS ID, bom_material.Kode_Prep as Kode_Prep, bom_material.Kode_Material as Kode_Material, `inventory`.`Item Name` as Nama_Material, inventory.Unit as Satuan, bom_material.Jumlah as Ukuran, inventory.Measure as Measure FROM bom_material LEFT JOIN inventory ON bom_material.Kode_Material = inventory.ID WHERE bom_material.Kode_Prep = $bom->Kode_Preparasi AND bom_material.Status = 2")->result();

                if (!empty($bahan)) {

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(0,5,'Bahan Baku : ',0,1,'L');
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(5,5,' ','L',0,'L');
                $pdf->Cell(15,5,'Kode',1,0,'C');
                $pdf->Cell(125,5,'Nama Bahan Baku',1,0,'C');
                $pdf->Cell(25,5,'Satuan',1,0,'C');
                $pdf->Cell(25,5,'Ukuran(mm)',1,0,'C');
                $pdf->Cell(20,5,'Kebutuhan',1,0,'C');
                $pdf->Cell(25,5,'Jumlah Potong',1,0,'C');
                $pdf->Cell(25,5,'Sisa Potong(mm)',1,1,'C');


                    foreach ($bahan as $bahan) {

                    $pdf->SetFont('Arial','',8);
                    $pdf->Cell(5,5,' ','L',0,'L');
                    $pdf->Cell(5,5,' ','L',0,'L');
                    $pdf->Cell(15,5,$bahan->Kode_Material,1,0,'C');
                    $pdf->Cell(125,5,$bahan->Nama_Material,1,0,'L');
                    $pdf->Cell(25,5,$bahan->Satuan,1,0,'C');
                    $pdf->Cell(25,5,$bahan->Measure,1,0,'C');
                    $pdf->Cell(20,5,$bahan->Ukuran,1,0,'C');

                    $measure = $bahan->Measure;
                    $ukuran = $bahan->Ukuran;
                    $jumlah_pot = floor($measure/$ukuran);
                    $sisa = $measure - ($jumlah_pot * $ukuran) ;   

                    $pdf->Cell(25,5,$jumlah_pot,1,0,'C');
                    $pdf->Cell(25,5,$sisa,1,1,'C'); 

                    }
                }
            }

        }

        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(120,10,'',0,1,'L');
        $pdf->Cell(190,6,'',0,0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'Diinput',1,0,'C');
        $pdf->Cell(20,6,'Diperiksa',1,0,'C');
        $pdf->Cell(20,6,'Disetujui',1,0,'C');
        $pdf->Cell(20,6,'Disahkan',1,1,'C');
        $pdf->Cell(190,6,'',0,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,0,'C');
        $pdf->Cell(20,15,'',1,1,'C');
        $pdf->Cell(190,6,'',0,0,'C');
        $pdf->Cell(20,6,'EDP',1,0,'C');
        $pdf->Cell(20,6,'RIK',1,0,'C');
        $pdf->Cell(20,6,'MMS',1,0,'C');
        $pdf->Cell(20,6,'GM',1,1,'C');

        $pdf->Output();
	}

    function cetak_spk ()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('P', 'mm','A4');
        $pdf->AddPage();

        $spk_header = $this->db->query("SELECT divisi, date_format(tgl_spk,'%d-%b-%Y') as tgl_spk FROM pro_spk_produksi WHERE tgl_cetak is null GROUP BY divisi, date_format(tgl_spk,'%d-%b-%Y') ORDER BY Urutan, date_format(tgl_spk,'%d-%b-%Y')")->result();

            foreach ($spk_header as $head) {

            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(0,7,'SURAT PERINTAH KERJA',0,1,'C');
            $tanggal = date('j F Y h:i:s A');
            $pdf->SetFont('Arial','',8);

            $pdf->Cell(30,6,'Seksi Unit Kerja',1,0,'L');
            $pdf->Cell(60,6,$head->divisi,1,0,'L');
            $pdf->Cell(10,6,'',0,0,'L');
            $pdf->Cell(30,6,'Tanggal Cetak',1,0,'L');
            $pdf->Cell(60,6,$tanggal,1,1,'L');

            $pdf->Cell(30,6,'Tanggal SPK',1,0,'L');
            $pdf->Cell(60,6,$head->tgl_spk,1,1,'L');

            $pdf->Cell(0,6,'',0,1);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(25,6,'Nomor',1,0,'C');
            $pdf->Cell(50,6,'Uraian Pekerjaan',1,0,'C');
            $pdf->Cell(20,6,'WS',1,0,'C');
            $pdf->Cell(20,6,'Mesin',1,0,'C');
            $pdf->Cell(20,6,'Jumlah',1,0,'C');
            $pdf->Cell(20,6,'Est. Menit',1,0,'C');
            $pdf->Cell(20,6,'Tgl. Mulai',1,0,'C');
            $pdf->Cell(15,6,'Ket.',1,1,'C');

                $spk_sub = $this->db->query("SELECT concat(idplan,' - ',nama_produk) as plan FROM pro_spk_produksi WHERE tgl_cetak is null AND divisi = '$head->divisi' GROUP BY concat(idplan,' - ',nama_produk) ")->result();

                foreach ($spk_sub as $sub) {

                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(190,2,'',0,1,'C');
                    $pdf->Cell(190,6,$sub->plan,0,1,'L');

                        $spk_sub1 = $this->db->query("SELECT produk FROM pro_spk_produksi WHERE tgl_cetak is null AND divisi = '$head->divisi' AND idplan = '$sub->plan' GROUP BY produk")->result() ;

                        foreach ($spk_sub1 as $sub1) {
                        $pdf->Cell(190,6,$sub1->produk,0,1,'L');

                            $spk_detail = $this->db->query("SELECT barcode, idplan, concat(nama_proses,'-',produk) as pekerjaan, jumlah, tgl_spk, tgl_cetak, est_menit, divisi, WS FROM pro_spk_produksi WHERE tgl_cetak is null AND divisi = '$head->divisi' AND idplan = '$sub->plan' AND produk = '$sub1->produk' ORDER BY TAHAP ")->result();

                            foreach ($spk_detail as $detail) {
                            $pdf->SetFont('Arial','',8);
                            $pdf->Cell(25,6,$detail->barcode,1,0,'C');
                            $pdf->Cell(50,6,$detail->pekerjaan,1,0,'C');
                            $pdf->Cell(20,6,$detail->WS,1,0,'C');
                            $pdf->Cell(20,6,'',1,0,'L');
                            $pdf->Cell(20,6,$detail->jumlah,1,0,'C');
                            $pdf->Cell(20,6,$detail->est_menit,1,0,'C');
                            $pdf->Cell(20,6,$detail->tgl_spk,1,0,'C');
                            $pdf->Cell(15,6,'',1,1,'C');

                            }
                        
                        $pdf->SetFont('Arial','B',8);

                        }
                
                }
            
            $pdf->Cell(40,6,'Manager / Wakil Manager Produksi');
            
            }

        
        $pdf->Output();
    }

}