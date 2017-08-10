<?php
class Stok extends Controller
{
	function Stok()
	{
		parent::Controller();
		$this->load->model('model_stok');
		val_url();
	}
	
    function index()
    {
		$status = get_status_user();
		
		$mydata = array(
			'form'				=> 'inventory/stok/add_stok',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_stok_daftar"',
			'active_menus'		=> 'id="active_menus_stok"',
			'page'				=> 'stok_page',
			'menu'				=> 'daftar_stok',
			'daftar_list_stok'	=> $this->model_stok->daftar_list_stok(),
			'data_stok'		    => $this->data_field_stock('', ''),
			'data_detail_stok'	=> $this->model_stok->get_stok_detail(''),
			'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$mydata);
    }
    
	function akses_stok($ambil_data)
	{
		if($ambil_data == 'stok_daftar')
		{
			$form	= 'inventory/stok/add_stok';
			$simpan = 'class="disable" disabled="disabled"';
			$edit	= 'class="disable" disabled="disabled"';
			$batal	= 'class="disable" disabled="disabled"';
			$cetak	= 'class="disable" disabled="disabled"';
		}
		elseif($ambil_data == 'stok_detail')
		{
			$form	= 'inventory/stok/add_stok';
			$simpan = 'class="disable" disabled="disabled"';
			$edit	= 'class="disable" disabled="disabled"';
			$batal	= 'class="disable" disabled="disabled"';
			$cetak	= 'class="disable" disabled="disabled"';
		}
		
		$status = get_status_user();
		$mydata = array(
			'form'				=> $form,
			'simpan'			=> $simpan,
			'edit'				=> $edit,
			'batal'				=> $batal,
			'cetak'				=> $cetak,
			'active_menu'		=> 'class="active_'.$ambil_data.'"',
			'active_menus'		=> 'id="active_menus_stok"',
			'page'				=> 'stok_page',
			'menu'				=> $ambil_data,
			'daftar_list_stok'	=> $this->model_stok->daftar_list_stok(),
			'data_stok'		    => $this->data_field_stock('', ''),
			'data_detail_stok'	=> $this->model_stok->get_stok_detail(''),
			'user_status'		=> $status
		);
        $this->load->view('mainpage',$mydata);
	}
	
	function index_stok_detail($data_id_barang)
	{
		$status = get_status_user();
		$batal = 'class="disable" disabled="disabled"';
		/*if($status[10]['status']==2)
		{
			$batal = '';
		}*/
			
		$mydata = array(
			'form'				=> 'inventory/stok/add_stok',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> $batal,
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menus'		=> 'id="active_menus_stok"',
			'page'			    => 'stok_page',
			'menu'			    => 'stok_detail',
			'data_stok'		    => $this->data_field_stock($data_id_barang, 'add_stok'),
			'data_detail_stok'	=> $this->model_stok->get_stok_detail($data_id_barang),
			'user_status'		=> $status
		);
        $this->load->view('mainpage', $mydata);
	}
	
	function add_stok()
	{
		$id_barang 			= $this->input->post('id_barang');
		$tglbaru 			= $this->input->post('tanggal_transaksi');
		$tanggal_transaksi 	= explode_date($tglbaru, 0);
		$total_stok_masuk = $this->input->post('total_stok_masuk');
		$total_stok_keluar = $this->input->post('total_stok_keluar');
		
		if($this->input->post('simpan') and ($total_stok_masuk!='' or $total_stok_keluar!=''))
		{
			$id_stok 	= $this->model_stok->generate_id_stok();
			$data_input = array(
					'id_stok'			=> $id_stok,
					'id_barang'			=> $id_barang,
					'tanggal_transaksi'	=> $tanggal_transaksi,
					'stok_masuk'		=> $total_stok_masuk,
					'stok_keluar'		=> $total_stok_keluar,
					'id_penjualan'		=> 0,
					'id_pembelian'		=> 0,
					'keterangan'		=> $this->input->post('keterangan_stok'),
					'active'			=> '1'
			);
			$this->model_stok->add_stok($data_input);
		}
		else
		{
			$id_stok = $this->input->post('batal_stok');
			if($id_stok!='')
			{
				foreach($id_stok as $id_delete)
				{
					$data_delete = array( 
						'id_stok'	=> $id_delete
					);
					$this->model_stok->delete_stok($data_delete);
				}
			}
		}
		
		$status = get_status_user();
		$batal = 'class="disable" disabled="disabled"';
		/*if($status[10]['status']==2)
		{
			$batal = '';
		}*/
		$mydata = array(
			'form'				=> 'inventory/stok/add_stok',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> $batal,
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menus'		=> 'id="active_menus_stok"',
			'page'			    => 'stok_page',
			'menu'			    => 'stok_detail',
			'data_stok'		    => $this->data_field_stock($id_barang, 'add_stok'),
			'data_detail_stok'	=> $this->model_stok->get_stok_detail($id_barang),
			'user_status'		=> $status
		);
        $this->load->view('mainpage',$mydata);
	}
	
	function data_field_stock($data_id_barang, $data)
    {
		if($data_id_barang=='')
		{
			$data_field = array(
				'id_barang'		=> '',
				'kode_barang'	=> '',
				'nama_barang'	=> '',
				'sisa_stok'		=> '',
				'status_stok'	=> $data
	    	);
		}
		else
		{
			$getrecord = $this->model_stok->get_stok_barang($data_id_barang);
			foreach($getrecord->result_array() as $recordset)
			{
				$id_barang		= $recordset['id_barang'];
				$kode_barang	= $recordset['kode_barang'];
				$nama_barang	= $recordset['nama_barang'];
				$sisa_stok		= $recordset['sisa_stok'];
			}
			
			$data_field = array(
				'id_barang'		=> $id_barang,
				'kode_barang'	=> $kode_barang,
				'nama_barang'	=> $nama_barang,
				'sisa_stok'		=> $sisa_stok,
				'status_stok'   => $data
			);
		}
		
        return $data_field;
    }
}
?>