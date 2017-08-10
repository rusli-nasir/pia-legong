<?php 
class Customer extends Controller
{
	function Customer()
	{
		parent::Controller();
		$this->load->model('model_customer');
		$this->load->model('model_propinsi');
		val_url();
	}
    
    function index()
    {
		$status = get_status_user();
		$load_data = array(
			'form'			=> 'inventory/customer/add_customer',
			'simpan'		=> 'class="disable" disabled="disabled"',
			'edit'			=> 'class="disable" disabled="disabled"',
			'batal'			=> 'class="disable" disabled="disabled"',
			'cetak'			=> 'class="disable" disabled="disabled"',
			'active_menu'	=> 'class="active_customer_master"',
			'active_menus'	=> 'id="active_menus_master"',
			'controller'	=> 'customer',
			'page'			=> 'customer_daftar',
			'list'			=> $this->model_customer->view_all_customer(),
			'propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'user_status'	=> $status
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_customer()
	{
		$user_status = get_status_user();
		$data = array(
			'id_customer'		=> $this->model_customer->generate_id_customer(),
			'nama_customer'		=> $this->input->post('nama_customer'),
			'alamat'			=> $this->input->post('alamat'),
			'id_propinsi'		=> $this->input->post('id_propinsi'),
			'telepon'			=> $this->input->post('telepon'),
			'contact_person1'	=> $this->input->post('contact_person1'),
			'telpon_cp1'		=> $this->input->post('telpon_cp1'),
			'hp_cp1'			=> $this->input->post('hp_cp1'),
			'contact_person2'	=> $this->input->post('contact_person2'),
			'telpon_cp2'		=> $this->input->post('telpon_cp2'),
			'hp_cp2'			=> $this->input->post('hp_cp2'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_customer->insert_customer($data);
		
		/*$load_data = array(
			'controller'	=> 'customer',
			'page'			=> 'customer_daftar',
			'list'			=> $this->model_customer->view_all_customer()
		);
		
		echo base_url().'index.php/inventory/customer';*/
		
		$list = $this->model_customer->view_all_customer();
		foreach($list->result_array() as $customer_detail)
		{
			echo '<tr class="isi_list">';
			echo '<td class="labelss_dpo" id="search1">'.$customer_detail['nama_customer'].'</td>';
			echo '<td class="labelss_dpo" id="search2">'.$customer_detail['contact_person1'].'</td>';
			echo '<td class="labelss_dpo" id="search3">'.$customer_detail['keterangan'].'</td>';
			if($user_status[3]['status']==2){
				echo '<td class="labelss_dpo"><div class="edit" onclick="find_customer(\''.$customer_detail['id_customer'].'\')">';
				echo '<a href="javascript:void(0)">Edit<span style="display:none">'.$customer_detail['id_customer'].'';
				echo '</span></a>';
				echo '</div></td>';
				echo '<td class="labelss_dpo"><div class="hapus" onclick="hapus_customer(\''.$customer_detail['id_customer'].'\')">';
				echo '<a href="javascript:void(0)">Hapus<span style="display:none">'.$customer_detail['id_customer'].'';
				echo '</span></a>';
				echo '</div></td>';
			}
			echo '</tr>';
		}
	}
	
	function find_customer()
	{
		$id_customer = $this->input->post('id_customer');
		$getdata = array(
			'data'		=> $this->model_customer->find_customer($id_customer)
		);
		
		foreach($getdata['data']->result_array() as $data_customer)
		{
			$load_data = $data_customer['id_customer'].",".
						 $data_customer['nama_customer'].",".
						 $data_customer['alamat'].",".
						 $data_customer['id_propinsi'].",".
						 $data_customer['telepon'].",".
						 $data_customer['contact_person1'].",".
						 $data_customer['telpon_cp1'].",".
						 $data_customer['hp_cp1'].",".
						 $data_customer['contact_person2'].",".
						 $data_customer['telpon_cp2'].",".
						 $data_customer['hp_cp2'].",".
						 $data_customer['keterangan'];
		}
		
		echo $load_data;
	}
	
	function edit_customer()
	{
		$data = array(
			'id_customer'		=> $this->input->post('id_customer'),
			'nama_customer'		=> $this->input->post('nama_customer'),
			'alamat'			=> $this->input->post('alamat'),
			'id_propinsi'		=> $this->input->post('id_propinsi'),
			'telepon'			=> $this->input->post('telepon'),
			'contact_person1'	=> $this->input->post('contact_person1'),
			'telpon_cp1'		=> $this->input->post('telpon_cp1'),
			'hp_cp1'			=> $this->input->post('hp_cp1'),
			'contact_person2'	=> $this->input->post('contact_person2'),
			'telpon_cp2'		=> $this->input->post('telpon_cp2'),
			'hp_cp2'			=> $this->input->post('hp_cp2'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		
		$this->model_customer->update_customer($data);
		
		$load_data = array(
			'controller'	=> 'customer',
			'page'			=> 'customer_daftar',
			'list'			=> $this->model_customer->view_all_customer()
		);
		
		echo base_url().'index.php/inventory/customer';
	}
	
	function hapus_customer()
	{
		$id_customer = $this->input->post('id_customer');
		
		$this->model_customer->delete_customer($id_customer);
		
		echo base_url().'index.php/inventory/customer';
	}
}
?>