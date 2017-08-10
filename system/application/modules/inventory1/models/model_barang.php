<?php
class Model_barang extends Model
{
	function Model_barang()
	{
		parent::Model();
	}
	
	function generate_id_barang()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_barang FROM tb_barang WHERE id_barang LIKE '%".$yearmonth."%' ORDER BY id_barang DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_barang'];
       }
       
       if($hasil == 0)
       {
            $id_barang = 'BRG'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_barang = 'BRG'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_barang;
	}
	
	function view_all_barang()
	{
		$result = $this->db->query("SELECT id_barang, nama_barang, harga_barang, keterangan FROM tb_barang WHERE active=1 ORDER BY nama_barang ASC;");
		return $result;
	}

	function view_all_barang_pertanggal($date)
	{
		$date = explode_date($date,0);
		$result = $this->db->query("SELECT a.id_barang, a.nama_barang, a.harga_barang, a.keterangan,  
								   	(SELECT COUNT(b.id_barang) FROM tb_stok_awal b 
										WHERE b.id_barang = a.id_barang AND b.active=1 AND b.tanggal_stok_awal='".$date."') jumlah, 
									(SELECT c.jumlah_stok FROM tb_stok_awal c 
									 	WHERE c.id_barang = a.id_barang AND c.active=1 AND c.tanggal_stok_awal='".$date."') stok 
									FROM tb_barang a WHERE a.active=1 ORDER BY a.nama_barang ASC;");
		return $result;
	}
	
	function update_barang($data)
	{
		$upd = array(
				'id_barang'			=> $data['id_barang'],
				'nama_barang'		=> $data['nama_barang'],
				'harga_barang'		=> $data['harga_barang'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
		$prm = array('id_barang'=>$data['id_barang'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_barang', $upd);
		
		return;
	}
	
	function insert_barang($data)
	{
		$ins = array(
				'id_barang'			=> $data['id_barang'],
				'nama_barang'		=> $data['nama_barang'],
				'harga_barang'		=> $data['harga_barang'],
				'keterangan'		=> $data['keterangan'],
				'active'			=> '1'
		);
        $this->db->insert('tb_barang', $ins);
        
        return;
	}
	
	function delete_barang($data)
	{
	   $upd = array(
				'id_barang'		=> $data,
				'active'		=> '0'
	   );
       $prm = array('id_barang'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_barang', $upd);
	   
	   return;
	}
	
	function find_barang($data)
	{
		$result = $this->db->query("SELECT id_barang, nama_barang, harga_barang, keterangan FROM tb_barang 
								   	WHERE active=1 AND id_barang='".$data."' ORDER BY nama_barang ASC");
		
		return $result;
	}
	
	function summary_barang($data)
	{
		$result = $this->db->query("SELECT a.id_barang, a.nama_barang, a.harga_barang, 
								   	(SELECT b.jumlah_stok FROM tb_stok_awal b 
									 	WHERE b.id_barang=a.id_barang AND b.active='1' AND b.tanggal_stok_awal='".$data."') stok_awal,
									(SELECT SUM(c.stok_keluar) FROM tb_transaksi_stok c LEFT JOIN tb_penjualan d ON d.id_penjualan = c.id_penjualan 
										WHERE c.id_barang=a.id_barang AND c.active='1' AND c.tanggal_transaksi_stok='".$data."' 
											AND d.id_cara_pembayaran_1 <> 'CRBY2011030000002') stok_terjual, 
									(SELECT SUM(c.stok_keluar) FROM tb_transaksi_stok c LEFT JOIN tb_penjualan d ON d.id_penjualan = c.id_penjualan 
										WHERE c.id_barang=a.id_barang AND c.active='1' AND c.tanggal_transaksi_stok='".$data."' 
											AND d.id_cara_pembayaran_1 = 'CRBY2011030000002') stok_free 
									FROM tb_barang a WHERE a.active='1' ORDER BY a.nama_barang ASC;");
		return $result;
	}
	
	function summary_barang_po($data)
	{
		$result = $this->db->query("SELECT a.id_barang, a.nama_barang, 
								   	(SELECT SUM(b.stok_pesan) FROM tb_detail_po b LEFT JOIN tb_po c ON c.no_po = b.no_po 
										WHERE b.id_barang = a.id_barang AND b.active='1' AND c.tanggal_po='".$data."') stok_pemesanan
									FROM tb_barang a WHERE a.active='1' ORDER BY a.nama_barang ASC;");
		return $result;
	}
	
	function summary_barang_jual($data)
	{
		$data = explode_date($data,0);
		$result = $this->db->query("SELECT a.id_barang, a.nama_barang, 
								   	(SELECT SUM(b.jumlah_stok) FROM tb_detail_penjualan b LEFT JOIN tb_penjualan c ON c.id_penjualan = b.id_penjualan
										WHERE b.id_barang = a.id_barang AND b.active='1' AND c.tanggal_penjualan='".$data."') stok_penjualan
									FROM tb_barang a WHERE a.active='1' ORDER BY a.nama_barang ASC;");
		return $result;
	}
	
	function pesan_belum_ambil_per_item($data)
	{
		$result = $this->db->query("SELECT a.id_barang, a.nama_barang,
								   	(SELECT SUM(b.stok_pesan) FROM tb_detail_po b LEFT JOIN tb_po c ON c.no_po = b.no_po
										WHERE b.id_barang = a.id_barang AND b.active='1' AND c.tanggal_po='".$data."' 
										AND b.no_po NOT IN (SELECT d.no_po FROM tb_penjualan d WHERE d.active='1' AND d.tanggal_penjualan='".$data."')) stok_pemesanan
									FROM tb_barang a WHERE a.active='1' ORDER BY a.nama_barang ASC;");
		return $result;
	}
}
?>