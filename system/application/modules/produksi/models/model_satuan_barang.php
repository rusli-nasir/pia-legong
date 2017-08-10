<?php
class Model_satuan_barang extends Model
{
	function Model_satuan_barang()
	{
		parent::Model();
	}
	
	function select_satuan_barang()
	{
		$result = $this->db->query("SELECT * FROM tb_satuan_barang WHERE active=1 ORDER BY kode_satuan ASC");
		return $result;
	}
	
	function generate_id_satuan_barang()
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
	
	function update_satuan_barang($data)
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
	
	function insert_satuan_barang($data)
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
	
	function delete_satuan_barang($data)
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
	
	function find_satuan_barang($data)
	{
		$result = $this->db->query("SELECT id_satuan_barang, kode_satuan, nama_satuan, keterangan, active FROM tb_satuan_barang WHERE active=1 AND id_satuan_barang='".$data."' ORDER BY kode_satuan ASC");
		
		return $result;
	}
}
?>