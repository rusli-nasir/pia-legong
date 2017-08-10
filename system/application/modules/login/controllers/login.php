<?php 
class login extends Controller
{
	function login()
	{
		parent::Controller();
		$this->load->model('model_login');
		$this->load->model('model_user');
	}
    
    function index($msg="")
    {
		$mydata = array(
			'form'		=> 'login/login/cek_login',
			'page'		=> 'login',
			'msg'		=> $msg
		);
		
        $this->load->view('mainpage_login', $mydata);
    }
	
	function blank()
	{
		$status = get_status_user();
		$mydata = array(
			'form'				=> '',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> '',
			'active_menus'		=> '',
            'tab'               => '',
			'page'			    => 'blank',
			'menu'			    => '',
			'form_bayar'		=> '',
			'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function cek_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$data_login = $this->model_login->cek_login($username,$password);
		if(count($data_login)>0)
		{
			$this->session->set_userdata('id_user',''.$data_login[0]['id_user'].'');
			//echo base_url().'index.php/inventory/barang/';
			redirect(base_url().'index.php/inventory/barang/');
		}
		else
		{
			//echo base_url().'index.php/login/login/';
			redirect(base_url().'index.php/login/login/');
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		echo base_url().'index.php/login/login/';
	}
}
?>