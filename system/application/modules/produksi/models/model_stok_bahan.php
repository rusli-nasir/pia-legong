<?php
class Model_stok_bahan extends Model
{
	function Model_stok_bahan()
	{
		parent::Model();
	}
	
	function generate_id_stok_bahan_baku()
	{
		$noref='';
		$yearmonth = date("Y").date("m");
		$query = $this->db->query("SELECT id_stok_bhn_baku FROM tb_stok_bahan_baku WHERE id_stok_bhn_baku LIKE '%".$yearmonth."%' ORDER BY id_stok_bhn_baku DESC LIMIT 0, 1");
		$hasil = $query->num_rows();
		
		foreach($query->result_array() as $query1)
		{
			$noref = $query1['id_stok_bhn_baku'];
		}
		
		if($hasil == 0)
		{
			$id_stok_bhn_baku = 'SBK'.$yearmonth.'0000001';
		}
		else
		{
			$gethasil = substr($noref, -7);
			$sumref = $gethasil+1;
			$joinref = '0000000'.$sumref;
			$id_stok_bhn_baku = 'SBK'.$yearmonth.substr($joinref,-7);
		}
		
		return $id_stok_bhn_baku;
	}
	
	function view_all_bahan_baku()
	{
		$result = $this->db->query("SELECT a.id_bhn_baku, a.nama_bhn_baku, a.id_satuan_barang, b.nama_satuan, a.stok_minimum, a.keterangan, 
								   	(SELECT SUM(aa.stok_masuk-aa.stok_keluar) FROM tb_stok_bahan_baku aa WHERE aa.active=1 AND aa.id_bhn_baku = a.id_bhn_baku)
										as sisa_stok
								   	FROM tb_bahan_baku a LEFT JOIN tb_satuan_barang b ON b.id_satuan_barang = a.id_satuan_barang 
									WHERE a.active=1 ORDER BY a.nama_bhn_baku ASC;");
		return $result;
	}
	
	function add_stok($data)
	{
		$this->db->insert('tb_stok_bahan_baku', $data);
		return;
	}
	
	function view_pembelian_stok_spesifik($data)
	{
		$result = $this->db->query("SELECT a.id_detail_pembelian, a.id_pembelian, a.id_bhn_baku, b.nama_bhn_baku, a.id_supplier, c.nama_supplier, c.telepon_1, 
								   	c.no_rekening, a.quantity, a.total_harga, 
									(SELECT aa.harga_bahan FROM tb_detail_bahan_baku aa 
									 	WHERE aa.id_bhn_baku=a.id_bhn_baku AND aa.id_supplier=a.id_supplier AND aa.active=1) harga_bhn_baku, 
									(SELECT SUM(bb.stok_masuk) FROM tb_stok_bahan_baku bb
										WHERE bb.id_bhn_baku=a.id_bhn_baku AND bb.id_pembelian=a.id_pembelian AND bb.active=1) total_masuk
									FROM tb_detail_pembelian a LEFT JOIN tb_bahan_baku b ON b.id_bhn_baku = a.id_bhn_baku
									LEFT JOIN tb_supplier c ON c.id_supplier = a.id_supplier
									WHERE a.active=1 AND a.id_pembelian='".$data."' ORDER BY a.id_detail_pembelian ASC;");
		return $result;
	}
	
	function view_transaksi_stok_per_pembelian($data)
	{
		$result = $this->db->query("SELECT a.id_stok_bhn_baku, a.id_bhn_baku, b.nama_bhn_baku, a.id_pembelian, a.tgl_transaksi, a.stok_masuk, a.stok_keluar 
								   	FROM tb_stok_bahan_baku a LEFT JOIN tb_bahan_baku b ON b.id_bhn_baku = a.id_bhn_baku 
									WHERE a.id_pembelian='".$data."' AND a.active=1 ORDER BY a.id_stok_bhn_baku ASC;");
		return $result;
	}
	
	function view_stok_detail_per_barang($data)
	{
		$result = $this->db->query("SELECT * FROM tb_stok_bahan_baku 
								   	WHERE active=1 AND id_bhn_baku = '".$data['id_bhn_baku']."' 
										AND (tgl_transaksi > '".$data['date1']."' OR tgl_transaksi = '".$data['date1']."') 
										AND (tgl_transaksi < '".$data['date']."' OR tgl_transaksi = '".$data['date']."') 
									ORDER BY tgl_transaksi ASC;");
		return $result;
	}
	
	function view_selected_stok_bahan($data)
	{
		$result = $this->db->query("SELECT * FROM tb_stok_bahan_baku WHERE active=1 AND id_stok_bhn_baku='".$data."';");
		return $result;
	}
	
	function inactive_stok_bahan($data)
	{
		$prm = array('id_stok_bhn_baku'=>$data['id_stok_bhn_baku'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_stok_bahan_baku', $data);
	}
}
?>