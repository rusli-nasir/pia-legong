<?php
class Model_propinsi extends Model
{
	function Model_propinsi()
	{
		parent::Model();
	}
	
	function view_all_propinsi()
	{
		$result = $this->db->query("SELECT id_propinsi, kode_propinsi, nama_propinsi, active FROM tb_propinsi WHERE active=1 ORDER BY nama_propinsi ASC");
		return $result;
	}
	
	/*function generate_id_propinsi()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_satuan_barang FROM tb_satuan_barang WHERE id_satuan_barang LIKE '%".$yearmonth."%' ORDER BY id_satuan_barang DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_satuan_barang'];
       }
       
       if($hasil == 0)
       {
            $id_satuan = 'UOM'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_satuan = 'UOM'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_satuan;
	}
	
	function update_propinsi($data)
	{
		$upd = array(
				'id_satuan_barang'			=> $data['id_satuan_barang'],
				'kode_satuan'		=> $data['kode_satuan'],
				'nama_satuan'		=> $data['nama_satuan'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
		$prm = array('id_satuan_barang'=>$data['id_satuan_barang'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_satuan_barang', $upd);
		
		return;
	}
	
	function insert_propinsi($data)
	{
		$ins = array(
				'id_satuan_barang'			=> $data['id_satuan_barang'],
				'kode_satuan'		=> $data['kode_satuan'],
				'nama_satuan'		=> $data['nama_satuan'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
        $this->db->insert('tb_satuan_barang', $ins);
        
        return;
	}
	
	function delete_propinsi($data)
	{
	   $upd = array(
				'id_satuan_barang'		=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_satuan_barang'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_satuan_barang', $upd);
	   
	   return;
	}
	
	function find_propinsi($data)
	{
		$result = $this->db->query("SELECT id_satuan_barang, kode_satuan, nama_satuan, keterangan, active FROM tb_satuan_barang WHERE active=1 AND id_satuan_barang='".$data."' ORDER BY kode_satuan ASC");
		
		return $result;
	}*/
}
?>