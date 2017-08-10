<?php 
class Supplier extends Controller
{
	function Supplier()
	{
		parent::Controller();
		$this->load->model('model_supplier');
		$this->load->model('model_propinsi');
		val_url();
	}
    
    function index()
    {
		$status = get_status_user();
		$load_data = array(
			'form'			=> 'inventory/supplier/add_supplier',
			'simpan'		=> 'class="disable" disabled="disabled"',
			'edit'			=> 'class="disable" disabled="disabled"',
			'batal'			=> 'class="disable" disabled="disabled"',
			'cetak'			=> 'class="disable" disabled="disabled"',
			'active_menu'	=> 'class="active_supplier_master"',
			'active_menus'	=> 'id="active_menus_master"',
			'controller'	=> 'supplier',
			'page'			=> 'supplier_daftar',
			'list'			=> $this->model_supplier->view_all_supplier(),
			'propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'user_status'	=> $status
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_supplier()
	{
		$user_status = get_status_user();
		$data = array(
			'id_supplier'		=> $this->model_supplier->generate_id_supplier(),
			'nama_supplier'		=> $this->input->post('nama_supplier'),
			'alamat'			=> $this->input->post('alamat'),
			'id_propinsi'		=> $this->input->post('id_propinsi'),
			'telepon'			=> $this->input->post('telepon'),
			'fax'				=> $this->input->post('fax'),
			'contact_person'	=> $this->input->post('contact_person'),
			'telepon_cp'		=> $this->input->post('telepon_cp'),
			'hp_cp'				=> $this->input->post('hp_cp'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_supplier->insert_supplier($data);
		
		/*$load_data = array(
			'controller'	=> 'supplier',
			'page'			=> 'supplier_daftar',
			'list'			=> $this->model_supplier->view_all_supplier()
		);
		
		echo base_url().'index.php/inventory/supplier';*/
		
		$list = $this->model_supplier->view_all_supplier();
		foreach($list->result_array() as $supplier_detail)
		{
			echo '<tr class="isi_list">';
			echo '<td class="labelss_dpo" id="search1">'.$supplier_detail['nama_supplier'].'</td>';
			echo '<td class="labelss_dpo" id="search2">'.$supplier_detail['contact_person'].'</td>';
			echo '<td class="labelss_dpo" id="search3">'.$supplier_detail['keterangan'].'</td>';
			if($user_status[2]['status']==2){
				echo '<td class="labelss_dpo"><div class="edit" onclick="find_supplier(\''.$supplier_detail['id_supplier'].'\')">';
				echo '<a href="javascript:void(0)">Edit<span style="display:none">'.$supplier_detail['id_supplier'].'';
				echo '</span></a>';
				echo '</div></td>';
				echo '<td class="labelss_dpo"><div class="hapus" onclick="hapus_supplier(\''.$supplier_detail['id_supplier'].'\')">';
				echo '<a href="javascript:void(0)">Hapus<span style="display:none">'.$supplier_detail['id_supplier'].'';
				echo '</span></a>';
				echo '</div></td>';
			}
			echo '</tr>';
		}
	}
	
	function find_supplier()
	{
		$id_supplier = $this->input->post('id_supplier');
		$getdata = array(
			'data'		=> $this->model_supplier->find_supplier($id_supplier)
		);
		
		foreach($getdata['data']->result_array() as $data_supplier)
		{
			$load_data = $data_supplier['id_supplier'].",".
						 $data_supplier['nama_supplier'].",".
						 $data_supplier['alamat'].",".
						 $data_supplier['id_propinsi'].",".
						 $data_supplier['telepon'].",".
						 $data_supplier['fax'].",".
						 $data_supplier['contact_person'].",".
						 $data_supplier['telepon_cp'].",".
						 $data_supplier['hp_cp'].",".
						 $data_supplier['keterangan'];
		}
		
		echo $load_data;
	}
	
	function edit_supplier()
	{
		$data = array(
			'id_supplier'		=> $this->input->post('id_supplier'),
			'nama_supplier'		=> $this->input->post('nama_supplier'),
			'alamat'			=> $this->input->post('alamat'),
			'id_propinsi'		=> $this->input->post('id_propinsi'),
			'telepon'			=> $this->input->post('telepon'),
			'fax'				=> $this->input->post('fax'),
			'contact_person'	=> $this->input->post('contact_person'),
			'telepon_cp'		=> $this->input->post('telepon_cp'),
			'hp_cp'				=> $this->input->post('hp_cp'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		
		$this->model_supplier->update_supplier($data);
		
		$load_data = array(
			'controller'	=> 'supplier',
			'page'			=> 'supplier_daftar',
			'list'			=> $this->model_supplier->view_all_supplier()
		);
		
		echo base_url().'index.php/inventory/supplier';
	}
	
	function hapus_supplier()
	{
		$id_supplier = $this->input->post('id_supplier');
		
		$this->model_supplier->delete_supplier($id_supplier);
		
		echo base_url().'index.php/inventory/supplier';
	}
}
?>