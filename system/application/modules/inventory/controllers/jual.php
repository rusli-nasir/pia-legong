<?php 
class Jual extends Controller
{
	function Jual()
	{
		parent::Controller();
		$this->load->model('model_cara_pembayaran');
		$this->load->model('model_jual');
		$this->load->model('model_barang');
		$this->load->model('model_stok');
		$this->load->model('model_po');
		val_url();
	}
    
    function index($date="")
    {
		$generate_id_penjualan = $this->model_jual->generate_no_jual();
		if($date=="")
			$date = date('d/m/Y');
		else
			$date = explode_date($date,1);
			
		$mydata = array(
			'form'				=> 'inventory/jual/delete_jual',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> '',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_jual_form"',
			'active_menus'		=> 'id="active_menus_penjualan"',
			'tab'           	=> 'akses_jual/jual_form',
			'page'				=> 'jual_page',
			'menu'				=> 'jual_form',
			'cara_bayar'		=> $this->model_cara_pembayaran->select_cara_bayar(),	//'',			
			'id_penjualan'		=> $generate_id_penjualan,
			'date'       		=> $date,
			'daftar_list_jual'	=> '',
			'data_detail'       => '',
			'data_detail_jual'	=> '',
			'data_bayar'       	=> '',
			'data_bayar_detail'	=> '',
			'list_barang'		=> $this->model_barang->view_all_barang_pertanggal($date),
			'list_detail_jual'	=> $this->model_jual->view_list_penjualan($date),
			'list_barang_jual'	=> $this->model_barang->summary_barang_jual($date)
			//'id_penjualan'		=> $generate_id_penjualan,
			//'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$mydata);
    }
	
	function export_to_excel($date=""){
		//$this->load->library('excel');
		if($date=="") $date = date('d/m/Y');
		else $date = explode_date($date,1);

		$data['list_barang']		= $this->model_barang->view_all_barang_pertanggal($date);
		$data['list_detail_jual']	= $this->model_jual->view_list_penjualan($date);
		$data['list_barang_jual']	= $this->model_barang->summary_barang_jual($date);

		$data['tanggal'] = $date;
		$data['perusahaan']['nama_perusahaan'] = 'PIA LEGONG';
		$data['perusahaan']['lokasi'] = 'Lokasi PIA LEGONG';
		//var_dump($data['list_detail_jual']->result_array());die();
		
		//---------------------------- EXCEL START
		$this->load->library('excel');
		$this->load->view('inventory/jual_export_excel', $data);
	}
    
	function view_jual()
	{
		$tgl 	= $this->input->post('tgl');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		echo base_url().'index.php/inventory/jual/index/'.$date;
	}
	
	function stok_awal()
	{
		$id_barang	= $this->input->post('id_barang');
		$jmlh_stok	= $this->input->post('jml_stok');
		$status		= $this->input->post('status');
		$tgl_stok	= $this->input->post('tanggal');
		$tgl_stok	= explode_date($tgl_stok, 0);
		$text		= $this->input->post('string');
		
		if($status == 0)
		{
			$data = array(
				'id_stok'	=> $this->model_stok->generate_id_stok_awal(),
				'tgl_stok'	=> $tgl_stok,
				'id_barang'	=> $id_barang,
				'jmlh_stok'	=> $jmlh_stok
			);
			$this->model_stok->add_stok_awal($data);
		}
		else
		{
			$data = array(
				'tgl_stok'	=> $tgl_stok,
				'id_barang'	=> $id_barang,
				'jmlh_stok'	=> $jmlh_stok
			);
			$this->model_stok->update_stok_awal($data);
		}
		
		echo $text;
	}

    /**
     * @param $ambil_data
     */
	function akses_jual($ambil_data)
	{
		$this->index();
	}
	
	function add_jual()
	{
		$id_penjualan		= $this->input->post('id_penjualan');
		$tglbaru			= $this->input->post('tgl_penjualan');
		$tanggal_penjualan 	= explode_date($tglbaru, 0);
		$id_cara_bayar_1	= $this->input->post('id_cara_pembayaran_1');
		$jumlah_bayar_1		= $this->input->post('jumlah_bayar_1');
		$id_cara_bayar_2	= $this->input->post('id_cara_pembayaran_2');
		$jumlah_bayar_2		= $this->input->post('jumlah_bayar_2');
		$total_seluruh		= $this->input->post('total_seluruh');
		$bayar_lunas		= $jumlah_bayar_1 + $jumlah_bayar_2;
		if($id_cara_bayar_1 != '0' and $id_cara_bayar_2 == '0')
		{
			if($id_cara_bayar_1 == 'CRBY2011030000002')
				$cek_lunas = 1;
			else if($jumlah_bayar_1 == $total_seluruh)
				$cek_lunas = 1;
			else
				$cek_lunas = 0;
		}
		elseif($id_cara_bayar_1 != '0' and $id_cara_bayar_2 != '0')
		{
			if($id_cara_bayar_1 == 'CRBY2011030000002')
				$cek_lunas = 1;
			else if($bayar_lunas == $total_seluruh)
			{
				if($jumlah_bayar_2 == 0 or $jumlah_bayar_2 == '')
					$id_cara_bayar_2 = 0;
				$cek_lunas = 1;
			}
			else
				$cek_lunas = 0;
		}
		else
			$cek_lunas = 0;		
		
		$data_input = array(
			'id_penjualan'			=> $id_penjualan,
			'tanggal_penjualan'		=> $tanggal_penjualan,
			'no_po'					=> '0',
			'id_cara_pembayaran_1'	=> $id_cara_bayar_1,
			'jumlah_bayar_1'		=> $jumlah_bayar_1,
			'id_cara_pembayaran_2'	=> $id_cara_bayar_2,
			'jumlah_bayar_2'		=> $jumlah_bayar_2,
			'active'				=> '1'
		);
		
		//============== Insert Untuk Detail Penjualan ==============
		$id_penjualan			= $id_penjualan;
		$id_barang				= $this->input->post('id_barang');
		$kuantum				= $this->input->post('kuantum');
		$total_harga			= $this->input->post('total_harga');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		$nama_barang 	= $this->input->post('nama_barang');
		foreach($id_barang as $result)
		{
			$data = array(
				'id_detail_penjualan'	=> '',
				'id_penjualan'			=> '',
				'id_barang'				=> $result,
				'kuantum'				=> $kuantum[$no],
				'total_harga' 			=> $total_harga[$no],
				'active' 				=> ''
			);
			
			if($kuantum[$no]!='' or $total_harga[$no]!='' or $nama_barang[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($kuantum[$no]!='' and $total_harga[$no]!='' and $nama_barang[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($sisa==0 and count($getrecord_detail2)>0 and $cek_lunas==1)
		{
			$hasil = 1;
			$this->model_jual->add_jual($data_input);
			
			//============== Insert Untuk Detail Penjualan ==============
			$contarr	= 0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				$data_input_detail = array(
					'id_detail_penjualan'	=> $this->model_jual->generate_no_detail_jual(),
					'id_penjualan'			=> $id_penjualan,
					'id_barang'				=> $id_barang[$contarr],
					'kuantum'				=> $kuantum[$contarr],
					'total_harga'			=> $total_harga[$contarr],
					'active'				=> '1'
				);
				
				$this->model_jual->add_detail_jual($data_input_detail);
				$contarr++;
			}
			
			//============== Insert Untuk Stok ==============
			$contarr=0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				
				$data_input_stok = array(
					'id_transaksi_stok'			=> $this->model_stok->generate_id_stok(),
					'id_penjualan'				=> $id_penjualan,
					'tanggal_transaksi_stok'	=> $tanggal_penjualan,
					'id_barang'					=> $data_id_barang,
					'stok_keluar'				=> $kuantum[$contarr],
					'active'					=> '1'
				);
				
				$this->model_stok->add_transaksi_stok($data_input_stok);
				$contarr++;
			}
			
			//============== Insert Untuk Pembayaran ==============
			if($id_cara_bayar_1!='0')
			{
				$data_input_bayar = array(
					'id_pembayaran'			=> $this->model_po->generate_id_pembayaran(),
					'tanggal_pembayaran'	=> $tanggal_penjualan,
					'id_po'					=> 0,
					'id_penjualan'			=> $id_penjualan,
					'id_cara_pembayaran'	=> $id_cara_bayar_1,
					'jumlah_bayar'			=> $jumlah_bayar_1,
					'active'				=> '1'
				);
				$this->model_po->add_po_bayar($data_input_bayar);
			}
			if($id_cara_bayar_2!='0')
			{
				$data_input_bayar = array(
					'id_pembayaran'			=> $this->model_po->generate_id_pembayaran(),
					'tanggal_pembayaran'	=> $tanggal_penjualan,
					'id_po'					=> 0,
					'id_penjualan'			=> $id_penjualan,
					'id_cara_pembayaran'	=> $id_cara_bayar_2,
					'jumlah_bayar'			=> $jumlah_bayar_2,
					'active'				=> '1'
				);
				$this->model_po->add_po_bayar($data_input_bayar);
			}
		}
		else
			$hasil = 0;
		echo $hasil;
	}
	
	function update_jual()
	{
		$id_penjualan 		= $this->input->post('id_penjualan');
		$tanggal_penjualan	= $this->input->post('tgl_penjualan');
		$cara_pembayaran_1	= $this->input->post('id_cara_pembayaran_1');
		$cara_pembayaran_2	= $this->input->post('id_cara_pembayaran_2');
		$jumlah_bayar_1		= $this->input->post('jumlah_bayar_1');
		$jumlah_bayar_2		= $this->input->post('jumlah_bayar_2');
		$total_seluruh		= $this->input->post('total_seluruh');
		$jml_dp				= $this->input->post('jumlah_dp');
		
		$bayar_lunas		= $jumlah_bayar_1 + $jumlah_bayar_2 + $jml_dp;
		if($cara_pembayaran_1 != '0' and $cara_pembayaran_2 == '0')
		{
			if($id_cara_bayar_1 == 'CRBY2011030000002')
				$cek_lunas = 1;
			else if($jumlah_bayar_1 == $total_seluruh)
			{
				$cek_lunas = 1;
			}
			else
			{
				$cek_lunas = 0;
			}
		}
		elseif($cara_pembayaran_1 != '0' and $cara_pembayaran_2 != '0')
		{
			if($id_cara_bayar_1 == 'CRBY2011030000002')
				$cek_lunas = 1;
			else if($bayar_lunas == $total_seluruh)
			{
				if($jumlah_bayar_2 == 0 or $jumlah_bayar_2 == '')
					$cara_pembayaran_2 = 0;
				$cek_lunas = 1;
			}
			else
				$cek_lunas = 0;
		}
		else
		{
			$cek_lunas = 0;
		}
		
		$tamp_data = $this->model_jual->select_penjualan($id_penjualan);
		$no_po = $tamp_data[0]['no_po'];
		
		$data_input = array(
			'id_penjualan'			=> $id_penjualan,
			'tanggal_penjualan'		=> $tanggal_penjualan,
			'no_po'					=> $no_po,
			'id_cara_pembayaran_1'	=> $cara_pembayaran_1,
			'jumlah_bayar_1'		=> $jumlah_bayar_1,
			'id_cara_pembayaran_2'	=> $cara_pembayaran_2,
			'jumlah_bayar_2'		=> $jumlah_bayar_2,
			'active'				=> '1'
		);
		
		//============== Insert Untuk Detail Penjualan ==============
		$id_penjualan			= $id_penjualan;
		$id_detail_penjualan	= $this->input->post('id_penjualan_detail');
		$id_barang				= $this->input->post('id_barang');
		$kuantum				= $this->input->post('kuantum');
		$total_harga			= $this->input->post('total_harga');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		$nama_barang 	= $this->input->post('nama_barang');
		foreach($id_barang as $result)
		{
			$data = array(
				'id_detail_penjualan'	=> '',
				'id_penjualan'			=> '',
				'id_barang'				=> $result,
				'kuantum'				=> $kuantum[$no],
				'total_harga' 			=> $total_harga[$no],
				'active' 				=> ''
			);
			
			if($kuantum[$no]!='' or $total_harga[$no]!='' or $nama_barang[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($kuantum[$no]!='' and $total_harga[$no]!='' and $nama_barang[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($sisa==0 and count($getrecord_detail2)>0 and $bayar_lunas==$total_seluruh and $cek_lunas==1)
		{
			$hasil = 1;
			$this->model_jual->update_jual($data_input);
			
			//============== Insert Untuk Detail Penjualan ==============
			$id_penjualan 		= $this->input->post('id_penjualan');
			$this->model_jual->del_detail_jual($id_penjualan);
			
			$contarr	= 0;
			foreach($id_barang as $data_id_barang)
			{
				$act=1;
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				
				if($kuantum[$contarr]==0 && $total_harga[$contarr]==0)
				{
					$act=0;	
				}
				$data_input_detail = array(
					'id_detail_penjualan'	=> $this->model_jual->generate_no_detail_jual(),
					'id_penjualan'			=> $id_penjualan,
					'id_barang'				=> $id_barang[$contarr],
					'kuantum'				=> $kuantum[$contarr],
					'total_harga'			=> $total_harga[$contarr],
					'active'				=> $act
				);
				
				$this->model_jual->add_detail_jual($data_input_detail);
				$contarr++;
			}
			
			//============== Insert Untuk Stok ==============
			$id_penjualan 		= $this->input->post('id_penjualan');
			$this->model_stok->delete_stok_jual($id_penjualan);
			
			$contarr=0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				
				$data_input_stok = array(
					'id_transaksi_stok'			=> $this->model_stok->generate_id_stok(),
					'id_penjualan'				=> $id_penjualan,
					'tanggal_transaksi_stok'	=> $tanggal_penjualan,
					'id_barang'					=> $data_id_barang,
					'stok_keluar'				=> $kuantum[$contarr],
					'active'					=> '1'
				);
				
				$this->model_stok->add_transaksi_stok($data_input_stok);
				$contarr++;
			}
			
			//============== Insert Untuk Pembayaran ==============
			$id_penjualan 		= $this->input->post('id_penjualan');
			$this->model_jual->del_bayar_jual($id_penjualan);
			
			if($cara_pembayaran_1!='0')
			{
				$data_input_bayar = array(
					'id_pembayaran'			=> $this->model_po->generate_id_pembayaran(),
					'tanggal_pembayaran'	=> $tanggal_penjualan,
					'id_po'					=> $no_po,
					'id_penjualan'			=> $id_penjualan,
					'id_cara_pembayaran'	=> $cara_pembayaran_1,
					'jumlah_bayar'			=> $jumlah_bayar_1,
					'active'				=> '1'
				);
				$this->model_po->add_po_bayar($data_input_bayar);
			}
			if($cara_pembayaran_2!='0')
			{
				$data_input_bayar = array(
					'id_pembayaran'			=> $this->model_po->generate_id_pembayaran(),
					'tanggal_pembayaran'	=> $tanggal_penjualan,
					'id_po'					=> $no_po,
					'id_penjualan'			=> $id_penjualan,
					'id_cara_pembayaran'	=> $cara_pembayaran_2,
					'jumlah_bayar'			=> $jumlah_bayar_2,
					'active'				=> '1'
				);
				$this->model_po->add_po_bayar($data_input_bayar);
			}
		}
		else
		{
			$hasil = 0;
		}
		echo $hasil;
	}
	
	function delete_jual()
	{
		$id_penjualan	= $this->input->post('batal_list');
		$tamp_tgl		= $this->input->post('tanggal_penjualan');
		$tgl_penjualan	= explode_date($tamp_tgl, 0);
		
		if($id_penjualan != '')
		{
			foreach($id_penjualan as $id_delete)
			{
				//================== Untuk Delete Penjualan ==================
				$this->model_jual->delete_jual($id_delete);
				
				//================== Untuk Delete Detail Penjualan ==================
				$this->model_jual->delete_detail_jual($id_delete);
				
				//================== Untuk Delete Stock ==================
				$this->model_stok->delete_transaksi_stok($id_delete);
				
				//================== Untuk Delete Pembayaran ==================
				$this->model_jual->delete_bayar_jual($id_delete);
			}
		}
		
		$this->index($tgl_penjualan);
	}
	
	function data_field_null($data)
    {
        $data_field = array(
			'id_penjualan'			=> '',
			'no_po'					=> '',
			'no_surat_jalan'		=> '',
			'tanggal_penjualan'		=> '',
			'tgl_jatuh_tempo'		=> '',
			'id_customer'			=> '',
			'id_cara_pembayaran'	=> '',
			'keterangan'			=> '',
			'id_karyawan'			=> '',
			'ppn'					=> '',
			'biaya_kirim'			=> '',
			'biaya_lain'			=> '',
			'total_harga'			=> '',
			'dp'					=> '',
			'status'             	=> $data
	    );
        
        return $data_field;
    }
	
	function data_detail_jual_null($data)
	{
		$data_field_detail = $this->model_jual->get_detail_jual($data);
		
		return $data_field_detail;
	}
	
	function find_jual()
	{
		$id_penjualan = $this->input->post('id_penjualan');
		//$getdata = $this->model_jual->get_jual($id_penjualan);
		$getdata = $this->model_jual->get_jual1($id_penjualan);
		
		foreach($getdata->result_array() as $jual)
		{
			$load_data = $jual['id_penjualan'].",".
						 $jual['tanggal_penjualan'].",".
						 $jual['id_cara_pembayaran_1'].",".
						 $jual['jumlah_bayar_1'].",".
						 $jual['id_cara_pembayaran_2'].",".
						 $jual['jumlah_bayar_2'].",".
						 $jual['no_po'].",".
						 $jual['dp'];
		}
		
		echo $load_data;
	}
	
	function find_jual_detail()
	{
		$id_penjualan = $this->input->post('id_penjualan');
		$getdata = array('data' => $this->model_jual->get_detail_jual($id_penjualan));
		
		$loop='';$no=0;$load_data='';
		$total_keseluruhan = 0;
		foreach($getdata['data']->result_array() as $jual)
		{
			$total_keseluruhan = $total_keseluruhan + $jual['total_harga'];
			
			if($no>0)
				$loop ='___';
			$load_data .= $loop.$jual['id_detail_penjualan'].",".
						 $jual['id_penjualan'].",".
						 $jual['id_barang'].",".
						 $jual['jumlah_stok'].",".
						 round($jual['total_harga'],5).",".
						 $jual['nama_barang'].",".
						 $jual['harga_barang'].",".
						 $total_keseluruhan;
			$no++;
		}
		
		echo $load_data;
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
	
	function data_detail_bayar_null($data)
	{
		$data_field_detail_bayar = $this->model_jual->get_detail_bayar($data);
		
		return $data_field_detail_bayar;
	}
    
    function max_kuantum()
    {
		$id_kuantum 	= $this->input->post('id_kuantum_');
		$id_barang 		= $this->input->post('id_barang_');
		$tgltransaksi	= $this->input->post('tgl_transaksi');
		$tgl_transaksi	= explode_date($tgltransaksi, 0);
		$data 			= array('id_barang' => $id_barang, 'tgl_transaksi' => $tgl_transaksi);
		$jumlah_stok 	= $this->model_stok->get_stok_barang($data);
		
		if($id_kuantum > $jumlah_stok)
		{
			echo ''.round($jumlah_stok).'_Kuantum melebihi Stok ('.round($jumlah_stok).')';
		}
		else
		{
			echo '';
		}
    }
}
?>