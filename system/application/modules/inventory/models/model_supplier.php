<?php
class Model_supplier extends Model
{
	function Model_supplier()
	{
		parent::Model();
	}
	
	function view_all_supplier()
	{
		$result = $this->db->query("SELECT a.id_supplier, a.nama_supplier, a.alamat, a.id_propinsi, a.telepon, a.fax, a.contact_person, a.telepon_cp, a.hp_cp, a.keterangan, a.active, b.nama_propinsi FROM tb_supplier a LEFT JOIN tb_propinsi b ON b.id_propinsi=a.id_propinsi WHERE a.active=1 ORDER BY a.nama_supplier ASC");
		return $result;
	}
	
	function generate_id_supplier()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_supplier FROM tb_supplier WHERE id_supplier LIKE '%".$yearmonth."%' ORDER BY id_supplier DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_supplier'];
       }
       
       if($hasil == 0)
       {
            $id_supplier = 'SPL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_supplier = 'SPL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_supplier;
	}
	
	function update_supplier($data)
	{
		$upd = array(
				'id_supplier'		=> $data['id_supplier'],
				'nama_supplier'		=> $data['nama_supplier'],
				'alamat'			=> $data['alamat'],
				'id_propinsi'		=> $data['id_propinsi'],
				'telepon'			=> $data['telepon'],
				'fax'				=> $data['fax'],
				'contact_person'	=> $data['contact_person'],
				'telepon_cp'		=> $data['telepon_cp'],
				'hp_cp'				=> $data['hp_cp'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
		$prm = array('id_supplier'=>$data['id_supplier'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_supplier', $upd);
		
		return;
	}
	
	function insert_supplier($data)
	{
		$ins = array(
				'id_supplier'		=> $data['id_supplier'],
				'nama_supplier'		=> $data['nama_supplier'],
				'alamat'			=> $data['alamat'],
				'id_propinsi'		=> $data['id_propinsi'],
				'telepon'			=> $data['telepon'],
				'fax'				=> $data['fax'],
				'contact_person'	=> $data['contact_person'],
				'telepon_cp'		=> $data['telepon_cp'],
				'hp_cp'				=> $data['hp_cp'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
        $this->db->insert('tb_supplier', $ins);
        
        return;
	}
	
	function delete_supplier($data)
	{
	   $upd = array(
				'id_supplier'		=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_supplier'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_supplier', $upd);
	   
	   return;
	}
	
	function find_supplier($data)
	{
		$result = $this->db->query("SELECT a.id_supplier, a.nama_supplier, a.alamat, a.id_propinsi, a.telepon, a.fax, a.contact_person, a.telepon_cp, a.hp_cp, a.keterangan, a.active, b.nama_propinsi FROM tb_supplier a LEFT JOIN tb_propinsi b ON b.id_propinsi=a.id_propinsi WHERE a.active=1 AND a.id_supplier='".$data."' ORDER BY a.nama_supplier ASC");
		
		return $result;
	}
}
?>