<?php
class Laporan extends Controller
{
	function Laporan()
	{
		parent::Controller();
		$this->load->model('model_barang');
		$this->load->model('model_cara_pembayaran');
		$this->load->model('model_operasional');
		$this->load->model('model_po');
		val_url();
	}
	
    function index()
    {
		//$status = get_status_user();
		$tamp_data = $this->model_operasional->select_saldo_awal(date("Y-m-d"));
		if($tamp_data->num_rows() != 0)
		{
			foreach($tamp_data->result_array() as $row)
			{
				$id_saldo = $row['id_saldo'];
				$jumlah_saldo = $row['jumlah_saldo'];
			}
		}
		else
		{
			$id_saldo = 0;
			$jumlah_saldo = 0;
		}
		
		$total_po = $this->model_po->jml_po(date("Y-m-d"));
		$total_po_ambil = $this->model_po->jml_po_sudah_ambil(date("Y-m-d"));
		$total_po_belum_ambil = $total_po[0]['jumlah_po'] - $total_po_ambil[0]['jumlah_po_ambil'];

		$mydata = array(
			'form'				=> '',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_laporan_jual"',
			'active_menus'		=> 'id="active_menus_laporan"',
			'page'				=> 'laporan_page',
			'menu'				=> 'laporan_jual',
			'list_pesan'		=> $total_po_belum_ambil,
			'list_barang_pesan'	=> $this->model_barang->pesan_belum_ambil_per_item(date("Y-m-d")),
			'list_barang'		=> $this->model_barang->summary_barang(date("Y-m-d")),
			'list_cara_bayar'	=> $this->model_cara_pembayaran->summary_cara_bayar(date("Y-m-d")),
			'list_pengeluaran'	=> $this->model_operasional->summary_pengeluaran(date("Y-m-d")),
			'tanggal'			=> date("d/m/Y"),
			'id_saldo'			=> $id_saldo,
			'jumlah_saldo'		=> $jumlah_saldo,
			'daftar_list_stok'	=> '',
			'data_stok'		    => '',
			'data_detail_stok'	=> ''
			//'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$mydata);
    }
    
	function laporan_pertanggal($date)
	{
		$tamp_data = $this->model_operasional->select_saldo_awal($date);
		if($tamp_data->num_rows() != 0)
		{
			foreach($tamp_data->result_array() as $row)
			{
				$id_saldo = $row['id_saldo'];
				$jumlah_saldo = $row['jumlah_saldo'];
			}
		}
		else
		{
			$id_saldo = 0;
			$jumlah_saldo = 0;
		}
		
		$total_po = $this->model_po->jml_po($date);
		$total_po_ambil = $this->model_po->jml_po_sudah_ambil($date);
		$total_po_belum_ambil = $total_po[0]['jumlah_po'] - $total_po_ambil[0]['jumlah_po_ambil'];
		
		$mydata = array(
			'form'				=> '',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_laporan_jual"',
			'active_menus'		=> 'id="active_menus_laporan"',
			'page'				=> 'laporan_page',
			'menu'				=> 'laporan_jual',
			'list_pesan'		=> $total_po_belum_ambil,
			'list_barang_pesan'	=> $this->model_barang->pesan_belum_ambil_per_item($date),
			'list_barang'		=> $this->model_barang->summary_barang($date),
			'list_cara_bayar'	=> $this->model_cara_pembayaran->summary_cara_bayar($date),
			'list_pengeluaran'	=> $this->model_operasional->summary_pengeluaran($date),
			'tanggal'			=> explode_date($date, 1),
			'id_saldo'			=> $id_saldo,
			'jumlah_saldo'		=> $jumlah_saldo,
			'daftar_list_stok'	=> '',
			'data_stok'		    => '',
			'data_detail_stok'	=> ''
			//'user_status'		=> $status
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function export_to_excel($date=""){
		if($date=="") $date = date('Y-m-d');
		
		$data['list_barang']	= $this->model_barang->summary_barang($date);
		
		$data['tanggal'] = $date;
		$data['perusahaan']['nama_perusahaan'] = 'PIA LEGONG';
		$data['perusahaan']['lokasi'] = 'Lokasi PIA LEGONG';
		
		//---------------------------- EXCEL START
		$this->load->library('excel');
		$this->load->view('inventory/laporan_jual_export_excel', $data);
	}
	
	function view_laporan()
	{
		$tgl = $this->input->post('tgl');
		$tgl = explode_date($tgl, 0);
		echo base_url().'index.php/inventory/laporan/laporan_pertanggal/'.$tgl;
	}
	
	function add_saldo_awal()
	{
		$id_saldo	= $this->input->post('id_saldo');
		$saldo		= $this->input->post('saldo_awal');
		$tanggal	= $this->input->post('tanggal');
		$tanggal	= explode_date($tanggal, 0);
		$status		= $this->input->post('status');
		$string		= $this->input->post('string');
		
		if($status == 0)
		{
			$data = array(
				'saldo'		=> $saldo,
				'tanggal'	=> $tanggal
			);
			$query = $this->model_operasional->add_saldo($data);
		}
		else
		{
			$data = array(
				'id_saldo'	=> $id_saldo,
				'saldo'		=> $saldo,
				'tanggal'	=> $tanggal
			);
			$query = $this->model_operasional->update_saldo($data);
		}
		
		echo $string;
	}
}
?>