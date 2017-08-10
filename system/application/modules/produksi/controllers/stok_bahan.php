<?php 
class Stok_bahan extends Controller
{
	function Stok_bahan()
	{
		parent::Controller();
		$this->load->model('model_stok_bahan');
		val_url();
	}
	
	function index()
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$date=date('Y-m-d');
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/beli/beli_bahan',
			'add'				=> '<li><div class="add_item"><a href="javascript:void(0)">Stok Masuk/Keluar</a></div></li>',
			'active_menu'		=> 'class="active_stok_daftar"',
			'active_menus'		=> 'id="active_menus_stok"',
			'menu'				=> 'stok_bahan_daftar',
			'page'				=> 'stok_bahan_page',
            'date'       		=> $date,
			'list'				=> $this->model_stok_bahan->view_all_bahan_baku()
		);
		
		$this->load->view('mainpage', $mydata);
	}
	
	function add_stok()
	{
		$tglbaru 			= $this->input->post('tgl_transaksi');
		$tgl_transaksi		= explode_date($tglbaru, 0);
		$id_bhn_baku 		= $this->input->post('id_bhn_baku');
		$nama_bhn_baku 		= $this->input->post('nama_bhn_baku');
		$stok_masuk 		= $this->input->post('stok_masuk');
		$stok_keluar 		= $this->input->post('stok_keluar');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		foreach($id_bhn_baku as $result)
		{
			$data = array(
				'id_stok_bhn_baku'		=> '',
				'id_bhn_baku'			=> $result,
				'nama_bhn_baku' 		=> $nama_bhn_baku[$no],
				'stok_masuk' 			=> $stok_masuk[$no],
				'stok_keluar' 			=> $stok_keluar[$no]
			);
			
			if($result!='' or $nama_bhn_baku[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($result!='' and $nama_bhn_baku[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($sisa==0 and count($getrecord_detail2)>0)
		{
			$hasil=1;
			
			$no=0;
			foreach($id_bhn_baku as $result)
			{
				$id_stok_bhn_baku = $this->model_stok_bahan->generate_id_stok_bahan_baku();
				$data = array(
					'id_stok_bhn_baku'		=> $id_stok_bhn_baku,
					'id_bhn_baku'			=> $result,
					'id_pembelian'			=> '0',
					'tgl_transaksi'			=> $tgl_transaksi,
					'stok_masuk' 			=> $stok_masuk[$no],
					'stok_keluar' 			=> $stok_keluar[$no],
					'active'				=> '1'
				);
				if($result!="" and $nama_bhn_baku[$no]!='')
					$this->model_stok_bahan->add_stok($data);
				$no++;
			}
		}
		else
			$hasil=0;
		echo $hasil;
	}
	
	function add_stok_beli()
	{
		$id_pembelian		= $this->input->post('id_pembelian');
		$tglbaru 			= $this->input->post('tgl_transaksi');
		$tgl_transaksi		= explode_date($tglbaru, 0);
		$id_bhn_baku 		= $this->input->post('id_bhn_baku');
		$nama_bhn_baku 		= $this->input->post('nama_bhn_baku');
		$stok_masuk 		= $this->input->post('stok_masuk');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		foreach($id_bhn_baku as $result)
		{
			$data = array(
				'id_stok_bhn_baku'		=> '',
				'id_bhn_baku'			=> $result,
				'nama_bhn_baku' 		=> $nama_bhn_baku[$no],
				'stok_masuk' 			=> $stok_masuk[$no]
			);
			
			if($result!='' or $nama_bhn_baku[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($result!='' and $nama_bhn_baku[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($sisa==0 and count($getrecord_detail2)>0)
		{
			$no=0;
			foreach($id_bhn_baku as $result)
			{
				$id_stok_bhn_baku = $this->model_stok_bahan->generate_id_stok_bahan_baku();
				$data = array(
					'id_stok_bhn_baku'		=> $id_stok_bhn_baku,
					'id_bhn_baku'			=> $result,
					'id_pembelian'			=> $id_pembelian,
					'tgl_transaksi'			=> $tgl_transaksi,
					'stok_masuk' 			=> $stok_masuk[$no],
					'stok_keluar' 			=> 0,
					'active'				=> '1'
				);
				if($result!="" and $nama_bhn_baku[$no]!='' and $stok_masuk[$no]!=0)
					$this->model_stok_bahan->add_stok($data);
				$no++;
			}
			
			$this->find_stok_pembelian_detail($id_pembelian);
		}
		else
			$this->find_stok_pembelian_detail($id_pembelian);
	}
	
	function hapus_stok($id_stok_bhn_baku)
	{
		$data_stok = $this->model_stok_bahan->view_selected_stok_bahan($id_stok_bhn_baku)->result_array();
		$mydata = array(
			'id_stok_bhn_baku'	=> $id_stok_bhn_baku,
			'active'		=> '0'
		);
		$this->model_stok_bahan->inactive_stok_bahan($mydata);
		$this->find_stok_pembelian_detail($data_stok[0]['id_pembelian']);
	}
	
	function find_stok_pembelian_detail($id_pembelian)
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$this->load->model('model_beli');
		
		$data_pembelian1 = $this->model_beli->view_pembelian_spesifik($id_pembelian)->result_array();
		$data_pembelian2 = $this->model_stok_bahan->view_pembelian_stok_spesifik($id_pembelian)->result_array();
		$data_stok		 = $this->model_stok_bahan->view_transaksi_stok_per_pembelian($id_pembelian)->result_array();
		
		$add = '<li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" /></li>';
		$date = date('Y-m-d');
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/stok_bahan/add_stok_beli',
			'add'				=> $add,
			'active_menu'		=> 'class="active_stok_detail"',
			'active_menus'		=> 'id="active_menus_stok"',
			'menu'				=> '',
			'page'				=> 'stok_bahan_form',
            'date'       		=> $date,
			'list'				=> '',
			'detail_head'		=> $data_pembelian1,
			'detail_list'		=> $data_pembelian2,
			'detail_stok'		=> $data_stok
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function find_stok_detail($id_bhn_baku,$data="")
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$this->load->model('model_bahan_baku');
		
		if($data == "")
		{			
			$date1 = date('Y').'-'.date('m').'-1';
			$date = date('Y-m-d');	
		}
		else
		{
			$data = explode('_',$data);
			$date1 = $data[0];
			$date = $data[1];
		}
		
		$data = array(
			'id_bhn_baku'	=> $id_bhn_baku,
			'date1'			=> $date1,
			'date'			=> $date
		);
		
		$data_bahan1 = $this->model_bahan_baku->find_bahan_baku($id_bhn_baku)->result_array();
		$data_bahan2 = $this->model_stok_bahan->view_stok_detail_per_barang($data)->result_array();
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/stok_bahan/add_stok_beli',
			'add'				=> '',
			'active_menu'		=> 'class="active_stok_detail"',
			'active_menus'		=> 'id="active_menus_stok"',
			'menu'				=> 'stok_bahan_detail',
			'page'				=> 'stok_bahan_page',
            'date1'       		=> $date1,
            'date'       		=> $date,
			'list'				=> '',
			'detail_head'		=> $data_bahan1,
			'detail_list'		=> $data_bahan2
		);
		
        $this->load->view('mainpage',$mydata);
	}
}
?>