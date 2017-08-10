<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('val_url'))
	{
		function val_url()
		{
			$CI = & get_instance();
			
			$data['id_user'] = $CI->session->userdata('id_user');
			if($data['id_user']=="")
				redirect(''.base_url().'index.php/login/login/');
		}
	}
?>