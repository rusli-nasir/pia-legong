<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('get_stok_minimal'))
	{
		function get_stok_minimal()
		{
			$CI = & get_instance();
			$CI->load->model('produksi/model_stok_bahan');
			
			$data_stok = $CI->model_stok_bahan->view_all_bahan_baku();
			$cek = 0;
			foreach($data_stok->result_array() as $row)
			{
				if($row['sisa_stok'] < $row['stok_minimum'])
					$cek++;
			}
			
			return $cek;
		}
	}
	
	if ( ! function_exists('view_stok_minimal'))
	{
		function view_stok_minimal()
		{
			$CI = & get_instance();
			$CI->load->model('produksi/model_stok_bahan');
			
			$data_stok = $CI->model_stok_bahan->view_all_bahan_baku();
			$id_bahan = array();
			$nama_bahan = array();
			$stok = array();
			$satuan = array();
			$cek = 0;
			foreach($data_stok->result_array() as $row)
			{
				if($row['sisa_stok'] < $row['stok_minimum'])
				{
					$id_bahan[$cek] = $row['id_bhn_baku'];
					$nama_bahan[$cek] = $row['nama_bhn_baku'];
					$stok[$cek] = $row['sisa_stok'];
					$satuan[$cek] = $row['nama_satuan'];
					$cek++;
				}
			}
			
			$mydata = array(
				'bahan_baku'		=> $id_bahan,
				'nama_bahan_baku'	=> $nama_bahan,
				'stok_kurang'		=> $stok,
				'satuan_barang'		=> $satuan

			);
			
			return $mydata;
		}
	}
?>