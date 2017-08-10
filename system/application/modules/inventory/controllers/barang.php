<?php 
class Barang extends Controller
{
	function Barang()
	{
		parent::Controller();
		$this->load->model('model_barang');
		$this->load->model('model_stok');
		val_url();
	}
	
    function index()
    {
		//$status = get_status_user();
		$load_data = array(
			'form'				=> 'inventory/barang/add_barang',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_barang_master"',
			'active_menus'		=> 'id="active_menus_master"',
			'controller'		=> 'barang',
			'page'				=> 'barang_daftar',
			'list'				=> $this->model_barang->view_all_barang()
			//'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_barang()
	{
		//$user_status = get_status_user();
		$data = array(
			'id_barang'			=> $this->model_barang->generate_id_barang(),
			'nama_barang'		=> $this->input->post('nama_barang'),
			'harga_barang'		=> $this->input->post('harga_barang'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_barang->insert_barang($data);
		
		$list = $this->model_barang->view_all_barang();
		foreach($list->result_array() as $brg_detail)
		{
            echo'<tr class="isi_list">';
                echo'<td class="labelss_dpo" id="search1">'.$brg_detail['nama_barang'].'</td>';
                echo'<td class="labelss_dpo" id="search2">'.$brg_detail['harga_barang'].'</td>';
                echo'<td class="labelss_dpo" id="search3">'.$brg_detail['keterangan'].'</td>';
				echo'<td class="labelss_dpo"><div class="edit" onclick="findBarang(\''.$brg_detail['id_barang'].'\');">';
					echo'<a href="javascript:void(0)"><span style="display:block">Edit</span></a>';
				echo'</div></td>';
				echo'<td class="labelss_dpo"><div class="hapus" onclick="hapusBarang(\''.$brg_detail['id_barang'].'\');">';
					echo'<a href="javascript:void(0)"><span style="display:block">Hapus</span></a>';
				echo'</div></td>';
            echo'</tr>';
		}
	}
	
	function find_barang()
	{
		$id_barang = $this->input->post('id_barang');
		$getdata = array(
			'data'		=> $this->model_barang->find_barang($id_barang)
		);
		
		foreach($getdata['data']->result_array() as $barang)
		{
			$load_data = $barang['id_barang'].",".
						 $barang['nama_barang'].",".
						 $barang['harga_barang'].",".
						 $barang['keterangan'];
		}
		
		echo $load_data;
	}
	
	function edit_barang()
	{
		$data = array(
			'id_barang'			=> $this->input->post('id_barang'),
			'nama_barang'		=> $this->input->post('nama_barang'),
			'harga_barang'		=> $this->input->post('harga_barang'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_barang->update_barang($data);
		
		$load_data = array(
			'controller'	=> 'barang',
			'page'			=> 'barang_daftar',
			'list'			=> $this->model_barang->view_all_barang()
		);
		
		echo base_url().'index.php/inventory/barang';
	}
	
	function hapus_barang()
	{
		$id_barang = $this->input->post('id_barang');
		
		$this->model_barang->delete_barang($id_barang);
		
		echo base_url().'index.php/inventory/barang';
	}
	
}
?>