<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('explode_date'))
{
	/**
	 * @param $tgl
	 * @param $action
	 *
	 * @return string
	 */
	function explode_date($tgl, $action)
	{
		if($action == 0)
		{
			$arrtgl = explode('/',$tgl);
			$date   = $arrtgl[2].'-'.$arrtgl[1].'-'.$arrtgl[0];
		}
		else
		{
			$arrtgl = explode('-',$tgl);
			$date   = $arrtgl[2].'/'.$arrtgl[1].'/'.$arrtgl[0];
		}

		return $date;
	}
}

if ( ! function_exists('array_jenis_pesanan'))
{

	/**
	 * @property $CI
	 */
	function array_jenis_pesanan()
	{
		$CI = & get_instance();
		$data = $CI->db->query("SELECT * FROM tb_jenis_pesanan")->result();
		$arrData ['']= '-- Pilih Jenis Pemesanan Via --';
		if($data){
			foreach ($data as $row){
				$arrData[$row->id_jenis_pesanan] = $row->jenis_pesanan;
			}
		}
		return $arrData;
	}
}

if ( ! function_exists('get_jenis_pesanan'))
{

	/**
	 * @property $CI
	 */
	function get_jenis_pesanan($id)
	{
		$CI = & get_instance();
		$data = $CI->db->query("SELECT * FROM tb_jenis_pesanan WHERE id_jenis_pesanan = '$id'")->row();
		if($data){
			return $data->jenis_pesanan;
		}else{
			return "Tidak terdata";
		}
	}
}
?>