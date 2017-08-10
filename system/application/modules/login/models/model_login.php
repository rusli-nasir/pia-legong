<?php
class Model_login extends Model
{
	function Model_login()
	{
		parent::Model();
	}
	
	function cek_login($username,$password)
	{
	   //$query = $this->db->query("select a.id_user from tb_user as a where a.active=1 and a.password_user='".md5($password)."' and a.username='".$username."'");   
	   $query = $this->db->query("select a.id_user from tb_user as a where a.active=1 and a.username='".$username."'");   
	   return $query->result_array();
	}
}
?>