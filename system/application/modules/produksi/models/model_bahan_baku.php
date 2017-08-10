<?php
class Model_bahan_baku extends Model
{
	function Model_bahan_baku()
	{
		parent::Model();
	}
	
	function generate_id_bahan_baku()
	{
		$noref='';
		$yearmonth = date("Y").date("m");
		$query = $this->db->query("SELECT id_bhn_baku FROM tb_bahan_baku WHERE id_bhn_baku LIKE '%".$yearmonth."%' ORDER BY id_bhn_baku DESC LIMIT 0, 1");
		$hasil = $query->num_rows();
		
		foreach($query->result_array() as $query1)
		{
			$noref = $query1['id_bhn_baku'];
		}
		
		if($hasil == 0)
		{
			$id_bhn_baku = 'BKU'.$yearmonth.'0000001';
		}
		else
		{
			$gethasil = substr($noref, -7);
			$sumref = $gethasil+1;
			$joinref = '0000000'.$sumref;
			$id_bhn_baku = 'BKU'.$yearmonth.substr($joinref,-7);
		}
		
		return $id_bhn_baku;
	}
	
	function generate_id_detail_bahan_baku()
	{
		$noref='';
		$yearmonth = date("Y").date("m");
		$query = $this->db->query("SELECT id_detail_bhn_baku FROM tb_detail_bahan_baku 
								  WHERE id_detail_bhn_baku LIKE '%".$yearmonth."%' ORDER BY id_detail_bhn_baku DESC LIMIT 0, 1");
		$hasil = $query->num_rows();
		
		foreach($query->result_array() as $query1)
		{
			$noref = $query1['id_detail_bhn_baku'];
		}
		
		if($hasil == 0)
		{
			$id_detail_bhn_baku = 'DKU'.$yearmonth.'0000001';
		}
		else
		{
			$gethasil = substr($noref, -7);
			$sumref = $gethasil+1;
			$joinref = '0000000'.$sumref;
			$id_detail_bhn_baku = 'DKU'.$yearmonth.substr($joinref,-7);
		}
		
		return $id_detail_bhn_baku;
	}
	
	function view_all_bahan_baku()
	{
		$result = $this->db->query("SELECT a.id_bhn_baku, a.nama_bhn_baku, a.id_satuan_barang, b.nama_satuan, a.stok_minimum, a.keterangan 
								   	FROM tb_bahan_baku a LEFT JOIN tb_satuan_barang b ON b.id_satuan_barang = a.id_satuan_barang 
									WHERE a.active=1 ORDER BY a.nama_bhn_baku ASC;");
		return $result;
	}
	
	function update_bahan_baku($data)
	{
		$prm = array('id_bhn_baku'=>$data['id_bhn_baku'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_bahan_baku', $data);
		
		return;
	}
	
	function insert_bahan_baku($data)
	{
        $this->db->insert('tb_bahan_baku', $data);
        
        return;
	}
	
	function insert_detail_bahan_baku($data)
	{
		$this->db->insert('tb_detail_bahan_baku', $data);
		
		return;
	}
	
	function unactive_bahan_baku($data)
	{
	   $upd = array(
				'id_bhn_baku'	=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_bhn_baku'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_bahan_baku', $upd);
	   
	   return;
	}
	
	function unactive_detail_bahan_baku($data)
	{
		$upd = array(
				'id_bhn_baku'	=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_bhn_baku'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_detail_bahan_baku', $upd);
	   
	   return;
	}
	
	function delete_detail_bahan_baku($data)
	{
		$del = array(
			'id_bhn_baku'	=> $data
	   	);
		$this->db->delete('tb_detail_bahan_baku', $del);
		
		return;
	}
	
	function find_bahan_baku($data)
	{
		$result = $this->db->query("SELECT a.id_bhn_baku, a.nama_bhn_baku, a.id_satuan_barang, b.nama_satuan, a.stok_minimum, a.keterangan 
								   	FROM tb_bahan_baku a LEFT JOIN tb_satuan_barang b ON b.id_satuan_barang = a.id_satuan_barang 
								   	WHERE a.active=1 AND a.id_bhn_baku='".$data."' ORDER BY nama_bhn_baku ASC");
		
		return $result;
	}
	
	function find_bahan_baku_detail($data)
	{
		$result = $this->db->query("SELECT a.id_detail_bhn_baku, a.id_bhn_baku, b.nama_bhn_baku, a.id_supplier, c.nama_supplier, c.alamat, a.keterangan, a.harga_bahan,
								   	c.contact_person, c.telepon_1, c.telepon_2, c.no_rekening, c.keterangan as keterangan_supplier 
								   	FROM tb_detail_bahan_baku a LEFT JOIN tb_bahan_baku b ON b.id_bhn_baku = a.id_bhn_baku 
									LEFT JOIN tb_supplier c ON c.id_supplier = a.id_supplier 
									WHERE a.active = 1 AND a.id_bhn_baku='".$data."' ORDER BY c.nama_supplier ASC;");
		return $result;
	}
	
	function find_bahan_baku_detail_spesifik($data)
	{
		$result = $this->db->query("SELECT a.id_detail_bhn_baku, a.id_bhn_baku, b.nama_bhn_baku, a.id_supplier, c.nama_supplier, c.alamat, a.keterangan, a.harga_bahan,
								   	c.contact_person, c.telepon_1, c.telepon_2, c.no_rekening, c.keterangan as keterangan_supplier 
								   	FROM tb_detail_bahan_baku a LEFT JOIN tb_bahan_baku b ON b.id_bhn_baku = a.id_bhn_baku 
									LEFT JOIN tb_supplier c ON c.id_supplier = a.id_supplier 
									WHERE a.active = 1 AND a.id_bhn_baku='".$data['id_bhn_baku']."' AND a.id_supplier='".$data['id_supplier']."' 
									ORDER BY c.nama_supplier ASC;");
		return $result;
	}
	
	function bhn_baku_with_conditon($data)
	{
		$result = $this->db->query("SELECT * FROM tb_bahan_baku WHERE active=1 AND nama_bhn_baku LIKE '%".$data."%' ORDER BY nama_bhn_baku ASC;");
		return $result;
	}
}
?>