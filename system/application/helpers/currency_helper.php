<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('currency_format'))
	{
		function currency_format($value,$currency = 'Rp')
		{
			$result = number_format($value,2,',','.');
			$result = trim($result);
			return $result;
		}	
	}
?>