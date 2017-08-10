<?php
class Model_jual extends Model
{
	function Model_jual()
	{
		parent::Model();
	}
	
	function generate_no_jual()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
	   $query = $this->db->query("SELECT id_penjualan FROM tb_penjualan WHERE id_penjualan LIKE '%".$yearmonth."%' ORDER BY id_penjualan DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_penjualan'];
       }
       
       if($hasil == 0)
       {
            $no_jual = 'PJL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_jual = 'PJL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_jual;
	}
	
	function generate_no_detail_jual()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
       $query = $this->db->query("SELECT id_detail_penjualan FROM tb_detail_penjualan WHERE id_detail_penjualan LIKE '%".$yearmonth."%' 
								 	ORDER BY id_detail_penjualan DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_detail_penjualan'];
       }
       
       if($hasil == 0)
       {
            $no_detail_jual = 'DJL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_detail_jual = 'DJL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_detail_jual;
	}
	
	function view_list_penjualan($data)
	{
		$data = explode_date($data, 0);
		$query = $this->db->query("SELECT a.id_detail_penjualan, a.id_penjualan, b.no_po, d.nama_customer, a.id_barang, c.nama_barang, a.jumlah_stok, a.total_harga 
								  	FROM tb_detail_penjualan a LEFT JOIN tb_penjualan b ON b.id_penjualan = a.id_penjualan 
									LEFT JOIN tb_barang c ON c.id_barang = a.id_barang 
									LEFT JOIN tb_po d ON b.no_po = d.no_po 
									WHERE a.active=1 AND b.tanggal_penjualan='".$data."' ORDER BY a.id_penjualan ASC");
		
		return $query;
	}
	
	function add_jual($data)
	{
		$ins = array(
				'id_penjualan'			=> $data['id_penjualan'],
				'tanggal_penjualan'		=> $data['tanggal_penjualan'],
				'no_po'					=> $data['no_po'],
				'id_cara_pembayaran_1'	=> $data['id_cara_pembayaran_1'],
				'jumlah_bayar_1'		=> $data['jumlah_bayar_1'],
				'id_cara_pembayaran_2'	=> $data['id_cara_pembayaran_2'],
				'jumlah_bayar_2'		=> $data['jumlah_bayar_2'],
				'active'				=> '1'
		);
        $this->db->insert('tb_penjualan', $ins);
        
        return;
	}
	
	function update_jual($data)
	{
		$upd = array(
				'id_penjualan'			=> $data['id_penjualan'],
				'tanggal_penjualan'		=> $data['tanggal_penjualan'],
				'no_po'					=> $data['no_po'],
				'id_cara_pembayaran_1'	=> $data['id_cara_pembayaran_1'],
				'jumlah_bayar_1'		=> $data['jumlah_bayar_1'],
				'id_cara_pembayaran_2'	=> $data['id_cara_pembayaran_2'],
				'jumlah_bayar_2'		=> $data['jumlah_bayar_2'],
				'active'				=> '1'
		);
		$prm = array('id_penjualan'=>$data['id_penjualan'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_penjualan', $upd);
		
		return;
	}
    
	function delete_jual($data)
	{
	   $upd = array('active' => '0');
       $prm = array('id_penjualan'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_penjualan', $upd);
	   
	   return;
	}
    
    function get_jual($data)
    {
        $result = $this->db->query("SELECT a.id_penjualan, a.tanggal_penjualan, a.no_po, a.id_cara_pembayaran_1, a.jumlah_bayar_1, a.id_cara_pembayaran_2, a.jumlah_bayar_2, a.active, b.nama_cara_pembayaran nama_cara_pembayaran_1, c.nama_cara_pembayaran nama_cara_pembayaran_2 FROM tb_penjualan a LEFT JOIN tb_cara_pembayaran b ON b.id_cara_pembayaran = a.id_cara_pembayaran_1 LEFT JOIN tb_cara_pembayaran c ON c.id_cara_pembayaran = a.id_cara_pembayaran_2 WHERE a.active=1 AND a.id_penjualan='".$data."'");
		
        return $result;
    }
	
	function get_jual1($data)
    {
        $result = $this->db->query("SELECT a.id_penjualan, a.tanggal_penjualan, a.no_po, a.id_cara_pembayaran_1, a.jumlah_bayar_1, a.id_cara_pembayaran_2, a.jumlah_bayar_2, a.active, b.nama_cara_pembayaran nama_cara_pembayaran_1, c.nama_cara_pembayaran nama_cara_pembayaran_2, (SELECT aa.jumlah_bayar FROM tb_pembayaran aa WHERE aa.active='1' AND aa.id_po = a.no_po AND aa.id_penjualan='0') dp FROM tb_penjualan a LEFT JOIN tb_cara_pembayaran b ON b.id_cara_pembayaran = a.id_cara_pembayaran_1 LEFT JOIN tb_cara_pembayaran c ON c.id_cara_pembayaran = a.id_cara_pembayaran_2 WHERE a.active='1' AND a.id_penjualan = '".$data."'");
		
        return $result;
    }
	
	function get_detail_jual($data)
    {
        $result = $this->db->query("SELECT a.id_detail_penjualan, a.id_penjualan, a.id_barang, a.jumlah_stok, a.total_harga, a.active, b.nama_barang, b.harga_barang FROM tb_detail_penjualan a LEFT JOIN tb_barang b ON b.id_barang = a.id_barang WHERE a.active=1 AND a.id_penjualan='".$data."'");
		
        return $result;
    }
	
	function add_detail_jual($data)
	{
		$ins_dtl = array(
			'id_detail_penjualan'	=> $data['id_detail_penjualan'],
			'id_penjualan'			=> $data['id_penjualan'],
			'id_barang'				=> $data['id_barang'],
			'jumlah_stok'			=> $data['kuantum'],
			'total_harga'			=> $data['total_harga'],
			'active'				=> $data['active']
		);
		$this->db->insert('tb_detail_penjualan', $ins_dtl);
		
		return;
	}
	
	function delete_detail_jual($data)
	{
	   	$upd = array('active'	=> 0);
		$prm = array('id_penjualan' => $data);
		
		$this->db->where($prm);
		$this->db->update('tb_detail_penjualan', $upd);
		
		return;
	}
	
	function del_detail_jual($data)
	{
		$prm = array('id_penjualan' => $data);
		
		$this->db->delete('tb_detail_penjualan', $prm);
		
		return;
	}
	
	function delete_alljual($data)
	{
		$select_jual = $this->db->query("SELECT id_penjualan FROM tb_penjualan 
										WHERE tanggal_penjualan >= '".$data['date_from']."' AND tanggal_penjualan <= '".$data['date_to']."';");
		foreach($select_jual->result_array() as $jual)
		{
			$result_1 = $this->db->query("DELETE FROM tb_detail_penjualan WHERE id_penjualan='".$jual['id_penjualan']."';");
			$result_2 = $this->db->query("DELETE FROM tb_penjualan WHERE id_penjualan='".$jual['id_penjualan']."';");
			$result_3 = $this->db->query("DELETE FROM tb_pembayaran WHERE id_penjualan='".$jual['id_penjualan']."';");
			$result_4 = $this->db->query("DELETE FROM tb_transaksi_stok WHERE id_penjualan='".$jual['id_penjualan']."';");
		}
	}
	#====================================================== Digunakan Untuk Pembayaran Jual ======================================================
	function del_bayar_jual($data)
	{
		$prm = array('id_penjualan' => $data);
		
		$this->db->delete('tb_pembayaran', $prm);
		
		return;
	}
	
	function delete_bayar_jual($data)
	{
	   	$upd = array('active'	=> '0');
		$prm = array('id_penjualan' => $data);
		
		$this->db->where($prm);
		$this->db->update('tb_pembayaran', $upd);
		
		return;
	}
	
	function add_bayar_jual($data)
	{
		$ins = array(
				'id_pembayaran'			=> $data['id_pembayaran'],
				'tanggal_pembayaran'	=> $data['tanggal_pembayaran'],
				'id_po'					=> 0,
				'id_penjualan'			=> $data['id_penjualan'],
				'id_cara_pembayaran'	=> $data['id_cara_pembayaran'],
				'jumlah_bayar'			=> $data['jumlah_bayar'],
				'keterangan'			=> $data['keterangan'],
				'active'				=> '1'
		);
        $this->db->insert('tb_pembayaran_jual', $ins);
        
        return;
	}
	
	function select_penjualan($id_penjualan)
	{
		$result = $this->db->query("SELECT id_penjualan, no_po, id_cara_pembayaran_1, jumlah_bayar_1, id_cara_pembayaran_2, jumlah_bayar_2 FROM tb_penjualan 
								   	WHERE active=1 AND id_penjualan='".$id_penjualan."';");
		return $result->result_array();
	}
	
	function get_detail_penjualan($id)
	{
        $query = $this->db->query("SELECT a.id_barang,a.id_satuan_barang,a.kuantum,a.harga_satuan,a.diskon_persen,a.diskon_rupiah,a.total_harga_barang, b.nama_barang, c.kode_satuan from tb_detail_penjualan as a, tb_barang as b, tb_satuan_barang as c where a.id_penjualan='".$id."' and a.id_barang=b.id_barang and a.id_satuan_barang=c.id_satuan_barang ORDER BY a.id_detail_penjualan ASC");
        return $query->result_array();
	}
}
?>