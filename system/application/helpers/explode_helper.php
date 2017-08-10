<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('explode_date'))
	{
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
?>