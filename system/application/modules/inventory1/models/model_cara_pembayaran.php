<?php
class Model_cara_pembayaran extends Model
{
	function Model_cara_pembayaran()
	{
		parent::Model();
	}
	
	function generate_id_cara_pembayaran()
	{
	   $noref='';
	   $yearmonth = date("Y").date("m");
	   $query = $this->db->query("SELECT id_cara_pembayaran FROM tb_cara_pembayaran 
								 WHERE id_cara_pembayaran LIKE '%".$yearmonth."%' ORDER BY id_cara_pembayaran DESC LIMIT 0, 1");
       $hasil = $query->num_rows();
       
       foreach($query->result_array() as $query1)
	   {
			$noref = $query1['id_cara_pembayaran'];
       }
       
       if($hasil == 0)
       {
            $id_cara_pembayaran = 'CRBY'.$yearmonth.'0000001';
       }
       else
       {
            $gethasil = substr($noref, -7);
            $sumref = $gethasil+1;
            $joinref = '0000000'.$sumref;
            $id_cara_pembayaran = 'CRBY'.$yearmonth.substr($joinref,-7);
       }
       
	   return $id_cara_pembayaran;
	}
	
	function select_cara_bayar()
	{
		$result = $this->db->query("SELECT id_cara_pembayaran, nama_cara_pembayaran, keterangan FROM tb_cara_pembayaran WHERE active=1");
		return $result;
	}
	
	function insert_cara_pembayaran($data)
	{
		$ins = array(
				'id_cara_pembayaran'	=> $data['id_cara_pembayaran'],
				'nama_cara_pembayaran'	=> $data['nama_cara_pembayaran'],
				'keterangan'			=> $data['keterangan'],
				'active'				=> '1'
		);
        $this->db->insert('tb_cara_pembayaran', $ins);
        
        return;
	}
	
	function update_cara_pembayaran($data)
	{
		$upd = array(
				'id_cara_pembayaran'	=> $data['id_cara_pembayaran'],
				'nama_cara_pembayaran'	=> $data['nama_cara_pembayaran'],
				'keterangan'			=> $data['keterangan'],
				'active'				=> '1'
		);
		$prm = array('id_cara_pembayaran'=>$data['id_cara_pembayaran'], 'active'=>'1');
		
		$this->db->where($prm);
		$this->db->update('tb_cara_pembayaran', $upd);
		
		return;
	}
	
	function delete_cara_pembayaran($data)
	{
	   $upd = array(
				'id_cara_pembayaran'	=> $data,
				'active'				=> '0'
	   );
       $prm = array('id_cara_pembayaran'=>$data);
	   
	   $this->db->where($prm);
       $this->db->update('tb_cara_pembayaran', $upd);
	   
	   return;
	}
	
	function find_cara_pembayaran($data)
	{
		$result = $this->db->query("SELECT id_cara_pembayaran, nama_cara_pembayaran, keterangan FROM tb_cara_pembayaran 
								   	WHERE active=1 AND id_cara_pembayaran='".$data."' ORDER BY nama_cara_pembayaran ASC");
		return $result;
	}
	
	function summary_cara_bayar($data)
	{
		$result = $this->db->query("SELECT a.id_cara_pembayaran, a.nama_cara_pembayaran, 
								   	(SELECT SUM(b.jumlah_bayar) FROM tb_pembayaran b 
										WHERE b.id_cara_pembayaran=a.id_cara_pembayaran AND b.active='1' AND b.tanggal_pembayaran='".$data."') jumlah_bayar 
								   	FROM tb_cara_pembayaran a WHERE a.active='1' AND a.id_cara_pembayaran <> 'CRBY2011030000002' ORDER BY a.nama_cara_pembayaran ASC;");
		return $result;
	}
}
?>