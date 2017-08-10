<?php
class Model_beli extends Model
{
	function Model_beli()
	{
		parent::Model();
	}
	
	function generate_no_beli()
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
            $no_beli = 'PBL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_beli = 'PBL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_beli;
	}
	
	function generate_no_detail_beli()
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
            $no_detail_beli = 'DBL'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_detail_beli = 'DBL'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_detail_beli;
	}
	
	function generate_no_bayar_beli()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
       $query = $this->db->query("SELECT id_pembayaran FROM tb_pembayaran_beli WHERE id_pembayaran LIKE '%".$yearmonth."%' ORDER BY id_pembayaran DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_pembayaran'];
       }
       
       if($hasil == 0)
       {
            $no_bayar_beli = 'PBB'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_bayar_beli = 'PBB'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_bayar_beli;
	}
	
	function generate_no_kuitansi()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
       $query = $this->db->query("SELECT no_kuitansi FROM tb_pembayaran_beli WHERE no_kuitansi LIKE '%".$yearmonth."%' ORDER BY no_kuitansi DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['no_kuitansi'];
       }
       
       if($hasil == 0)
       {
            $no_kuitansi = 'KWT'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_kuitansi = 'KWT'.$yearmonth.substr($joinref,-7);
       }
       
	   return $no_kuitansi;
	}
    
	function generate_id_jurnal()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
       $query = $this->db->query("SELECT id_jurnal FROM tb_jurnal WHERE id_jurnal LIKE '%".$yearmonth."%' ORDER BY id_jurnal DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_jurnal'];
       }
       
       if($hasil == 0)
       {
            $id_jurnal = 'JUR'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_jurnal = 'JUR'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_jurnal;
	}
	
	function generate_no_jurnal()
	{
	   $noref='';
	   $yearmonth = date("y").date("m");
       $query = $this->db->query("SELECT no_jurnal FROM tb_jurnal WHERE no_jurnal LIKE '%".$yearmonth."%' ORDER BY no_jurnal DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['no_jurnal'];
       }
       
       if($hasil == 0)
       {
            $no_jurnal = 'GJ'.$yearmonth.'00001';
       }
       else
       {
            $gethasil = substr($noref, -5);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $no_jurnal = 'GJ'.$yearmonth.substr($joinref,-5);
       }
       
	   return $no_jurnal;
	}
	
	function add_beli($data)
	{
		$ins = array(
				'id_pembelian'			=> $data['id_pembelian'],
				'tgl_pembelian'			=> $data['tgl_pembelian'],
				'no_po'					=> $data['no_po'],
				'no_invoice'			=> $data['no_invoice'],
				'no_surat_jalan'		=> $data['no_surat_jalan'],
				'tgl_jatuh_tempo'		=> $data['tgl_jatuh_tempo'],
				'nama_karyawan'			=> $data['nama_karyawan'],
				'id_supplier'			=> $data['id_supplier'],
				'id_cara_pembayaran'	=> $data['id_cara_pembayaran'],
				'keterangan'			=> $data['keterangan'],
				'ppn'					=> $data['ppn'],
				'biaya_pengiriman'		=> $data['biaya_pengiriman'],
				'biaya_lain'			=> $data['biaya_lain'],
				'pembayaran'			=> $data['pembayaran'],
				'total_pembayaran'		=> $data['total_pembayaran'],
				'active'				=> '1'
		);
        $this->db->insert('tb_pembelian', $ins);
        
        return;
	}
	
	function update_beli($data, $dataprm)
	{
		if($dataprm=='')
		{
			$upd = array(
					'id_pembelian'			=> $data['id_pembelian'],
					'tgl_pembelian'			=> $data['tgl_pembelian'],
					'no_po'					=> $data['no_po'],
					'no_invoice'			=> $data['no_invoice'],
					'no_surat_jalan'		=> $data['no_surat_jalan'],
					'tgl_jatuh_tempo'		=> $data['tgl_jatuh_tempo'],
					'nama_karyawan'			=> $data['nama_karyawan'],
					'id_supplier'			=> $data['id_supplier'],
					'id_cara_pembayaran'	=> $data['id_cara_pembayaran'],
					'keterangan'			=> $data['keterangan'],
					'ppn'					=> $data['ppn'],
					'biaya_pengiriman'		=> $data['biaya_pengiriman'],
					'biaya_lain'			=> $data['biaya_lain'],
					'pembayaran'			=> $data['pembayaran'],
					'total_pembayaran'		=> $data['total_pembayaran'],
					'active'				=> '1'
			);
		}
		elseif($dataprm=='1')
		{
			$upd = array(
					'id_pembelian'			=> $data['id_pembelian'],
					'pembayaran'			=> $data['pembayaran'],
					'active'				=> '1'
			);
		}
		elseif($dataprm=='2')
		{
			$upd = array(
					'id_pembelian'			=> $data['id_pembelian'],
					'total_pembayaran'		=> $data['total_pembayaran'],
					'active'				=> '1'
			);
		}
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'active'=>'1');
		$this->db->where($prm);
		$this->db->update('tb_pembelian', $upd);
		
		return;
	}
    
	function delete_beli($data)
	{
	   	$upd = array(
			'id_pembelian'	=> $data['id_pembelian'],
			'active'		=> '0'
	   	);
		$prm = array('id_pembelian'=>$data['id_pembelian']);
		
		$this->db->where($prm);
		$this->db->update('tb_pembelian', $upd);
		
		return;
	}
	
	/*function daftar_list_po($data)
	{
		
		if($data=='')
		{
			$result = $this->db->query("SELECT a.no_po, a.id_supplier, a.total_po, b.nama_supplier FROM tb_po a LEFT JOIN tb_supplier b ON b.id_supplier=a.id_supplier ORDER BY a.no_po ASC");
		}
		else
		{
			$result = $this->db->query("SELECT a.no_po, a.id_supplier, a.total_po, b.nama_supplier FROM tb_po a LEFT JOIN tb_supplier b ON b.id_supplier=a.id_supplier WHERE a.active=1 AND a.no_po='".$data."' ORDER BY a.no_po ASC");
		}
		return $result;
		
	}*/
	
    function daftar_list_beli()
	{
		$result = $this->db->query("SELECT a.id_pembelian, a.no_invoice, a.tgl_pembelian, a.no_po, a.no_surat_jalan, a.tgl_jatuh_tempo, a.total_pembayaran, a.pembayaran, b.nama_supplier, (SELECT SUM(aa.bayar) bayar FROM tb_pembayaran_beli aa WHERE aa.active=1 AND aa.id_pembelian=a.id_pembelian) total_bayar  FROM tb_pembelian a LEFT JOIN tb_supplier b ON b.id_supplier=a.id_supplier WHERE a.active=1 ORDER BY a.id_pembelian DESC");
		
		return $result;
	}
    
    function get_beli($data)
    {
        $result = $this->db->query("SELECT a.id_pembelian, a.tgl_pembelian, a.no_po, a.no_invoice, a.no_surat_jalan, a.tgl_jatuh_tempo, a.nama_karyawan, a.id_supplier, a.id_cara_pembayaran, a.keterangan, a.ppn, a.biaya_pengiriman, a.biaya_lain, a.pembayaran, a.total_pembayaran, a.active, b.nama_supplier FROM tb_pembelian a LEFT JOIN tb_supplier b ON  b.id_supplier=a.id_supplier WHERE a.active=1 AND a.id_pembelian='".$data."'");
		
        return $result;
    }
	
	function get_detail_beli($data)
    {
        $result = $this->db->query("SELECT a.id_detail_pembelian, a.id_pembelian, a.id_barang, a.id_satuan_barang, a.no_batch, a.kuantum, a.harga_satuan, a.diskon_persen, a.diskon_rupiah, a.total_harga_barang, a.active, b.nama_barang, b.kode_barang, c.kode_satuan FROM tb_detail_pembelian a LEFT JOIN tb_barang b ON b.id_barang=a.id_barang LEFT JOIN tb_satuan_barang c ON c.id_satuan_barang=a.id_satuan_barang WHERE a.active=1 AND a.id_pembelian='".$data."'");
		
        return $result;
    }
	
	function add_detail_beli($data)
	{
	   $id_detail_beli = $this->generate_no_detail_beli();
		$ins_dtl = array(
			'id_detail_pembelian'	=> $id_detail_beli,
			'id_pembelian'			=> $data['id_pembelian'],
			'id_barang'				=> $data['id_barang'],
			'id_satuan_barang'		=> $data['id_satuan_barang'],
			'no_batch'				=> $data['no_batch'],
			'kuantum'				=> $data['kuantum'],
			'harga_satuan'			=> $data['harga_satuan'],
			'diskon_persen'			=> $data['diskon_persen'],
			'diskon_rupiah'			=> $data['diskon_rupiah'],
			'total_harga_barang'	=> $data['total_harga_barang'],
			'active'				=> '1'
		);
        $this->db->insert('tb_detail_pembelian', $ins_dtl);
        
        return;
	}
	
	function batal_barang($data)
	{
		/*
		$upd = array('active'=> '0');
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'id_detail_pembelian'=>$data['id_detail_pembelian']);
		
		$this->db->where($prm);
		$this->db->update('tb_detail_pembelian', $upd);
		
		return;
		*/
	}
	
	function delete_detail_beli($data)
	{
	   	$del = array(
			'id_pembelian'	=> $data
	   	);
		$this->db->delete('tb_detail_pembelian', $del);
		
		return;
	}
	
	#====================================================== Digunakan Untuk Pembayaran Beli ======================================================
	function delete_bayar_beli($data)
	{
	   	$upd = array('active'=> '0');
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'id_pembayaran'=>$data['id_pembayaran']);
		
		$this->db->where($prm);
		$this->db->update('tb_pembayaran_beli', $upd);
		
		return;
	}
	
	function add_bayar_beli($data)
	{
		$ins = array(
				'id_pembayaran'			=> $data['id_pembayaran'],
				'no_invoice'			=> $data['no_invoice'],
				'id_pembelian'			=> $data['id_pembelian'],
				'no_kuitansi'			=> $data['no_kuitansi'],
				'tanggal_pembayaran'	=> $data['tanggal_pembayaran'],
				'bayar'					=> $data['bayar'],
				'id_cara_pembayaran'	=> $data['id_cara_pembayaran'],
				'active'				=> '1'
		);
        $this->db->insert('tb_pembayaran_beli', $ins);
        
        return;
	}
	
	function get_detail_bayar($data)
    {
        $result = $this->db->query("SELECT a.id_pembayaran, a.id_pembelian, a.no_invoice, a.no_kuitansi, a.tanggal_pembayaran, a.bayar, a.id_cara_pembayaran, b.nama_cara_pembayaran, a.active FROM tb_pembayaran_beli a LEFT JOIN tb_cara_pembayaran b ON a.id_cara_pembayaran = b.id_cara_pembayaran WHERE a.active=1 AND a.id_pembelian='".$data."' ORDER BY a.id_pembayaran ASC");
		
        return $result;
    }
	
	#====================================================== Digunakan Untuk Jurnal ======================================================
	function add_jurnal_beli($data)
	{
		$ins = array(
				'id_jurnal'				=> $data['id_jurnal'],
				'no_jurnal'				=> $data['no_jurnal'],
				'id_coa'				=> $data['id_coa'],
				'tanggal_transaksi'		=> $data['tanggal_transaksi'],
				'id_pembelian'			=> $data['id_pembelian'],
				'id_pembayaran_beli'	=> $data['id_pembayaran_beli'],
				'debit'					=> $data['debit'],
				'kredit'				=> $data['kredit'],
				'keterangan'			=> $data['keterangan'],
				'active'				=> $data['active']
		);
        $this->db->insert('tb_jurnal', $ins);
        
        return;
	}
	
	function delete_jurnal_beli($data)
	{
	   	$upd = array('active'=>'0');
		$prm = array('no_jurnal'=>$data['no_jurnal'], 'id_pembelian'=>$data['id_pembelian']);
		
		$this->db->where($prm);
		$this->db->update('tb_jurnal', $upd);
		
		return;
	}
	
	function delete_jurnal_bayar_beli($data)
	{
	   	$upd = array('active'=>'0');
		$prm = array('id_pembelian'=>$data['id_pembelian'], 'id_pembayaran_beli'=>$data['id_pembayaran_beli']);
		
		$this->db->where($prm);
		$this->db->update('tb_jurnal', $upd);
		
		return;
	}
	
	function get_no_jurnal($data)
    {
        $query = $this->db->query("SELECT no_jurnal, id_coa, debit, kredit FROM tb_jurnal WHERE id_pembelian='".$data[0]."' AND id_pembayaran_beli='".$data[1]."' ORDER BY id_jurnal ASC");
		
        return $query;
    }
	
	function nojurnal_max($data)
    {
		$nojrnmax = '';
        //$query = $this->db->query("SELECT MAX(no_jurnal) no_jurnal FROM tb_jurnal WHERE id_pembelian = '".$data."'");
		$query = $this->db->query("SELECT MAX(no_jurnal) no_jurnal FROM tb_jurnal WHERE id_pembelian = '".$data."' And id_pembayaran_beli=0 And active=1");
		foreach($query->result_array() as $row)
		{
			$nojrnmax = $row['no_jurnal'];
		}
		
        return $nojrnmax;
    }
	
	function get_no_jurnal_max($data)
    {
        $query = $this->db->query("SELECT no_jurnal, id_coa, debit, kredit FROM tb_jurnal WHERE id_pembelian='".$data[0]."' AND id_pembayaran_beli='".$data[1]."' AND no_jurnal = '".$data[2]."' ORDER BY id_jurnal ASC");
		
        return $query;
    }
	
	/////////////////////////////////////////////////Laporan Pembelian/////////////////////////////////////////////////////////////
	function get_data_pembelian($date)
	{
        $query = $this->db->query("SELECT a.id_pembelian, a.tgl_pembelian,a.no_invoice,a.no_surat_jalan,a.nama_karyawan, a.ppn, a.biaya_pengiriman, a.biaya_lain, a.total_pembayaran from tb_pembelian as a where a.active=1 and a.tgl_pembelian >= '".$date['startdate']."' and a.tgl_pembelian <= '".$date['enddate']."' ORDER BY a.id_pembelian ASC");
        return $query->result_array();
	}
	
	function get_detail_pembelian($id)
	{
        $query = $this->db->query("SELECT a.id_barang,a.id_satuan_barang,a.kuantum,a.harga_satuan,a.diskon_persen,a.diskon_rupiah,a.total_harga_barang, b.nama_barang, c.kode_satuan from tb_detail_pembelian as a, tb_barang as b, tb_satuan_barang as c where a.id_pembelian='".$id."' and a.id_barang=b.id_barang and a.id_satuan_barang=c.id_satuan_barang ORDER BY a.id_detail_pembelian ASC");
        return $query->result_array();
	}
	
	function select_kuantum_beli()
	{
		$query = $this->db->query("SELECT kuantum FROM tb_detail_pembelian WHERE id_barang='".$data."' AND id_pem;");
	}
}
?>