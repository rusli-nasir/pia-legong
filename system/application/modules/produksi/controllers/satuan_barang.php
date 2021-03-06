<?php 
class Satuan_barang extends Controller
{
	function Satuan_barang()
	{
		parent::Controller();
		$this->load->model('model_satuan_barang');
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
			'notification'	=> $notif,
			'form'			=> 'produksi/satuan_barang/add_satuan_barang',
			'add'			=> '<li><div class="add_item"><a href="javascript:void(0)">Tambah Satuan</a></div></li>',
			'active_menu'	=> 'class="active_satuan_barang_master"',
			'active_menus'	=> 'id="active_menus_master"',
			'controller'	=> 'satuan_barang',
			'page'			=> 'satuan_barang_daftar',
			'list'			=> $this->model_satuan_barang->select_satuan_barang()
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_satuan_barang()
	{
		$data = array(
			'id_satuan_barang'	=> $this->model_satuan_barang->generate_id_satuan_barang(),
			'kode_satuan'		=> $this->input->post('kode_satuan'),
			'nama_satuan'		=> $this->input->post('nama_satuan'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_satuan_barang->insert_satuan_barang($data);
		
		$list = $this->model_satuan_barang->select_satuan_barang();
		foreach($list->result_array() as $satuan_detail)
		{
			echo '<tr class="isi_list">';
			echo '<td class="labelss_dpo" id="search1">'.$satuan_detail['nama_satuan'].'</td>';
			echo '<td class="labelss_dpo" id="search2">'.$satuan_detail['kode_satuan'].'</td>';
			echo '<td class="labelss_dpo" id="search3">'.$satuan_detail['keterangan'].'</td>';
			echo '<td class="labelss_dpo"><div class="edit" onclick="find_satuan(\''.$satuan_detail['id_satuan_barang'].'\');">';
			echo '<a href="javascript:void(0)"><span style="display:block">Edit</span><span style="display:none">'.$satuan_detail['id_satuan_barang'].'';
			echo '</span></a>';
			echo '</div></td>';
			echo '<td class="labelss_dpo"><div class="hapus" onclick="hapus_satuan(\''.$satuan_detail['id_satuan_barang'].'\');">';
			echo '<a href="javascript:void(0)"><span style="display:block">Hapus</span><span style="display:none">'.$satuan_detail['id_satuan_barang'].'';
			echo '</span></a>';
			echo '</div></td>';
			echo '</tr>';
		}
	}
	
	function find_satuan_barang()
	{
		$id_satuan_barang = $this->input->post('id_satuan_barang');
		$getdata = array(
			'data'		=> $this->model_satuan_barang->find_satuan_barang($id_satuan_barang)
		);
		
		foreach($getdata['data']->result_array() as $satuan_barang)
		{
			$load_data = $satuan_barang['id_satuan_barang'].",".
						 $satuan_barang['kode_satuan'].",".
						 $satuan_barang['nama_satuan'].",".
						 $satuan_barang['keterangan'];
		}
		
		echo $load_data;
	}
	
	function edit_satuan_barang()
	{
		$data = array(
			'id_satuan_barang'	=> $this->input->post('id_satuan_barang'),
			'kode_satuan'		=> $this->input->post('kode_satuan'),
			'nama_satuan'		=> $this->input->post('nama_satuan'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_satuan_barang->update_satuan_barang($data);
		
		$load_data = array(
			'controller'	=> 'satuan_barang',
			'page'			=> 'satuan_barang_daftar',
			'list'			=> $this->model_satuan_barang->select_satuan_barang()
		);
		
		echo base_url().'index.php/produksi/satuan_barang';
	}
	
	function hapus_satuan_barang()
	{
		$id_satuan_barang = $this->input->post('id_satuan_barang');
		
		$this->model_satuan_barang->delete_satuan_barang($id_satuan_barang);
		
		echo base_url().'index.php/produksi/satuan_barang';
	}
}
?>