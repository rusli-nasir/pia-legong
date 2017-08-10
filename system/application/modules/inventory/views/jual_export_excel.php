<?php
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator($perusahaan['nama_perusahaan'])
							 ->setLastModifiedBy($perusahaan['nama_perusahaan'])
							 ->setTitle("DATA PENJUALAN")
							 ->setSubject("DATA PENJUALAN")
							 ->setDescription("DATA PENJUALAN - ".$perusahaan['nama_perusahaan'])
							 ->setKeywords("DATA PENJUALAN")
							 ->setCategory("DATA PENJUALAN");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('DATA PENJUALAN');

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
				->mergeCells('A1:E1')
				->setCellValue('A2', $perusahaan['lokasi'])
				->mergeCells('A2:E2')
				->mergeCells('A3:E3')
				->setCellValue('A4', 'DATA PENJUALAN')
				->mergeCells('A4:E4')
				->setCellValue('A5', 'Tanggal : '.$tanggal)
				->mergeCells('A5:E5')
            ->setCellValue('A6', 'No. Penjualan')
            ->setCellValue('B6', 'Nama Customer')
            ->setCellValue('C6', 'Nama Barang')
            ->setCellValue('D6', 'Quantity')
            ->setCellValue('E6', 'Total Harga');


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

$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray(
	array(
            'borders' => array(
			'top'		=> $style_border,
			'left'		=> $style_border,
			'bottom'	=> $style_border_none,
			'right'		=> $style_border
		)
	)
);


$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->applyFromArray(
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
$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFill()->applyFromArray(
         array(
             'type'       => PHPExcel_Style_Fill::FILL_SOLID,
             'startcolor' => array(
                 'rgb' => 'dfdfdf'
             )
         )
 );

$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->applyFromArray(
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

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(30);


if(isset($list_detail_jual))
{
	$counter=7; 
	$i = 1;
	foreach($list_detail_jual->result_array() as $jual_detail)
	{
                $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':E'.$counter)->applyFromArray(
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
		$objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'right')));
		$objPHPExcel->getActiveSheet()->getStyle('E'.$counter)->applyFromArray(array('borders'=>array('right'=>$style_border),'alignment'=>array('horizontal'=>'right')));
		
		$id_penjualan = $jual_detail['id_penjualan'];
		if(isset($tamp_id_penjualan)){
			if($tamp_id_penjualan==$jual_detail['id_penjualan']){
				$id_penjualan = '';
			}
		}
		$objPHPExcel->getActiveSheet()
                    ->setCellValue('A'.$counter, $id_penjualan)
                    ->setCellValue('B'.$counter, $jual_detail['nama_customer'])
                    ->setCellValue('C'.$counter, $jual_detail['nama_barang'])
                    ->setCellValue('D'.$counter, $jual_detail['jumlah_stok'])
                    ->setCellValue('E'.$counter, $jual_detail['total_harga']);
                    //->setCellValue('E'.$counter, currency_format($jual_detail['total_harga'],0));
        
		
		$objPHPExcel->getActiveSheet()->getRowDimension($counter)->setRowHeight(15);

		$counter++;
		$tamp_id_penjualan = $jual_detail['id_penjualan'];
	}

        //last row bottom border
        $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':E'.$counter)->applyFromArray(array('borders'=>array('top'=>$style_border)));
}

// Redirect output to a client's web browser (Excel5)
$tanggal = str_replace('/','-',$tanggal);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Data_Penjualan_'.$tanggal.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>