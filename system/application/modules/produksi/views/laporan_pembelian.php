<?php
/**
 * Created by PhpStorm.
 * User: AcenetDev
 * Date: 1/7/2018
 * Time: 10:05 PM
 */
ini_set('memory_limit','32M');
class PDF extends FPDF
{
    function Header()
    {
//        // Logo
//        $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(130);
        // Title
        $this->Cell(30,10,'Laporan Pembelian',0,0,'C');
        $this->Ln(20);

    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function TransData($header,$data){
        foreach ($data as $key => $row){
            $pembelian = $row['pembelian'];
            $detail = $row['detail'];
            $this->SetTextColor(0);
            $this->SetDrawColor(0);
            $this->SetFont('Arial','',11);

            $this->Cell(35,7,'ID Pembelian','T',0,'L',false);
            $this->Cell(60,7,' : '.$pembelian->id_pembelian,'T',0,'L',false);
            $this->Cell(80,7,'Tanggal Pembelian','T',0,'R',false);
            $this->Cell(35,7,' : ' . $pembelian->tgl_pembelian,'T',1,'R',false);

            $this->Cell(35,7,'Cara Bayar',0,0,'L',false);
            $this->Cell(60,7,' : '.$pembelian->id_cara_pembayaran,0,0,'L',false);
            $this->Cell(80,7,'Jatuh Tempo',0,0,'R',false);
            $this->Cell(35,7,' : '.$pembelian->tgl_jatuh_tempo,0,1,'R',false);

//            $this->Cell(100,7,$pembelian->jumlah_bayar,0,0,'R',false);
//            $this->Cell(100,7,$pembelian->total_pembelian,0,1,'R',false);
            $this->FancyTable($header,$detail);
            $this->Ln(5);
            $this->Ln();

//            $w = array(40, 35, 40, 45, 45, 45);
//            for($i=0;$i<count($pembelian);$i++){
//                $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
//            }


        }
    }

    // Colored table
    function FancyTable($header, $data)
    {

        // Colors, line width and bold font
        $this->SetFillColor(128,128,128);
        $this->SetTextColor(255);
//        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont('','B');
//        // Header
        $w = array(80, 80, 30, 40, 40);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
//        // Color and font restoration
//        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
//        // Data
        $fill = false;
//        $stok_awal = 0;
//        $stok_terjual = 0;
//        $stok_free = 0;
        $total_qty = 0;
        $total_harga = 0;
        $this->SetFont('Arial','',11);
        foreach($data as $row)
        {
            $nama_bhn_baku   = $row->nama_bhn_baku;
            $nama_supplier   = $row->nama_supplier;
            $quantity        = $row->quantity;
            $harga_bhn_baku  = $row->harga_bhn_baku;
            $sub_total_harga = $row->total_harga;
            $total_qty +=$quantity;
            $total_harga  += $sub_total_harga;

//            $stok_awal += $row[1];
//            $stok_terjual += $row[2];
//            $stok_free+= $row[3];
//            $sisa_stok+= $row[4];
//            $total_harga+= $row[5];
//
            $this->Cell($w[0],6,$nama_bhn_baku,'LR',0,'L',$fill);
            $this->Cell($w[1],6,$nama_supplier,'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($quantity),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($harga_bhn_baku),'LR',0,'R',$fill);
            $this->Cell($w[4],6,number_format($sub_total_harga),'LR',0,'R',$fill);
//            $this->Cell($w[1],6,number_format($row[1]),'LR',0,'R',$fill);
//            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
//            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
//            $this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
//            $this->Cell($w[5],6,number_format($row[5]),'LR',0,'R',$fill);
            $this->Ln();
//            $fill = !$fill;
        }
        $fill = !$fill;
        $this->SetTextColor(255);
        $this->SetFont('Arial','B',12);
        $this->Cell($w[0]+$w[1],8,'TOTAL','LR',0,'C',$fill);
        $this->Cell($w[2],8,number_format($total_qty),'LR',0,'R',$fill);
        $this->Cell($w[3]+$w[4],8,number_format($total_harga),'LR',0,'R',$fill);
//        $this->Cell($w[2],6,number_format($stok_terjual),'LR',0,'R',$fill);
//        $this->Cell($w[3],6,number_format($stok_free),'LR',0,'R',$fill);
//        $this->Cell($w[4],6,number_format($sisa_stok),'LR',0,'R',$fill);
//        $this->Cell($w[5],6,number_format($total_harga),'LR',0,'R',$fill);
//        $this->Ln();
//        // Closing line
//        $this->Cell(array_sum($w),0,'','T');
    }
}

if($list){
    $data = [];
    foreach($list->result_array() as $row){

        $data[$row['id_pembelian']]['pembelian']= (object)$row;
        $detailBeli = $this->model_beli->view_pembelian_detail_spesifik($row['id_pembelian']);
        if($detailBeli){
            foreach ($detailBeli->result_array() as $rowDetail){
                $data[$row['id_pembelian']]['detail'][] = (object)$rowDetail;
            }
        }
    }
//    echo '<pre>';
    $header = array('Nama Barang','supplier','Qty','Harga','Sub Total');
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->TransData($header,$data);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetMargins(10,5,10);
    $pdf->Output();
//

//    echo '</pre>';
}