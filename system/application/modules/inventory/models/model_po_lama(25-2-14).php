<?php
class Model_po extends Model
{
	function Model_po()
	{
		parent::Model();
	}
	
	function generate_no_po()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
       $query = $this->db->query("SELECT no_po FROM tb_po WHERE no_po LIKE '%".$yearmonth."%' ORDER BY no_po DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['no_po'];
       }
       
       if($hasil == 0)
       {
            $no_po = 'PUO'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_po = 'PUO'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_po;
	}
    
    function generate_no_detail_po()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
       $query = $this->db->query("SELECT id_detail_po FROM tb_detail_po WHERE id_detail_po LIKE '%".$yearmonth."%' ORDER BY id_detail_po DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_detail_po'];
       }
       
       if($hasil == 0)
       {
            $no_po = 'DPO'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_po = 'DPO'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_po;
	}
    
	function add_po($data)
	{
       $ins = array(
                'no_po'             => $data['no_po'],
                'tanggal_po'		=> $data['tanggal_po'],
                'nama_customer'		=> $data['nama_customer'],
                'telepon'           => $data['telepon'],
                'telepon_2'	        => $data['telepon_2'],
                'telepon_3'         => $data['telepon_3'],
                'jumlah_bayar'      => $data['jumlah_bayar'],
                'id_cara_pembayaran'=> $data['id_cara_pembayaran'],
                'bayar_awal'        => $data['bayar_awal'],
                'active'            => '1'
        );
        $this->db->insert('tb_po', $ins);
	}
    
    function generate_id_pembayaran()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m").date("d");
       $query = $this->db->query("SELECT id_pembayaran FROM tb_pembayaran WHERE id_pembayaran LIKE '%".$yearmonth."%' ORDER BY id_pembayaran DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_pembayaran'];
       }
       
       if($hasil == 0)
       {
            $id_pembayaran = 'BYR'.$yearmonth.'0001';
       }
       else
       {
            $gethasil = substr($noref, -4);
            $sumref = $gethasil+1;
            $joinref = '0000'.$sumref;
            $id_pembayaran = 'BYR'.$yearmonth.substr($joinref,-4);
       }
       
	   return $id_pembayaran;
	}
    
	function add_po_bayar($data)
	{
		$this->db->set('id_pembayaran', $data['id_pembayaran']);
		$this->db->set('tanggal_pembayaran', $data['tanggal_pembayaran']);
		$this->db->set('id_po', $data['id_po']);
		$this->db->set('id_penjualan', $data['id_penjualan']);
		$this->db->set('id_cara_pembayaran', $data['id_cara_pembayaran']);
		$this->db->set('jumlah_bayar', $data['jumlah_bayar']);
		$this->db->set('active', '1');
        $this->db->insert('tb_pembayaran');
	}
	
    function add_po_detail($data)
	{
       $ins_dtl = array(
                'id_detail_po'      => $data['id_detail_po'],
                'no_po'             => $data['no_po'],
                'id_barang'         => $data['id_barang'],
                'stok_pesan'        => $data['stok_pesan'],
                'total_harga'       => $data['total_harga'],
                'active'            => '1'
        );
        $this->db->insert('tb_detail_po', $ins_dtl);
	}
	
	function select_pembayaran($data)
	{
       $query = $this->db->query("SELECT * FROM tb_pembayaran where id_po='".$data."' and active=1;");
	   return $query->result_array();
	}
    
    function daftar_list_po($date)
	{
		$query = $this->db->query("SELECT a.no_po, a.tanggal_po, a.nama_customer, a.telepon, a.telepon_2, a.telepon_3, a.bayar_awal, a.id_cara_pembayaran, 
								  	a.jumlah_bayar, (SELECT COUNT(b.no_po) FROM tb_penjualan b WHERE b.no_po = a.no_po AND b.active='1') jumlah_po 
								   	FROM tb_po a WHERE a.active=1 and a.tanggal_po='".$date."' ORDER BY a.no_po DESC");
		$result = $query->result_array();
		$no=0;
		foreach($result as $data)
		{
			$result[$no]['pembayaran'] = $this->select_pembayaran($data['no_po']);
			$no++;
		}
		return $result;
	}
    
	function get_detail_po($data)
    {
        $result = $this->db->query("SELECT a.id_detail_po, a.no_po, a.id_barang, a.stok_pesan, a.total_harga, b.nama_barang, b.harga_barang
								   	FROM tb_detail_po a, tb_barang as b WHERE a.active=1 AND a.no_po='".$data."' and a.id_barang=b.id_barang");
        return $result;
    }
    
    function get_po($data)
    {
        $result = $this->db->query("SELECT a.no_po, a.tanggal_po, a.nama_customer, a.telepon, a.telepon_2, a.telepon_3, a.bayar_awal, a.id_cara_pembayaran, a.jumlah_bayar, b.nama_cara_pembayaran FROM tb_po a LEFT JOIN tb_cara_pembayaran b ON b.id_cara_pembayaran=a.id_cara_pembayaran WHERE a.no_po='".$data."'");
		
		return $result;
    }
    
    function get_po2($data)
    {
        $query = $this->db->query("SELECT a.no_po, a.tanggal_po, a.nama_customer, a.telepon, a.telepon_2, a.telepon_3, a.bayar_awal, a.id_cara_pembayaran, a.jumlah_bayar, b.nama_cara_pembayaran FROM tb_po a LEFT JOIN tb_cara_pembayaran b ON b.id_cara_pembayaran=a.id_cara_pembayaran WHERE a.no_po='".$data."'");
		$result = $query->result_array();
		$detail = $this->select_pembayaran($result[0]['no_po']);
		
		$jum=0;$no=0;
		foreach($detail as $data)
		{
			$jum = $jum + $data['jumlah_bayar'];
			$no++;
		}
		$result[0]['jum_pembayaran'] = $jum;
		$result[0]['count_pembayaran'] = $no;
		
		return $result;
    }
    
    function select_pembayaran_awal($no_po)
    {
        $result = $this->db->query("SELECT id_pembayaran FROM tb_pembayaran WHERE id_po='".$no_po."' and active=1 order by id_pembayaran DESC limit 0,1;");
		
		return $result->result_array();
    }
    
    function inactive_po_bayar($id_pembayaran)
    {
        $result = $this->db->query("update tb_pembayaran set active=0 where id_pembayaran='".$id_pembayaran."';");
    }
    
    function update_po_bayar($data)
    {
        $result = $this->db->query("update tb_pembayaran set tanggal_pembayaran='".$data['tanggal_pembayaran']."', id_cara_pembayaran='".$data['id_cara_pembayaran']."', jumlah_bayar='".$data['jumlah_bayar']."' where id_pembayaran='".$data['id_pembayaran']."';");
    }
    
    function update_po($data)
    {
        $result = $this->db->query("update tb_po set tanggal_po='".$data['tanggal_po']."', nama_customer='".$data['nama_customer']."', telepon='".$data['telepon']."', telepon_2='".$data['telepon_2']."', telepon_3='".$data['telepon_3']."', jumlah_bayar='".$data['jumlah_bayar']."', bayar_awal='".$data['bayar_awal']."', id_cara_pembayaran='".$data['id_cara_pembayaran']."' where no_po='".$data['no_po']."';");
    }
	
	function delete_detail_po($data)
	{
	   	$del = array(
			'no_po'	=> $data
	   	);
		$this->db->delete('tb_detail_po', $del);
		
		return;
	}
    
    function inactive_po($no_po)
    {
        $result = $this->db->query("update tb_po set active=0 where no_po='".$no_po."';");
    }
	
	function inactive_detail_po($no_po)
	{
		$result = $this->db->query("UPDATE tb_detail_po SET active=0 WHERE no_po='".$no_po."';");
		return $result;
	}
	
	function detail_pembayaran($no_po)
	{
		$result = $this->db->query("SELECT id_pembayaran, id_cara_pembayaran, jumlah_bayar FROM tb_pembayaran 
								   	WHERE active=1 AND id_po='".$no_po."' AND id_penjualan='0';");
		return $result->result_array();
	}
	
	function update_bayar_po($data)
	{
		$result = $this->db->query("UPDATE tb_pembayaran SET id_penjualan='".$data['id_penjualan']."' WHERE active=1 AND id_po='".$data['id_po']."';");
		return $result;
	}
	
	function jml_po($data)
	{
		$result = $this->db->query("SELECT COUNT(no_po) jumlah_po FROM tb_po WHERE active='1' AND tanggal_po='".$data."';");
		return $result->result_array();
	}
	
	function jml_po_sudah_ambil($data)
	{
		$result = $this->db->query("SELECT COUNT(no_po) jumlah_po_ambil FROM tb_penjualan WHERE no_po<>'0' AND active='1' AND tanggal_penjualan='".$data."';");
		return $result->result_array();
	}
	
	function delete_po($data)
	{
		$select_po = $this->db->query("SELECT no_po FROM tb_po WHERE tanggal_po >= '".$data['date_from']."' AND tanggal_po <= '".$data['date_to']."';");
		foreach($select_po->result_array() as $po)
		{
			$result_1 = $this->db->query("DELETE FROM tb_detail_po WHERE no_po='".$po['no_po']."';");
			$result_2 = $this->db->query("DELETE FROM tb_po WHERE no_po='".$po['no_po']."';");
		}
	}
}
?>