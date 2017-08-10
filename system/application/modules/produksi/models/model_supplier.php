<?php
class Model_supplier extends Model
{
	function Model_supplier()
	{
		parent::Model();
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
            $id_supplier = 'SUP'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_supplier = 'SUP'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_supplier;
	}
	
	function view_all_supplier()
	{
		$result = $this->db->query("SELECT * FROM tb_supplier WHERE active=1 ORDER BY nama_supplier ASC;");
		return $result;
	}
	
	function view_supplier_spesifik($data)
	{
		$result = $this->db->query("SELECT * FROM tb_supplier WHERE active=1 AND nama_supplier LIKE '%".$data."%' ORDER BY nama_supplier ASC;");
		return $result;
	}
	
	function update_supplier($data)
	{
		$prm = array('id_supplier'=>$data['id_supplier'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_supplier', $data);
		
		return;
	}
	
	function insert_supplier($data)
	{
        $this->db->insert('tb_supplier', $data);
        
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
		$result = $this->db->query("SELECT * FROM tb_supplier 
								   	WHERE active=1 AND id_supplier='".$data."' ORDER BY nama_supplier ASC");
		
		return $result;
	}
}
?>