<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('get_status_user'))
	{
		function get_status_user()
		{
			$CI = & get_instance();
			$CI->load->model('inventory/model_user');
			
			$data['id_user'] = $CI->session->userdata('id_user');
			$status = $CI->model_user->get_status_user($data);
			return $status;
		}
	}
?>