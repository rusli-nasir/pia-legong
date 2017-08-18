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
		$email 		= $this->input->post('email');

		$nama_penerima 		= $this->input->post('nama_penerima');
		$via_pemesanan 		= $this->input->post('via_pemesanan');
		$tgl_pemesanan 		= $this->input->post('tgl_pemesanan');
		$tanggal_pesan 		= explode_date($tgl_pemesanan, 0);
		
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
				'id_cara_pembayaran'    => $id_cara_pembayaran,	
				'tanggal_pesan'			=> $tanggal_pesan,			
				'nama_penerima'    		=> $nama_penerima,
				'via_pemesanan'    		=> $via_pemesanan,
				'email'    		=> $email
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
			$data = array(
				'hasil'	=> $hasil,
				'no_po'	=> $no_po
			);
		}
		else{
			$hasil=0;
			$data = array(
				'hasil'	=> $hasil,
				'no_po'	=> ''
			);
		}
		echo json_encode($data);
	}

	function report_nota($no_po)
	{
		$this->load->library('fpdf');
		
		$data = array(
			'data_po'			=> $this->model_po->get_po($no_po),
			'data_po_detail'	=> $this->model_po->get_detail_po($no_po)
		);
		
		$this->load->view("print_nota",$data);
	}

	function detail_po($date="", $filter = "")
	{
		//$status = get_status_user();
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
			'menu'			    => 'po_detail',
			'list_cara_bayar'   => $this->model_cara_pembayaran->select_cara_bayar(),
//			'no_po'             => $generate_no_po,
			'data_detail'       => '',
			'date'       		=> $date,
			'filter'       		=> $filter,
			'list_barang'		=> $this->model_barang->summary_barang_po($date),
			'daftar_list_po'    => $this->model_po->daftar_list_po_harian(array(
				'tanggal' => $date,
				'via' => $filter,
			)),
			'data_detail_po'	=> $this->data_detail_po_null('')
			//'user_status'		=> $status
		);

		$this->load->view('mainpage', $mydata);
	}

	function pengambilan_po($date="", $filter = "transaksi"){
		//$status = get_status_user();
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
			'menu'			    => 'po_pengambilan',
//			'list_cara_bayar'   => $this->model_cara_pembayaran->select_cara_bayar(),
//			'no_po'             => $generate_no_po,
			'data_detail'       => '',
			'date'       		=> $date,
			'filter'       		=> $filter,
//			'list_barang'		=> $this->model_barang->summary_barang_po($date),
			'daftar_list_po'    => $this->model_po->daftar_list_po_pengambilan(array(
				'tanggal' => $date,
				'filter' => $filter,
			)),
//			'data_detail_po'	=> $this->data_detail_po_null('')
			//'user_status'		=> $status
		);

		$this->load->view('mainpage', $mydata);
    }

    function batal_pengambilan($no_po){
	    $this->load->library('user_agent');
	    $data_input = array(
		    'no_po'         => $no_po,
	    );
	    $this->model_po->batal_pengambilan($data_input);

	    redirect($_SERVER['HTTP_REFERER']);
    }

    function verifikasi_pengambilan($no_po){
//	    $no_po 				= $this->input->post('no_po');
	    $data_input = array(
		    'no_po'         => $no_po,
		    'is_diambil'    => 1,
		    'tgl_ambil'     => date('Y-m-d h:i:s'),
	    );
	    $update = $this->model_po->verifikasi_pengambilan($data_input);
	    if($update){

	        $imgvalid = '<img src="'.base_url().'image/check.jpg'.'" width="30" />';
		    $data_input['status'] = true;
		    $data_input['img_valid'] = $imgvalid;
		    echo json_encode($data_input);
	    }else{
		    $data_input['status'] = false;
		    echo json_encode($data_input);
        }

    }
	
	function view_po()
	{
		$tgl 	= $this->input->post('tgl');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		echo base_url().'index.php/inventory/po/index/'.$date;
	}

	function view_detail_pemesanan()
	{
		$tgl 	= $this->input->post('tanggal');
		$filter 	= $this->input->post('filter');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		echo base_url().'index.php/inventory/po/detail_po/'.$date . '/' .$filter;
	}

	function view_pesanan_harian()
	{
		$tgl 	= $this->input->post('tanggal');
		$filter 	= $this->input->post('filter');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		echo base_url().'index.php/inventory/po/pengambilan_po/'.$date . '/' .$filter;
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
						 $po['telepon_3'] . ",".
						 $po['email'] . ",".
                         (($po['tgl_diambil'])? explode_date($po['tgl_diambil'],1):'') . ",".
						 $po['is_diambil'] . ","
            ;
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
						 $po['bayar_awal'].",".
						 $po['nama_penerima'].",".
						 $po['via_pemesanan'];
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
				
		$nama_penerima 		= $this->input->post('nama_penerima');
		$via_pemesanan 		= $this->input->post('via_pemesanan');
		$tgl_pemesanan 		= $this->input->post('tgl_pemesanan');
		$tanggal_pesan 		= explode_date($tgl_pemesanan, 0);
		
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
				if(count($data_bayar)>0)
				{
					$this->model_po->inactive_po_bayar($data_bayar[0]['id_pembayaran']);
					$id_cara_pembayaran=0;
					$bayar_awal=0;
				}
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
				'id_cara_pembayaran'    => $id_cara_pembayaran,
				'tanggal_pesan'			=> $tanggal_pesan,
				'nama_penerima'			=> $nama_penerima,
				'via_pemesanan'			=> $via_pemesanan
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
			$data_json = array(
				'hasil'	=> $hasil,
				'no_po'	=> $no_po
			);
		}
		else
		{
			$hasil=0;
			$data_json = array(
				'hasil'	=> $hasil,
				'no_po'	=> ''
			);
		}
		
		echo json_encode($data_json);
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
	
	function print_selected(){
		$list_po = $this->input->post('list');
		$arr_po = explode(',', $list_po);
		$ret = '<div>';
		$ret .= '<style type="text/css">
					@media print {
						.page-break { display: block; page-break-before: always; }
					}
					body {
						font-family:Arial;
					}
				</style>';
		foreach($arr_po as $idx=>$no_po){
			$data_po		= $this->model_po->get_po($no_po);
			$data_po_detail	= $this->model_po->get_detail_po($no_po);
			//$ret .= ' '.$no_po; die();
			foreach($data_po->result_array() as $po)
			{
				$tanggal = explode_date($po['tanggal_po'], 1);
				$nama = $po['nama_customer'];
				$telepon1 = $po['telepon'];
				$telepon2 = $po['telepon_2'];
				$telepon3 = $po['telepon_3'];
				$jml_byr = $po['jumlah_bayar'];
			}
			
			$ret  .= '<table>';
				$ret  .= '<tr>
							<td width="250"></td>
							<td>Tgl</td>
							<td>:</td>
							<td>'.$tanggal.'</td>
						</tr>
							<td></td>
							<td>Nama</td>
							<td>:</td>
							<td style="letter-spacing:3px;">'.strtoupper($nama).'</td>
						</tr>
							<td></td>
							<td>Tlpn</td>
							<td>:</td>
							<td style="letter-spacing:3px;">'.$telepon1.'</td>
						</tr>
							<td></td>
							<td></td>
							<td></td>
							<td style="letter-spacing:3px;">'.$telepon2.'</td>
						</tr>
							<td></td>
							<td></td>
							<td></td>
							<td style="letter-spacing:3px;">'.$telepon3.'</td>
						</tr>';
			$ret  .= '</table>';
			
			$ret .= '<table border="1" style="background:#000;">';
				$ret .= '<tr style="background:#fff;">
							<td style="text-align:center; font-weight:bold; width:170px;">Nama Barang</td>
							<td style="text-align:center; font-weight:bold; width:120px;">Jml Barang<br /> (dos)<br /> 1 dos @ 8 bj</td>
							<td style="text-align:center; font-weight:bold; width:120px;">Harga<br /> (IDR)</td>
							<td style="text-align:center; font-weight:bold; width:120px;">Total Harga<br /> (IDR)</td>
						</tr>';
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
						//$jenis = 'Campur';
						//$jenis_detail = '(Keju + Coklat)';
						$jenis = 'Campur (Keju + Coklat)';
					}
					
					$ret .= '<tr  style="background:#fff;">
								<td>'.$jenis.'</td>
								<td style="text-align:center;">'.$po_detail['stok_pesan'].'</td>
								<td style="text-align:right;">'.number_format($po_detail['harga_barang'],0,'','.').'</td>
								<td style="text-align:right;">'.number_format($po_detail['total_harga'],0,'','.').'</td>
							</tr>';
										
					$tot_brg = $tot_brg + $po_detail['stok_pesan'];
				}
				$ret .= '<tr  style="background:#fff;">
							<td colspan="2" style="text-align:center;">
								Jumlah Barang : <br />
								'.$tot_brg.'
							</td>
							<td colspan="2" style="text-align:center;">
								Jumlah Harga (IDR) :<br /> 
								'.number_format($jml_byr,0,'','.').'
							</td>
						</tr>';
						
				
				$ret .= '<tr  style="background:#fff;">
							<td colspan="4">
								Keterangan
							</td>
						</tr>';
			
			$ret .= '</table>';		
			
			$ret  .= '<table>';
				$ret  .= '<tr>
							<td style="padding-left:50px; font-size:11px; text-align:center;">
								<div style="border:1px solid #000; width:100px;">
									Barang yang sudah dibeli tidak dapat ditukar / dikembalikan
								</div>
							</td>
							<td style="padding-left:100px;">Hormat Kami</td>
						</tr>';
				$ret  .= '<tr>
							<td conlspan="2" style="font-size:12px; text-align:center;">
								NPWP 31.381.299.2-905.000 <br />
								( CV LEGONG BERKARYA ) <br />
								BYPASS NG. RAI, LING PESALAKAN <br />
								TUBAN - KUTA, BADUNG <br />
							</td>
							<td></td>
						</tr>';
			$ret  .= '</table>';
			
			$ret .= '<div class="page-break"></div>';
		}
		$ret .= '</div>';
		echo $ret;
	}

	function print_pemesanan_harian(){
		$tanggal = $this->input->post('tanggal');
		$via = $this->input->post('via');
		$ar_tgl = explode('/',$tanggal);
		$tanggal 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];

		$data_po = $this->model_po->daftar_list_po_harian(array(
			'tanggal' => $tanggal,
			'via' => $via,
		));
		if($data_po){
			?>
            <center>
                <h1>Laporan Daftar Transaksi Pesanan Harian</h1>
                <h3>Tanggal <?php echo date('d-m-Y' , strtotime($tanggal))?></h3>
            </center>
            <br><br>
			<div>
				<style type="text/css">
					@page {
						size: A4;
						margin: 25mm 15mm 15mm 15mm;
					}
					@media print {
						.page-break { display: block; page-break-before: always; }
						html, body {
							width: 210mm;
							height: 297mm;
						}
						.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc; width: 100%}
						.tg td{font-family:Arial, sans-serif;font-size:10pt;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
                        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
						.tg .header-label{font-weight:bold;background-color:#efefef;color:#000000;text-align:center;vertical-align:top}
						.tg .text-right {text-align:right;vertical-align:middle}
						.tg .text-left{background-color:#f9f9f9;vertical-align:middle}
						.tg .tg-right-odd{background-color:#f9f9f9;text-align:right;vertical-align:middle}
						.no-print, .no-print *
						{
							display: none !important;
						}
					}

					.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc; width: 100%}
					.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
					.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
					.tg .header-label{font-weight:bold;background-color:#efefef;color:#000000;text-align:center;vertical-align:top}
					.tg .text-right {text-align:right;vertical-align:middle}
					.tg .text-left{background-color:#f9f9f9;vertical-align:middle}
					.tg .tg-right-odd{background-color:#f9f9f9;text-align:right;vertical-align:middle}

					.cetak{ background-color: #4CAF50; /* Green */
						border: none;
						color: white;
						padding: 15px 32px;
						text-align: center;
						text-decoration: none;
						display: inline-block;
						font-size: 16px;
						margin-bottom: 10px;
					}
					body {
						font-family:Arial;
					}
				</style>
				<button type="button" class="cetak no-print" onclick="window.print()">Cetak</button>
				<table class="tg">
					<thead>
					<tr>
						<th class="header-label">No</th>
						<th class="header-label">Tgl Pesan</th>
						<th class="header-label">Nama Customer</th>
						<th class="header-label">Phone</th>
						<th class="header-label">Email</th>
						<th class="header-label">Total Transaksi</th>
						<th class="header-label">Tanggal Diambil</th>
						<th class="header-label">Keterangan</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						$totalTransaksi = 0;
						foreach ($data_po as $row){
							?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php
									$tmp = explode_date($row->tanggal_pesan, 1);
									$arr_date = explode('/', $tmp);
									$tgl_pesan = $arr_date[0].'-'.$arr_date[1];
									if($tgl_pesan=='00-00'){
										$tgl_pesan = '';
									}
									echo $tgl_pesan;
                                    ?></td>
								<td><?php echo $row->nama_customer?></td>
								<td><?php echo $row->telepon?></td>
								<td><?php echo $row->email?></td>
								<td style="text-align: right"><?php echo number_format($row->jumlah_bayar,2,',','.')?></td>
								<td><?php echo ($row->is_diambil)? date('d-m-Y h:i:s',strtotime($row->tgl_diambil)):'Belum Diambil'?></td>
								<td><?php echo get_jenis_pesanan($row->via_pemesanan)?></td>
							</tr>
							<?php
							$totalTransaksi +=$row->jumlah_bayar;
							$i ++;
						}
						?>
					</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total</td>
                            <td colspan="6" style="text-align: center; font-weight: bold"><?php echo number_format($totalTransaksi,2,',','.')?></td>
                        </tr>
                    </tfoot>
				</table>
			</div>
			<?php
		}

	}

	function print_pengambilan_pemesanan_harian(){
		$tanggal = $this->input->post('tanggal');
		$filter = $this->input->post('filter');
		$ar_tgl = explode('/',$tanggal);
		$tanggal 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];

		$data_po = $this->model_po->daftar_list_po_pengambilan(array(
			'tanggal' => $tanggal,
			'filter' => $filter,
		));
		if($data_po){
			?>
            <center>
                <h1>Laporan Daftar Pengambilan Pesanan Harian</h1>
                <h3>Tanggal <?php echo date('d-m-Y' , strtotime($tanggal))?></h3>
            </center>
            <br><br>
            <div>
                <style type="text/css">
                    @page {
                        size: A4;
                        margin: 25mm 15mm 15mm 15mm;
                    }
                    @media print {
                        .page-break { display: block; page-break-before: always; }
                        html, body {
                            width: 210mm;
                            height: 297mm;
                        }
                        .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc; width: 100%}
                        .tg td{font-family:Arial, sans-serif;font-size:10pt;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
                        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
                        .tg .header-label{font-weight:bold;background-color:#efefef;color:#000000;text-align:center;vertical-align:top}
                        .tg .text-right {text-align:right;vertical-align:middle}
                        .tg .text-left{background-color:#f9f9f9;vertical-align:middle}
                        .tg .tg-right-odd{background-color:#f9f9f9;text-align:right;vertical-align:middle}
                        .no-print, .no-print *
                        {
                            display: none !important;
                        }
                    }

                    .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc; width: 100%}
                    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
                    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
                    .tg .header-label{font-weight:bold;background-color:#efefef;color:#000000;text-align:center;vertical-align:top}
                    .tg .text-right {text-align:right;vertical-align:middle}
                    .tg .text-left{background-color:#f9f9f9;vertical-align:middle}
                    .tg .tg-right-odd{background-color:#f9f9f9;text-align:right;vertical-align:middle}

                    .cetak{ background-color: #4CAF50; /* Green */
                        border: none;
                        color: white;
                        padding: 15px 32px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 16px;
                        margin-bottom: 10px;
                    }
                    body {
                        font-family:Arial;
                    }
                </style>
                <button type="button" class="cetak no-print" onclick="window.print()">Cetak</button>
                <table class="tg">
                    <thead>
                    <tr>
                        <th class="header-label">No</th>
                        <th class="header-label">Tgl Pesan</th>
                        <th class="header-label">Nama Customer</th>
                        <th class="header-label">Phone</th>
                        <th class="header-label">Email</th>
                        <th class="header-label">Total Transaksi</th>
                        <th class="header-label">Tanggal Diambil</th>
                        <th class="header-label">Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					$i=1;
					$totalTransaksi = 0;
					foreach ($data_po as $row){
						?>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php
								$tmp = explode_date($row->tanggal_pesan, 1);
								$arr_date = explode('/', $tmp);
								$tgl_pesan = $arr_date[0].'-'.$arr_date[1];
								if($tgl_pesan=='00-00'){
									$tgl_pesan = '';
								}
								echo $tgl_pesan;
								?></td>
                            <td><?php echo $row->nama_customer?></td>
                            <td><?php echo $row->telepon?></td>
                            <td><?php echo $row->email?></td>
                            <td style="text-align: right"><?php echo number_format($row->jumlah_bayar,2,',','.')?></td>
                            <td><?php echo ($row->is_diambil)? date('d-m-Y h:i:s',strtotime($row->tgl_diambil)):'Belum Diambil'?></td>
                            <td><?php echo get_jenis_pesanan($row->via_pemesanan)?></td>
                        </tr>
						<?php
						$totalTransaksi +=$row->jumlah_bayar;
						$i ++;
					}
					?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">Total</td>
                        <td colspan="6" style="text-align: center; font-weight: bold"><?php echo number_format($totalTransaksi,2,',','.')?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
			<?php
		}

	}

}
?>