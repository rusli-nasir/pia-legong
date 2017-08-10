<?php 
class Beli extends Controller
{
	function Beli()
	{
		parent::Controller();
		$this->load->model('model_cara_pembayaran');
		$this->load->model('model_beli');
		$this->load->model('model_satuan_barang');
		$this->load->model('model_supplier');
		$this->load->model('model_barang');
		$this->load->model('model_po');
		$this->load->model('model_stok');
		val_url();
	}
    
    function index()
    {
		$status = get_status_user();
		$mydata = array(
			'form'				=> 'inventory/beli/add_beli',
			'simpan'			=> '',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'active_menu'		=> 'class="active_beli_form"',
			'active_menus'		=> 'id="active_menus_pembelian"',
            'tab'               => 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => 'beli_form',
			'form_bayar'		=> 'beli_form',
            'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
            'data_detail'       => $this->data_field_null('add'),
            'daftar_list_beli'	=> $this->model_beli->daftar_list_beli(),
			'data_detail_beli'	=> $this->data_detail_beli_null('')->result_array(),
			'data_bayar'       	=> $this->data_field_bayar_null('', ''),
			'data_bayar_detail'	=> $this->data_detail_bayar_null(''),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
		
        $this->load->view('mainpage',$mydata);
    }
    
	function akses_beli($ambil_data)
	{
		$status = get_status_user();
		if($ambil_data == 'beli_form')
		{
			$form	= 'inventory/beli/add_beli';
			$simpan = '';
			$edit	= 'class="disable" disabled="disabled"';
			$batal	= 'class="disable" disabled="disabled"';
			$cetak	= 'class="disable" disabled="disabled"';
		}
		elseif($ambil_data == 'beli_daftar')
		{
			$form	= 'inventory/beli/delete_beli';
			$simpan = 'class="disable" disabled="disabled"';
			$edit	= 'class="disable" disabled="disabled"';
			$batal	= 'class="disable" disabled="disabled"';
			if($status[6]['status']==2)
				$batal	= '';
			$cetak	= 'class="disable" disabled="disabled"';
		}
		elseif($ambil_data == 'pembayaran_beli_form')
		{
			$form	= 'inventory/beli/add_bayar_beli';
			$simpan = 'class="disable" disabled="disabled"';
			$edit	= 'class="disable" disabled="disabled"';
			$batal	= 'class="disable" disabled="disabled"';
			$cetak	= 'class="disable" disabled="disabled"';
		}
		else
		{
			$form	= '';
			$simpan = 'class="disable" disabled="disabled"';
			$edit	= 'class="disable" disabled="disabled"';
			$batal	= 'class="disable" disabled="disabled"';
			$cetak	= 'class="disable" disabled="disabled"';
		}
		
		$mydata = array(
			'form'				=> $form,
			'simpan'			=> $simpan,
			'edit'				=> $edit,
			'batal'				=> $batal,
			'cetak'				=> $cetak,
			'active_menu'		=> 'class="active_'.$ambil_data.'"',
			'active_menus'		=> 'id="active_menus_pembelian"',
            'tab'               => 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => $ambil_data,
			'form_bayar'		=> $ambil_data,
            'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
            'data_detail'       => $this->data_field_null('add'),
            'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
			'data_detail_beli'	=> $this->data_detail_beli_null('')->result_array(),
			'data_bayar'       	=> $this->data_field_bayar_null('', ''),
			'data_bayar_detail'	=> $this->data_detail_bayar_null(''),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
		
        $this->load->view('mainpage',$mydata);
	}
	
	function add_beli()
	{
		$id_pembelian 		= $this->model_beli->generate_no_beli();
		$tglbaru 			= $this->input->post('tgl_pembelian');
		$tgl_pembelian		= explode_date($tglbaru, 0);
		$tglbaru 			= $this->input->post('tgl_jatuh_tempo');
		$tgl_jatuh_tempo	= explode_date($tglbaru, 0);
		$id_cara_pembayaran	= $this->input->post('id_cara_pembayaran');
		$keterangan			= $this->input->post('keterangan');
		$no_po				= $this->input->post('no_po');
		$no_surat_jalan		= $this->input->post('no_surat_jalan');
		$no_invoice			= $this->input->post('no_invoice');
		$nama_karyawan		= $this->input->post('nama_karyawan');
		$nama_supplier		= $this->input->post('nama_supplier');
		
		$data_input = array(
				'id_pembelian'			=> $id_pembelian,
				'tgl_pembelian'			=> $tgl_pembelian,
				'no_po'					=> $no_po,
				'no_invoice'			=> $no_invoice,
				'no_surat_jalan'		=> $no_surat_jalan,
				'tgl_jatuh_tempo'		=> $tgl_jatuh_tempo,
				'nama_karyawan'			=> $nama_karyawan,
				'id_supplier'			=> $this->input->post('id_supplier'),
				'id_cara_pembayaran'	=> $id_cara_pembayaran,
				'keterangan'			=> $keterangan,
				'ppn'					=> $this->input->post('ppn'),
				'biaya_pengiriman'		=> $this->input->post('biaya_pengiriman'),
				'biaya_lain'			=> $this->input->post('biaya_lain'),
				'pembayaran'			=> $this->input->post('pembayaran'),
				'total_pembayaran'		=> $this->input->post('total_pembayaran'),
				'active'				=> '1',
				'status'				=> 'edit',
            	'nama_supplier'   		=> $nama_supplier
		);
			
		//============== Insert Untuk Detail Pembelian ==============
		$id_pembelian          	= $id_pembelian;
		$id_detail_po			= $this->input->post('id_detail_pembelian'); //jika menggunakan po
		$id_barang				= $this->input->post('id_barang');
		$id_satuan_barang		= $this->input->post('id_satuan_barang');
		$no_batch				= $this->input->post('no_batch');
		$kuantum				= $this->input->post('kuantum');
		$kuantum_asli			= $this->input->post('kuantum_asli');
		$harga_satuan			= $this->input->post('harga_satuan');
		$diskon_persen			= $this->input->post('diskon_persen');
		$diskon_rupiah			= $this->input->post('diskon_rupiah');
		$total_harga_barang		= $this->input->post('total_harga_barang');
			
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		$nama_barang = $this->input->post('nama_barang');
		$no_batch = $this->input->post('no_batch');
		foreach($id_barang as $result)
		{
			$data = array(
				'id_detail_pembelian' => '',
				'id_pembelian' => '',
				'id_barang' => $result,
				'id_satuan_barang' => $id_satuan_barang[$no],
				'no_batch' => $no_batch[$no],
				'kuantum' => $kuantum[$no],
				'kuantum_asli' => $kuantum_asli[$no],
				'harga_satuan' => $harga_satuan[$no],
				'diskon_persen' => $diskon_persen[$no],
				'diskon_rupiah' => $diskon_rupiah[$no],
				'total_harga_barang' => $total_harga_barang[$no],
				'active' => '',
				'nama_barang' => $nama_barang[$no],
				'kode_barang' => '',
				'kode_satuan' => ''
			);
			
			if($id_satuan_barang[$no]!='0' or $kuantum[$no]!='' or $harga_satuan[$no]!='' or $diskon_persen[$no]!='' or $diskon_rupiah[$no]!='' or $total_harga_barang[$no]!='' or $nama_barang[$no]!='' or $id_barang[$no]!='')	//or $no_batch[$no]!=''
			{
				$getrecord_detail[] = $data;
			}
			
			if($id_satuan_barang[$no]!='0' and $kuantum[$no]!='' and $harga_satuan[$no]!='' and $total_harga_barang[$no]!='' and $nama_barang[$no]!='' and $id_barang[$no]!='')	//and $no_batch[$no]!=''
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		
		if($no_surat_jalan!="" and $no_invoice!="" and $nama_karyawan!="" and $sisa==0 and count($getrecord_detail2)>0)
		{
			$this->model_beli->add_beli($data_input);
			
			$contarr=0;
			$cek_active_po=0;
			$cek_active_beli=0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$cek_active_beli++;
					$contarr++;
					continue;
				}
				
				$data_input_detail = array(
					'id_pembelian' 			=> $id_pembelian,
					'id_barang' 			=> $data_id_barang,
					'id_satuan_barang' 		=> $id_satuan_barang[$contarr],
					'no_batch' 				=> $no_batch[$contarr],
					'kuantum' 				=> $kuantum[$contarr],
					'harga_satuan' 			=> $harga_satuan[$contarr],
					'diskon_persen' 		=> $diskon_persen[$contarr],
					'diskon_rupiah' 		=> $diskon_rupiah[$contarr],
					'total_harga_barang' 	=> $total_harga_barang[$contarr]
				);
				
				$this->model_beli->add_detail_beli($data_input_detail);
				
				$kuantum_send = $kuantum_asli[$contarr] - $kuantum[$contarr];
				if($kuantum[$contarr] == $kuantum_asli[$contarr])
				{
					$this->model_po->update_detail_po_active0($id_detail_po[$contarr], $kuantum_send);
					$cek_active_po++;
				}
				else
				{
					$this->model_po->update_detail_po_active1($id_detail_po[$contarr], $kuantum_send);
				}
				$contarr++;
			}
			//nonactive po yang sudah terkirim
			if($cek_active_po == ($contarr-$cek_active_beli))
			{
				$this->model_po->update_po_active0($no_po);
			}
			//============== Insert Untuk Pembayaran ==============
			$bayar = $this->input->post('pembayaran');
			if($bayar>=1)
			{
				$id_pembayaran 	= $this->model_beli->generate_no_bayar_beli();
				$data_input = array(
						'id_pembayaran'			=> $id_pembayaran,
						'no_invoice'			=> $this->input->post('no_invoice'),
						'id_pembelian'			=> $id_pembelian,
						'no_kuitansi'			=> $this->model_beli->generate_no_kuitansi(),
						'tanggal_pembayaran'	=> $tgl_pembelian,
						'bayar'					=> $bayar,
						'id_cara_pembayaran'	=> $this->input->post('id_cara_pembayaran'),
						'active'				=> '1'
				);
				$this->model_beli->add_bayar_beli($data_input);
			}
			//============== Insert Untuk Stok ==============
			$contarr=0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				
				$data_input_stok = array(
					'id_stok'			=> $this->model_stok->generate_id_stok(),
					'id_barang'			=> $data_id_barang,
					'tanggal_transaksi'	=> $tgl_pembelian,
					'stok_masuk'		=> $kuantum[$contarr],
					'stok_keluar'		=> 0,
					'id_penjualan'		=> 0,
					'id_pembelian'		=> $id_pembelian,
					'keterangan'		=> '',
					'active'			=> '1'
				);
				
				$this->model_stok->add_stok($data_input_stok);
				$contarr++;
			}
			
			//============== Insert Untuk Jurnal ==============
			$no_jurnal			= $this->model_beli->generate_no_jurnal();
			$total_keseluruhan	= $this->input->post('total_keseluruhan');
			$ppn				= $this->input->post('ppn');
			$pajak				= ($ppn/100) * $total_keseluruhan;
			$biaya_pengiriman	= $this->input->post('biaya_pengiriman');
			$biaya_lain			= $this->input->post('biaya_lain');
			if($id_cara_pembayaran=='CBY0001')	//============== Untuk Pembayaran Cash/Lunas
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000027');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0002')	//============== Untuk Pembayaran Transfer/Lunas
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000025');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0003')	//============== Untuk Pembayaran Cash/Kredit
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000027');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0004')	//============== Untuk Pembayaran Transfer/Kredit
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000025');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			redirect(base_url().'index.php/inventory/beli/akses_beli/beli_daftar');
		}
		else
		{
			$status = get_status_user();
			$mydata = array(
				'form'				=> 'inventory/beli/add_beli',
				'simpan'			=> '',
				'edit'				=> 'class="disable" disabled="disabled"',
				'batal'				=> 'class="disable" disabled="disabled"',
				'cetak'				=> 'class="disable" disabled="disabled"',
				'tab'               => 'index_edit/beli_form',
				'page'			    => 'beli_page',
				'menu'			    => 'beli_form',
				'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
				'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
				'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
				'data_detail'       => $data_input,
				'data_detail_beli'	=> $getrecord_detail,
				'user_status'		=> $status,
				'list_po'			=> $this->model_po->daftar_list_po()
			);
			$this->load->view('mainpage', $mydata);
		}
	}
	
	function add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit)
	{
		$no_jurnal 		= $vdata[0];
		$tgl_pembelian	= $vdata[1];
		$id_pembelian	= $vdata[2];
		$id_pembayaran	= $vdata[3];
		$keterangan		= $vdata[4];
		
		for($i=0; $i<=1; $i++)
		{
			$data_input_jurnal = array(
			'id_jurnal'				=> $this->model_beli->generate_id_jurnal(),
			'no_jurnal'				=> $no_jurnal,
			'id_coa'				=> $idcoa[$i],
			'tanggal_transaksi'		=> $tgl_pembelian,
			'id_pembelian'			=> $id_pembelian,
			'id_pembayaran_beli'	=> $id_pembayaran,
			'debit'					=> $debet[$i],
			'kredit'				=> $kredit[$i],
			'keterangan'			=> $keterangan,
			'active'				=> '1'
			);
			$this->model_beli->add_jurnal_beli($data_input_jurnal);
		}
	}
	
	function update_beli()
	{
		$id_pembelian		= $this->input->post('id_pembelian');
		$tglbaru 			= $this->input->post('tgl_pembelian');
		$tgl_pembelian		= explode_date($tglbaru, 0);
		$tglbaru 			= $this->input->post('tgl_jatuh_tempo');
		$tgl_jatuh_tempo	= explode_date($tglbaru, 0);
		$id_cara_pembayaran	= $this->input->post('id_cara_pembayaran');
		$keterangan			= $this->input->post('keterangan');
		$no_po				= $this->input->post('no_po');
		$no_surat_jalan		= $this->input->post('no_surat_jalan');
		$no_invoice			= $this->input->post('no_invoice');
		$nama_karyawan		= $this->input->post('nama_karyawan');
		$nama_supplier		= $this->input->post('nama_supplier');
		
		$data_input = array(
				'id_pembelian'			=> $id_pembelian,
				'tgl_pembelian'			=> $tgl_pembelian,
				'no_po'					=> $no_po,
				'no_invoice'			=> $no_invoice,
				'no_surat_jalan'		=> $no_surat_jalan,
				'tgl_jatuh_tempo'		=> $tgl_jatuh_tempo,
				'nama_karyawan'			=> $nama_karyawan,
				'id_supplier'			=> $this->input->post('id_supplier'),
				'id_cara_pembayaran'	=> $id_cara_pembayaran,
				'keterangan'			=> $keterangan,
				'ppn'					=> $this->input->post('ppn'),
				'biaya_pengiriman'		=> $this->input->post('biaya_pengiriman'),
				'biaya_lain'			=> $this->input->post('biaya_lain'),
				'pembayaran'			=> $this->input->post('pembayaran'),
				'total_pembayaran'		=> $this->input->post('total_pembayaran'),
				'active'				=> '1',
				'status'				=> 'edit',
            	'nama_supplier'   		=> $nama_supplier
		);
		
		//============== Insert Untuk Detail Pembelian ==============
		$id_pembelian          	= $id_pembelian;
		$id_barang				= $this->input->post('id_barang');
		$id_satuan_barang		= $this->input->post('id_satuan_barang');
		$no_batch				= $this->input->post('no_batch');
		$kuantum				= $this->input->post('kuantum');
		$harga_satuan			= $this->input->post('harga_satuan');
		$diskon_persen			= $this->input->post('diskon_persen');
		$diskon_rupiah			= $this->input->post('diskon_rupiah');
		$total_harga_barang		= $this->input->post('total_harga_barang');
		
		/*$getrecord_detail = $this->model_beli->get_detail_beli("PBL2011020000003");
		echo '<pre>';
		print_r($getrecord_detail->result_array());
		echo '</pre>';*/
			
		$getrecord_detail = array();
		$getrecord_detail2 = array();
		$no=0;
		$nama_barang = $this->input->post('nama_barang');
		$no_batch = $this->input->post('no_batch');
		foreach($id_barang as $result)
		{
			$data = array(
				'id_detail_pembelian' => '',
				'id_pembelian' => '',
				'id_barang' => $result,
				'id_satuan_barang' => $id_satuan_barang[$no],
				'no_batch' => $no_batch[$no],
				'kuantum' => $kuantum[$no],
				'harga_satuan' => $harga_satuan[$no],
				'diskon_persen' => $diskon_persen[$no],
				'diskon_rupiah' => $diskon_rupiah[$no],
				'total_harga_barang' => $total_harga_barang[$no],
				'active' => '',
				'nama_barang' => $nama_barang[$no],
				'kode_barang' => '',
				'kode_satuan' => ''
			);
			
			if($id_satuan_barang[$no]!='0' or $kuantum[$no]!='' or $harga_satuan[$no]!='' or $diskon_persen[$no]!='' or $diskon_rupiah[$no]!='' or $total_harga_barang[$no]!='' or $nama_barang[$no]!='' or $no_batch[$no]!='')
			{
				$getrecord_detail[] = $data;
			}
			
			if($id_satuan_barang[$no]!='0' and $kuantum[$no]!='' and $harga_satuan[$no]!='' and $total_harga_barang[$no]!='' and $nama_barang[$no]!='' and $no_batch[$no]!='')
			{
				$getrecord_detail2[] = $data;
			}
			$no++;
		}
		$sisa = count($getrecord_detail) - count($getrecord_detail2);
		/*echo '<pre>';
		print_r($getrecord_detail2);
		echo '</pre>';*/
		if($no_po!="" and $no_surat_jalan!="" and $no_invoice!="" and $nama_karyawan!="" and $sisa==0 and count($getrecord_detail2)>0)
		{
			$this->model_beli->update_beli($data_input, '');
			
			//============== Untuk Delete Tabel Detail Pembelian ============== 
			$this->model_beli->delete_detail_beli($id_pembelian);
			
			$contarr=0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				$data_input_detail = array(
					'id_pembelian' 			=> $id_pembelian,
					'id_barang' 			=> $data_id_barang,
					'id_satuan_barang' 		=> $id_satuan_barang[$contarr],
					'no_batch' 				=> $no_batch[$contarr],
					'kuantum' 				=> $kuantum[$contarr],
					'harga_satuan' 			=> $harga_satuan[$contarr],
					'diskon_persen' 		=> $diskon_persen[$contarr],
					'diskon_rupiah' 		=> $diskon_rupiah[$contarr],
					'total_harga_barang' 	=> $total_harga_barang[$contarr]
				);
				
				$this->model_beli->add_detail_beli($data_input_detail);
				$contarr++;
			}
			//============== Insert Untuk Pembayaran ==============
			$bayar = $this->input->post('pembayaran');
			if($bayar>=1)
			{
				$id_pembayaran 	= $this->model_beli->generate_no_bayar_beli();
				$data_input = array(
						'id_pembayaran'			=> $id_pembayaran,
						'no_invoice'			=> $this->input->post('no_invoice'),
						'id_pembelian'			=> $id_pembelian,
						'no_kuitansi'			=> $this->model_beli->generate_no_kuitansi(),
						'tanggal_pembayaran'	=> $tgl_pembelian,
						'bayar'					=> $this->input->post('pembayaran'),
						'id_cara_pembayaran'	=> $this->input->post('id_cara_pembayaran'),
						'active'				=> '1'
				);
				$this->model_beli->add_bayar_beli($data_input);
			}
			
			//============== Untuk Delete Tabel Stock ============== 
			$this->model_stok->delete_stok_beli_jual($id_pembelian, '0');
			//============== Insert Untuk Stock ==============
			$contarr=0;
			foreach($id_barang as $data_id_barang)
			{
				if($data_id_barang=='')
				{
					$contarr++;
					continue;
				}
				
				$data_input_stok = array(
					'id_stok'			=> $this->model_stok->generate_id_stok(),
					'id_barang'			=> $data_id_barang,
					'tanggal_transaksi'	=> $tgl_pembelian,
					'stok_masuk'		=> $kuantum[$contarr],
					'stok_keluar'		=> 0,
					'id_penjualan'		=> 0,
					'id_pembelian'		=> $id_pembelian,
					'keterangan'		=> '',
					'active'			=> '1'
				);
				
				$this->model_stok->add_stok($data_input_stok);
				$contarr++;
			}
			
			//============== Untuk Tabel Jurnal ==============
			$id_pembelian 		= $this->input->post('id_pembelian');
			$get_no_jrnmax		= $this->model_beli->nojurnal_max($id_pembelian);
			$no_jurnal			= $this->model_beli->generate_no_jurnal();
			$tglbaru 			= date("Y-m-d");
			$mdata				= array('0'=>$id_pembelian, '1'=>'0', '2'=>$get_no_jrnmax);
			$get_data_jurnal	= $this->model_beli->get_no_jurnal_max($mdata);
			
			//============== Update Untuk Tabel Jurnal ==============
			$data_upd_jurnal = array(
				'no_jurnal'				=> $get_no_jrnmax,
				'id_pembelian'			=> $id_pembelian,
				'active'				=> '0'
			);
			$this->model_beli->delete_jurnal_beli($data_upd_jurnal);
			
			$i=0;
			foreach($get_data_jurnal->result_array() as $row)
			{
				$idcoa = $row['id_coa'];
				$keterangan	= 'Reversal dari No. Jurnal '.$row['no_jurnal'];		 
				if($row['debit']>=1 && $row['kredit']<=0)
				{
					$debet	= '0';
					$kredit	= $row['debit'];
				}
				if($row['debit']<=0 && $row['kredit']>=1)
				{
					$debet	= $row['kredit'];
					$kredit	= '0';
				}
				
				$data_input_jurnal = array(
					'id_jurnal'				=> $this->model_beli->generate_id_jurnal(),
					'no_jurnal'				=> $no_jurnal,
					'id_coa'				=> $idcoa,
					'tanggal_transaksi'		=> $tglbaru,
					'id_pembelian'			=> $id_pembelian,
					'id_pembayaran_beli'	=> '0',
					'debit'					=> $debet,
					'kredit'				=> $kredit,
					'keterangan'			=> $keterangan,
					'active'				=> '0'
					);
				$this->model_beli->add_jurnal_beli($data_input_jurnal);
				$i++;
			}
			
			$no_jurnal			= $this->model_beli->generate_no_jurnal();
			$total_keseluruhan	= $this->input->post('total_keseluruhan');
			$ppn				= $this->input->post('ppn');
			$pajak				= ($ppn/100) * $total_keseluruhan;
			$biaya_pengiriman	= $this->input->post('biaya_pengiriman');
			$biaya_lain			= $this->input->post('biaya_lain');
			$id_cara_pembayaran	= $this->input->post('id_cara_pembayaran');
			$keterangan			= $this->input->post('keterangan');
			
			if($id_cara_pembayaran=='CBY0001')	//============== Untuk Pembayaran Cash/Lunas
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000027');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0002')	//============== Untuk Pembayaran Transfer/Lunas
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000025');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0003')	//============== Untuk Pembayaran Cash/Kredit
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000027');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0004')	//============== Untuk Pembayaran Transfer/Kredit
			{
				if($bayar<=0)
				{
					$id_pembayaran='0';
				}
				
				if($total_keseluruhan>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000037', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$total_keseluruhan, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$total_keseluruhan);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($pajak>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000052', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$pajak, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$pajak);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_pengiriman>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000096', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_pengiriman, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_pengiriman);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($biaya_lain>=1)
				{
					$vdata 	= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>'0', '4'=>$keterangan);
					$idcoa 	= array('0'=>'COA2011010000124', '1'=>'COA2011010000048');
					$debet 	= array('0'=>$biaya_lain, '1'=>'0');
					$kredit = array('0'=>'0', '1'=>$biaya_lain);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tgl_pembelian, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000025');
					$debet 		= array('0'=>$bayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$bayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			redirect(base_url().'index.php/inventory/beli/akses_beli/beli_daftar');
		}
		else
		{
			$status = get_status_user();
			$edit = 'class="disable" disabled="disabled"';
			if($status[6]['status']==2)
				$edit = '';
			$mydata = array(
				'form'				=> 'inventory/beli/update_beli',
				'simpan'			=> 'class="disable" disabled="disabled"',
				'edit'				=> $edit,
				'batal'				=> 'class="disable" disabled="disabled"',
				'cetak'				=> 'class="disable" disabled="disabled"',
				'tab'               => 'index_edit/beli_form',
				'page'			    => 'beli_page',
				'menu'			    => 'beli_form',
				'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
				'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
				'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
				'data_detail'       => $data_input,
				'data_detail_beli'	=> $getrecord_detail,
				'user_status'		=> $status,
				'list_po'			=> $this->model_po->daftar_list_po()
				
			);
			$this->load->view('mainpage', $mydata);
		}
		
		/*$mydata = array(
			'form'				=> 'inventory/beli/add_beli',
			'simpan'			=> '',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'           	=> 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => 'beli_form',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
			'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
            'data_detail'       => $this->data_field_null('add'),
			'data_detail_beli'	=> $this->data_detail_beli_null('')->result_array()
		);
        $this->load->view('mainpage', $mydata);*/
	}
	
	function delete_beli()
	{
		$id_pembelian = $this->input->post('batal_list');
		
		if($id_pembelian != '')
		{
			//========== Untuk Membalik nilai pembayaran ====================
			$getid	= 'False';
			foreach($id_pembelian as $id_beli)
			{
				$get_data_bayar = $this->model_beli->get_detail_bayar($id_beli);
				$i=0;
				foreach($get_data_bayar->result_array() as $row)
				{
					$xid_pembelian[$i]	= $row['id_pembelian'];
					$xid_pembayaran[$i]	= $row['id_pembayaran'];
					$getid='True';
					$i++;
				}
			}
			
			if($getid=='True')
			{
				for($i=0; $i<count($xid_pembelian); $i++)
				{
					$no_jurnal			= $this->model_beli->generate_no_jurnal();
					$get_no_jrnmax		= $this->model_beli->nojurnal_max($xid_pembelian[$i]);
					$mdata				= array('0'=>$xid_pembelian[$i], '1'=>$xid_pembayaran[$i], '2'=>$get_no_jrnmax);
					$get_data_jurnal	= $this->model_beli->get_no_jurnal_max($mdata);
					$tanggal			= date("Y-m-d");
					foreach($get_data_jurnal->result_array() as $row)
					{
						$idcoa 		= $row['id_coa'];
						$keterangan	= 'Reversal dari No. Jurnal '.$row['no_jurnal'];
						if($row['debit']>=1 && $row['kredit']<=0)
						{
							$debet	= '0';
							$kredit	= $row['debit'];
						}
						if($row['debit']<=0 && $row['kredit']>=1)
						{
							$debet	= $row['kredit'];
							$kredit	= '0';
						}
						$data_input_jurnal = array(
							'id_jurnal'				=> $this->model_beli->generate_id_jurnal(),
							'no_jurnal'				=> $no_jurnal,
							'id_coa'				=> $idcoa,
							'tanggal_transaksi'		=> $tanggal,
							'id_pembelian'			=> $xid_pembelian[$i],
							'id_pembayaran_beli'	=> $xid_pembayaran[$i],
							'debit'					=> $debet,
							'kredit'				=> $kredit,
							'keterangan'			=> $keterangan,
							'active'				=> '0'
						);
						$this->model_beli->add_jurnal_beli($data_input_jurnal);
					}
				}
			}
			else
			{
				foreach($id_pembelian as $id_beli)
				{
					$get_no_jrnmax = $this->model_beli->nojurnal_max($id_beli);
				}
			}
			//========== Untuk Membalik nilai header ====================
			foreach($id_pembelian as $id_beli)
			{
				$get_data_bayar = $this->model_beli->get_beli($id_beli);
				$i=0;
				foreach($get_data_bayar->result_array() as $row)
				{
					$nid_pembelian[$i]	= $row['id_pembelian'];
					$i++;
				}
			}
			$no_jurnal = $this->model_beli->generate_no_jurnal();
			for($i=0; $i<count($nid_pembelian); $i++)
			{
				$mdata				= array('0'=>$nid_pembelian[$i], '1'=>0, '2'=>$get_no_jrnmax);
				$get_data_jurnal	= $this->model_beli->get_no_jurnal_max($mdata);
				$y=0;
				
				$arr_nojurnal	= array();
				$arr_idcoa		= array();
				$arr_debit		= array();
				$arr_kredit		= array();
				foreach($get_data_jurnal->result_array() as $row)
				{
					$arr_nojurnal[$y]	= $row['no_jurnal'];
					$arr_idcoa[$y]		= $row['id_coa'];
					$arr_debit[$y]		= $row['debit'];
					$arr_kredit[$y]		= $row['kredit'];
					$y++;
				}
				$data_jurnal[$i] = array('jurnal_no'=>$arr_nojurnal, 'coa_id'=>$arr_idcoa, 'debet_acc'=>$arr_debit, 'kredit_acc'=>$arr_kredit);
			}
			for($i=0; $i<count($data_jurnal); $i++)
			{
				$no_jurnal		= $this->model_beli->generate_no_jurnal();
				$id_pembelian	= $nid_pembelian[$i];
				$no_jurnal_old	= $data_jurnal[$i]['jurnal_no'];
				$coa_id			= $data_jurnal[$i]['coa_id'];
				$debet_acc		= $data_jurnal[$i]['debet_acc'];
				$arr_kredit		= $data_jurnal[$i]['kredit_acc'];
				$tanggal		= date("Y-m-d");
				for($y=0; $y<count($no_jurnal_old); $y++)
				{
					$idcoa 		= $coa_id[$y];
					$keterangan	= 'Reversal dari No. Jurnal '.$no_jurnal_old[$y];			
					if($debet_acc[$y]>=1 && $arr_kredit[$y]<=0)
					{
						$debet	= '0';
						$kredit	= $debet_acc[$y];
					}
					if($debet_acc[$y]<=0 && $arr_kredit[$y]>=1)
					{
						$debet	= $arr_kredit[$y];
						$kredit	= '0';
					}
					$data_input_jurnal = array(
						'id_jurnal'				=> $this->model_beli->generate_id_jurnal(),
						'no_jurnal'				=> $no_jurnal,
						'id_coa'				=> $idcoa,
						'tanggal_transaksi'		=> $tanggal,
						'id_pembelian'			=> $id_pembelian,
						'id_pembayaran_beli'	=> '0',
						'debit'					=> $debet,
						'kredit'				=> $kredit,
						'keterangan'			=> $keterangan,
						'active'				=> '0'
					);
					$this->model_beli->add_jurnal_beli($data_input_jurnal);
				}
			}
			
			//============== Update Untuk Tabel Jurnal ==============
			$data_upd_jurnal = array(
				'no_jurnal'				=> $get_no_jrnmax,
				'id_pembelian'			=> $id_pembelian
			);
			$this->model_beli->delete_jurnal_beli($data_upd_jurnal);
			
			$id_pembelian = $this->input->post('batal_list');
			foreach($id_pembelian as $id_delete)
			{
				//============== Update Untuk Tabel PO (jika ada) ==============
				$tamp_no_po = $this->model_beli->get_beli($id_delete);
				foreach($tamp_no_po->result_array() as $no_po)
				{
					if($no_po['no_po'] != '')//dpt no_po
					{
						$result = $this->model_po->update_po_active1($no_po);
						
						$tamp_id_barang = $this->model_beli->get_detail_beli($id_delete);//dpt id_barang
						foreach($tamp_id_barang->result_array() as $id_barang)
						{
							$kuantum_detail_po 	= $this->model_po->select_kuantum_po($id_barang['id_barang'], $no_po['no_po']);
							foreach($kuantum_detail_po->result_array() as $detail_po)
							{
								$id_detail_po	= $detail_po['id_detail_po'];
								$kuantum_po 	= $detail_po['kuantum'];
							}
							
							$kuantum_beli	= $id_barang['kuantum'];
							$kuantum		= $kuantum_po + $kuantum_beli;
							
							$this->model_po->update_detail_po_kuantum_active1($kuantum, $id_detail_po);
						}
					}
				}
				
				$data_delete = array( 
					'id_pembelian'	=> $id_delete
				);
				$this->model_beli->delete_beli($data_delete);
			}
		}
		
		$status = get_status_user();
		$batal = 'class="disable" disabled="disabled"';
		if($status[6]['status']==2)
			$batal = '';
		$mydata = array(
			'form'				=> 'inventory/beli/delete_beli',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> $batal,
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'           	=> 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => 'beli_daftar',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
			'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
            'data_detail'       => $this->data_field_null('add'),
			'data_detail_beli'	=> $this->data_detail_beli_null('')->result_array(),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
        $this->load->view('mainpage', $mydata);
	}
	
	function index_edit($data_edit)
	{
		$getrecord = $this->model_beli->get_beli($data_edit);
		foreach($getrecord->result_array() as $recordset)
		{
			$id_pembelian		= $recordset['id_pembelian'];
			$tgl_pembelian		= $recordset['tgl_pembelian'];
			$no_po				= $recordset['no_po'];
			$no_invoice			= $recordset['no_invoice'];
			$no_surat_jalan		= $recordset['no_surat_jalan'];
			$tgl_jatuh_tempo	= $recordset['tgl_jatuh_tempo'];
			$nama_karyawan		= $recordset['nama_karyawan'];
			$id_supplier		= $recordset['id_supplier'];
			$id_cara_pembayaran	= $recordset['id_cara_pembayaran'];
			$keterangan			= $recordset['keterangan'];
			$ppn				= $recordset['ppn'];
			$biaya_pengiriman	= $recordset['biaya_pengiriman'];
			$biaya_lain			= $recordset['biaya_lain'];
			$pembayaran			= $recordset['pembayaran'];
			$total_pembayaran	= $recordset['total_pembayaran'];
			$nama_supplier		= $recordset['nama_supplier'];
		}
        
		$data_field = array(
			'id_pembelian'			=> $id_pembelian,
			'tgl_pembelian'			=> $tgl_pembelian,
			'no_po'					=> $no_po,
			'no_invoice'			=> $no_invoice,
			'no_surat_jalan'		=> $no_surat_jalan,
			'tgl_jatuh_tempo'		=> $tgl_jatuh_tempo,
			'nama_karyawan'			=> $nama_karyawan,
			'id_supplier'			=> $id_supplier,
			'id_cara_pembayaran'	=> $id_cara_pembayaran,
			'keterangan'			=> $keterangan,
			'ppn'					=> $ppn,
			'biaya_pengiriman'		=> $biaya_pengiriman,
			'biaya_lain'			=> $biaya_lain,
			'pembayaran'			=> $pembayaran,
			'total_pembayaran'		=> $total_pembayaran,
			'nama_supplier'			=> $nama_supplier,
			'status'             	=> 'edit'
		);
		$getrecord_detail = $this->model_beli->get_detail_beli($data_edit);
		
		$status = get_status_user();
		$edit = 'class="disable" disabled="disabled"';
		if($status[6]['status']==2)
			$edit = '';
		$mydata = array(
			'form'				=> 'inventory/beli/update_beli',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> $edit,
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'               => 'index_edit/'.$data_edit,
			'page'			    => 'beli_page',
			'menu'			    => 'beli_form',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
			'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
            'data_detail'       => $data_field,
			'data_detail_beli'	=> $getrecord_detail->result_array(),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
        $this->load->view('mainpage', $mydata);
	}
	
	function data_field_null($data)
    {
        $data_field = array(
			'no_po'					=> '',
			'tgl_pembelian'			=> '',
			'tgl_jatuh_tempo'		=> '',
			'no_surat_jalan'		=> '',
			'no_invoice'			=> '',
			'nama_karyawan'			=> '',
			'id_cara_pembayaran'	=> '',
			'keterangan'			=> '',
			'total_keseluruhan'		=> '',
			'ppn'					=> '',
			'biaya_pengiriman'		=> '',
			'biaya_lain'			=> '',
			'total_pembayaran'		=> '',
			'pembayaran'			=> '',
			'sisa_bayar'			=> '',
			'id_supplier'			=> '',
			'nama_supplier'			=> '',
			'status'             	=> $data
	    );
        
        return $data_field;
    }
	
	function data_detail_beli_null($data)
	{
		$data_field_detail = $this->model_beli->get_detail_beli($data);
		
		return $data_field_detail;
	}
	
	function find_beli()
	{
		$id_pembelian = $this->input->post('id_pembelian');
		$getdata = array(
			'data'		=> $this->model_beli->get_beli($id_pembelian)
		);
		
		foreach($getdata['data']->result_array() as $beli)
		{
			$load_data = $beli['no_po'].",".
						 $beli['tgl_pembelian'].",".
						 $beli['tgl_jatuh_tempo'].",".
						 $beli['no_surat_jalan'].",".
						 $beli['no_invoice'].",".
						 $beli['total_pembayaran'].",".
						 $beli['pembayaran'].",".
						 $beli['keterangan'];
		}
		
		echo $load_data;
	}
	
	function find_beli_detail()
	{
		$id_pembelian = $this->input->post('id_pembelian');
		$getdata = array(
			'data'	=> $this->model_beli->get_detail_beli($id_pembelian)
		);
		
		$load_data='<tr id="id_tr_detail"><td width="200">Nama Barang</td><td width="200">Satuan</td><td width="200">Qty</td><td width="200">Harga</td><td width="200">Disk(%)</td><td width="200">Disk(Rp)</td><td width="200">Sub Total</td></tr>';
		foreach($getdata['data']->result_array() as $po)
		{
			$load_data .= '<tr><td width="200">'.$po['nama_barang'].'</td><td width="200">'.$po['kode_satuan'].'</td><td width="200">'.round($po['kuantum'],5).'</td><td width="200">'.currency_format($po['harga_satuan'],0).'</td><td width="200">'.round($po['diskon_persen'],5).'</td><td width="200">'.currency_format($po['diskon_rupiah'],5).'</td><td width="200">'.currency_format($po['total_harga_barang'],0).'</td></tr>';
		}
		
		echo $load_data;
	}
	
	function find_supplier()
	{
		$data = $this->model_supplier->view_all_supplier();
		
		$mydata = array();
		foreach($data->result_array() as $row)
		{
			$mydata[] = $row;
		}
		
		echo json_encode($mydata);
	}
	
	function get_sumbayar($data)
	{
		$sumbayar = $this->model_beli->get_sum_bayar($data);
		foreach($sumbayar->result_array() as $jmlbayar)
	   	{
			$totalbayar = $jmlbayar['id_pembelian'];
       	}
		
		return $totalbayar;
	}
	
	function find_all_barang()
	{
		$data = $this->model_barang->view_all_barang();
		
		$mydata = array();
		foreach($data->result_array() as $row)
		{
			$mydata[] = $row;
		}
		
		echo json_encode($mydata);
	}	
	
	function find_all_po()
	{
		$data = $this->model_po->daftar_list_po();
		$datapo = array();
		foreach($data->result_array() as $row)
		{
			$datapo[] = $row;
		}
		echo json_encode($datapo);
	}
	
	function find_po()
	{	
		$no_po		= $this->input->post('no_po');
		echo base_url().'index.php/inventory/beli/show_po/'.$no_po;
	}
	
	function show_po($data)
	{
		$getrecord = $this->model_po->get_po($data);
		foreach($getrecord->result_array() as $recordset)
		{
			$id_pembelian		= '';
			$tgl_pembelian		= date("Y-m-d");
			$no_po				= $recordset['no_po'];
			$no_invoice			= '';
			$no_surat_jalan		= '';
			$tgl_jatuh_tempo	= date("Y-m-d");
			$nama_karyawan		= '';
			$id_supplier		= '';
			$id_cara_pembayaran	= '';
			$keterangan			= '';
			$ppn				= '';
			$biaya_pengiriman	= '';
			$biaya_lain			= '';
			$pembayaran			= '';
			$total_pembayaran	= $recordset['total_po'];
			$nama_supplier		= $recordset['nama_supplier'];
		}
        
		$data_field = array(
			'id_pembelian'			=> $id_pembelian,
			'tgl_pembelian'			=> $tgl_pembelian,
			'no_po'					=> $no_po,
			'no_invoice'			=> $no_invoice,
			'no_surat_jalan'		=> $no_surat_jalan,
			'tgl_jatuh_tempo'		=> $tgl_jatuh_tempo,
			'nama_karyawan'			=> $nama_karyawan,
			'id_supplier'			=> $id_supplier,
			'id_cara_pembayaran'	=> $id_cara_pembayaran,
			'keterangan'			=> $keterangan,
			'ppn'					=> $ppn,
			'biaya_pengiriman'		=> $biaya_pengiriman,
			'biaya_lain'			=> $biaya_lain,
			'pembayaran'			=> $pembayaran,
			'total_pembayaran'		=> $total_pembayaran,
			'nama_supplier'			=> $nama_supplier,
			'status'             	=> 'edit'
		);
		$getrecord_detail = $this->model_po->get_detail_beli_po($data);
		
		$status = get_status_user();
		$mydata = array(
			'form'				=> 'inventory/beli/add_beli',
			'simpan'			=> '',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'               => 'index_edit/'.$data,
			'page'			    => 'beli_page',
			'menu'			    => 'beli_form',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
			'daftar_list_beli'  => $this->model_beli->daftar_list_beli(),
            'data_detail'       => $data_field,
			'data_detail_beli'	=> $getrecord_detail->result_array(),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
        $this->load->view('mainpage', $mydata);
	}
	#====================================================== Digunakan Untuk Pembayaran Beli ======================================================
	function cancl_bayar($id_all)
	{
		$explodeid 			= explode('_', $id_all);
		$id_pembayaran 		= $explodeid[0];
		$id_pembelian 		= $explodeid[1];
		
		$data_delete = array(
			'id_pembelian'	=> $id_pembelian,
			'id_pembayaran'	=> $id_pembayaran
		);
		$this->model_beli->delete_bayar_beli($data_delete);
		
		//============== Digunakan untuk reversal ke jurnal =================
		$no_jurnal			= $this->model_beli->generate_no_jurnal();
		$tglbaru 			= date("Y-m-d");
		$tanggal_pembayaran	= date("Y-m-d");
		$mdata				= array('0'=>$id_pembelian, '1'=>$id_pembayaran);
		$get_data_jurnal	= $this->model_beli->get_no_jurnal($mdata);
		
		//======================= Update Untuk Jurnal Yang di Reversal =======================================
		$data_upd_jurnal = array(
			'id_pembelian'			=> $id_pembelian,
			'id_pembayaran_beli'	=> $id_pembayaran,
			'active'				=> '0'
			);
		$this->model_beli->delete_jurnal_bayar_beli($data_upd_jurnal);
		
		$i=0;
		foreach($get_data_jurnal->result_array() as $row)
		{			
			//======================= Insert Reversal Jurnal =======================================
			$idcoa = $row['id_coa'];
			$keterangan			= 'Reversal dari No. Jurnal '.$row['no_jurnal'];		 
			if($row['debit']>=1 && $row['kredit']<=0)
			{
				$debet	= '0';
				$kredit	= $row['debit'];
			}
			if($row['debit']<=0 && $row['kredit']>=1)
			{
				$debet	= $row['kredit'];
				$kredit	= '0';
			}
			
			$data_input_jurnal = array(
				'id_jurnal'				=> $this->model_beli->generate_id_jurnal(),
				'no_jurnal'				=> $no_jurnal,
				'id_coa'				=> $idcoa,
				'tanggal_transaksi'		=> $tanggal_pembayaran,
				'id_pembelian'			=> $id_pembelian,
				'id_pembayaran_beli'	=> $id_pembayaran,
				'debit'					=> $debet,
				'kredit'				=> $kredit,
				'keterangan'			=> $keterangan,
				'active'				=> '0'
				);
			$this->model_beli->add_jurnal_beli($data_input_jurnal);
			$i++;
		}
		
		//update tb_pembelian
		$data_detail = $this->model_beli->get_detail_bayar($id_pembelian)->result_array();
		
		if(count($data_detail)==0)
			$this->model_beli->update_beli(array('id_pembelian'=>$id_pembelian,'pembayaran'=>'0'), 1);
		
		$status = get_status_user();
		$mydata = array(
			'form'				=> 'inventory/beli/add_bayar_beli',
			'simpan'			=> '',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'               => 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => 'pembayaran_beli_form',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
            'data_bayar'       	=> $this->data_field_bayar_null($id_pembelian, 'add_bayar'),
			'data_bayar_detail'	=> $this->data_detail_bayar_null($id_pembelian),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
		
        $this->load->view('mainpage', $mydata);
	}
	
	function add_bayar_beli()
	{
		$id_pembayaran 		= $this->model_beli->generate_no_bayar_beli();
		$id_pembelian		= $this->input->post('id_pembelian');
		$tglbaru 			= $this->input->post('tanggal_pembayaran');
		$tanggal_pembayaran	= explode_date($tglbaru, 0);
		$id_cara_pembayaran	= $this->input->post('id_cara_pembayaran');
		$no_invoice			= $this->input->post('no_invoice');
		$keterangan			= 'Pembayaran dari No. Invoice '.$no_invoice;
		
		$data_input = array(
				'id_pembayaran'			=> $id_pembayaran,
				'no_invoice'			=> $this->input->post('no_invoice'),
				'id_pembelian'			=> $id_pembelian,
				'no_kuitansi'			=> $this->model_beli->generate_no_kuitansi(),
				'tanggal_pembayaran'	=> $tanggal_pembayaran,
				'bayar'					=> $this->input->post('dibayar'),
				'id_cara_pembayaran'	=> $id_cara_pembayaran,
				'active'				=> '1'
		);
		
		$id_pembelian 		= $this->input->post('id_pembelian');
		$bayar				= $this->input->post('bayar');
		$dibayar			= $this->input->post('dibayar');
		$jml_total_bayar	= $bayar + $dibayar;
		
		if($dibayar!="")
		{
			$this->model_beli->add_bayar_beli($data_input);
			$data = array(
				'id_pembelian'			=> $id_pembelian,
				'pembayaran'			=> $jml_total_bayar,
				'active'				=> '1'
			);
			$this->model_beli->update_beli($data, '1');
			
			if($id_cara_pembayaran=='CBY0001')
			{
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tanggal_pembayaran, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000027');
					$debet 		= array('0'=>$dibayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$dibayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0002')
			{
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tanggal_pembayaran, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000025');
					$debet 		= array('0'=>$dibayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$dibayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0003')
			{
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tanggal_pembayaran, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000027');
					$debet 		= array('0'=>$dibayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$dibayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
			if($id_cara_pembayaran=='CBY0004')
			{
				if($bayar>=1)
				{
					$no_jurnal	= $this->model_beli->generate_no_jurnal();
					$vdata 		= array('0'=>$no_jurnal, '1'=>$tanggal_pembayaran, '2'=>$id_pembelian, '3'=>$id_pembayaran, '4'=>$keterangan);
					$idcoa 		= array('0'=>'COA2011010000048', '1'=>'COA2011010000025');
					$debet 		= array('0'=>$dibayar, '1'=>'0');
					$kredit 	= array('0'=>'0', '1'=>$dibayar);
					$this->add_jurnal_allpaid($vdata, $idcoa, $debet, $kredit);
				}
			}
		}
		$status = get_status_user();
		$mydata = array(
			'form'				=> 'inventory/beli/add_bayar_beli',
			'simpan'			=> '',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'               => 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => 'pembayaran_beli_form',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
            'data_bayar'       	=> $this->data_field_bayar_null($id_pembelian, 'add_bayar'),
			'data_bayar_detail'	=> $this->data_detail_bayar_null($id_pembelian),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
        $this->load->view('mainpage', $mydata);
	}
	
	function index_form_bayar($data_bayar)
	{
		$getrecord = $this->model_beli->get_beli($data_bayar);
		foreach($getrecord->result_array() as $recordset)
		{
			$id_pembelian		= $recordset['id_pembelian'];
			$no_invoice			= $recordset['no_invoice'];
			$tgl_pembelian		= $recordset['tgl_pembelian'];
			$tgl_jatuh_tempo	= $recordset['tgl_jatuh_tempo'];
			$total_pembayaran	= $recordset['total_pembayaran'];
			$pembayaran			= $recordset['pembayaran'];
			$id_cara_pembayaran	= $recordset['id_cara_pembayaran'];
		}
		
		$data_bayar = array(
			'id_pembelian'			=> $id_pembelian,
			'no_invoice'			=> $no_invoice,
			'tgl_pembelian'			=> $tgl_pembelian,
			'tgl_jatuh_tempo'		=> $tgl_jatuh_tempo,
			'total_pembayaran'		=> $total_pembayaran,
			'pembayaran'			=> $pembayaran,
			'id_cara_pembayaran'	=> $id_cara_pembayaran,
			'status_bayar'          => 'add_bayar'
		);
		$getrecord_detail_bayar = $this->model_beli->get_detail_bayar($data_bayar);
		
		$status = get_status_user();
		$mydata = array(
			'form'				=> 'inventory/beli/add_bayar_beli',
			'simpan'			=> '',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> 'class="disable" disabled="disabled"',
			'tab'               => 'akses_beli/beli_form',
			'page'			    => 'beli_page',
			'menu'			    => 'pembayaran_beli_form',
			'cara_bayar'	    => $this->model_cara_pembayaran->select_cara_bayar(),
			'satuan_barang'     => $this->model_satuan_barang->select_satuan_barang(),
            'data_bayar'       	=> $data_bayar,
			'data_bayar_detail'	=> $this->data_detail_bayar_null($id_pembelian),
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
        $this->load->view('mainpage', $mydata);
	}
	
	function data_field_bayar_null($data_id_beli, $data)
    {
		if($data_id_beli=='')
		{
			$data_field = array(
				'id_pembelian'			=> '',
				'no_invoice'			=> '',
				'tgl_pembelian'			=> '',
				'tgl_jatuh_tempo'		=> '',
				'total_pembayaran'		=> '',
				'bayar'					=> '',
				'id_cara_pembayaran'	=> '',
				'status_bayar'			=> $data
	    	);
		}
		else
		{
			$getrecord = $this->model_beli->get_beli($data_id_beli);
			foreach($getrecord->result_array() as $recordset)
			{
				$id_pembelian		= $recordset['id_pembelian'];
				$no_invoice			= $recordset['no_invoice'];
				$tgl_pembelian		= $recordset['tgl_pembelian'];
				$tgl_jatuh_tempo	= $recordset['tgl_jatuh_tempo'];
				$total_pembayaran	= $recordset['total_pembayaran'];
				$pembayaran			= $recordset['pembayaran'];
				$id_cara_pembayaran	= $recordset['id_cara_pembayaran'];
			}
			
			$data_field = array(
				'id_pembelian'			=> $id_pembelian,
				'no_invoice'			=> $no_invoice,
				'tgl_pembelian'			=> $tgl_pembelian,
				'tgl_jatuh_tempo'		=> $tgl_jatuh_tempo,
				'total_pembayaran'		=> $total_pembayaran,
				'pembayaran'			=> $pembayaran,
				'id_cara_pembayaran'	=> $id_cara_pembayaran,
				'status_bayar'          => $data
			);
		}
		
        return $data_field;
    }
	
	function data_detail_bayar_null($data)
	{
		$data_field_detail_bayar = $this->model_beli->get_detail_bayar($data);
		
		return $data_field_detail_bayar;
	}
	
	function find_laporan_beli()
	{
		$tgl_1 	= $this->input->post('tgl_awal');
		$tgl_2	= $this->input->post('tgl_akhir');
		
		$tgl_awal 	= explode_date($tgl_1, 0);
		$tgl_akhir 	= explode_date($tgl_2, 0);
		echo base_url().'index.php/inventory/beli/laporan_beli/'.$tgl_awal.'_'.$tgl_akhir;
	}
	
	function laporan_beli($get_date="")
	{
		$m = date('m')-1;
		if($m<10)
			$m='0'.$m;
			
		$date = array(
			'startdate'=>date('Y').'-'.$m.'-'.date('d'),
			'enddate'=>date('Y-m-d')
		);
		
		if($get_date!="")
		{
			$ar_get_date=explode('_',$get_date);
				
			$date = array(
				'startdate'=>$ar_get_date[0],
				'enddate'=>$ar_get_date[1]
			);
		}
		
		$data_beli = $this->model_beli->get_data_pembelian($date);
		$data = array();
		if(count($data_beli)>0)
		{
			foreach($data_beli as $result)
			{
				$result['detail'] = $this->model_beli->get_detail_pembelian($result['id_pembelian']);
				$data[]=$result;		
			}
		}
		
		$status = get_status_user();
		$mydata = array(
			'form'				=> '',
			'simpan'			=> 'class="disable" disabled="disabled"',
			'edit'				=> 'class="disable" disabled="disabled"',
			'batal'				=> 'class="disable" disabled="disabled"',
			'cetak'				=> ' id="simplePrint"',
			'active_menu'		=> 'class="active_laporan_beli"',
			'active_menus'		=> 'id="active_menus_laporan"',
			'page'			    => 'laporan_page',
			'menu'			    => 'laporan_beli',
			'list'				=> $data,
			'date'				=> $date,
			'user_status'		=> $status,
			'list_po'			=> $this->model_po->daftar_list_po()
		);
        $this->load->view('mainpage', $mydata);
	}
}
?>