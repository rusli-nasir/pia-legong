<?php
/**
 * Created by PhpStorm.
 * User: AcenetDev
 * Date: 1/4/2018
 * Time: 5:54 PM
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
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Daftar Stok Bahan',0,0,'C');
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
        $w = array(50, 35, 40, 60);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {

            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,number_format($row[1]),'LR',0,'R',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
}

if(isset($list)){
    $header = array('Nama Bahan Baku','Jumlah Stok','Stok Minimum','Satuan');
    $counter=7;
    $i = 1;
    $data = array();

    foreach($list->result_array() as $row){
        if($row['sisa_stok']==NULL){
            $sisa_stok = 0;
        }else{
            $sisa_stok = round($row['sisa_stok']);
        }
        $data[] = array($row['nama_bhn_baku'],$sisa_stok,round($row['stok_minimum']), $row['nama_satuan']);
        $counter++;
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->FancyTable($header,$data);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetMargins(10,5,10);
    $pdf->Output();
}
