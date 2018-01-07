<?php 
class Beli extends Controller
{
	function Beli()
	{
		parent::Controller();
        $this->load->model('model_beli');
        $this->load->model('model_cara_pembayaran_bhn');
		$this->load->model('model_bahan_baku');
		val_url();
	}
	
	function index($data="")
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
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
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/beli/beli_bahan',
			'add'				=> '<li><div class="add_item"><a href="'.site_url("produksi/beli/akses_beli/beli_form").'">Tambah Pembelian</a></div></li>',
			'active_menu'		=> 'class="active_beli_daftar"',
			'active_menus'		=> 'id="active_menus_pembelian"',
			'menu'				=> 'beli_daftar',
			'page'				=> 'beli_page',
			'date1'				=> $date1,
            'date'       		=> $date,
			'list'				=> $this->model_beli->view_pembelian($date1, $date),
			'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar()
		);
		
		$this->load->view('mainpage', $mydata);
	}
	
	function akses_beli($ambil_data)
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		if($ambil_data == "beli_form")
		{
			$add = '<li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" /></li>';
			$menu = 'beli_form';
		}
		
		$date=date('Y-m-d');
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/beli/add_beli',
			'add'				=> $add,
			'active_menu'		=> 'class="active_'.$ambil_data.'"',
			'active_menus'		=> 'id="active_menus_pembelian"',
			'menu'				=> $menu,
			'page'				=> 'beli_page',
            'date'       		=> $date,
			'list'				=> '',
			'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar(),
			'detail_head'		=> false,
			'detail_list'		=> false
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function add_beli()
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$tglbaru 				= $this->input->post('tgl_pembelian1');
		$tgl_pembelian			= explode_date($tglbaru, 0);
		$tglbaru1 				= $this->input->post('tgl_jatuh_tempo');
		$tgl_jatuh_tempo		= explode_date($tglbaru1, 0);
		$total_harga 			= $this->input->post('total_harga');
		$dibayar 				= $this->input->post('dibayar');
		$id_cara_pembayaran_bhn = $this->input->post('id_cara_pembayaran_bhn');
		
		$id_bhn_baku 		= $this->input->post('id_bhn_baku');
		$id_supplier 		= $this->input->post('id_supplier');
		$harga_bahan 		= $this->input->post('harga_bahan');
		$quantity 			= $this->input->post('quantity');
		$total_per_barang 	= $this->input->post('total_per_barang');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		foreach($id_bhn_baku as $result)
		{
			$data = array(
				'id_detail_pembelian'	=> '',
				'id_bhn_baku'			=> $result,
				'id_supplier' 			=> $id_supplier[$no],
				'harga_bahan' 			=> $harga_bahan[$no],
				'quantity' 				=> $quantity[$no],
				'total_per_barang' 		=> $total_per_barang[$no]
			);
			
			if($result!='' or $id_supplier[$no]!='' or $harga_bahan[$no]!=0 or $quantity[$no]!=0)
			{
				$getrecord_detail[] = $data;
			}
			
			if($result!='' and $id_supplier[$no]!='' and $harga_bahan[$no]!=0 and $quantity[$no]!=0)
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		$cek = 1;
		if(($id_cara_pembayaran_bhn != '0' and $dibayar == 0) or ($id_cara_pembayaran_bhn == '0' and $dibayar != 0))
			$cek = 0;
		
		if($cek==1 and $sisa==0 and count($getrecord_detail2)>0)
		{
			if($dibayar!="" and $dibayar!=0)
			{
				$id_pembayaran_bhn = $this->model_beli->generate_id_pembayaran_bhn();
				$data_input_bayar = array(
					'id_pembayaran_bhn'			=> $id_pembayaran_bhn,
					'tgl_pembayaran'			=> $tgl_pembelian,
					'id_pembelian'				=> $this->model_beli->generate_id_pembelian(),
					'id_cara_pembayaran_bhn'	=> $id_cara_pembayaran_bhn,
					'jumlah_bayar'    			=> $dibayar,
					'dp_type'					=> '1',
					'active'					=> '1'
				);
				$this->model_beli->add_beli_bayar($data_input_bayar);
			}
			
			$id_pembelian = $this->model_beli->generate_id_pembelian();
			$data_input = array(
				'id_pembelian'				=> $id_pembelian,
				'tgl_pembelian'				=> $tgl_pembelian,
				'tgl_jatuh_tempo'			=> $tgl_jatuh_tempo,
				'id_cara_pembayaran'		=> $id_cara_pembayaran_bhn,
				'jumlah_bayar'          	=> $dibayar,
				'total_pembelian'          	=> $total_harga,
				'active'					=> '1'
			);
			$this->model_beli->add_beli($data_input);
			$no=0;
			foreach($id_bhn_baku as $result)
			{
				$data = array(
					'id_detail_pembelian'	=> $this->model_beli->generate_id_detail_pembelian(),
					'id_pembelian'			=> $id_pembelian,
					'id_bhn_baku'			=> $result,
					'id_supplier' 			=> $id_supplier[$no],
					'quantity' 				=> $quantity[$no],
					'total_harga' 			=> $total_per_barang[$no],
					'active'				=> '1'
				);
				if($result!="")
					$this->model_beli->add_beli_detail($data);
				$no++;
			}
			
			$date1 = date('Y').'-'.date('m').'-1';
			$date=date('Y-m-d');
			$mydata = array(
				'notification'		=> $notif,
				'form'				=> 'produksi/beli/beli_bahan',
				'add'				=> '<li><div class="add_item"><a href="'.site_url("produksi/beli/akses_beli/beli_form").'">Tambah Pembelian</a></div></li>',
				'active_menu'		=> 'class="active_beli_daftar"',
				'active_menus'		=> 'id="active_menus_pembelian"',
				'menu'				=> 'beli_daftar',
				'page'				=> 'beli_page',
				'date1'				=> $date1,
				'date'       		=> $date,
				'list'				=> $this->model_beli->view_pembelian($date1, $date),
				'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar()
			);
			
			$this->load->view('mainpage', $mydata);
		}
		else
		{
			$add = '<li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" /></li>';
			$menu = 'beli_form';
			$date1 = date('Y').'-'.date('m').'-1';
			$date = date('Y-m-d');
			
			$this->session->set_userdata('message', 'Pengisian Data Barang belum lengkap');
			
			$mydata = array(
				'notification'		=> $notif,
				'form'				=> 'produksi/beli/add_beli',
				'add'				=> $add,
				'active_menu'		=> 'class="active_beli_form"',
				'active_menus'		=> 'id="active_menus_pembelian"',
				'menu'				=> $menu,
				'page'				=> 'beli_page',
				'date'       		=> $date,
				'list'				=> '',
				'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar(),
				'detail_head'		=> false,
				'detail_list'		=> false
			);
			
			$this->load->view('mainpage',$mydata);
		}
	}
	
	function edit_beli()
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$id_pembelian			= $this->input->post('id_pembelian');
		$tglbaru 				= $this->input->post('tgl_pembelian1');
		$tgl_pembelian			= explode_date($tglbaru, 0);
		$tglbaru1 				= $this->input->post('tgl_jatuh_tempo');
		$tgl_jatuh_tempo		= explode_date($tglbaru1, 0);
		$total_harga 			= $this->input->post('total_harga');
		$dibayar 				= $this->input->post('dibayar');
		$id_cara_pembayaran_bhn = $this->input->post('id_cara_pembayaran_bhn');
		
		$id_bhn_baku 		= $this->input->post('id_bhn_baku');
		$id_supplier 		= $this->input->post('id_supplier');
		$harga_bahan 		= $this->input->post('harga_bahan');
		$quantity 			= $this->input->post('quantity');
		$total_per_barang 	= $this->input->post('total_per_barang');
		
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		foreach($id_bhn_baku as $result)
		{
			$data = array(
				'id_detail_pembelian'	=> '',
				'id_bhn_baku'			=> $result,
				'id_supplier' 			=> $id_supplier[$no],
				'harga_bahan' 			=> $harga_bahan[$no],
				'quantity' 				=> $quantity[$no],
				'total_per_barang' 		=> $total_per_barang[$no]
			);
			
			if($result!='' or $id_supplier[$no]!='' or $harga_bahan[$no]!=0 or $quantity[$no]!=0)
			{
				$getrecord_detail[] = $data;
			}
			
			if($result!='' and $id_supplier[$no]!='' and $harga_bahan[$no]!=0 and $quantity[$no]!=0)
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		$cek = 1;
		if(($id_cara_pembayaran_bhn != '0' and $dibayar == 0) or ($id_cara_pembayaran_bhn == '0' and $dibayar != 0))
			$cek = 0;
		
		if($cek==1 and $sisa==0 and count($getrecord_detail2)>0)
		{
			if($dibayar!="" and $dibayar!=0)
			{
				$id_pembayaran_bhn = $this->model_beli->generate_id_pembayaran_bhn();
				$data_input_bayar = array(
					'id_pembayaran_bhn'			=> $id_pembayaran_bhn,
					'tgl_pembayaran'			=> $tgl_pembelian,
					'id_pembelian'				=> $id_pembelian,
					'id_cara_pembayaran_bhn'	=> $id_cara_pembayaran_bhn,
					'jumlah_bayar'    			=> $dibayar,
					'dp_type'					=> '1',
					'active'					=> '1'
				);
			
				$this->model_beli->delete_pembayaran($id_pembelian);
				$this->model_beli->add_beli_bayar($data_input_bayar);
			}
			
			$data_input = array(
				'id_pembelian'				=> $id_pembelian,
				'tgl_pembelian'				=> $tgl_pembelian,
				'tgl_jatuh_tempo'			=> $tgl_jatuh_tempo,
				'id_cara_pembayaran'		=> $id_cara_pembayaran_bhn,
				'jumlah_bayar'          	=> $dibayar,
				'total_pembelian'          	=> $total_harga,
				'active'					=> '1'
			);
			$this->model_beli->update_beli($data_input);
			
			$this->model_beli->delete_beli_detail($id_pembelian);
			$no=0;
			foreach($id_bhn_baku as $result)
			{
				$data = array(
					'id_detail_pembelian'	=> $this->model_beli->generate_id_detail_pembelian(),
					'id_pembelian'			=> $id_pembelian,
					'id_bhn_baku'			=> $result,
					'id_supplier' 			=> $id_supplier[$no],
					'quantity' 				=> $quantity[$no],
					'total_harga' 			=> $total_per_barang[$no],
					'active'				=> '1'
				);
				if($result!="")
					$this->model_beli->add_beli_detail($data);
				$no++;
			}
			
			$date1 = date('Y').'-'.date('m').'-1';
			$date=date('Y-m-d');
			$mydata = array(
				'notification'		=> $notif,
				'form'				=> 'produksi/beli/beli_bahan',
				'add'				=> '<li><div class="add_item"><a href="'.site_url("produksi/beli/akses_beli/beli_form").'">Tambah Pembelian</a></div></li>',
				'active_menu'		=> 'class="active_beli_daftar"',
				'active_menus'		=> 'id="active_menus_pembelian"',
				'menu'				=> 'beli_daftar',
				'page'				=> 'beli_page',
				'date1'				=> $date1,
				'date'       		=> $date,
				'list'				=> $this->model_beli->view_pembelian($date1, $date),
				'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar()
			);
			
			$this->load->view('mainpage', $mydata);
		}
		else
		{
			$this->session->set_userdata('message', 'Pengisian Data Barang belum lengkap');
			$this->find_pembelian_detail($id_pembelian);
		}
	}
	
	function add_bayar()
	{
		$id_pembelian			= $this->input->post('id_pembelian');
		$tgl					= explode('/',$this->input->post('tgl_pembayaran'));
		$tgl_pembayaran			= $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
		$id_cara_pembayaran_bhn	= $this->input->post('id_cara_pembayaran_bhn');
		$dibayar				= $this->input->post('dibayar');
		
		$cek = 1;
		if($id_cara_pembayaran_bhn == '0')
		{
			$this->session->set_userdata('message_cara_bayar', 'Field Cara Pembayaran Belum Dipilih');
			$cek = 0;
		}
		if($dibayar == 0)
		{
			$this->session->set_userdata('message_dibayar', 'Field Dibayar Belum Diisi');
			$cek = 0;
		}
		
		if($cek == 1)
		{
			$id_pembayaran_bhn = $this->model_beli->generate_id_pembayaran_bhn();
			$data_input_bayar = array(
				'id_pembayaran_bhn'			=> $id_pembayaran_bhn,
				'tgl_pembayaran'			=> $tgl_pembayaran,
				'id_pembelian'				=> $id_pembelian,
				'id_cara_pembayaran_bhn'	=> $id_cara_pembayaran_bhn,
				'jumlah_bayar'    			=> $dibayar,
				'dp_type'					=> '0',
				'active'					=> '1'
			);
			$this->model_beli->add_beli_bayar($data_input_bayar);
		}
		$this->find_pembayaran_detail($id_pembelian);
	}
	
	function hapus_pembayaran($id_pembayaran_bhn)
	{
		$data_pembayaran = $this->model_beli->viem_selected_pembayaran($id_pembayaran_bhn)->result_array();
		
		$mydata = array(
			'id_pembayaran_bhn'	=> $id_pembayaran_bhn,
			'active'		=> '0'
		);
		if($data_pembayaran[0]['dp_type'] == 1)
		{
			$sendData = array(
				'id_pembelian'			=> $data_pembayaran[0]['id_pembelian'],
				'id_cara_pembayaran'	=> 0,
				'jumlah_bayar'			=> 0,
			);
			$this->model_beli->update_beli($sendData);
			$this->model_beli->inactive_pembayaran_beli_spesifik($mydata);
		}
		else
			$this->model_beli->inactive_pembayaran_beli_spesifik($mydata);
			
		$this->find_pembayaran_detail($data_pembayaran[0]['id_pembelian']);
	}
	
	function find_pembelian_detail($id_pembelian)
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$data_pembelian1 = $this->model_beli->view_pembelian_spesifik($id_pembelian)->result_array();
		$data_pembelian2 = $this->model_beli->view_pembelian_detail_spesifik($id_pembelian)->result_array();
		
		$add = '<li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" /></li>';
		$menu = 'beli_form';
		$date = date('Y-m-d');
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/beli/edit_beli',
			'add'				=> $add,
			'active_menu'		=> 'class="active_beli_form"',
			'active_menus'		=> 'id="active_menus_pembelian"',
			'menu'				=> $menu,
			'page'				=> 'beli_page',
            'date'       		=> $date,
			'list'				=> '',
			'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar(),
			'detail_head'		=> $data_pembelian1,
			'detail_list'		=> $data_pembelian2
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function find_pembayaran_detail($id_pembelian)
	{
		$cek_stok = get_stok_minimal();
		if($cek_stok > 0)
			$notif = view_stok_minimal();
		else
			$notif = '';
		
		$data_pembelian = $this->model_beli->view_pembelian_spesifik($id_pembelian)->result_array();
		$data_pembayaran = $this->model_beli->view_pembayaran_detail_spesifik($id_pembelian)->result_array();
		
		$add = '<li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" /></li>';
		$menu = 'beli_bayar';
		$date = date('Y-m-d');
		
		$mydata = array(
			'notification'		=> $notif,
			'form'				=> 'produksi/beli/add_bayar',
			'add'				=> $add,
			'active_menu'		=> 'class="active_beli_bayar"',
			'active_menus'		=> 'id="active_menus_pembelian"',
			'menu'				=> $menu,
			'page'				=> 'beli_page',
            'date'       		=> $date,
			'list'				=> '',
			'list_cara_bayar'	=> $this->model_cara_pembayaran_bhn->select_cara_bayar(),
			'detail_head'		=> $data_pembelian,
			'detail_list'		=> $data_pembayaran
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function find_beli()
	{
		$id_pembelian = $this->input->post('id_pembelian');
		$data_pembelian = $this->model_beli->view_pembelian_spesifik($id_pembelian);
		
		foreach($data_pembelian->result_array() as $row)
		{
			$load_data = $row['id_pembelian'].",".
						 explode_date($row['tgl_pembelian'],1).",".
						 explode_date($row['tgl_jatuh_tempo'],1).",".
						 $row['id_cara_pembayaran'].",".
						 $row['jumlah_bayar'].",".
						 $row['total_pembelian'];
		}
		
		echo $load_data;
	}
	
	function find_beli_detail()
	{
		$id_pembelian = $this->input->post('id_pembelian');
		$data_pembelian = $this->model_beli->view_pembelian_detail_spesifik($id_pembelian);
		
		$loop='';$no=0;$load_data='';
		foreach($data_pembelian->result_array() as $row)
		{
			if($no>0)
				$loop ='___';
			$load_data .= $loop.$row['id_detail_pembelian'].",".
						 $row['id_bhn_baku'].",".
						 $row['id_supplier'].",".
						 $row['nama_bhn_baku'].",".
						 $row['nama_supplier'].",".
						 $row['telepon_1'].",".
						 $row['no_rekening'].",".
						 $row['harga_bhn_baku'].",".
						 round($row['quantity']).",".
						 $row['total_harga'];
			$no++;
		}
		
		echo $load_data;
	}
	
	function find_beli_detail2()
	{
		$id_pembelian = $this->input->post('id_pembelian');
		$data_pembelian = $this->model_beli->view_pembelian_detail_spesifik($id_pembelian);
		
		$load_data='<tr>
						<td class="labels_dpo">Nama Barang</td>
						<td class="labels_dpo">Supplier</td>
						<td class="labels_dpo">Telepon</td>
						<td class="labels_dpo">No. Rekening</td>
						<td class="labels_dpo">Harga Barang</td>
						<td class="labels_dpo">Quantity</td>
						<td class="labels_dpo">Total Per Barang</td>
					</tr>';
		$jml_pesan = 0;
		foreach($data_pembelian->result_array() as $beli)
		{
			$load_data .= '<tr>
								<td class="labelss_dpo">'.$beli['nama_bhn_baku'].'</td>
								<td class="labelss_dpo">'.$beli['nama_supplier'].'</td>
								<td class="labelss_dpo">'.$beli['telepon_1'].'</td>
								<td class="labelss_dpo">'.$beli['no_rekening'].'</td>
								<td class="labelss_dpo">'.currency_format($beli['harga_bhn_baku'],0).'</td>
								<td class="labelss_dpo">'.round($beli['quantity']).'</td>
								<td class="labelss_dpo">'.currency_format($beli['total_harga'],0).'</td>
						   </tr>';
			$jml_pesan = $jml_pesan + $beli['quantity'];
		}
		$load_data .= '<tr><td class="labelss_dpo">Total Pembelian</td><td class="labelss_dpo">'.$jml_pesan.'</td>';
		
		echo $load_data;
	}
	
	function hapus_beli()
	{
		$id_pembelian = $this->input->post('id_pembelian');
		
		$mydata = array(
			'id_pembelian'	=> $id_pembelian,
			'active'		=> '0'
		);
		$data_pembelian1 = $this->model_beli->inactive_beli($mydata);
		$data_pembelian2 = $this->model_beli->inactive_detail_beli($mydata);
		$data_pembelian3 = $this->model_beli->inactive_pembayaran_beli($mydata);
	}
	
	function find_supplier()
	{
		$id_bhn_baku = $this->input->post('id_bhn_baku');
		$array = $this->input->post('array');
		$data_supplier = $this->model_bahan_baku->find_bahan_baku_detail($id_bhn_baku);
		
		$load_data = '<tr>
						<td class="labels_dpo">Nama Supplier</td>
						<td class="labels_dpo">Alamat</td>
						<td class="labels_dpo">Contact Person</td>
						<td class="labels_dpo">Telepon 1</td>
						<td class="labels_dpo">Telepon 2</td>
						<td class="labels_dpo">No Rekening</td>
						<td class="labels_dpo">Keterangan</td>
						<td class="labels_dpo">Harga Bahan</td>
						<td class="labels_dpo">Pilih</td>
					  </tr>';
		
		foreach($data_supplier->result_array() as $row)
		{
			$mydata = $row['id_supplier'].'_'.$array;
			$load_data .= '<tr>
							<td class="labelss_dpo">'.$row['nama_supplier'].'</td>
							<td class="labelss_dpo">'.$row['alamat'].'</td>
							<td class="labelss_dpo">'.$row['contact_person'].'</td>
							<td class="labelss_dpo">'.$row['telepon_1'].'</td>
							<td class="labelss_dpo">'.$row['telepon_2'].'</td>
							<td class="labelss_dpo">'.$row['no_rekening'].'</td>
							<td class="labelss_dpo">'.$row['keterangan_supplier'].'</td>
							<td class="labelss_dpo">'.currency_format($row['harga_bahan'],0).'</td>
							<td class="labelss_dpo" style="text-align:center">
								<span style="display:block" id="pilih_supplier" onclick=pilih_supplier("'.$mydata.'")>
									<a href="javascript:void(0)">PILIH<span style="display:none" >'.$row['id_supplier'].'_'.$array.'</span></a>
								</span>
							</td>
						   </tr>';
		}
		
		echo $load_data;
	}
	
	function find_supplier_spesifik()
	{
		$array = $this->input->post('array');
		$data = array(
			'id_bhn_baku'	=> $this->input->post('id_bhn_baku'),
			'id_supplier'	=> $this->input->post('id_supplier')
		);
		
		$supplier_data = $this->model_bahan_baku->find_bahan_baku_detail_spesifik($data);
		foreach($supplier_data->result_array() as $row)
		{
			$load_data = $array.",".
						 $row['id_supplier'].",".
						 $row['nama_supplier'].",".
						 $row['telepon_1'].",".
						 $row['no_rekening'].",".
						 $row['harga_bahan'];
		}
		
		echo $load_data;
	}

	function cetak_beli($data =""){
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

        $mydata = array(
            'title'				=> 'Laporan Pembelian',
            'date1'				=> $date1,
            'date'       		=> $date,
            'list'				=> $this->model_beli->view_pembelian_list($date1, $date),
        );
        $this->load->library('fpdf');
        $this->load->view('produksi/laporan_pembelian.php',$mydata);
    }
}
?>