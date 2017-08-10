<?php 
class Po extends Controller
{
	function Po()
	{
		parent::Controller();
		$this->load->model('model_cara_pembayaran');
        $this->load->model('model_po');
        $this->load->model('model_barang');
        $this->load->model('model_jual');
        $this->load->model('model_stok');
		val_url();
	}
    
    function index($date="")
    {
		//$status = get_status_user();
		$generate_no_po = $this->model_po->generate_no_po();
		if($date=="")
			$date=date('Y-m-d');
			
		$mydata = array(
			'form'				=> 'inventory/po/delete_po',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> '',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_po_daftar"',
			'active_menus'		=> 'id="active_menus_po"',
			'page'			    => 'po_page',
			'menu'			    => 'po_daftar',
            'list_cara_bayar'   => $this->model_cara_pembayaran->select_cara_bayar(),
            'no_po'             => $generate_no_po,
            'data_detail'       => '',
            'date'       		=> $date,
			'list_barang'		=> $this->model_barang->summary_barang_po($date),
            'daftar_list_po'    => $this->model_po->daftar_list_po($date),
			'data_detail_po'	=> $this->data_detail_po_null('')
			//'user_status'		=> $status
		);
		
        $this->load->view('mainpage', $mydata);
    }
    
	function add_po()
	{
		$no_po 				= $this->input->post('no_po');
		$tglbaru 			= $this->input->post('tanggal_pesan');
		$tgl_po 			= explode_date($tglbaru, 0);
		$nama_customer 		= $this->input->post('nama_customer');
		$telepon 			= $this->input->post('telepon');
		$telepon_2 			= $this->input->post('telepon_2');
		$telepon_3 			= $this->input->post('telepon_3');
		$jumlah_bayar 		= $this->input->post('jumlah_bayar');
		$id_cara_pembayaran = $this->input->post('id_cara_pembayaran');
		$total_seluruh 		= $this->input->post('total_seluruh');
		$bayar_awal 		= $this->input->post('bayar_awal');
		if($bayar_awal != '')
		{
			if($id_cara_pembayaran!='0' and $jumlah_bayar>0)
				$cek_bayar = 1;
			else
				$cek_bayar = 0;
		}
		else
		{
			if($id_cara_pembayaran=='0' and $jumlah_bayar==0)
				$cek_bayar = 1;
			else
				$cek_bayar = 0;
		}
		
		$id_detail_po 		= $this->input->post('id_detail_po');
		$id_barang 			= $this->input->post('id_barang');
		$harga_satuan 		= $this->input->post('harga_satuan');
		$nama_barang 		= $this->input->post('nama_barang');
		$kuantum 			= $this->input->post('kuantum');
		$total_harga 		= $this->input->post('total_harga');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		foreach($id_barang as $result)
		{
			$data = array(
				'id_detail_po'	=> '',
				'no_po'			=> $no_po,
				'id_barang' 	=> $result,
				'stok_pesan' 	=> $kuantum[$no],
				'total_harga' 	=> $total_harga[$no]
			);
			
			if($result!='' or $kuantum[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($result!='' and $kuantum[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($nama_customer!="" and $sisa==0 and count($getrecord_detail2)>0 and $cek_bayar)
		{
			$hasil=1;
			
			if($bayar_awal!="")
			{
				$id_pembayaran = $this->model_po->generate_id_pembayaran();
				$data_input_bayar = array(
					'id_pembayaran'			=> $id_pembayaran,
					'tanggal_pembayaran'	=> $tgl_po,
					'id_po'    				=> $no_po,
					'id_penjualan'			=> '0',
					'id_cara_pembayaran'    => $id_cara_pembayaran,
					'jumlah_bayar'    		=> $jumlah_bayar
				);
				$this->model_po->add_po_bayar($data_input_bayar);
			}
			else
				$bayar_awal=0;
				
			$data_input = array(
				'no_po'                 => $no_po,
				'tanggal_po'            => $tgl_po,
				'nama_customer'         => $nama_customer,
				'telepon'         		=> $telepon,
				'telepon_2'         	=> $telepon_2,
				'telepon_3'         	=> $telepon_3,
				'jumlah_bayar'          => $total_seluruh,
				'bayar_awal'   			=> $bayar_awal,
				'id_cara_pembayaran'    => $id_cara_pembayaran
			);
			$this->model_po->add_po($data_input);
			$no=0;
			foreach($id_barang as $result)
			{
				$generate_no_po_detail = $this->model_po->generate_no_detail_po();
				$data = array(
					'id_detail_po'	=> $generate_no_po_detail,
					'no_po' 		=> $no_po,
					'id_barang' 	=> $result,
					'stok_pesan' 	=> $kuantum[$no],
					'total_harga' 	=> $total_harga[$no]
				);
				if($result!="")
					$this->model_po->add_po_detail($data);
				$no++;
			}
		}
		else
			$hasil=0;
		echo $hasil;
	}
	
	function view_po()
	{
		$tgl 	= $this->input->post('tgl');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		echo base_url().'index.php/inventory/po/index/'.$date;
	}
	
	function data_detail_po_null($data)
	{
		$data_field_detail = $this->model_po->get_detail_po($data)->result_array();
		
		return $data_field_detail;
	}
	
	function find_all_barang()
	{
		$data = $this->model_barang->view_all_barang();
		
		$mydata = array();
		foreach($data->result_array() as $row)
		{
			$mydata[] = $row;
		}
		
		echo json_encode($mydata);		
	}
	
    function data_field_null($data)
    {
        $data_field = array(
			'no_po'              => '',
			'tgl_po'             => '',
			'no_invoice'         => '',
			'total_po'           => '',
			'nama_karyawan'      => '',
			'id_cara_pembayaran' => '',
			'keterangan'         => '',
			'id_supplier'        => '',
			'nama_supplier'        => '',
            'status'             => $data
	    );
        
        return $data_field;
    }
	
	function find_po()
	{
		$no_po = $this->input->post('no_po');
		$getdata = array(
			'data'		=> $this->model_po->get_po($no_po)
		);
		
		foreach($getdata['data']->result_array() as $po)
		{
			$load_data = $po['no_po'].",".
						 explode_date($po['tanggal_po'],1).",".
						 $po['nama_customer'].",".
						 $po['telepon'].",".
						 currency_format($po['jumlah_bayar'],0).",".
						 $po['nama_cara_pembayaran'].",".
						 $po['telepon_2'].",".
						 $po['telepon_3'];
		}
		
		echo $load_data;
	}
	
	function find_po_detail()
	{
		$no_po = $this->input->post('no_po');
		$getdata = array(
			'data'		=> $this->model_po->get_detail_po($no_po)
		);
		
		$load_data='<tr><td class="labels_dbyr">Nama Barang</td><td class="labels_dbyr">Quantity</td><td class="labels_dbyr">Total Harga Barang</td></tr>';
		$jml_pesan = 0;
		foreach($getdata['data']->result_array() as $po)
		{
			$load_data .= '<tr><td class="labelss_dbyr">'.$po['nama_barang'].'</td><td class="labelss_dbyr">'.$po['stok_pesan'].'</td><td class="labelss_dbyr">'.currency_format($po['total_harga'],0).'</td></tr>';
			$jml_pesan = $jml_pesan + $po['stok_pesan'];
		}
		$load_data .= '<tr><td class="labelss_dbyr">Total Pemesanan</td><td class="labelss_dbyr">'.$jml_pesan.'</td>';
		
		echo $load_data;
	}
	
	function find_po2()
	{
		$no_po = $this->input->post('no_po');
		$getdata = array(
			'data'		=> $this->model_po->get_po2($no_po)
		);
		
		foreach($getdata['data'] as $po)
		{
			$load_data = $po['no_po'].",".
						 explode_date($po['tanggal_po'],1).",".
						 $po['nama_customer'].",".
						 $po['telepon'].",".
						 $po['telepon_2'].",".
						 $po['telepon_3'].",".
						 round($po['jumlah_bayar'],5).",".
						 $po['nama_cara_pembayaran'].",".
						 $po['id_cara_pembayaran'].",".
						 $po['count_pembayaran'].",".
						 $po['jum_pembayaran'].",".
						 $po['bayar_awal'];
		}
		
		echo $load_data;
	}
	
	function find_po_detail2()
	{
		$no_po = $this->input->post('no_po');
		$getdata = array(
			'data'		=> $this->model_po->get_detail_po($no_po)
		);
		
		$loop='';$no=0;$load_data='';
		foreach($getdata['data']->result_array() as $po)
		{
			if($no>0)
				$loop ='___';
			$load_data .= $loop.$po['id_detail_po'].",".
						 $po['no_po'].",".
						 $po['id_barang'].",".
						 $po['stok_pesan'].",".
						 round($po['total_harga'],5).",".
						 $po['nama_barang'].",".
						 $po['harga_barang'];
			$no++;
		}
		
		echo $load_data;
	}
    
	function edit_po()
	{
		$no_po 				= $this->input->post('no_po');
		$tglbaru 			= $this->input->post('tanggal_pesan');
		$tgl_po 			= explode_date($tglbaru, 0);
		$nama_customer 		= $this->input->post('nama_customer');
		$telepon 			= $this->input->post('telepon');
		$telepon_2 			= $this->input->post('telepon_2');
		$telepon_3 			= $this->input->post('telepon_3');
		$jumlah_bayar 		= $this->input->post('jumlah_bayar');
		$id_cara_pembayaran = $this->input->post('id_cara_pembayaran');
		$total_seluruh 		= $this->input->post('total_seluruh');
		$bayar_awal 		= $this->input->post('bayar_awal');
		if($bayar_awal != '')
		{
			if($id_cara_pembayaran!='0' and $jumlah_bayar>0)
			{
				$cek_bayar = 1;
			}
			else
			{
				$cek_bayar = 0;
			}
		}
		else
		{
			if($id_cara_pembayaran=='0' and $jumlah_bayar==0)
			{
				$cek_bayar = 1;
			}
			else
			{
				$cek_bayar = 0;
			}
		}
		
		$id_detail_po 		= $this->input->post('id_detail_po');
		$id_barang 			= $this->input->post('id_barang');
		$harga_satuan 		= $this->input->post('harga_satuan');
		$nama_barang 		= $this->input->post('nama_barang');
		$kuantum 			= $this->input->post('kuantum');
		$total_harga 		= $this->input->post('total_harga');
		
		$getrecord_detail 	= array();
		$getrecord_detail2 	= array();
		$no=0;
		foreach($id_barang as $result)
		{
			$data = array(
				'id_detail_po'	=> '',
				'id_barang'		=> $result,
				'stok_pesan' 	=> $kuantum[$no],
				'total_harga' 	=> $total_harga[$no]
			);
			
			if($result!='' or $kuantum[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($result!='' and $kuantum[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($nama_customer!="" and $sisa==0 and count($getrecord_detail2)>0 and $cek_bayar==1)
		{
			$hasil=1;
			$data_bayar = $this->model_po->select_pembayaran_awal($no_po);
			
			if($bayar_awal!="")
			{
				if($jumlah_bayar<=0)
					$id_cara_pembayaran=0;
				
				if(count($data_bayar)>0)
				{
					$data_input_bayar = array(
						'id_pembayaran'         => $data_bayar[0]['id_pembayaran'],
						'tanggal_pembayaran'   	=> $tgl_po,
						'id_cara_pembayaran'    => $id_cara_pembayaran,
						'jumlah_bayar'    		=> $jumlah_bayar
					);
					if($jumlah_bayar>0)
						$this->model_po->update_po_bayar($data_input_bayar);
					else
						$this->model_po->inactive_po_bayar($data_bayar[0]['id_pembayaran']);
				}
				else
				{
					$id_pembayaran = $this->model_po->generate_id_pembayaran();
					$data_input_bayar = array(
						'id_pembayaran'                 => $id_pembayaran,
						'tanggal_pembayaran'   			=> $tgl_po,
						'id_po'    						=> $no_po,
						'id_penjualan'   				=> '0',
						'id_cara_pembayaran'   	 		=> $id_cara_pembayaran,
						'jumlah_bayar'    				=> $jumlah_bayar
					);
					$this->model_po->add_po_bayar($data_input_bayar);
				}
			}
			else
			{
				$this->model_po->inactive_po_bayar($data_bayar[0]['id_pembayaran']);
				$id_cara_pembayaran=0;
				$bayar_awal=0;
			}
			
			if($id_cara_pembayaran==0 and $jumlah_bayar<=0)
				$bayar_awal=0;
			$data_input = array(
				'no_po'                 => $no_po,
				'tanggal_po'            => $tgl_po,
				'nama_customer'         => $nama_customer,
				'telepon'         		=> $telepon,
				'telepon_2'         	=> $telepon_2,
				'telepon_3'         	=> $telepon_3,
				'jumlah_bayar'          => $total_seluruh,
				'bayar_awal'   			=> $bayar_awal,
				'id_cara_pembayaran'    => $id_cara_pembayaran
			);
			$this->model_po->update_po($data_input);
			
			$this->model_po->delete_detail_po($no_po);
			$no=0;
			foreach($id_barang as $result)
			{
				$generate_no_po_detail = $this->model_po->generate_no_detail_po();
				$data = array(
					'id_detail_po'	=> $generate_no_po_detail,
					'no_po' 		=> $no_po,
					'id_barang' 	=> $result,
					'stok_pesan' 	=> $kuantum[$no],
					'total_harga' 	=> $total_harga[$no]
				);
				if($result!="")
					$this->model_po->add_po_detail($data);
				$no++;
			}
		}
		else
		{
			$hasil=0;
		}
		
		echo $hasil;
	}
	
	function delete_po()
	{
		$batal_list 	= $this->input->post('batal_list');
		$tgl 	= $this->input->post('tgl_po');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		
		if(isset($batal_list[0]))
		{
			foreach($batal_list as $data)
			{
				$this->model_po->inactive_po($data);
				$this->model_po->inactive_detail_po($data);
			}
		}
		
		redirect("".base_url().'index.php/inventory/po/index/'.$date."");
	}
	
	function addto_penjualan()
	{
		$no_po 					= $this->input->post('no_po');
		$tglbaru 				= $this->input->post('tanggal_pesan');
		$tgl_po 				= explode_date($tglbaru, 0);
		$nama_customer 			= $this->input->post('nama_customer');
		$telepon 				= $this->input->post('telepon');
		$total_seluruh 			= $this->input->post('total_seluruh');
		$sisa_bayar 			= $this->input->post('sisa_bayar');
		$jumlah_bayar 			= $this->input->post('jumlah_bayar');
		$id_cara_pembayaran		= $this->input->post('id_cara_pembayaran');
		$jumlah_bayar1 			= $this->input->post('jumlah_bayar1');
		$id_cara_pembayaran1	= $this->input->post('id_cara_pembayaran1');
		$jumlah_bayar2			= $this->input->post('jumlah_bayar2');
		$id_cara_pembayaran2 	= $this->input->post('id_cara_pembayaran2');
		$bayar_lunas			= $jumlah_bayar1 + $jumlah_bayar2;
		if($id_cara_pembayaran1 != '0' and $id_cara_pembayaran2 == '0')
		{
			if($jumlah_bayar1 == $sisa_bayar)
				$cek_lunas = 1;
			else
				$cek_lunas = 0;
		}
		elseif($id_cara_pembayaran1 != '0' and $id_cara_pembayaran2 != '0')
		{
			if($bayar_lunas == $sisa_bayar)
			{
				if($jumlah_bayar2 == 0 or $jumlah_bayar2 == '')
					$id_cara_pembayaran2 = 0;
				$cek_lunas = 1;
			}
			else
				$cek_lunas = 0;
		}
		else
			$cek_lunas = 0;
		
		if($sisa_bayar == 0)
		{
			$tamp_data = $this->model_po->detail_pembayaran($no_po);
			foreach($tamp_data as $row)
			{
				$jumlah_bayar1 = $row['jumlah_bayar'];
				$id_cara_pembayaran1 = $row['id_cara_pembayaran'];
				$cek_lunas = 1;
			}
		}
		
		if($jumlah_bayar1!="" and $id_cara_pembayaran1!="0" and $cek_lunas==1)
		{
			$return = 1;
			
			$id_penjualan = $this->model_jual->generate_no_jual($data);
			$tanggal_penjualan = date('Y-m-d');
			
			$data_input = array(
				'id_penjualan'			=> $id_penjualan,
				'tanggal_penjualan'		=> $tgl_po,
				'no_po'					=> $no_po,
				'id_cara_pembayaran_1'	=> $id_cara_pembayaran1,
				'jumlah_bayar_1'		=> $jumlah_bayar1,
				'id_cara_pembayaran_2'	=> $id_cara_pembayaran2,
				'jumlah_bayar_2'		=> $jumlah_bayar2,
				'active'				=> '1'
			);
			$this->model_jual->add_jual($data_input);
			
			$data = $this->model_po->get_detail_po($no_po)->result_array();
			
			foreach($data as $result)
			{
				$data_input_detail = array(
					'id_detail_penjualan'	=> $this->model_jual->generate_no_detail_jual(),
					'id_penjualan'			=> $id_penjualan,
					'id_barang'				=> $result['id_barang'],
					'kuantum'				=> $result['stok_pesan'],
					'total_harga'			=> $result['total_harga'],
					'active'				=> '1'
				);
				
				$this->model_jual->add_detail_jual($data_input_detail);
				
				$data_input_stok = array(
					'id_transaksi_stok'			=> $this->model_stok->generate_id_stok(),
					'id_penjualan'				=> $id_penjualan,
					'tanggal_transaksi_stok'	=> $tgl_po,
					'id_barang'					=> $result['id_barang'],
					'stok_keluar'				=> $result['stok_pesan'],
					'active'					=> '1'
				);
				
				$this->model_stok->add_transaksi_stok($data_input_stok);
			}
			
			$data_input_bayar = array(
				'id_pembayaran'			=> $this->model_po->generate_id_pembayaran(),
				'tanggal_pembayaran'	=> $tgl_po,
				'id_po'					=> $no_po,
				'id_penjualan'			=> $id_penjualan,
				'id_cara_pembayaran'	=> $id_cara_pembayaran1,
				'jumlah_bayar'			=> $jumlah_bayar1,
				'active'				=> '1'
			);
			if($sisa_bayar == 0)
			{
				$this->model_po->update_bayar_po($data_input_bayar);
			}
			else
			{
				$this->model_po->add_po_bayar($data_input_bayar);
			}
			
			if($jumlah_bayar2!="" and $id_cara_pembayaran2!="0")
			{
				$data_input_bayar = array(
					'id_pembayaran'			=> $this->model_po->generate_id_pembayaran(),
					'tanggal_pembayaran'	=> $tgl_po,
					'id_po'					=> $no_po,
					'id_penjualan'			=> $id_penjualan,
					'id_cara_pembayaran'	=> $id_cara_pembayaran2,
					'jumlah_bayar'			=> $jumlah_bayar2,
					'active'				=> '1'
				);
				$this->model_po->add_po_bayar($data_input_bayar);
			}
		}
		else
			$return = 0;
		echo $return;
	}
}
?>