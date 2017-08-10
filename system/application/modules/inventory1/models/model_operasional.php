<?php
class Model_operasional extends Model
{
	function Model_operasional()
	{
		parent::Model();
	}
	
	function generate_id_produksi()
	{
		$noref='';
		$yearmonth = date("Y").date("m").date("d");
		$query = $this->db->query("SELECT id_produksi FROM tb_pengeluaran_produksi WHERE id_produksi LIKE '%".$yearmonth."%' ORDER BY id_produksi DESC LIMIT 0, 1");
		$hasil = $query->num_rows();
		
		foreach($query->result_array() as $query1)
		{
			$noref = $query1['id_produksi'];
		}
		
		if($hasil == 0)
		{
			$id_produksi = 'PRO'.$yearmonth.'00001';
		}
		else
		{
			$gethasil = substr($noref, -5);
			$sumref = $gethasil+1;
			$joinref = '00000'.$sumref;
			$id_produksi = 'PRO'.$yearmonth.substr($joinref,-5);
		}
		
		return $id_produksi;
	}
	
	function generate_id_saldo()
	{
		$noref='';
		$yearmonth = date("Y").date("m").date("d");
		$query = $this->db->query("SELECT id_saldo FROM tb_saldo_awal WHERE id_saldo LIKE '%".$yearmonth."%' ORDER BY id_saldo DESC LIMIT 0, 1");
		$hasil = $query->num_rows();
		
		foreach($query->result_array() as $query1)
		{
			$noref = $query1['id_saldo'];
		}
		
		if($hasil == 0)
		{
			$id_saldo = 'PRO'.$yearmonth.'00001';
		}
		else
		{
			$gethasil = substr($noref, -5);
			$sumref = $gethasil+1;
			$joinref = '00000'.$sumref;
			$id_saldo = 'PRO'.$yearmonth.substr($joinref,-5);
		}
		
		return $id_saldo;
	}
	
	function view_operasional_per_tgl($date)
	{
		$result = $this->db->query("SELECT id_produksi, nama_transaksi, jumlah_pengeluaran FROM `tb_pengeluaran_produksi` where active=1 and tanggal_pengeluaran='".$date."' order by id_produksi Asc;");
		return $result;
	}
	
	function add_operasional($data)
	{
		$result = $this->db->query("insert into tb_pengeluaran_produksi (id_produksi, tanggal_pengeluaran, nama_transaksi, jumlah_pengeluaran, active) values('".$data['id_produksi']."','".$data['tanggal_transaksi']."','".$data['nama_transaksi']."','".$data['jumlah_pengeluaran']."','1');");
	}
	
	function findOperasional_perID($data)
	{
		$result = $this->db->query("SELECT id_produksi, tanggal_pengeluaran, nama_transaksi, jumlah_pengeluaran FROM tb_pengeluaran_produksi 
								   	WHERE active=1 AND id_produksi='".$data."';");
		
		return $result;
	}
	
	function edit_operasional($data)
	{
		$result = $this->db->query("update tb_pengeluaran_produksi set tanggal_pengeluaran='".$data['tanggal_transaksi']."', nama_transaksi='".$data['nama_transaksi']."', jumlah_pengeluaran='".$data['jumlah_pengeluaran']."' where id_produksi='".$data['id_produksi']."';");
	}
	
	function batal_operasional($data)
	{
		$result = $this->db->query("update tb_pengeluaran_produksi set active='0' where id_produksi='".$data."';");
	}
	
	function summary_pengeluaran($data)
	{
		$result = $this->db->query("SELECT SUM(jumlah_pengeluaran) jml_pengeluaran FROM tb_pengeluaran_produksi WHERE active=1 AND tanggal_pengeluaran='".$data."';");
		return $result;
	}
	
	function delete_pengeluaran($data)
	{
		$result = $this->db->query("DELETE FROM tb_pengeluaran_produksi WHERE tanggal_pengeluaran >= '".$data['date_from']."' 
									AND tanggal_pengeluaran <= '".$data['date_to']."';");
	}
	
	function select_saldo_awal($date)
	{
		$result = $this->db->query("SELECT id_saldo, jumlah_saldo FROM tb_saldo_awal WHERE tanggal_saldo='".$date."' AND active='1';");
		return $result;
	}
	
	function add_saldo($data)
	{
		$id_saldo = $this->generate_id_saldo();
		$result = $this->db->query("INSERT INTO tb_saldo_awal (id_saldo, tanggal_saldo, jumlah_saldo, active) 
									VALUES('".$id_saldo."', '".$data['tanggal']."', '".$data['saldo']."', '1');");
		return $result;
	}
	
	function update_saldo($data)
	{
		$result = $this->db->query("UPDATE tb_saldo_awal SET jumlah_saldo='".$data['saldo']."' WHERE id_saldo='".$data['id_saldo']."' AND active='1';");
		return $result;
	}
	
	function delete_saldo($data)
	{
		$result = $this->db->query("DELETE FROM tb_saldo_awal WHERE tanggal_saldo >= '".$data['date_from']."' AND tanggal_saldo <= '".$data['date_to']."';");
	}
}
?>