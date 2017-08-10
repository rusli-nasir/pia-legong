<?php 
class User extends Controller
{
	function User()
	{
		parent::Controller();
		$this->load->model('model_user');
		$this->load->model('model_propinsi');
		val_url();
	}
    
    function index()
    {
		$status = get_status_user();
		
		$leveluser = $this->session->userdata('level_user');
		if($leveluser > 1)
		{
			$form 		= 'login/user/add_user';
			$menu 		= 'form_user';
			$list		= $this->model_user->view_all_user($leveluser);
			$other_list	= $this->model_user->view_all_karyawan();
		}
		else
		{
			$form 		= 'login/user/add_jabatan';
			$menu 		= 'jabatan_daftar';
			$list		= $this->model_user->view_all_jabatan();
			$other_list	= $this->model_user->view_all_jabatan();
		}
		
		$load_data = array(
			'form'				=> $form,
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_user_master"',
			'active_menus'		=> 'id="active_menus_master"',
			'tab'               => 'akses_user/jabatan_daftar',
			'tab_user'          => 'form_user',
			'controller'		=> 'user',
			'page'				=> 'user_page',
			'menu'			    => $menu,
			'list'				=> $list,
			'other_list'		=> $other_list,
			'list_propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$load_data);
    }
	
	function akses_user($ambil_data)
	{
		$leveluser	= $this->session->userdata('level_user');
		
		if($ambil_data == 'jabatan_daftar')
		{
			$form		= 'login/user/add_jabatan';
			$simpan 	= 'class="disable" disabled="disabled"';
			$edit		= 'class="disable" disabled="disabled"';
			$batal		= 'class="disable" disabled="disabled"';
			$cetak		= 'class="disable" disabled="disabled"';
			$list		= $this->model_user->view_all_jabatan();
			$other_list	= $this->model_user->view_all_jabatan();
		}
		elseif($ambil_data == 'karyawan_daftar')
		{
			$form		= 'login/user/add_karyawan';
			$simpan 	= 'class="disable" disabled="disabled"';
			$edit		= 'class="disable" disabled="disabled"';
			$batal		= 'class="disable" disabled="disabled"';
			$cetak		= 'class="disable" disabled="disabled"';
			$list		= $this->model_user->view_all_karyawan();
			$other_list	= $this->model_user->view_all_jabatan();
		}
		elseif($ambil_data == 'form_user')
		{
			$form		= 'login/user/add_user';
			$simpan 	= 'class="disable" disabled="disabled"';
			$edit		= 'class="disable" disabled="disabled"';
			$batal		= 'class="disable" disabled="disabled"';
			$cetak		= 'class="disable" disabled="disabled"';
			$list		= $this->model_user->view_all_user($leveluser);
			$other_list	= $this->model_user->view_all_karyawan();
		}
		elseif($ambil_data == 'user_menu')
		{
			$form		= 'login/user/add_permission';
			$simpan 	= '';
			$edit		= 'class="disable" disabled="disabled"';
			$batal		= 'class="disable" disabled="disabled"';
			$cetak		= 'class="disable" disabled="disabled"';
			$list		= ''; //$this->model_user->view_all_user($leveluser);
			$other_list	= ''; //$this->model_user->view_all_karyawan();
		}
		
		$get_status_user = get_status_user();
		$mydata = array(
			'form'				=> $form,
			'simpan'			=> $simpan,
			'edit'				=> $edit,
			'batal'				=> $batal,
			'cetak'				=> $cetak,
			'active_menu'		=> 'class="active_'.$ambil_data.'"',
            'tab'               => 'akses_user/jabatan_daftar',
			'tab_user'          => 'form_user',
			'active_menus'		=> 'id="active_menus_master"',
			'page'			    => 'user_page',
			'menu'              => $ambil_data,
			'list'				=> $list,
			'other_list'		=> $other_list,
			'list_propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'status'			=> $this->status_null(),
			'user_status'		=> $get_status_user
		);
        $this->load->view('mainpage',$mydata);
	}
	
	function add_jabatan()
	{
		$data = array(
			'id_jabatan'	=> $this->model_user->generate_id_jabatan(),
			'nama_jabatan'	=> $this->input->post('nama_jabatan'),
			'keterangan'	=> $this->input->post('keterangan'),
			'active'		=> '1'
		);
		$this->model_user->insert_jabatan($data);
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'jabatan_daftar',
			'list'			=> $this->model_user->view_all_jabatan()
		);
		
		echo base_url().'index.php/login/user';
	}
	
	function edit_jabatan()
	{
		$data = array(
			'id_jabatan'	=> $this->input->post('id_jabatan'),
			'nama_jabatan'	=> $this->input->post('nama_jabatan'),
			'keterangan'	=> $this->input->post('keterangan'),
			'active'		=> '1'
		);
		$this->model_user->update_jabatan($data);
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'jabatan_daftar',
			'list'			=> $this->model_user->view_all_jabatan()
		);
		
		echo base_url().'index.php/login/user';
	}
	
	function hapus_jabatan()
	{
		$id_jabatan = $this->input->post('id_jabatan');
		
		$this->model_user->delete_jabatan($id_jabatan);
		
		echo base_url().'index.php/login/user';
	}
	
	function find_jabatan()
	{
		$id_jabatan = $this->input->post('id_jabatan');
		$getdata = array(
			'data'	=> $this->model_user->find_jabatan($id_jabatan)
		);
		
		foreach($getdata['data']->result_array() as $jabatan)
		{
			$load_data = $jabatan['id_jabatan'].",".
						 $jabatan['nama_jabatan'].",".
						 $jabatan['keterangan'];
		}
		
		echo $load_data;
	}
	
	//=============================== Untuk Karyawan ===============================
	function add_karyawan()
	{
		$data = array(
			'id_karyawan'		=> $this->model_user->generate_id_karyawan(),
			'nama_karyawan'		=> $this->input->post('nama_karyawan'),
			'jenis_kelamin'		=> $this->input->post('jenis_kelamin'),
			'alamat'			=> $this->input->post('alamat'),
			'id_propinsi'		=> $this->input->post('id_propinsi'),
			'telepon'			=> $this->input->post('telepon'),
			'hp'				=> $this->input->post('hp'),
			'agama'				=> $this->input->post('agama'),
			'status_perkawinan'	=> $this->input->post('status_perkawinan'),
			'id_jabatan'		=> $this->input->post('id_jabatan'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_user->insert_karyawan($data);
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'karyawan_daftar',
			'list'			=> $this->model_user->view_all_karyawan()
		);
		
		echo base_url().'index.php/login/user/akses_user/karyawan_daftar';
	}
	
	function edit_karyawan()
	{
		$data = array(
			'id_karyawan'		=> $this->input->post('id_karyawan'),
			'nama_karyawan'		=> $this->input->post('nama_karyawan'),
			'jenis_kelamin'		=> $this->input->post('jenis_kelamin'),
			'alamat'			=> $this->input->post('alamat'),
			'id_propinsi'		=> $this->input->post('id_propinsi'),
			'telepon'			=> $this->input->post('telepon'),
			'hp'				=> $this->input->post('hp'),
			'agama'				=> $this->input->post('agama'),
			'status_perkawinan'	=> $this->input->post('status_perkawinan'),
			'id_jabatan'		=> $this->input->post('id_jabatan'),
			'keterangan'		=> $this->input->post('keterangan'),
			'active'			=> '1'
		);
		$this->model_user->update_karyawan($data);
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'karyawan_daftar',
			'list'			=> $this->model_user->view_all_karyawan()
		);
		
		echo base_url().'index.php/login/user/akses_user/karyawan_daftar';
	}
	
	function hapus_karyawan()
	{
		$id_karyawan = $this->input->post('id_karyawan');
		
		$this->model_user->delete_karyawan($id_karyawan);
		
		echo base_url().'index.php/login/user/akses_user/karyawan_daftar';
	}
	
	function find_karyawan()
	{
		$id_karyawan = $this->input->post('id_karyawan');
		$getdata = array(
			'data'	=> $this->model_user->find_karyawan($id_karyawan)
		);
		
		foreach($getdata['data']->result_array() as $karyawan)
		{
			$load_data = $karyawan['id_karyawan'].",".
						 $karyawan['nama_karyawan'].",".
						 $karyawan['agama'].",".
						 $karyawan['status_perkawinan'].",".
						 $karyawan['jenis_kelamin'].",".
						 $karyawan['id_jabatan'].",".
						 $karyawan['id_propinsi'].",".
						 $karyawan['alamat'].",".
						 $karyawan['telepon'].",".
						 $karyawan['hp'].",".
						 $karyawan['keterangan'];
		}
		
		echo $load_data;
	}
	
	function find_all_karyawan()
	{
		$data_namalogin = $this->model_user->get_name_user();
		$search = '';
		foreach($data_namalogin as $result)
		{
			$search .="and a.id_karyawan<>'".$result['id_karyawan']."' ";
		}
		$data = $this->model_user->get_name_view($search);
		
		$mydata = array();
		foreach($data->result_array() as $row)
		{
			$mydata[] = $row;
		}
		
		echo json_encode($mydata);
	}
	
	//=============================== Untuk User ===============================
	function add_user()
	{
		$nama_user	= $this->input->post('nama_user');
		$username	= $this->session->set_userdata('username_login', $nama_user);
		$leveluser	= $this->session->userdata('level_user');
		
		$data = array(
			'id_karyawan'	=> $this->input->post('id_karyawan'),
			'username'		=> $nama_user,
			'password_user'	=> $this->input->post('pass'),
			'level'			=> $this->input->post('level'),
			'active'		=> '1'
		);
		$this->model_user->insert_user($data);
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'form_user',
			'list'			=> $this->model_user->view_all_user($leveluser)
		);
		
		echo base_url().'index.php/login/user/akses_user/form_user';
	}
	
	function edit_user()
	{
		$id_user	= $this->input->post('id_user');
		$this->session->set_userdata('iduser_login', $id_user);
		$leveluser	= $this->session->userdata('level_user');
		
		$data = array(
			'id_user'		=> $id_user,
			'id_karyawan'	=> $this->input->post('id_karyawan'),
			'username'		=> $this->input->post('nama_user'),
			'password_user'	=> $this->input->post('pass'),
			'level'			=> $this->input->post('level'),
			'active'		=> '1'
		);
		$this->model_user->update_user($data);
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'form_user',
			'list'			=> $this->model_user->view_all_user($leveluser)
		);
		
		echo base_url().'index.php/login/user/index_menu';
	}
	
	function go_user_management()
	{
		$id_user	= $this->input->post('id_user');
		$this->session->set_userdata('iduser_login', $id_user);
		$leveluser	= $this->session->userdata('level_user');
		
		$load_data = array(
			'controller'	=> 'user',
			'page'			=> 'form_user',
			'list'			=> $this->model_user->view_all_user($leveluser)
		);
		
		echo base_url().'index.php/login/user/index_menu';
	}
	
	function hapus_user()
	{
		$id_user = $this->input->post('id_user');
		$this->model_user->delete_user($id_user);
		
		echo base_url().'index.php/login/user/akses_user/form_user';
	}
	
	function find_user()
	{
		$id_user = $this->input->post('id_user');
		$getdata = array(
			'data'	=> $this->model_user->find_user($id_user)
		);
		
		foreach($getdata['data']->result_array() as $user)
		{
			$load_data = $user['id_user'].",".
						 $user['username'].",".
						 $user['id_karyawan'].",".
						 $user['nama_karyawan'].",".
						 $user['level'].",".
						 $user['password_user'];
		}
		
		echo $load_data;
	}
	
	//=============================== Untuk Menu ===============================
	function add_permission()
	{
		$get_username	= $this->session->userdata('username_login');
		$find_id_user	= $this->model_user->get_username($get_username);
		foreach($find_id_user->result_array() as $user)
		{
			$id_user = $user['id_user'];
		}
		$leveluser	= $this->session->userdata('level_user');
		
		//=================================== Untuk Inventory ===================================
		// Master
		$menu[1] 	= $this->input->post('barang');
		$menu[2]	= $this->input->post('satuan_barang');
		$menu[3] 	= $this->input->post('supplier');
		$menu[4] 	= $this->input->post('customer');
		$menu[5] 	= $this->input->post('user');
		// Purchase Order
		$menu[6] 	= $this->input->post('purchase_order');
		// Pembelian Barang
		$menu[7] 	= $this->input->post('pembelian_barang');
		$menu[8] 	= $this->input->post('pembayaran_pembelian');
		// Penjualan Barang
		$menu[9] 	= $this->input->post('penjualan_barang');
		$menu[10] 	= $this->input->post('pembayaran_penjualan');
		// Stock Barang
		$menu[11] 	= $this->input->post('stok_barang');
		// Laporan Inventory
		$menu[12] 	= $this->input->post('laporan_pembelian');
		$menu[13] 	= $this->input->post('laporan_penjualan');
		
		//=================================== Untuk Accounting ===================================
		// Pajak
		$menu[14] 	= $this->input->post('pajak');
		// Daftar COA
		$menu[15] 	= $this->input->post('daftar_coa');
		// Transaksi Jurnal
		$menu[16] 	= $this->input->post('transaksi_jurnal');
		// Laporan Kuangan
		$menu[17] 	= $this->input->post('laporan_jurnal');
		$menu[18] 	= $this->input->post('laporan_neraca');
		$menu[19] 	= $this->input->post('laporan_rugi_laba');
		
		$this->model_user->insert_permission($id_user, $menu);
		
		$get_status_user = get_status_user();
		$mydata = array(
			'form'				=> 'login/user/add_user',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_form_user"',
			'active_menus'		=> 'id="active_menus_master"',
            'tab'               => 'akses_user/jabatan_daftar',
			'tab_user'          => 'form_user',
			'page'			    => 'user_page',
			'menu'              => 'form_user',
			'list'				=> $this->model_user->view_all_user($leveluser),
			'other_list'		=> $this->model_user->view_all_karyawan(),
			'list_propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'user_status'		=> $get_status_user
		);
        $this->load->view('mainpage',$mydata);
	}
	
	function edit_permission()
	{
		$get_id_user	= $this->session->userdata('iduser_login');
		$leveluser	= $this->session->userdata('level_user');
		
		//=================================== Untuk Inventory ===================================
		// Master
		$menu[1] 	= $this->input->post('barang');
		$menu[2]	= $this->input->post('satuan_barang');
		$menu[3] 	= $this->input->post('supplier');
		$menu[4] 	= $this->input->post('customer');
		$menu[5] 	= $this->input->post('user');
		// Purchase Order
		$menu[6] 	= $this->input->post('purchase_order');
		// Pembelian Barang
		$menu[7] 	= $this->input->post('pembelian_barang');
		$menu[8] 	= $this->input->post('pembayaran_pembelian');
		// Penjualan Barang
		$menu[9] 	= $this->input->post('penjualan_barang');
		$menu[10] 	= $this->input->post('pembayaran_penjualan');
		// Stock Barang
		$menu[11] 	= $this->input->post('stok_barang');
		// Laporan
		$menu[12] 	= $this->input->post('laporan_pembelian');
		$menu[13] 	= $this->input->post('laporan_penjualan');
		
		//=================================== Untuk Accounting ===================================
		// Pajak
		$menu[14] 	= $this->input->post('pajak');
		// Daftar COA
		$menu[15] 	= $this->input->post('daftar_coa');
		// Transaksi Jurnal
		$menu[16] 	= $this->input->post('transaksi_jurnal');
		// Laporan Kuangan
		$menu[17] 	= $this->input->post('laporan_jurnal');
		$menu[18] 	= $this->input->post('laporan_neraca');
		$menu[19] 	= $this->input->post('laporan_rugi_laba');
		
		$this->model_user->update_permission($get_id_user, $menu);
		
		$get_status_user = get_status_user();
		$mydata = array(
			'form'				=> 'login/user/add_user',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_form_user"',
			'active_menus'		=> 'id="active_menus_master"',
            'tab'               => 'akses_user/jabatan_daftar',
			'tab_user'          => 'form_user',
			'page'			    => 'user_page',
			'menu'              => 'form_user',
			'list'				=> $this->model_user->view_all_user($leveluser),
			'other_list'		=> $this->model_user->view_all_karyawan(),
			'list_propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'user_status'		=> $get_status_user
		);
        $this->load->view('mainpage',$mydata);
	}
	
	function hapus_permission()
	{
		$id_user = $this->input->post('id_user');
		$this->model_user->delete_user($id_user);
		
		echo base_url().'index.php/login/user/akses_user/form_user';
	}
	
	function find_permission()
	{
		$id_user = $this->input->post('id_user');
		$getdata = array(
			'data'	=> $this->model_user->find_user($id_user)
		);
		
		foreach($getdata['data']->result_array() as $user)
		{
			$load_data = $user['id_user'].",".
						 $user['username'].",".
						 $user['id_karyawan'].",".
						 $user['nama_karyawan'].",".
						 $user['level'].",".
						 $user['password_user'];
		}
		
		echo $load_data;
	}
	
	function get_status()
	{
		$get_id_user	= $this->session->userdata('iduser_login');		//Ambil Session
		$jml_menu		= $this->model_user->count_menu();
		for($i=1; $i<=$jml_menu; $i++)
		{
			$status[$i] = 0;
		}
		$permission = $this->model_user->get_status_permission($get_id_user);
		$no = 1;
		foreach($permission as $row)
		{
			$status[$no] = $row['status'];
			$no++;
		}
	}
	
	function index_menu()
	{
		$get_id_user	= $this->session->userdata('iduser_login');		//Ambil Session
		
		$leveluser		= $this->session->userdata('level_user');
		$jml_menu		= $this->model_user->count_menu();
		for($i=1; $i<=$jml_menu; $i++)
		{
			$status[$i] = 0;
		}
		$permission = $this->model_user->get_status_permission($get_id_user);
		$no = 1;
		foreach($permission as $row)
		{
			$status[$no] = $row['status'];
			$no++;
		}
		
		$get_status_user = get_status_user();
		$edit='class="disable" disabled="disabled"';
		if($get_status_user[4]['status']==2)
		{
			$edit='';
		}
		$mydata = array(
			'form'				=> 'login/user/edit_permission',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> $edit,
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_form_user"',
            'tab'               => 'akses_user/jabatan_daftar',
			'active_menus'		=> 'id="active_menus_master"',
			'tab_user'          => 'form_user',
			'page'			    => 'user_page',
			'menu'              => 'user_menu',
			'status'			=> $status,
			'list'				=> $this->model_user->view_all_user($leveluser),
			'other_list'		=> $this->model_user->view_all_karyawan(),
			'list_propinsi'		=> $this->model_propinsi->view_all_propinsi(),
			'user_status'		=> $get_status_user
		);
        $this->load->view('mainpage',$mydata);
	}
	
	function status_null()
	{
		$jml_menu		= $this->model_user->count_menu();
		for($i=1; $i<=$jml_menu; $i++)
		{
			$status_empty[$i] = 0;
		}
		
		return $status_empty;
	}

	function backup_system()
	{
		$this->load->helper('download');
		$dbhost   = "localhost";
		$dbuser   = "root";
		$dbpwd    = "";
		$dbname   = "db_pia_legong";
		$dumpfile = $dbname . "_" .date("Y-m-d_H-i-s"). ".sql";
		
		//linux punya : exec("/usr/bin/mysqldump --opt --host=$dbhost --user=$dbuser --password=$dbpwd $dbname > /var/www/apps/printing/backup/$dumpfile");
		exec("D:/PIALEGONG/mysql/bin/mysqldump --opt --host=$dbhost --user=$dbuser --password=$dbpwd $dbname > D:/PIALEGONG/htdocs/pia_legong/backup/$dumpfile");
		
		// report - disable with // if not needed
		// must look like "-- Dump completed on ..." 
		
		//echo "$dumpfile "; passthru("tail -1 $dumpfile");
		
		$data = file_get_contents("D:/PIALEGONG/htdocs/pia_legong/backup/".$dumpfile); // Read the file's contents
		$name = $dumpfile;
		
		force_download($name, $data);
	}
}
?>