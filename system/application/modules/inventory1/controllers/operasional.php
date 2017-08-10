<?php
class operasional extends Controller
{
	function operasional()
	{
		parent::Controller();
		$this->load->model('model_operasional');
		$this->load->model('model_po');
		$this->load->model('model_jual');
		$this->load->model('model_stok');
		val_url();
	}
	
    function index($date="")
    {
		if($date=="")
			$date = date('Y-m-d');
	
		$mydata = array(
			'form'				=> '',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_operasional_daftar"',
			'active_menus'		=> 'id="active_menus_operasional"',
			'page'				=> 'operasional_page',
			'menu'				=> 'daftar_operasional',
			'date'				=> $date,
			'list'				=> $this->model_operasional->view_operasional_per_tgl($date)
		);
		
        $this->load->view('mainpage',$mydata);
    }
	
	function add_operasional()
	{
		$nama_transaksi 			= $this->input->post('nama_transaksi');
		$jumlah_pengeluaran			= $this->input->post('jumlah_pengeluaran');
		$date						= $this->input->post('tgl_operasional');
		$ar_tgl_transaksi 			= explode('/',$date);
		$tanggal_transaksi			= $ar_tgl_transaksi[2].'-'.$ar_tgl_transaksi[1].'-'.$ar_tgl_transaksi[0];
		
		$id_operasional = $this->model_operasional->generate_id_produksi();
		$data_input = array(
				'id_produksi'			=> $id_operasional,
				'nama_transaksi'		=> $nama_transaksi,
				'jumlah_pengeluaran'	=> $jumlah_pengeluaran,
				'tanggal_transaksi'		=> $tanggal_transaksi
		);
		
		$this->model_operasional->add_operasional($data_input);
		
		echo base_url().'index.php/inventory/operasional/index/'.$tanggal_transaksi;
	}
	
	function find_operasional()
	{
		$tgl 	= $this->input->post('tgl');
		$ar_tgl = explode('/',$tgl);
		$date 	= $ar_tgl[2].'-'.$ar_tgl[1].'-'.$ar_tgl[0];
		echo base_url().'index.php/inventory/operasional/index/'.$date;
	}
	
	function findOperasional_perID()
	{
		$id_produksi = $this->input->post('id_produksi');
		$getdata = array(
			'data'		=> $this->model_operasional->findOperasional_perID($id_produksi)
		);
		
		foreach($getdata['data']->result_array() as $list)
		{
			$load_data = $list['id_produksi'].",".
						 $list['tanggal_pengeluaran'].",".
						 $list['nama_transaksi'].",".
						 $list['jumlah_pengeluaran'];
		}
		
		echo $load_data;
	}
	
	function edit_operasional()
	{
		$id_produksi 				= $this->input->post('id_produksi');
		$nama_transaksi 			= $this->input->post('nama_transaksi');
		$jumlah_pengeluaran			= $this->input->post('jumlah_pengeluaran');
		$date						= $this->input->post('tgl_operasional');
		$ar_tgl_transaksi 			= explode('/',$date);
		$tanggal_transaksi			= $ar_tgl_transaksi[2].'-'.$ar_tgl_transaksi[1].'-'.$ar_tgl_transaksi[0];
		
		$data_input = array(
				'id_produksi'			=> $id_produksi,
				'nama_transaksi'		=> $nama_transaksi,
				'jumlah_pengeluaran'	=> $jumlah_pengeluaran,
				'tanggal_transaksi'		=> $tanggal_transaksi
		);
		
		$this->model_operasional->edit_operasional($data_input);
		
		echo base_url().'index.php/inventory/operasional/index/'.$tanggal_transaksi;
	}
	
	function batal_operasional()
	{
		$id_produksi = $this->input->post('id_produksi');
		$date = $this->input->post('tgl_operasional');
		$ar_tgl_transaksi 			= explode('/',$date);
		$tanggal_transaksi			= $ar_tgl_transaksi[2].'-'.$ar_tgl_transaksi[1].'-'.$ar_tgl_transaksi[0];
		
		$this->model_operasional->batal_operasional($id_produksi);
		
		echo base_url().'index.php/inventory/operasional/index/'.$tanggal_transaksi;
	}
	
	function delete_system()
	{
		$date = date("d/m/Y");
		$mydata = array(
			'form'				=> 'inventory/operasional/delete_system_periodic',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_operasional_delete"',
			'active_menus'		=> 'id="active_menus_master"',
			'page'				=> 'delete_system_form',
			'controller'		=> 'operasional',
			'date'				=> $date,
			'list'				=> ''
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function delete_system_periodic()
	{
		$date_first = $this->input->post('date_first');
		$date_last = $this->input->post('date_last');
		$date = array(
			'date_from' => explode_date($date_first, 0),
			'date_to'	=> explode_date($date_last, 0)
		);
		
		#======delete tb_po dan tb_detail_po======#
		$delete_po = $this->model_po->delete_po($date);
		
		#======delete tb_penjualan dan tb_detail_penjualan + tb_pembayaran dan tb_transaksi_stok======#
		$delete_jual = $this->model_jual->delete_alljual($date);
		
		#======delete tb_stok_awal======#
		$delete_stok_awal = $this->model_stok->delete_stok_awal($date);
		
		#======delete tb_saldo_awal======#
		$delete_saldo_awal = $this->model_operasional->delete_saldo($date);
		
		#======delete_pengeluaran_produksi======#
		$delete_pengeluaran = $this->model_operasional->delete_pengeluaran($date);
		
		$this->delete_system();
	}
}
?>