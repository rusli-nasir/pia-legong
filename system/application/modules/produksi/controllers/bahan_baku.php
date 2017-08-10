<?php 
class Bahan_baku extends Controller
{
	function Bahan_baku()
	{
		parent::Controller();
		$this->load->model('model_bahan_baku');
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
			'notification'		=> $notif,
			'form'				=> 'produksi/bahan_baku/add_bahan_baku',
			'add'				=> '<li><div class="add_item"><a href="javascript:void(0)">Tambah Item</a></div></li>',
			'active_menu'		=> 'class="active_barang_master"',
			'active_menus'		=> 'id="active_menus_master"',
			'controller'		=> 'bahan_baku',
			'page'				=> 'bahan_baku_daftar',
			'list'				=> $this->model_bahan_baku->view_all_bahan_baku(),
			'satuan'			=> $this->model_satuan_barang->select_satuan_barang()
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function add_bahan_baku()
	{
		$data = array(
			'id_bhn_baku'		=> $this->model_bahan_baku->generate_id_bahan_baku(),
			'nama_bhn_baku'		=> $this->input->post('nama_bhn_baku'),
			'id_satuan_barang'	=> $this->input->post('satuan_bhn_baku'),
			'stok_minimum'		=> $this->input->post('stok_minimum'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_bahan_baku->insert_bahan_baku($data);
		
		$id_supplier	= $this->input->post('id_supplier');
		$harga_bhn		= $this->input->post('harga_bhn');
		$ket_detail		= $this->input->post('keterangan_detail');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		
		foreach($id_supplier as $supplier)
		{
			$data_detail = array(
				'id_detail_bhn_baku'	=> $this->model_bahan_baku->generate_id_detail_bahan_baku(),
				'id_bhn_baku'			=> $data['id_bhn_baku'],
				'id_supplier'			=> $supplier,
				'keterangan'			=> $ket_detail[$no],
				'harga_bahan'			=> $harga_bhn[$no]
			);
			
			if($supplier!='' or $harga_bhn[$no]!=''){
				$getrecord_detail[] = $data_detail;
			}
			
			if($supplier!='' and $harga_bhn[$no]!=''){
				$getrecord_detail2[] = $data_detail;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($sisa==0 and count($getrecord_detail2)>0)
		{
			$no=0;
			foreach($id_supplier as $supplier)
			{
				$data_detail = array(
					'id_detail_bhn_baku'	=> $this->model_bahan_baku->generate_id_detail_bahan_baku(),
					'id_bhn_baku'			=> $data['id_bhn_baku'],
					'id_supplier'			=> $supplier,
					'keterangan'			=> $ket_detail[$no],
					'harga_bahan'			=> $harga_bhn[$no],
					'active'				=> '1'
				);
				if($supplier!='')
					$this->model_bahan_baku->insert_detail_bahan_baku($data_detail);
				$no++;
			}
			
			$list = $this->model_bahan_baku->view_all_bahan_baku();
			foreach($list->result_array() as $brg_detail)
			{
				echo'<tr class="isi_list">';
					echo'<td class="labelss_dpo" id="search1">'.$brg_detail['nama_bhn_baku'].'</td>';
					echo'<td class="labelss_dpo" id="search2">'.$brg_detail['nama_satuan'].'</td>';
					echo'<td class="labelss_dpo" id="search3">'.$brg_detail['keterangan'].'</td>';
					echo'<td class="labelss_dpo"><div class="edit" onclick="findBarang(\''.$brg_detail['id_bhn_baku'].'\');">';
						echo'<a href="javascript:void(0)"><span style="display:block">Edit</span></a>';
					echo'</div></td>';
					echo'<td class="labelss_dpo"><div class="hapus" onclick="hapusBarang(\''.$brg_detail['id_bhn_baku'].'\');">';
						echo'<a href="javascript:void(0)"><span style="display:block">Hapus</span></a>';
					echo'</div></td>';
				echo'</tr>';
			}
		}
		else
		{
			echo 'Data Salah';
		}
	}
	
	function find_bahan_baku()
	{
		$id_bhn_baku = $this->input->post('id');
		$getdata = array(
			'data'		=> $this->model_bahan_baku->find_bahan_baku($id_bhn_baku)
		);
		
		foreach($getdata['data']->result_array() as $bahan_baku)
		{
			$load_data = $bahan_baku['id_bhn_baku'].",".
				$bahan_baku['nama_bhn_baku'].",".
				$bahan_baku['id_satuan_barang'].",".
				round($bahan_baku['stok_minimum']).",".
				$bahan_baku['keterangan'];
		}
		
		echo $load_data;
	}
	
	function find_bahan_baku_detail()
	{
		$id_bhn_baku = $this->input->post('id');
		$getdata = array(
			'data'		=> $this->model_bahan_baku->find_bahan_baku_detail($id_bhn_baku)
		);
		
		$loop=''; $no=0;
		foreach($getdata['data']->result_array() as $bahan_baku)
		{
			if($no>0)
				$loop ='___';
			$load_data .= $loop.$bahan_baku['id_detail_bhn_baku'].",".
				$bahan_baku['id_supplier'].",".
				$bahan_baku['nama_supplier'].",".
				$bahan_baku['alamat'].",".
				round($bahan_baku['harga_bahan'],5).",".
				$bahan_baku['keterangan'];
			$no++;
		}
		
		echo $load_data;
	}
	
	function edit_bahan_baku()
	{
		$data = array(
			'id_bhn_baku'		=> $this->input->post('id_bhn_baku_tamp'),
			'nama_bhn_baku'		=> $this->input->post('nama_bhn_baku'),
			'id_satuan_barang'	=> $this->input->post('satuan_bhn_baku'),
			'stok_minimum'		=> $this->input->post('stok_minimum'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_bahan_baku->update_bahan_baku($data);
		
		$id_detail_bhn	= $this->input->post('id_detail_bhn_baku');
		$id_supplier	= $this->input->post('id_supplier');
		$harga_bhn		= $this->input->post('harga_bhn');
		$ket_detail		= $this->input->post('keterangan_detail');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		
		foreach($id_supplier as $supplier)
		{
			$data_detail = array(
				'id_detail_bhn_baku'	=> '',
				'id_bhn_baku'			=> $data['id_bhn_baku'],
				'id_supplier'			=> $supplier,
				'keterangan'			=> $ket_detail[$no],
				'harga_bahan'			=> $harga_bhn[$no]
			);
			
			if($supplier!='' or $harga_bhn[$no]!=''){
				$getrecord_detail[] = $data_detail;
			}
			
			if($supplier!='' and $harga_bhn[$no]!=''){
				$getrecord_detail2[] = $data_detail;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($sisa==0 and count($getrecord_detail2)>0)
		{
			$this->model_bahan_baku->delete_detail_bahan_baku($data['id_bhn_baku']);
			
			$no=0;
			foreach($id_supplier as $supplier)
			{
				$data_detail = array(
					'id_detail_bhn_baku'	=> $this->model_bahan_baku->generate_id_detail_bahan_baku(),
					'id_bhn_baku'			=> $data['id_bhn_baku'],
					'id_supplier'			=> $supplier,
					'keterangan'			=> $ket_detail[$no],
					'harga_bahan'			=> $harga_bhn[$no],
					'active'				=> '1'
				);
				if($supplier!='')
					$this->model_bahan_baku->insert_detail_bahan_baku($data_detail);
				$no++;
			}
			
			$list = $this->model_bahan_baku->view_all_bahan_baku();
			foreach($list->result_array() as $brg_detail)
			{
				echo'<tr class="isi_list">';
					echo'<td class="labelss_dpo" id="search1">'.$brg_detail['nama_bhn_baku'].'</td>';
					echo'<td class="labelss_dpo" id="search2">'.$brg_detail['nama_satuan'].'</td>';
					echo'<td class="labelss_dpo" id="search3">'.$brg_detail['keterangan'].'</td>';
					echo'<td class="labelss_dpo"><div class="edit" onclick="findBarang(\''.$brg_detail['id_bhn_baku'].'\');">';
						echo'<a href="javascript:void(0)"><span style="display:block">Edit</span></a>';
					echo'</div></td>';
					echo'<td class="labelss_dpo"><div class="hapus" onclick="hapusBarang(\''.$brg_detail['id_bhn_baku'].'\');">';
						echo'<a href="javascript:void(0)"><span style="display:block">Hapus</span></a>';
					echo'</div></td>';
				echo'</tr>';
			}
		}
		else
		{
			echo 'Data Salah';
		}
	}
	
	function hapus_bahan_baku()
	{
		$id_bhn_baku = $this->input->post('id');
		
		$this->model_bahan_baku->unactive_bahan_baku($id_bhn_baku);
		$this->model_bahan_baku->unactive_detail_bahan_baku($id_bhn_baku);
		
		echo base_url().'index.php/produksi/bahan_baku';
	}
	
	function find_this_barang()
	{
		$id = $_GET['q'];
		$data = $this->model_bahan_baku->bhn_baku_with_conditon($id);
		
		$mydata = array();
		foreach($data->result_array() as $row)
		{
			$mydata[] = $row;
		}
		
		echo json_encode($mydata);
	}
}
?>