<?php
class Model_beli extends Model
{
	function Model_beli()
	{
		parent::Model();
	}
	
	function generate_id_pembelian()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_pembelian FROM tb_pembelian WHERE id_pembelian LIKE '%".$yearmonth."%' ORDER BY id_pembelian DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_pembelian'];
       }
       
       if($hasil == 0)
       {
            $id_pembelian = 'PBL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_pembelian = 'PBL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_pembelian;
	}
	
	function generate_id_detail_pembelian()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_detail_pembelian FROM tb_detail_pembelian WHERE id_detail_pembelian LIKE '%".$yearmonth."%' ORDER BY id_detail_pembelian DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_detail_pembelian'];
       }
       
       if($hasil == 0)
       {
            $id_detail_pembelian = 'DBL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_detail_pembelian = 'DBL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_detail_pembelian;
	}
	
	function view_pembelian($data1, $data)
	{
		$result = $this->db->query("SELECT a.id_detail_pembelian, a.id_pembelian, a.id_bhn_baku, c.nama_bhn_baku, a.id_supplier, d.nama_supplier, a.quantity, 
								   	a.total_harga, b.total_pembelian, c.id_satuan_barang, e.nama_satuan 
								   	FROM tb_detail_pembelian a LEFT JOIN tb_pembelian b ON b.id_pembelian = a.id_pembelian
									LEFT JOIN tb_bahan_baku c ON c.id_bhn_baku = a.id_bhn_baku LEFT JOIN tb_supplier d ON d.id_supplier = a.id_supplier 
									LEFT JOIN tb_satuan_barang e ON c.id_satuan_barang = e.id_satuan_barang
									WHERE a.active = 1 AND (b.tgl_pembelian > '".$data1."' OR b.tgl_pembelian = '".$data1."') 
										AND (b.tgl_pembelian < '".$data."' OR b.tgl_pembelian = '".$data."') ORDER BY a.id_pembelian ASC;");
		return $result;
	}
	
	function view_pembelian_spesifik($data)
	{
		$result = $this->db->query("SELECT * FROM tb_pembelian WHERE active=1 AND id_pembelian='".$data."';");
		return $result;
	}
	
	function view_pembelian_detail_spesifik($data)
	{
		$result = $this->db->query("SELECT a.id_detail_pembelian, a.id_pembelian, a.id_bhn_baku, b.nama_bhn_baku, a.id_supplier, c.nama_supplier, c.telepon_1, 
								   	c.no_rekening, a.quantity, a.total_harga, 
									(SELECT aa.harga_bahan FROM tb_detail_bahan_baku aa 
									 	WHERE aa.id_bhn_baku=a.id_bhn_baku AND aa.id_supplier=a.id_supplier AND aa.active=1) harga_bhn_baku
									FROM tb_detail_pembelian a LEFT JOIN tb_bahan_baku b ON b.id_bhn_baku = a.id_bhn_baku
									LEFT JOIN tb_supplier c ON c.id_supplier = a.id_supplier
									WHERE a.active=1 AND a.id_pembelian='".$data."' ORDER BY a.id_detail_pembelian ASC;");
		return $result;
	}
	
	function add_beli($data)
	{
		 $this->db->insert('tb_pembelian', $data);
		 return;
	}
	
	function update_beli($data)
	{
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_pembelian', $data);
	}
	
	function inactive_beli($data)
	{
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_pembelian', $data);
	}
	
	function add_beli_detail($data)
	{
		$this->db->insert('tb_detail_pembelian', $data);
		return;
	}
	
	function delete_beli_detail($data)
	{
		$del = array(
			'id_pembelian'	=> $data
	   	);
		$this->db->delete('tb_detail_pembelian', $del);
		return;
	}
	
	function inactive_detail_beli($data)
	{
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_detail_pembelian', $data);
	}
	
	//============================================================Pembayaran Pembelian Bahan Baku=================================================================//
	
	function generate_id_pembayaran_bhn()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
       $query = $this->db->query("SELECT id_pembayaran_bhn FROM tb_pembayaran_bhn WHERE id_pembayaran_bhn LIKE '%".$yearmonth."%' 
								 ORDER BY id_pembayaran_bhn DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_pembayaran_bhn'];
       }
       
       if($hasil == 0)
       {
            $id_pembayaran_bhn = 'BRN'.$yearmonth.'0001';
       }
       else
       {
            $gethasil = substr($noref, -4);
            $sumref = $gethasil+1;
            $joinref = '0000'.$sumref;
            $id_pembayaran_bhn = 'BRN'.$yearmonth.substr($joinref,-4);
       }
       
	   return $id_pembayaran_bhn;
	}
	
	function add_beli_bayar($data)
	{
		 $this->db->insert('tb_pembayaran_bhn', $data);
		 return;
	}
	
	function delete_pembayaran($data)
	{
		$del = array(
			'id_pembelian'	=> $data
	   	);
		$this->db->delete('tb_pembayaran_bhn', $del);
		return;
	}
	
	function inactive_pembayaran_beli($data)
	{
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_pembayaran_bhn', $data);
	}
	
	function inactive_pembayaran_beli_spesifik($data)
	{
		$prm = array('id_pembayaran_bhn'=>$data['id_pembayaran_bhn'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_pembayaran_bhn', $data);
	}
	
	function view_pembayaran($data)
	{
		$result = $this->db->query("SELECT * FROM tb_pembayaran_bhn WHERE active=1 AND id_pembelian='".$data."';");
		return $result;
	}
	
	function view_pembayaran_detail_spesifik($data)
	{
		$result = $this->db->query("SELECT a.id_pembayaran_bhn, a.tgl_pembayaran, a.id_cara_pembayaran_bhn, b.nama_cara_pembayaran, a.jumlah_bayar, a.dp_type
								   	FROM tb_pembayaran_bhn a LEFT JOIN tb_cara_pembayaran_bhn b ON b.id_cara_pembayaran = a.id_cara_pembayaran_bhn
									WHERE a.active=1 AND id_pembelian='".$data."' ORDER BY a.id_pembayaran_bhn ASC;");
		return $result;
	}
	
	function viem_selected_pembayaran($data)
	{
		$result = $this->db->query("SELECT * FROM tb_pembayaran_bhn WHERE active=1 AND id_pembayaran_bhn = '".$data."';");
		return $result;
	}
}
?>