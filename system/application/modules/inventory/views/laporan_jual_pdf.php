<?php

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
        $this->Cell(100);
        // Title
        $this->Cell(30,10,'Summary Penjualan Stok',0,0,'C');
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

    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(128,128,128);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont('','B');
        // Header
        $w = array(40, 35, 40, 45, 45, 45);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        $stok_awal = 0;
        $stok_terjual = 0;
        $stok_free = 0;
        $sisa_stok = 0;
        $total_harga = 0;
        foreach($data as $row)
        {
            $stok_awal += $row[1];
            $stok_terjual += $row[2];
            $stok_free+= $row[3];
            $sisa_stok+= $row[4];
            $total_harga+= $row[5];

            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,number_format($row[1]),'LR',0,'R',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
            $this->Cell($w[5],6,number_format($row[5]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->SetFont('Arial','B',14);
        $this->Cell($w[0],6,'TOTAL','LR',0,'C',$fill);
        $this->Cell($w[1],6,number_format($stok_awal),'LR',0,'R',$fill);
        $this->Cell($w[2],6,number_format($stok_terjual),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($stok_free),'LR',0,'R',$fill);
        $this->Cell($w[4],6,number_format($sisa_stok),'LR',0,'R',$fill);
        $this->Cell($w[5],6,number_format($total_harga),'LR',0,'R',$fill);
        $this->Ln();
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
}
if(isset($list_barang)){
    $header = array('Nama Barang','Stok Hari Ini','Stok Terjual','Stok Free','Sisa Stok','Total Harga');
    $counter=7;
    $i = 1;
    $data = array();
    foreach ($list_barang->result_array() as $barang){
        $stok_awal = $barang['stok_awal'];
        if($stok_awal=='') $stok_awal = 0;
        $stok_terjual = $barang['stok_terjual'];
        if($stok_terjual=='') $stok_terjual = 0;
        $stok_free = $barang['stok_free'];
        if($stok_free=='') $stok_free = 0;
        $sisa_stok = $barang['stok_awal'] - $barang['stok_terjual'] - $barang['stok_free'];
        $total_harga = $barang['harga_barang'] * $barang['stok_terjual'];

        $data[] = array($barang['nama_barang'],$stok_awal,$stok_terjual,$stok_free,$sisa_stok,$total_harga);
        $counter++;
    }
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->FancyTable($header,$data);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetMargins(10,5,10);
    $pdf->Output();
}

?>