<?php 
class Cara_pembayaran_bhn extends Controller
{
	function Cara_pembayaran_bhn()
	{
		parent::Controller();
		$this->load->model('model_cara_pembayaran_bhn');
		val_url();
	}
	
    function index()
    {
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$load_data = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/cara_pembayaran_bhn/add_cara_pembayaran',
			'add'				=> '<li><div class="add_item"><a href="javascript:void(0)">Tambah Cara Bayar</a></div></li>',
			'active_menu'		=> 'class="active_cara_bayar_master"',
			'active_menus'		=> 'id="active_menus_master"',
			'controller'		=> 'cara_pembayaran_bhn',
			'page'				=> 'cara_pembayaran_bhn_daftar',
			'list'				=> $this->model_cara_pembayaran_bhn->select_cara_bayar()
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_cara_pembayaran()
	{
		//$user_status = get_status_user();
		$data = array(
			'id_cara_pembayaran'	=> $this->model_cara_pembayaran_bhn->generate_id_cara_pembayaran(),
			'nama_cara_pembayaran'	=> $this->input->post('cara_bayar'),
			'keterangan'			=> $this->input->post('keterangan'),
			'active'				=> '1'
		);
		$this->model_cara_pembayaran_bhn->insert_cara_pembayaran($data);
		
		$list = $this->model_cara_pembayaran_bhn->select_cara_bayar();
		foreach($list->result_array() as $cara_bayar)
		{
            echo'<tr class="isi_list">';
                echo'<td class="labelss_dbyr" id="search1">'.$cara_bayar['nama_cara_pembayaran'].'</td>';
                echo'<td class="labelss_dbyr" id="search3">'.$cara_bayar['keterangan'].'</td>';
				echo'<td class="labelss_dbyr"><div class="edit" onclick="findCaraBayar(\''.$cara_bayar['id_cara_pembayaran'].'\');">';
					echo'<a href="javascript:void(0)"><span style="display:block">Edit</span></a>';
				echo'</div></td>';
				echo'<td class="labelss_dbyr"><div class="hapus" onclick="hapusCaraBayar(\''.$cara_bayar['id_cara_pembayaran'].'\');">';
					echo'<a href="javascript:void(0)"><span style="display:block">Hapus</span></a>';
				echo'</div></td>';
            echo'</tr>';
		}
	}
	
	function find_cara_pembayaran()
	{
		$id_cara_pembayaran = $this->input->post('id_cara_bayar');
		$getdata = array(
			'data'		=> $this->model_cara_pembayaran_bhn->find_cara_pembayaran($id_cara_pembayaran)
		);
		
		foreach($getdata['data']->result_array() as $barang)
		{
			$load_data = $barang['id_cara_pembayaran'].",".
						 $barang['nama_cara_pembayaran'].",".
						 $barang['keterangan'];
		}
		
		echo $load_data;
	}
	
	function edit_cara_pembayaran()
	{
		$data = array(
			'id_cara_pembayaran'	=> $this->input->post('id_cara_bayar'),
			'nama_cara_pembayaran'	=> $this->input->post('cara_bayar'),
			'keterangan'			=> $this->input->post('keterangan'),
			'active'				=> '1'
		);
		$this->model_cara_pembayaran_bhn->update_cara_pembayaran($data);
		
		$load_data = array(
			'controller'	=> 'cara_pembayaran_bhn',
			'page'			=> 'cara_pembayaran_bhn_daftar',
			'list'			=> $this->model_cara_pembayaran_bhn->select_cara_bayar()
		);
		
		echo base_url().'index.php/produksi/cara_pembayaran_bhn';
	}
	
	function hapus_cara_pembayaran()
	{
		$id_cara_pembayaran = $this->input->post('id_cara_bayar');
		
		$this->model_cara_pembayaran_bhn->delete_cara_pembayaran($id_cara_pembayaran);
		
		echo base_url().'index.php/produksi/cara_pembayaran_bhn';
	}
}
?>