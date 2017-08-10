<?php 
	class PDF extends FPDF
	{
		//Page header
	}
	global $tanggal, $nama, $telepon1, $telepon2, $telepon3, $jml_byr;
	
	foreach($data_po->result_array() as $po)
	{
		$tanggal = explode_date($po['tanggal_po'], 1);
		$nama = $po['nama_customer'];
		$telepon1 = $po['telepon'];
		$telepon2 = $po['telepon_2'];
		$telepon3 = $po['telepon_3'];
		$jml_byr = $po['jumlah_bayar'];
	}
	
	$pdf = new PDF('P', 'mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false);
	$pdf->SetMargins(10,5,20);
	//$pdf->content_body();
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(57,5,'',0,0,'L');
	$pdf->Cell(10,5,'Tgl',0,0,'L');
	$pdf->Cell(2,5,':',0,0,'L');
	$pdf->Cell(25,5,$tanggal,0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(57,5,'',0,0,'L');
	$pdf->Cell(10,5,'Nama',0,0,'L');
	$pdf->Cell(2,5,':',0,0,'L');
	if(strlen($nama) > 14){
		$nama1 = substr($nama, 0, 13);
		$nama2 = substr($nama, 13, strlen($nama));
		$pdf->Cell(25,5,$nama1,0,0,'L');
		
		if(strlen(substr($nama, 13, strlen($nama))) > 14){
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(57,5,'',0,0,'L');
			$pdf->Cell(10,5,'',0,0,'L');
			$pdf->Cell(40,5,$nama2,0,0,'L');
		}
		else{
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(57,5,'',0,0,'L');
			$pdf->Cell(10,5,'',0,0,'L');
			$pdf->Cell(2,5,'',0,0,'L');
			$pdf->Cell(25,5,$nama2,0,0,'L');
		}
	}
	else
		$pdf->Cell(25,5,$nama,0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(57,5,'',0,0,'L');
	$pdf->Cell(10,5,'Tlp',0,0,'L');
	$pdf->Cell(2,5,':',0,0,'L');
	$pdf->Cell(25,5,$telepon1,0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(57,5,'',0,0,'L');
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(25,5,$telepon2,0,0,'L');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(57,5,'',0,0,'L');
	$pdf->Cell(10,5,'',0,0,'L');
	$pdf->Cell(2,5,'',0,0,'L');
	$pdf->Cell(25,5,$telepon3,0,0,'L');
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,4,'','LTR',0,'C');
	$pdf->Cell(25,4,'Jml Barang','LTR',0,'C');
	$pdf->Cell(20,4,'Harga','LTR',0,'C');
	$pdf->Cell(25,4,'Total Harga','LTR',0,'C');
	
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,4,'Nama Barang','LR',0,'C');
	$pdf->Cell(25,4,'(dos)','LR',0,'C');
	$pdf->Cell(20,4,'(IDR)','LR',0,'C');
	$pdf->Cell(25,4,'(IDR)','LR',0,'C');
	
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,4,'','LBR',0,'C');
	$pdf->Cell(25,4,'1 dos @ 8 bj','LBR',0,'C');
	$pdf->Cell(20,4,'','LBR',0,'C');
	$pdf->Cell(25,4,'','LBR',0,'C');
	
	$tot_brg = 0;
	foreach($data_po_detail->result_array() as $po_detail)
	{
		if($po_detail['nama_barang'] == 'k')
			$jenis = 'Keju';
		elseif($po_detail['nama_barang'] == 'kh')
			$jenis = 'Kacang Hijau';
		elseif($po_detail['nama_barang'] == 'c')
			$jenis = 'Coklat';
		elseif($po_detail['nama_barang'] == 'cp'){
			$jenis = 'Campur';
			$jenis_detail = '(Keju + Coklat)';
		}
		
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,4,$jenis,'LR',0,'L');
		$pdf->Cell(25,4,$po_detail['stok_pesan'],'LR',0,'C');
		$pdf->Cell(20,4,number_format($po_detail['harga_barang'],0,'','.'),'LR',0,'C');
		$pdf->Cell(25,4,number_format($po_detail['total_harga'],0,'','.'),'LR',0,'C');
		
		if($po_detail['nama_barang'] == 'cp'){
			$pdf->Ln(4);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(25,4,$jenis_detail,'LR',0,'L');
			$pdf->Cell(25,4,'','LR',0,'C');
			$pdf->Cell(20,4,'','LR',0,'C');
			$pdf->Cell(25,4,'','LR',0,'C');
		}
		$tot_brg = $tot_brg + $po_detail['stok_pesan'];
	}
	
	$pdf->Ln(4);
	$pdf->Cell(25,4,'Jumlah Barang:','LT',0,'L');
	$pdf->Cell(25,4,$tot_brg,'TR',0,'C');
	$pdf->Cell(45,4,'Jumlah Harga(IDR):','LTR',0,'C');
	
	$pdf->Ln(4);
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(50,6,'','LBR',0,'L');
	$pdf->Cell(45,6,number_format($jml_byr,0,'','.'),'LBR',0,'C');

	$pdf->Ln(6);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(95,4,'Keterangan :','LTR',0,'L');

	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(95,4,'','LBR',0,'L');

	$pdf->Ln(8);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'Barang yang sudah dibeli','LTR',0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'tidak dapat','LR',0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'ditukar / dikembalikan','LBR',0,'C');
	$pdf->Cell(5,5,'',0,0,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(50,5,'Hormat Kami',0,0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'NPWP 31.381.299.2-905.000',0,0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'( CV LEGONG BERKARYA )',0,0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'BYPASS NG. RAI, LING PESALAKAN',0,0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'TUBAN - KUTA, BADUNG',0,0,'C');
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(35,5,'',0,0,'C');
	
	$pdf->Output();
?>