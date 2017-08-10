<?php
class Model_user extends Model
{
	function Model_user()
	{
		parent::Model();
	}
	
	function generate_id_jabatan()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_jabatan FROM tb_jabatan WHERE id_jabatan LIKE '%".$yearmonth."%' ORDER BY id_jabatan DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_jabatan'];
       }
       
       if($hasil == 0)
       {
            $id_jabatan = 'JBT'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_jabatan = 'JBT'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_jabatan;
	}
	
	function generate_id_karyawan()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_karyawan FROM tb_karyawan WHERE id_karyawan LIKE '%".$yearmonth."%' ORDER BY id_karyawan DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_karyawan'];
       }
       
       if($hasil == 0)
       {
            $id_karyawan = 'KRY'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_karyawan = 'KRY'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_karyawan;
	}
	
	function view_all_jabatan()
	{
		$result = $this->db->query("SELECT id_jabatan, nama_jabatan, keterangan, active FROM tb_jabatan WHERE active=1 ORDER BY nama_jabatan ASC");
		return $result;
	}
	
	function view_all_karyawan()
	{
		$result = $this->db->query("SELECT a.id_karyawan, a.nama_karyawan, a.jenis_kelamin, a.alamat, a.id_propinsi, a.telepon, a.hp, a.agama, a.status_perkawinan, a.id_jabatan, a.keterangan, a.active, b.nama_propinsi, c.nama_jabatan FROM tb_karyawan a LEFT JOIN tb_propinsi b ON b.id_propinsi = a.id_propinsi LEFT JOIN tb_jabatan c ON c.id_jabatan = a.id_jabatan WHERE a.active=1 ORDER BY a.nama_karyawan ASC");
		return $result;
	}
	
	function view_all_user($data)
	{
		if($data=='1')
		{
			$result = $this->db->query("SELECT a.id_user, a.id_karyawan, a.username, a.password_user, a.level, a.active, b.nama_karyawan FROM tb_user a LEFT JOIN tb_karyawan b ON b.id_karyawan = a.id_karyawan WHERE a.active=1 AND a.username<>'admin' ORDER BY b.nama_karyawan ASC");
		}
		elseif($data=='2')
		{
			$result = $this->db->query("SELECT a.id_user, a.id_karyawan, a.username, a.password_user, a.level, a.active, b.nama_karyawan FROM tb_user a LEFT JOIN tb_karyawan b ON b.id_karyawan = a.id_karyawan WHERE a.active=1 AND a.username<>'admin' AND a.level >2 ORDER BY b.nama_karyawan ASC");
		}
		elseif($data=='3')
		{
			$result = $this->db->query("SELECT a.id_user, a.id_karyawan, a.username, a.password_user, a.level, a.active, b.nama_karyawan FROM tb_user a LEFT JOIN tb_karyawan b ON b.id_karyawan = a.id_karyawan WHERE a.active=1 AND a.username<>'admin' AND a.level >3 ORDER BY b.nama_karyawan ASC");
		}
		elseif($data=='4')
		{
			$result = $this->db->query("SELECT a.id_user, a.id_karyawan, a.username, a.password_user, a.level, a.active, b.nama_karyawan FROM tb_user a LEFT JOIN tb_karyawan b ON b.id_karyawan = a.id_karyawan WHERE a.active=1 AND a.username<>'admin' AND a.level >4 ORDER BY b.nama_karyawan ASC");
		}
		
		return $result;
	}
	
	function insert_jabatan($data)
	{
		$ins = array(
				'id_jabatan'	=> $data['id_jabatan'],
				'nama_jabatan'	=> $data['nama_jabatan'],
				'keterangan'	=> $data['keterangan'],
				'active'		=> '1'
		);
        $this->db->insert('tb_jabatan', $ins);
        
        return;
	}
	
	function update_jabatan($data)
	{
		$upd = array(
				'id_jabatan'		=> $data['id_jabatan'],
				'nama_jabatan'		=> $data['nama_jabatan'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
		$prm = array('id_jabatan' => $data['id_jabatan'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_jabatan', $upd);
		
		return;
	}
	
	function delete_jabatan($data)
	{
	   $upd = array(
				'id_jabatan'	=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_jabatan'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_jabatan', $upd);
	   
	   return;
	}
	
	function find_jabatan($data)
	{
		$result = $this->db->query("SELECT id_jabatan, nama_jabatan, keterangan, active FROM tb_jabatan WHERE active=1 AND id_jabatan = '".$data."' ORDER BY nama_jabatan ASC");
		
		return $result;
	}
	
	//=========================== Untuk Model Karyawan ===========================
	function insert_karyawan($data)
	{
		$ins = array(
				'id_karyawan'		=> $data['id_karyawan'],
				'nama_karyawan'		=> $data['nama_karyawan'],
				'jenis_kelamin'		=> $data['jenis_kelamin'],
				'alamat'			=> $data['alamat'],
				'id_propinsi'		=> $data['id_propinsi'],
				'telepon'			=> $data['telepon'],
				'hp'				=> $data['hp'],
				'agama'				=> $data['agama'],
				'status_perkawinan'	=> $data['status_perkawinan'],
				'id_jabatan'		=> $data['id_jabatan'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
        $this->db->insert('tb_karyawan', $ins);
        
        return;
	}
	
	function update_karyawan($data)
	{
		$upd = array(
				'id_karyawan'		=> $data['id_karyawan'],
				'nama_karyawan'		=> $data['nama_karyawan'],
				'jenis_kelamin'		=> $data['jenis_kelamin'],
				'alamat'			=> $data['alamat'],
				'id_propinsi'		=> $data['id_propinsi'],
				'telepon'			=> $data['telepon'],
				'hp'				=> $data['hp'],
				'agama'				=> $data['agama'],
				'status_perkawinan'	=> $data['status_perkawinan'],
				'id_jabatan'		=> $data['id_jabatan'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
		$prm = array('id_karyawan' => $data['id_karyawan'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_karyawan', $upd);
		
		return;
	}
	
	function delete_karyawan($data)
	{
	   $upd = array(
				'id_karyawan'	=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_karyawan'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_karyawan', $upd);
	   
	   return;
	}
	
	function find_karyawan($data)
	{
		$result = $this->db->query("SELECT a.id_karyawan, a.nama_karyawan, a.jenis_kelamin, a.alamat, a.id_propinsi, a.telepon, a.hp, a.agama, a.status_perkawinan, a.id_jabatan, a.keterangan, a.active, b.nama_propinsi, c.nama_jabatan FROM tb_karyawan a LEFT JOIN tb_propinsi b ON b.id_propinsi = a.id_propinsi LEFT JOIN tb_jabatan c ON c.id_jabatan = a.id_jabatan WHERE a.active=1 AND a.id_karyawan = '".$data."' ORDER BY a.nama_karyawan ASC");
		
		return $result;
	}
	
	//=========================== Untuk Model User ===========================
	function insert_user($data)
	{
		$result = $this->db->query("INSERT INTO tb_user(id_karyawan, username, password_user, level, active)
									VALUES('".$data['id_karyawan']."', '".$data['username']."', MD5('".$data['password_user']."'), '".$data['level']."', '1')");
		return;
	}
	
	function update_user($data)
	{
		$result = $this->db->query("UPDATE tb_user SET id_karyawan='".$data['id_karyawan']."', username='".$data['username']."', password_user=MD5('".$data['password_user']."'), 
									level='".$data['level']."', active='1' WHERE id_user='".$data['id_user']."'");
		return;
	}
	
	function delete_user($data)
	{
	   $upd = array(
				'id_user'	=> $data,
				'active'	=> '0'
	   );
       $prm = array('id_user'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_user', $upd);
	   
	   return;
	}
	
	function find_user($data)
	{
		$result = $this->db->query("SELECT a.id_user, a.id_karyawan, a.username, a.password_user, a.level, a.active, b.nama_karyawan FROM tb_user a LEFT JOIN tb_karyawan b ON b.id_karyawan = a.id_karyawan WHERE a.active=1 AND a.id_user = '".$data."' ORDER BY b.nama_karyawan ASC");
		
		return $result;
	}
	
	//=========================== Untuk Model Permission ===========================
	function insert_permission($username, $menu)
	{
		$no = 1;
		foreach($menu as $row)
		{
			$data = array(
				'id_menu'	=> $no,
				'id_user' 	=> $username,
				'status' 	=> $row
			);
			$this->db->insert('tb_permission', $data);
			$no++;
		}
		
		return;
	}
	
	function update_permission($username, $menu)
	{
		$no = 1;
		foreach($menu as $row)
		{
			$data = array(
				'status' 	=> $row
			);
			$this->db->where('id_menu', $no);
			$this->db->where('id_user', $username);
			$this->db->update('tb_permission', $data); 
			
			$no++;
		}
		
		return;
	}
	
	function delete_permission($data)
	{
	   /*$upd = array(
				'id_permission'	=> $data
	   );
       $prm = array('id_permission'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_permission', $upd);
	   
	   return;*/
	}
	
	function get_username($data)
	{
		$result = $this->db->query("SELECT id_user, id_karyawan, username, password_user, level, active FROM tb_user WHERE active=1 AND username = '".$data."' ORDER BY username ASC");
		
		return $result;
	}
	
	function count_menu()
	{
		$jml_menu = '';
		$result = $this->db->query("SELECT COUNT(id_menu) jumlah FROM tb_menu WHERE active=1 ORDER BY id_menu ASC");
		foreach($result->result_array() as $hasil)
		{
			$jumlah_menu = $hasil['jumlah'];
		}
		return $jumlah_menu;
	}
	
	function get_status_permission($username)
	{
		$result = $this->db->query("SELECT id_permission, id_menu, id_user, status FROM tb_permission WHERE id_user='".$username."'ORDER BY id_menu ASC;");
		
		return $result->result_array();
	}
	
	function find_permission($data)
	{
		/*$result = $this->db->query("SELECT a.id_permission, a.id_menu, a.id_user, a.status, b.id_menu, b.nama_menu, b.active FROM tb_permission a LEFT JOIN tb_menu b ON b.id_menu = a.id_menu WHERE a.id_permission = '".$data."' ORDER BY a.id_permission ASC");
		
		return $result;*/
	}
	
	function get_status_user($data)
	{
		$result = $this->db->query("SELECT status, id_menu FROM tb_permission WHERE id_user='".$data['id_user']."' order by id_menu Asc;");
		
		return $result->result_array();
	}
	
	function get_name_user()
	{
		$result = $this->db->query("SELECT id_karyawan FROM tb_user where id_karyawan!='0' and active=1;");
		
		return $result->result_array();
	}
	
	function get_name_view($search)
	{
		$result = $this->db->query("SELECT a.id_karyawan, a.nama_karyawan, a.jenis_kelamin, a.alamat, a.id_propinsi, a.telepon, a.hp, a.agama, a.status_perkawinan, a.id_jabatan, a.keterangan, a.active, b.nama_propinsi, c.nama_jabatan FROM tb_karyawan a LEFT JOIN tb_propinsi b ON b.id_propinsi = a.id_propinsi LEFT JOIN tb_jabatan c ON c.id_jabatan = a.id_jabatan WHERE a.active=1 ".$search." ORDER BY a.nama_karyawan ASC");
		
		return $result;
	}
}
?>