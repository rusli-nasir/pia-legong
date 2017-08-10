<?php
class Model_customer extends Model
{
	function Model_customer()
	{
		parent::Model();
	}
	
	function view_all_customer()
	{
		$result = $this->db->query("SELECT a.id_customer, a.nama_customer, a.alamat, a.id_propinsi, a.telepon, a.contact_person1, a.telpon_cp1, a.hp_cp1, a.contact_person2, a.telpon_cp2, a.hp_cp2, a.keterangan, a.active, b.nama_propinsi FROM tb_customer a LEFT JOIN tb_propinsi b ON b.id_propinsi=a.id_propinsi WHERE a.active=1 ORDER BY a.nama_customer ASC");
		
		return $result;
	}
	
	function generate_id_customer()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_customer FROM tb_customer WHERE id_customer LIKE '%".$yearmonth."%' ORDER BY id_customer DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_customer'];
       }
       
       if($hasil == 0)
       {
            $id_customer = 'CST'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_customer = 'CST'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_customer;
	}
	
	function update_customer($data)
	{
		$upd = array(
				'id_customer'		=> $data['id_customer'],
				'nama_customer'		=> $data['nama_customer'],
				'alamat'			=> $data['alamat'],
				'id_propinsi'		=> $data['id_propinsi'],
				'telepon'			=> $data['telepon'],
				'contact_person1'	=> $data['contact_person1'],
				'telpon_cp1'		=> $data['telpon_cp1'],
				'hp_cp1'			=> $data['hp_cp1'],
				'contact_person2'	=> $data['contact_person2'],
				'telpon_cp2'		=> $data['telpon_cp2'],
				'hp_cp2'			=> $data['hp_cp2'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
		$prm = array('id_customer'=>$data['id_customer'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_customer', $upd);
		
		return;
	}
	
	function insert_customer($data)
	{
		$ins = array(
				'id_customer'		=> $data['id_customer'],
				'nama_customer'		=> $data['nama_customer'],
				'alamat'			=> $data['alamat'],
				'id_propinsi'		=> $data['id_propinsi'],
				'telepon'			=> $data['telepon'],
				'contact_person1'	=> $data['contact_person1'],
				'telpon_cp1'		=> $data['telpon_cp1'],
				'hp_cp1'			=> $data['hp_cp1'],
				'contact_person2'	=> $data['contact_person2'],
				'telpon_cp2'		=> $data['telpon_cp2'],
				'hp_cp2'			=> $data['hp_cp2'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
        $this->db->insert('tb_customer', $ins);
        
        return;
	}
	
	function delete_customer($data)
	{
	   $upd = array(
				'id_customer'		=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_customer'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_customer', $upd);
	   
	   return;
	}
	
	function find_customer($data)
	{
		$result = $this->db->query("SELECT a.id_customer, a.nama_customer, a.alamat, a.id_propinsi, a.telepon, a.contact_person1, a.telpon_cp1, a.hp_cp1, a.contact_person2, a.telpon_cp2, a.hp_cp2, a.keterangan, a.active, b.nama_propinsi FROM tb_customer a LEFT JOIN tb_propinsi b ON b.id_propinsi=a.id_propinsi WHERE a.active=1 AND a.id_customer='".$data."' ORDER BY a.nama_customer ASC");
		
		return $result;
	}
}
?>