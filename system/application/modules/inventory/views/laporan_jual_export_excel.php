<?php
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator($perusahaan['nama_perusahaan'])
							 ->setLastModifiedBy($perusahaan['nama_perusahaan'])
							 ->setTitle("LAPORAN PENJUALAN")
							 ->setSubject("LAPORAN PENJUALAN")
							 ->setDescription("LAPORAN PENJUALAN - ".$perusahaan['nama_perusahaan'])
							 ->setKeywords("LAPORAN PENJUALAN")
							 ->setCategory("LAPORAN PENJUALAN");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('LAPORAN PENJUALAN');

$style_border = array(
	'style' => PHPExcel_Style_Border::BORDER_THIN,
	'color' => array('rgb' => '000000')
);

$style_border_none = array(
	'style' => PHPExcel_Style_Border::BORDER_NONE
);

// Add some data
$objPHPExcel->getActiveSheet()
				->setCellValue('A1', $perusahaan['nama_perusahaan'])
				->mergeCells('A1:G1')
				->setCellValue('A2', $perusahaan['lokasi'])
				->mergeCells('A2:G2')
				->mergeCells('A3:G3')
				->setCellValue('A4', 'LAPORAN PENJUALAN')
				->mergeCells('A4:G4')
				->setCellValue('A5', 'Tanggal : '.$tanggal)
				->mergeCells('A5:G5')
            ->setCellValue('A6', 'ID Barang')
            ->setCellValue('B6', 'Nama Barang')
            ->setCellValue('C6', 'Stok Hari Ini')
            ->setCellValue('D6', 'Stok Terjual')
            ->setCellValue('E6', 'Stok Free')
            ->setCellValue('F6', 'Sisa Stok')
            ->setCellValue('G6', 'Total Harga');


// Set font,Alignment Company Name
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
	array(
		'font'    => array(
                    'name'	=> 'Arial',
                    'size'	=> 16,
                    'bold'	=> true,
                    'color'	=> array(
							'rgb'   => '000000'
                    )
		),
                'alignment' => array(
							'horizontal'=> 'left'
		)
	)
);

$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(array('font'=>array('size'=>10)));

$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);


//Set Fill + set Border + alignment Title Header Table
$objPHPExcel->getActiveSheet()->getStyle('A4:A5')->getFill()->applyFromArray(
         array(
             'type'       => PHPExcel_Style_Fill::FILL_SOLID,
             'startcolor' => array(
                 'rgb' => '367bce'
             )
         )
 );

$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->applyFromArray(
	array(
            'borders' => array(
			'top'		=> $style_border,
			'left'		=> $style_border,
			'bottom'	=> $style_border_none,
			'right'		=> $style_border
		)
	)
);


$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray(
	array(
            'borders' => array(
			'top'		=> $style_border_none,
			'left'		=> $style_border,
			'bottom'	=> $style_border,
			'right'		=> $style_border
		)
	)
);

$objPHPExcel->getActiveSheet()->getStyle('A4:A5')->applyFromArray(array('alignment'=>array('horizontal'=>'center','vertical'=>'center'),'font'=>array('bold'=> true)));

$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);



//Set Fill + Font, Alignment + border Column Title Header Table
$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFill()->applyFromArray(
         array(
             'type'       => PHPExcel_Style_Fill::FILL_SOLID,
             'startcolor' => array(
                 'rgb' => 'dfdfdf'
             )
         )
 );

$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray(
	array(
		'font'    => array(
			'name'      => 'Arial',
			'size'		=> 10,
			'bold'      => true
		),
		'alignment' => array(
			'horizontal'	=> 'center'
		)
	)
);

$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray(array('borders' => array('right'	=> $style_border)));
$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray(array('borders' => array('right'	=> $style_border)));
$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray(array('borders' => array('right'	=> $style_border)));
$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray(array('borders' => array('right'	=> $style_border)));
$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray(array('borders' => array('right'	=> $style_border)));
$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray(array('borders' => array('right'	=> $style_border)));
$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray(array('borders' => array('right'	=> $style_border)));

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(20);


if(isset($list_barang))
{
	$counter=7; 
	$i = 1;
	foreach($list_barang->result_array() as $barang)
	{
                $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->applyFromArray(
                        array(
                                'font'    => array(
                                        'name'      => 'Arial',
                                        'size'		=> 10
                                ),
                                'borders' => array(
                                        'left'	=> $style_border,
                                        'right'	=> $style_border
                                )
                        )
                );

		$objPHPExcel->getActiveSheet()->getStyle('A'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'center')));
		$objPHPExcel->getActiveSheet()->getStyle('B'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'left')));
		$objPHPExcel->getActiveSheet()->getStyle('C'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'center')));
		$objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'center')));
		$objPHPExcel->getActiveSheet()->getStyle('E'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'center')));
		$objPHPExcel->getActiveSheet()->getStyle('F'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'center')));
		$objPHPExcel->getActiveSheet()->getStyle('G'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'right')));
		
		$stok_awal = $barang['stok_awal'];
			if($stok_awal=='') $stok_awal = 0;
		$stok_terjual = $barang['stok_terjual'];
			if($stok_terjual=='') $stok_terjual = 0;
		$stok_free = $barang['stok_free'];
			if($stok_free=='') $stok_free = 0;
		$sisa_stok = $barang['stok_awal'] - $barang['stok_terjual'] - $barang['stok_free'];
		$total_harga = $barang['harga_barang'] * $barang['stok_terjual'];
		$objPHPExcel->getActiveSheet()
                    ->setCellValue('A'.$counter, $barang['id_barang'])
                    ->setCellValue('B'.$counter, $barang['nama_barang'])
                    ->setCellValue('C'.$counter, $stok_awal)
                    ->setCellValue('D'.$counter, $stok_terjual)
                    ->setCellValue('E'.$counter, $stok_free)
                    ->setCellValue('F'.$counter, $sisa_stok)
                    ->setCellValue('G'.$counter, $total_harga);
                    //->setCellValue('G'.$counter, currency_format($total_harga,0));
        
		
		$objPHPExcel->getActiveSheet()->getRowDimension($counter)->setRowHeight(15);

		$counter++;
	}

        //last row bottom border
        $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->applyFromArray(array('borders'=>array('top'=>$style_border)));
}

// Redirect output to a client's web browser (Excel5)
$tanggal = str_replace('/','-',$tanggal);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan_Penjualan_'.$tanggal.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>