<?php
class Model_stok extends Model
{
	function Model_stok()
	{
		parent::Model();
	}
	
	function generate_id_stok()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
	   $query = $this->db->query("SELECT id_transaksi_stok FROM tb_transaksi_stok WHERE id_transaksi_stok LIKE '%".$yearmonth."%' ORDER BY id_transaksi_stok DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_transaksi_stok'];
       }
       
       if($hasil == 0)
       {
            $id_stok = 'STK'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_stok = 'STK'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_stok;
	}
	
	function generate_id_stok_awal()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
	   $query = $this->db->query("SELECT id_stok_awal FROM tb_stok_awal WHERE id_stok_awal LIKE '%".$yearmonth."%' ORDER BY id_stok_awal DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_stok_awal'];
       }
       
       if($hasil == 0)
       {
            $id_stok = 'STKA'.$yearmonth.'0001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000'.$sumref;
            $id_stok = 'STKA'.$yearmonth.substr($joinref,-4);
       }
       
	   return $id_stok;
	}
	
	function add_stok_awal($data)
	{
		$ins = array(
			'id_stok_awal'		=> $data['id_stok'],
			'tanggal_stok_awal'	=> $data['tgl_stok'],
			'id_barang'			=> $data['id_barang'],
			'jumlah_stok'		=> $data['jmlh_stok'],
			'active'			=> '1'
		);
		$this->db->insert('tb_stok_awal', $ins);
		
		return;
	}
	
	function update_stok_awal($data)
	{
		$upd = array(
			'tanggal_stok_awal'	=> $data['tgl_stok'],
			'id_barang'			=> $data['id_barang'],
			'jumlah_stok'		=> $data['jmlh_stok'],
			'active'			=> '1'
		);
		
		$prm = array(
			'tanggal_stok_awal'	=> $data['tgl_stok'],
			'id_barang'			=> $data['id_barang'],
			'active'			=> '1'
		);
		$this->db->where($prm);
		$this->db->update('tb_stok_awal', $upd);
		
		return;
	}
	
	function add_transaksi_stok($data)
	{
		$ins = array(
				'id_transaksi_stok'			=> $data['id_transaksi_stok'],
				'id_penjualan'				=> $data['id_penjualan'],
				'tanggal_transaksi_stok'	=> $data['tanggal_transaksi_stok'],
				'id_barang'					=> $data['id_barang'],
				'stok_keluar'				=> $data['stok_keluar'],
				'active'					=> '1'
		);
        $this->db->insert('tb_transaksi_stok', $ins);
        
        return;
	}
	
	function update_stok($data, $dataprm)
	{
		if($dataprm=='')
		{
			$upd = array(
					'id_stok'			=> $data['id_stok'],
					'tanggal_transaksi'	=> $data['tanggal_transaksi'],
					'id_barang'			=> $data['id_barang'],
					'stok_masuk'		=> $data['stok_masuk'],
					'stok_keluar'		=> $data['stok_keluar'],
					'id_penjualan'		=> $data['id_penjualan'],
					'id_pembelian'		=> $data['id_pembelian'],
					'keterangan'		=> $data['keterangan'],
					'active'			=> '1'
			);
		}
		else
		{
			$upd = array(
					'id_stok'		=> $data['id_stok'],
					'active'		=> '1'
			);
		}
		$prm = array('id_stok'=>$data['id_stok'], 'active'=>'1');
		$this->db->where($prm);
		$this->db->update('tb_stok', $upd);
		
		return;
	}
	
	function delete_transaksi_stok($data)
	{
		
	   	$upd = array('active'=> '0');
		$prm = array('id_penjualan' => $data);
		
		$this->db->where($prm);
		$this->db->update('tb_transaksi_stok', $upd);
		
		return;
	}
	
	function delete_stok_jual($data)
	{
		$del = array('id_penjualan'	=> $data);
		$this->db->delete('tb_transaksi_stok', $del);
		
		return;
	}
	
	function delete_stok_awal($data)
	{
		$result = $this->db->query("DELETE FROM tb_stok_awal WHERE tanggal_stok_awal >= '".$data['date_from']."' AND tanggal_stok_awal <= '".$data['date_to']."';");
	}
	
	function daftar_list_stok()
	{
		$result = $this->db->query("SELECT a.id_barang, a.kode_barang, a.nama_barang, (SELECT SUM(aa.stok_masuk)-SUM(aa.stok_keluar) jml_stok FROM tb_stok aa WHERE aa.active=1 AND aa.id_barang=a.id_barang) sisa_stok FROM tb_barang a WHERE a.active=1 ORDER BY a.nama_barang ASC");
		
		return $result;
	}
	
	function get_stok_barang($data)
	{
		$query1 = $this->db->query("SELECT id_barang, SUM(jumlah_stok) jumlah_stok FROM tb_stok_awal WHERE active=1 AND id_barang='".$data['id_barang']."' AND tanggal_stok_awal='".$data['tgl_transaksi']."'");
		foreach($query1->result_array() as $jumlahstok)
		{
			$jumlah_stok = $jumlahstok['jumlah_stok'];
		}
		$query2 = $this->db->query("SELECT id_barang, SUM(stok_keluar) stok_keluar FROM tb_transaksi_stok WHERE active=1 AND id_barang='".$data['id_barang']."' AND tanggal_transaksi_stok='".$data['tgl_transaksi']."'");
		foreach($query2->result_array() as $stokkeluar)
		{
			$stok_keluar = $stokkeluar['stok_keluar'];
		}
		$jumlah_stok = $jumlah_stok - $stok_keluar;
		
		return $jumlah_stok;
	}
	
	function get_stok_detail($data)
	{
		$result = $this->db->query("SELECT a.id_stok, a.id_barang, a.tanggal_transaksi, a.stok_masuk, a.stok_keluar, a.id_penjualan, a.id_pembelian, a.keterangan, a.active, b.kode_barang, b.nama_barang FROM tb_stok a LEFT JOIN tb_barang b ON a.id_barang=b.id_barang WHERE a.active=1 AND a.id_barang = '".$data."' ORDER BY a.tanggal_transaksi DESC");
		
		return $result;
	}
}
?>