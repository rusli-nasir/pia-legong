<?php 
class Supplier extends Controller
{
	function Supplier()
	{
		parent::Controller();
		$this->load->model('model_supplier');
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
			'form'				=> 'produksi/supplier/add_supplier',
			'add'				=> '<li><div class="add_item"><a href="javascript:void(0)">Tambah Supplier</a></div></li>',
			'active_menu'		=> 'class="active_supplier_master"',
			'active_menus'		=> 'id="active_menus_master"',
			'controller'		=> 'supplier',
			'page'				=> 'supplier_daftar',
			'list'				=> $this->model_supplier->view_all_supplier()
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_supplier()
	{
		//$user_status = get_status_user();
		$data = array(
			'id_supplier'		=> $this->model_supplier->generate_id_supplier(),
			'nama_supplier'		=> $this->input->post('nama'),
			'alamat'			=> $this->input->post('alamat'),
			'contact_person'	=> $this->input->post('cp'),
			'telepon_1'			=> $this->input->post('tel_1'),
			'telepon_2'			=> $this->input->post('tel_2'),
			'no_rekening'		=> $this->input->post('rekening'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_supplier->insert_supplier($data);
		
		$list = $this->model_supplier->view_all_supplier();
		foreach($list->result_array() as $sup_detail)
		{
            echo'<tr class="isi_list">';
                echo'<td class="labelss_dpo" id="search1">'.$sup_detail['nama_supplier'].'</td>';
                echo'<td class="labelss_dpo" id="search2">'.$sup_detail['alamat'].'</td>';
                echo'<td class="labelss_dpo" id="search3">'.$sup_detail['telepon_1'].'</td>';
                echo'<td class="labelss_dpo" id="search4">'.$sup_detail['no_rekening'].'</td>';
                echo'<td class="labelss_dpo" id="search5">'.$sup_detail['keterangan'].'</td>';
				echo'<td class="labelss_dpo"><div class="edit" onclick="findSupplier(\''.$sup_detail['id_supplier'].'\');">';
					echo'<a href="javascript:void(0)"><span style="display:block">Edit</span></a>';
				echo'</div></td>';
				echo'<td class="labelss_dpo"><div class="hapus" onclick="hapusSupplier(\''.$sup_detail['id_supplier'].'\');">';
					echo'<a href="javascript:void(0)"><span style="display:block">Hapus</span></a>';
				echo'</div></td>';
            echo'</tr>';
		}
	}
	
	function find_supplier()
	{
		$id_supplier = $this->input->post('id_supplier');
		$getdata = array(
			'data'		=> $this->model_supplier->find_supplier($id_supplier)
		);
		
		foreach($getdata['data']->result_array() as $supplier)
		{
			$load_data = $supplier['id_supplier'].",".
						 $supplier['nama_supplier'].",".
						 $supplier['alamat'].",".
						 $supplier['contact_person'].",".
						 $supplier['telepon_1'].",".
						 $supplier['telepon_2'].",".
						 $supplier['no_rekening'].",".
						 $supplier['keterangan'];
		}
		
		echo $load_data;
	}
	
	function find_supplier_spesifik()
	{
		$nama_sup = $_GET['q'];
		$data = $this->model_supplier->view_supplier_spesifik($nama_sup);
		
		$mydata = array();
		foreach($data->result_array() as $row)
		{
			$mydata[] = $row;
		}
		
		echo json_encode($mydata);
	}
	
	function edit_supplier()
	{
		$data = array(
			'id_supplier'		=> $this->input->post('id'),
			'nama_supplier'		=> $this->input->post('nama'),
			'alamat'			=> $this->input->post('alamat'),
			'contact_person'	=> $this->input->post('cp'),
			'telepon_1'			=> $this->input->post('tel_1'),
			'telepon_2'			=> $this->input->post('tel_2'),
			'no_rekening'		=> $this->input->post('rekening'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_supplier->update_supplier($data);
		
		$load_data = array(
			'controller'	=> 'barang',
			'page'			=> 'barang_daftar',
			'list'			=> $this->model_supplier->view_all_supplier()
		);
		
		echo base_url().'index.php/produksi/supplier';
	}
	
	function hapus_supplier()
	{
		$id_supplier = $this->input->post('id_supplier');
		
		$this->model_supplier->delete_supplier($id_supplier);
		
		echo base_url().'index.php/produksi/supplier';
	}
	
}
?>