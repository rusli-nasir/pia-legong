<script>
	$(function(){
		//View Detail Pemesanan
		$( "span#detail_po" ).click(function(){
			var no_po = $(this).attr('class');
			find_po(no_po);
			
			$( "#dialog-add" ).dialog({
				title: 'Data Detail PO'
			});
			$( "#dialog-add" ).dialog( "open" );
		});
		
		$( "#dialog-detail" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 380,
			width: 600,
			modal: true,
			closeOnEscape: false,
			buttons: {
			},
		});
		
		//Add Or Edit Pemesanan
		$('.add_po').click(function(){
			$( "#dialog-add" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-add" ).dialog( "open" );
		});
		
		$( "#dialog-add" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 500,
			width: 700,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan": function() {
					var id_detail_po = $("#id_detail_po_0").val();
					if(id_detail_po=="")
					{//add
						var tamp = {};
						$.ajax({
							async: false,
							dataType: "json",
							type: "POST",
							url: "<?php echo base_url();?>index.php/inventory/po/add_po",
							data: $("#form_add").serialize(),
							cache: false,
							success: function(data){
								tamp = data;
								if(data.hasil==0)
								{
									alert("Input Data Salah");
									$( "#dialog-add" ).dialog({
										title: 'Input Data'
									});
									$( "#dialog-add" ).dialog( "open" );
								}
								else
								{
									var tgl 	= $("#datepicker").val();
									var ar_tgl 	= tgl.split('/');
									tgl = ar_tgl[2]+'-'+ar_tgl[1]+'-'+ar_tgl[0];
									window.location.href="<?php echo base_url();?>index.php/inventory/po/index/"+tgl;
								}
							}
						});//alert(tamp.hasil);
						if(tamp.hasil == '1'){
							window.open("<?php echo site_url('inventory/po/report_nota')?>/"+tamp.no_po, "status=1,width=350,height=150");
						}
					}
					else
					{//edit
						var tamp = {};
						$.ajax({
							async: false,
							dataType: "json",
							type: "POST",
							url: "<?php echo base_url();?>index.php/inventory/po/edit_po",
							data: $("#form_add").serialize(),
							cache: false,
							success: function(data){
								tamp = data;
								if(data.hasil==0)
								{
									alert("Input Data Salah");
									$( "#dialog-add" ).dialog({
										title: 'Input Data'
									});
									$( "#dialog-add" ).dialog( "open" );
								}
								else
								{
									var tgl 	= $("#datepicker").val();
									var ar_tgl = tgl.split('/');
									tgl = ar_tgl[2]+'-'+ar_tgl[1]+'-'+ar_tgl[0];
									window.location.href="<?php echo base_url();?>index.php/inventory/po/index/"+tgl;
								}
							}
						});
						if(tamp.hasil == '1'){
							window.open("<?php echo site_url('inventory/po/report_nota')?>/"+tamp.no_po, "status=1,width=350,height=150");
						}
					}
					
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},			
			close: function()
			{
				$(".tanggal_pesan_tamp").val($("#datepicker").val());
				$(".no_po_tamp").val($("#new_po").val());
				//$( ".bayar_awal" ).val('');
				$( ".nama_customer" ).val('');
				$( ".cara_bayar" ).val('');
				$( ".telepon" ).val('');
				$( ".telepon_2" ).val('');
				$( ".telepon_3" ).val('');
				$( ".jumlah_bayar" ).val('');
				$( ".total_pesan" ).val(0);
				$( ".total_seluruh" ).val('');
				$("#check_bayar").attr("checked","");
				var cek = 0;
				$('#trhide').find('tr').hide();
				for(var index=0 ; index<=cek ; index++){
					$('tr.'+index).show();
				}
				
				for(var i=0;i<=50;i++)
				{
					$( "#id_detail_po_"+i ).val('');
					$( "#id_barang_"+i ).val('');
					$( "#id_harga_satuan"+i ).val('');
					$( "#nama_barang_"+i ).val('');
					$( "#id_kuantum"+i ).val('');
					$( "#id_total_harga_barang"+i ).val('');
				}
			}			
		});
		
		//Go To Penjualan
		$( "#dialog-goto_penjualan" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 450,
			width: 700,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan": function() {
					$.ajax({
						async: false,
						type: "POST",
						url: "<?php echo base_url();?>index.php/inventory/po/addto_penjualan",
						data: $("#form_jual").serialize(),
						cache: false,
						success: function(data){
							if(data==0)
							{
								alert("Input Data Salah");
								$( "#dialog-goto_penjualan" ).dialog({
									title: 'Input Data'
								});
								$( "#dialog-goto_penjualan" ).dialog( "open" );
							}
							else
							{
								var tgl 	= $("#datepicker").val();
								var ar_tgl = tgl.split('/');
								tgl = ar_tgl[2]+'-'+ar_tgl[1]+'-'+ar_tgl[0];
								window.location.href="<?php echo base_url();?>index.php/inventory/po/index/"+tgl;
							}
						}
					});
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},			
			close: function()
			{
				$(".tanggal_pesan_tamp").val($("#datepicker").val());
				$(".no_po_tamp").val($("#new_po").val());
				//$( ".bayar_awal" ).val('');
				$( ".nama_customer" ).val('');
				$( ".cara_bayar" ).val('');
				$( ".telepon" ).val('');
				$( ".telepon_2" ).val('');
				$( ".telepon_3" ).val('');
				$( ".jumlah_bayar" ).val('');
				$( ".total_pesan." ).val(0);
				$( ".total_seluruh" ).val('');
				$("#check_bayar").attr("checked","");
				var cek = 0;
				$('#trhide').find('tr').hide();
				for(var index=0 ; index<=cek ; index++){
					$('tr.'+index).show();
				}
				
				for(var i=0;i<=50;i++)
				{
					$( "#id_detail_po_"+i ).val('');
					$( "#id_barang_"+i ).val('');
					$( "#id_harga_satuan"+i ).val('');
					$( "#nama_barang_"+i ).val('');
					$( "#id_kuantum"+i ).val('');
					$( "#id_total_harga_barang"+i ).val('');
				}
			}			
		});
		
		//Show Or Hide Row
		var cek = $(this).find('input#index_ke').attr('value');
		$('#trhide').find('tr').hide();
		for(var index=0 ; index<=cek ; index++){
			$('tr.'+index).show();
		}
		
		$('.add').click(function(){
			var arr = $(this).find('input#index_ke').attr('value');
			var ind = Number(arr) + 1;
			$('tr.'+ind).show();
			$('#index_ke').val(ind);
		});
		
		$('span#batal').click(function(){
			var n = $(this).attr('class');
			var m = $('input#index_ke').attr('value');
			while(n < m)
			{
				var tamp_n = Number(n) + 1;
				$('#nama_barang_'+n).val($('#nama_barang_'+tamp_n).val());
				$('#id_kuantum'+n).val($('#id_kuantum'+tamp_n).val());
				$('#id_total_harga_barang'+n).val($('#id_total_harga_barang'+tamp_n).val());
				n = tamp_n;
			}
			
			$('#nama_barang_'+m).val('');
			$('#id_kuantum'+m).val('');
			$('#id_total_harga_barang'+m).val('');
			$('#id_barang_'+m).val('');
			
			if(m > 0)
			{
				$('tr.'+m).fadeOut();
				$('#index_ke').val(m - 1);
			}
			
			var limit_index = $('#index_ke').val();
			jml_total1 = 0;
			var jml_order_barang = 0;
			for(i=0; i<=limit_index; i++)
			{
				jml_subtotal = 0;
				var jml_subtotal = $('#id_total_harga_barang'+i).val();
				jml_total = Number(jml_total1) + Number(jml_subtotal);
				jml_total1 = 0;
				jml_total1 = jml_total;
				
				var jml_suborder_barang = 0;
				jml_suborder_barang = $('#id_kuantum'+i).val();
				
				jml_order_barang = Number(jml_order_barang) + Number(jml_suborder_barang);
			}
			
			//============ Untuk Jumlah Total ============
			$('.total_pesan').val(jml_order_barang);
			$('.total_seluruh').val(jml_total);
		});
		
		//View Date Pemesanan
		$( "#datepicker" ).change(function(){
			var tgl 	= $(this).val();
			$.ajax({
				async: false,
				type: "POST",
				url: "<?php echo base_url();?>index.php/inventory/po/view_po",
				data: "tgl="+tgl,
				cache: false,
				success: function(data){
					window.location.href=data;
				}
			});
		});
	});
	
	function cetak_po(no_po){
		window.open("<?php echo site_url('inventory/po/report_nota')?>/"+no_po, "status=1,width=350,height=150");
	}	
	
	function print_po(no_po){
		var tamp = new Array();
		var cek = 0;
		var x = 0;
		var list = '';
		$(".select-po-print").each(function(){
			if($(this).attr('checked')==true){
				//console.log($(this).val());
								
				if(x > 0){
					list = '-'+$(this).val();
				}else{
					list = $(this).val();
				}
				
				tamp[x] = $(this).val();
				cek = 1;
				x++;
			}
		});
		if(cek==0){
			alert('Pilih PO dulu..');			
		}else{
			console.log(tamp);
			
			$.ajax({
				async: false,
				type: "POST",
				url: "<?php echo base_url();?>index.php/inventory/po/print_selected",
				data: "list="+tamp,
				cache: false,
				success: function(data){
					console.log(data);
					Popup($(data).html());		
				}
			});
		}
		//Popup($(elem).html());
				
	}
	
    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Nota</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

	//hitung total seluruh
	function detail_count(thisval, arrval)
	{
		$(document).ready(function(){
			var id_barang			= $('#id_barang_'+arrval).val();
			var id_kuantum			= $('#id_kuantum'+arrval).val();
			var id_harga_satuan		= $('#id_harga_satuan'+arrval).val();
			
			hrg_per_item = id_harga_satuan;
			sub_total = id_kuantum * hrg_per_item;
			
			$('#id_total_harga_barang'+arrval).val(sub_total);
			
			var limit_index = $('#index_ke').val();
			jml_total1 = 0;
			var jml_order_barang = 0;
			for(i=0; i<=limit_index; i++)
			{
				var jml_subtotal = 0;
				jml_subtotal = $('#id_total_harga_barang'+i).val();
				
				jml_total = Number(jml_total1) + Number(jml_subtotal);
				jml_total1 = 0;
				jml_total1 = jml_total;
				
				var jml_suborder_barang = 0;
				jml_suborder_barang = $('#id_kuantum'+i).val();
				
				jml_order_barang = Number(jml_order_barang) + Number(jml_suborder_barang);
			}
			
			//============ Untuk Jumlah Total ============
			$('.total_pesan').val(jml_order_barang);
			$('.total_seluruh').val(jml_total);
		});
	}

	//View Detail Pemesanan
	function detail_po(no_po)
	{
		find_po(no_po);
			
		$( "#dialog-detail" ).dialog({
			title: 'Data Detail Pemesanan'
		});
		$( "#dialog-detail" ).dialog( "open" );
	}

	function find_po(no_po)
	{
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/po/find_po",
			data: "no_po="+no_po,
			cache: false,
			success: function(data){
				get_data(data);			
			}
		});
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/po/find_po_detail",
			data: "no_po="+no_po,
			cache: false,
			success: function(data){
				get_data_detail(data);			
			}
		});
	}
	
	function get_data(mydata)
	{
		var dataArr 				= mydata.split(",");
		var no_po 					= dataArr[0];
		var tanggal_po 				= dataArr[1];
		var nama_customer			= dataArr[2];
		var telepon 				= dataArr[3];
		var jumlah_bayar			= dataArr[4];
		var nama_cara_pembayaran 	= dataArr[5];
		var telepon_2	 			= dataArr[7];
		var telepon_3	 			= dataArr[8];
		
		$(document).ready(function(){
			$("#no_po").val(no_po);
			$("#tgl_po").val(tanggal_po);
			$("#nama_customer").val(nama_customer);
			$("#telepon").val(telepon);
			$("#telepon_2").val(telepon_2);
			$("#telepon_3").val(telepon_3);
			$("#jumlah_bayar").val(jumlah_bayar);
		});
	}
	
	function get_data_detail(mydata)
	{
		$("#tabel_detail").html(mydata);
	}
	
	//Edit Pemesanan
	function edit_po(no_po)
	{
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/po/find_po2",
			data: "no_po="+no_po,
			cache: false,
			success: function(data){
				get_data_tamp(data);			
			}
		});
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/po/find_po_detail2",
			data: "no_po="+no_po,
			cache: false,
			success: function(data){
				get_data_detail_tamp(data);			
			}
		});
		
		$( "#dialog-add" ).dialog({
			title: 'Edit Data'
		});
		$( "#dialog-add" ).dialog( "open" );
	}
	
	function get_data_tamp(mydata)
	{
		var dataArr 				= mydata.split(",");
		var no_po 					= dataArr[0];
		var tanggal_po 				= dataArr[1];
		var nama_customer			= dataArr[2];
		var telepon 				= dataArr[3];
		var telepon2 				= dataArr[4];
		var telepon3 				= dataArr[5];
		var jumlah_bayar			= dataArr[6];
		var nama_cara_pembayaran 	= dataArr[7];
		var id_cara_pembayaran 		= dataArr[8];
		var count_pembayaran 		= dataArr[9];
		var jum_pembayaran 			= dataArr[10];
		var bayar_awal 				= dataArr[11];		
		var nama_penerima 			= dataArr[12];
		var via_pemesanan 			= dataArr[13];
	
		$(document).ready(function(){
			$(".no_po_tamp").val(no_po);
			$(".tanggal_pesan_tamp").val(tanggal_po);
			$(".nama_customer").val(nama_customer);
			$(".telepon").val(telepon);
			$(".telepon_2").val(telepon2);
			$(".telepon_3").val(telepon3);
			$(".total_seluruh").val(jumlah_bayar);
			$(".jumlah_bayar").val(jum_pembayaran);
			$(".cara_bayar").val(id_cara_pembayaran);
			if(bayar_awal!=0)
				$("#check_bayar").attr("checked","checked");
			else
				$("#check_bayar").attr("checked","");
				
			$('input[name="nama_penerima"]').val(nama_penerima);
			$('select[name="via_pemesanan"]').val(via_pemesanan);
		});
	}
	
	function get_data_detail_tamp(mydata)
	{
		var arr_data 		= mydata.split("___");
		var jum_data 		= arr_data.length;
		
		var cek = jum_data-1;
		$('#index_ke').val(cek);
		$('#trhide').find('tr').hide();
		for(var index=0 ; index<=cek ; index++){
			$('tr.'+index).show();
		}
		
		var jml_pemesanan = 0;
		for(var i=0;i<jum_data;i++)
		{
			var dataArr 		= arr_data[i].split(",");
			var no_po_detail 	= dataArr[0];
			var no_po 			= dataArr[1];
			var id_barang		= dataArr[2];
			var kuantum		 	= dataArr[3];
			var jumlah_bayar	= dataArr[4];
			var nama_barang		= dataArr[5];
			var harga_barang	= dataArr[6];
			
		
			$(document).ready(function(){
				$("#id_detail_po_"+i).val(no_po_detail);
				$("#id_barang_"+i).val(id_barang);
				$("#id_harga_satuan"+i).val(harga_barang);
				$("#nama_barang_"+i).val(nama_barang);
				$("#id_kuantum"+i).val(kuantum);
				$("#id_total_harga_barang"+i).val(jumlah_bayar);
				
				jml_pemesanan = Number(jml_pemesanan) + Number(kuantum);
			});
		}
		$(".total_pesan").val(jml_pemesanan);
	}
	
	//Pilih Masuk ke Penjualan
	function goto_penjualan(no_po)
	{
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/po/find_po2",
			data: "no_po="+no_po,
			cache: false,
			success: function(data){
				get_data_jual_tamp(data);			
			}
		});
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/po/find_po_detail",
			data: "no_po="+no_po,
			cache: false,
			success: function(data){
				get_data_jual_detail(data);			
			}
		});
		
		$( "#dialog-goto_penjualan" ).dialog({
			title: 'Penjualan'
		});
		$( "#dialog-goto_penjualan" ).dialog( "open" );
	}
	
	function get_data_jual_tamp(mydata)
	{
		var dataArr 				= mydata.split(",");
		var no_po 					= dataArr[0];
		var tanggal_po 				= dataArr[1];
		var nama_customer			= dataArr[2];
		var telepon 				= dataArr[3];
		var telepon_2 				= dataArr[4];
		var telepon_3 				= dataArr[5];
		var jumlah_bayar			= dataArr[6];
		var nama_cara_pembayaran 	= dataArr[7];
		var id_cara_pembayaran 		= dataArr[8];
		var count_pembayaran 		= dataArr[9];
		var jum_pembayaran 			= dataArr[10];
		var bayar_awal 				= dataArr[11];
		var sisa_bayar 				= jumlah_bayar-jum_pembayaran;
		
		$(document).ready(function(){
			$(".no_po_tamp").val(no_po);
			$(".tanggal_pesan_tamp").val(tanggal_po);
			$(".nama_customer").val(nama_customer);
			$(".telepon").val(telepon);
			$(".telepon_2").val(telepon_2);
			$(".telepon_3").val(telepon_3);
			$(".total_seluruh").val(jumlah_bayar);
			$(".jumlah_bayar").val(jum_pembayaran);
			$(".cara_bayar").val(id_cara_pembayaran);
			if(bayar_awal!=0)
				$("#check_bayar").attr("checked","checked");
			else
				$("#check_bayar").attr("checked","");
			$(".sisa_bayar").val(sisa_bayar);
		});
	}
	
	function get_data_jual_detail(mydata)
	{
		$("#tabel_jual_detail").html(mydata);
	}
	
	//autocomplete barang
	function nilai(data, arr)
	{
		$(function(){
			$('#nama_barang_'+arr).autocomplete("<?php echo base_url();?>index.php/inventory/po/find_all_barang", 
				{
					parse: function(data){ 
						var parsed = [];
						for (var i=0; i < data.length; i++) {
							parsed[i] = {
								data: data[i],
								value: data[i].nama_barang
							};
						}
						return parsed;
					},
					formatItem: function(data,i,max){
						var str = '<div class="search_content">';
						str += '<u>'+data.nama_barang+'</u>';
						str += '</div>';
						return str;
					},
					width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
					dataType: 'json'
				}
			).result(
				function(event,data,formated){
					$('#nama_barang_'+arr).val(data.nama_barang);
					$('#id_barang_'+arr).val(data.id_barang);
					$('#id_harga_satuan'+arr).val(data.harga_barang);
					$('#id_kuantum'+arr).val(1);
		
					detail_count(data.id_barang, arr);
				}
			);
		});
	}
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Daftar Pemesanan</legend>
    	<table>
        	<tr>
                <td style="width: 150px;">Tanggal Transaksi</td>
                <td>
                	<input style="color:#0000FF;" type="text" id="datepicker" name="tgl_po" size="10" maxlength="10" readonly="readonly" value="<?php 
					echo explode_date($date,1);?>" />
					<input type="hidden" name="new_po" id="new_po" value="<?php echo $no_po;?>" />
                </td>
				<td width="100" style="text-align:right;">
					<a href="javascript:void(0);" onclick="print_po();">
						<img src="<?php echo base_url().'image/print_icon.png'; ?>" width="30" />
					</a>
				</td>
            </tr>
        </table>
        <table>
        	<tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table id="gridview">
            <tr>
                <td class="labels_dpo print-po" style="width:50px;"></td>
                <!--<td class="labels_dbyr">No. Pemesanan</td> -->
                <td class="labels_dpo" style="width:100px;">Tgl Pesan</td>
                <td class="labels_dpo" style="width:150px;">Via Pesan</td>
                <td class="labels_dpo" style="width:150px;">Penerima</td>
                <td class="labels_dpo" style="width:250px !important;">Nama Customer</td>
                <td class="labels_dpo" style="width:130px;">Phone</td>
                <td class="labels_dpo">Detail<br /> Barang</td>
                <td class="labels_dpo">Edit</td>
                <td class="labels_dpo" style="width:50px !important;">Batal</td>
                <td class="labels_dpo">Penjualan</td>
                <td class="labels_dpo" style="width:50px !important;">Status</td>
            </tr>
		</table>
        <div id="scrollable" class="yui3-scrollview-loading">
        <table id="gridview">
            <?php
			foreach($daftar_list_po as $daftarlistpo)
			{
				$tglbaru	= $daftarlistpo['tanggal_po'];
				$tgl_po		= explode_date($tglbaru, 1);
				$z_nowdate 	= date('z', strtotime("".date('F j').""));
				$ar_date = explode('-',$date);
				$z_lastdate = date('z', mktime(0, 0, 0, $ar_date[1], $ar_date[2], $ar_date[0]));
				?>
				<tr class="isi_list">
					<td class="" style="background:#fff; border:1px solid #F1F1F1; text-align:center; width:40px;">
						<input type="checkbox" name=select_po_print[] class="select-po-print" value="<?php echo $daftarlistpo['no_po']; ?>" />
					</td>
					<td class="labelss_dpo" style="width:120px;">
						<?php 
							$tmp = explode_date($daftarlistpo['tanggal_pesan'], 1);
							$arr_date = explode('/', $tmp);
							$tgl_pesan = $arr_date[0].'-'.$arr_date[1];
							if($tgl_pesan=='00-00'){
								$tgl_pesan = '';
							}
							echo $tgl_pesan;
							//echo explode_date($daftarlistpo['tanggal_po'], 1);
						?>
					</td>
					<td class="labelss_dpo">
                    	<?php echo $daftarlistpo['via_pemesanan'];?>
					</td>
					<td class="labelss_dpo">
                    	<?php echo $daftarlistpo['nama_penerima'];?>
					</td>
                    <!--
					<td class="labelss_dpo" id="search1">
                    	<a href="javascript:void(0)" onclick="cetak_po('<?php echo $daftarlistpo['no_po'];?>')"><?php echo $daftarlistpo['no_po'];?></a>
					</td>
					-->
					<td class="labelss_dpo" id="search2" style="width:300px !important;"><?php echo $daftarlistpo['nama_customer']; ?></td> 
					<td class="labelss_dpo" style="width:150px !important;" id="search3"><?php echo $daftarlistpo['telepon']; ?>
						<input type="hidden" id="search_tlp_2" value="<?php echo $daftarlistpo['telepon_2']; ?>" />
						<input type="hidden" id="search_tlp_3" value="<?php echo $daftarlistpo['telepon_3']; ?>" />
					</td>
					<td class="labelss_dpo" style="width:100px !important;">
						<a href="javascript:void(0)" onclick="detail_po('<?php echo $daftarlistpo['no_po'];?>')"><span style="display:block">Detail</span></a></td>
					<td class="labelss_dpo" style="width:100px !important;">
                    <?php if($daftarlistpo['jumlah_po'] > 0)
					{?>
                    	&nbsp;
						<?php 
					}
					else
					{
						if(date('Y')>=$ar_date[0] and $z_lastdate>=$z_nowdate){?>
                            <a href="javascript:void(0)" onclick="edit_po('<?php echo $daftarlistpo['no_po'];?>')"><span style="display:block">Edit</span></a>
                        	<?php 
						}
					}?>
					</td>
					<td class="labelss_dpo" style="width:70px !important;">
                    <?php if($daftarlistpo['jumlah_po'] > 0)
					{?>
                    	&nbsp;
						<?php 
					}
					else
					{?>
						<input type="checkbox" name=batal_list[] value="<?php echo $daftarlistpo['no_po']; ?>" />
						<?php 
					}?>
					</td>
					<td class="labelss_dpo" style="width:100px !important;">
                    <?php if($daftarlistpo['jumlah_po'] > 0)
					{?>
                    	&nbsp;
						<?php 
					}
					else
					{?>
						<a href="javascript:void(0)" onclick="goto_penjualan('<?php echo $daftarlistpo['no_po'];?>')"><span style="display:block">Pilih</span></a>
						<?php 
					}?>
                    </td>
                    <td class="labelss_dpo" style="width:70px !important;">
						
						<?php 
						//if($daftarlistpo['jumlah_po'] > 0){echo 'Barang sudah diambil';}else{echo 'Barang belum diambil';}
						$sudah = base_url().'image/check.jpg';
						$belum = base_url().'image/wrongicon.jpg';
						if($daftarlistpo['jumlah_po'] > 0){
							echo '<img src="'.$sudah.'" width="30" />';
						}else{
							echo '<img src="'.$belum.'" width="30" />';
						}
						?>
					</td>
				</tr>
                <?php
			}?>
        </table>
        </div>
        <div class="add_po">
            <a href="javascript:void(0)">+</a>
        </div>
        
    </fieldset>
</div>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Total Stok Pemesanan</legend>
    	<table id="gridview">
            <tr>
                <td class="labels_dpo">Nama Barang</td>
                <td class="labels_dpo">Total Stok Pemesanan</td>
            </tr>
            <?php 
			$total_pemesanan = 0;
			foreach($list_barang->result_array() as $list)
			{?>
				<tr>
                	<td class="labelss_dpo"><?php echo $list['nama_barang'];?></td>
                	<td class="labelss_dpo"><?php if($list['stok_pemesanan']==''){$list['stok_pemesanan']=0; echo '0';}else{echo $list['stok_pemesanan'];}?></td>
                </tr>
				<?php 
				$total_pemesanan = $total_pemesanan + $list['stok_pemesanan'];
			}?>
			<tr>
            	<td class="labelss_dpo">TOTAL</td>
            	<td class="labelss_dpo"><?php echo $total_pemesanan;?></td>
            </tr>
		</table>
    </fieldset>
</div>

<!--For Add Or Edit Pemesanan-->
<div id="dialog-add" title="">
<form>&nbsp;</form>
<form name="form_pesan" id="form_add">
	<p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM PEMESANAN
    </p>
    <input type="hidden" name="tanggal_pesan" class="tanggal_pesan_tamp" value="<?php echo explode_date($date,1);?>" />
    <table>
    	<tr>
        	<td style="width: 150px;">Tgl. Pemesanan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="tgl_pemesanan" class="" size="22" value="<?php echo explode_date($date,1);?>" id="datepicker2" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td></td>
        </tr>
    	<tr>
        	<td style="width: 150px;">No. Pemesanan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="no_po" class="no_po_tamp" size="25" value="<?php echo $no_po;?>" readonly="1" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td><input type="checkbox" name="bayar_awal" class="bayar_awal" value="1" id="check_bayar"/>Bayar Awal</td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Nama Customer</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="nama_customer" class="nama_customer" size="25" value="" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Cara Pembayaran</td><td>:</td><td>&nbsp;</td>
            <td>
            	<select name="id_cara_pembayaran" class="cara_bayar">
                	<option value="0">.:Pembayaran:.</option>
                    <?php 
					foreach($list_cara_bayar->result_array() as $row)
					{
						?>
						<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php 
					}
					?>
                </select>
            </td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Telepon/Handphone 1</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="telepon" class="telepon" size="25" value="" onkeypress="return checkIt(event)" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Jumlah Bayar</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_bayar" class="jumlah_bayar" size="25" value="" onkeypress="return checkIt(event)" /></td>
        </tr>
        <tr>
        	<td style="width: 150px;">Telepon/Handphone 2</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="telepon_2" class="telepon_2" size="25" value="" onkeypress="return checkIt(event)" /></td>
            <td style="width: 50px;">&nbsp;</td>
        </tr>
        <tr>
        	<td style="width: 150px;">Telepon/Handphone 3</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="telepon_3" class="telepon_3" size="25" value="" onkeypress="return checkIt(event)" /></td>
            <td style="width: 50px;">&nbsp;</td>
        </tr>
        <tr>
        	<td style="width: 150px;">Total Keseluruhan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_seluruh" class="total_seluruh" size="25" value="" readonly="1" /></td>
        </tr>
		
    	<tr>
        	<td style="width: 150px;">Nama Penerima</td><td>:</td><td>&nbsp;</td>
            <td colspan="5"><input type="text" name="nama_penerima" class="" size="25" value="" /></td>
        </tr>
		<tr>
        	<td style="width: 150px;">Via Pemesanan</td><td>:</td><td>&nbsp;</td>
            <td>
				<select name="via_pemesanan">
					<option value="langsung">Langsung</option>
					<option value="email">Email</option>
					<option value="telepon">Telepon</option>
					<option value="sms">SMS</option>
					<option value="ibu">IBU</option>
					<option value="bapak">BAPAK</option>
				</select>
			</td>
            <td style="width: 50px;">&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <table id="tabel_detail">
        <thead>
        <tr id="id_tr_detail">
            <td class="labels_dpo">Nama Barang</td>
            <td class="labels_dpo">Quantity</td>
            <td class="labels_dpo">Total Harga Barang</td>
            <td class="labels_dpo">Batal</td>
        </tr>
        </thead>
        <tbody id="trhide">
        <?php
        $i=0;
        $brs=0;
        
        for($ind=$brs ; $ind<=50 ; $ind++)
        {
			?>
                <tr class="<?php echo $ind;?>">
                    <input type="hidden" name=id_detail_po[] id="id_detail_po_<?php echo $ind;?>" value="" />
                    <input type="hidden" name=id_barang[] id="id_barang_<?php echo $ind;?>" value="" />
                    <input type="hidden" name=harga_satuan[] id="id_harga_satuan<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" readonly="readonly" />
                    <td class="labelss">
                        <input type="text" name=nama_barang[] id="nama_barang_<?php echo $ind;?>" value="" onclick="nilai(this.value, <?php echo $ind;?>)" /></td>
                    <td class="labelss"><input type="text" name=kuantum[] id="id_kuantum<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=total_harga[] id="id_total_harga_barang<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><a href="javascript:void(0)"><span id="batal" class="<?php echo $ind;?>" style="display:block">Batal</span></a></td>
                </tr>
        	<?php
        	$i++;
        }
		?>
        </tbody>
    </table>
    <div class="add">
        <input type="hidden" name="index" id="index_ke" value="<?php echo $brs;?>">
        <a href="javascript:void(0)">+</a>
    </div>
    <div class="clear"></div>
    <div class="total_order">
    <table>
    	<tr>
        	<td style="width: 100px;">Total Pemesanan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_pesan" class="total_pesan" size="10" value="0" /></td>
        </tr>
    </table>
    </div>
</form>
</div>

<!--View Detail Data Pemesanan-->
<div id="dialog-detail" title="">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        DETAIL PEMESANAN
    </p>
    <table>
        <tr>
            <td style="width: 150px;">No. Pemesanan</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="no_po" size="25" readonly="readonly" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Nama Customer</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="nama_customer" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Telepon / HP</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="telepon" size="25" readonly="readonly" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Total Harga</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="jumlah_bayar" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td colspan="4">&nbsp;</td>
            <td><input type="text" id="telepon_2" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td colspan="4">&nbsp;</td>
            <td><input type="text" id="telepon_3" size="25" readonly="readonly" /></td>
        </tr>
    </table>
    <table id="tabel_detail">
    </table>
</div>

<!--Go To Penjualan-->
<div id="dialog-goto_penjualan" title="">
<form>&nbsp;</form>
<form name="form_jual" id="form_jual">
	<p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM PENJUALAN
    </p>
    <input type="hidden" name="tanggal_pesan" class="tanggal_pesan_tamp" value="<?php echo explode_date($date,1);?>" />
    <table>
    	<tr>
        	<td style="width: 150px;">No. Pemesanan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="no_po" class="no_po_tamp" size="25" value="<?php echo $no_po;?>" readonly="1" /></td>
            <td style="width: 50px;">&nbsp;</td>
        	<td style="width: 150px;">Total Keseluruhan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_seluruh" class="total_seluruh" size="25" value="" readonly="1" /></td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Nama Customer</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="nama_customer" class="nama_customer" size="25" value="" readonly="1" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Sisa Bayar</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="sisa_bayar" class="sisa_bayar" size="25" value="" onkeypress="return checkIt(event)" readonly="1" /></td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Telepon/Handphone</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="telepon" class="telepon" size="25" value="" onkeypress="return checkIt(event)" readonly="1" /></td>
            <td style="width: 50px;">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
            <td><input type="text" name="telepon_2" class="telepon_2" size="25" value="" onkeypress="return checkIt(event)" readonly="1" /></td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
            <td><input type="text" name="telepon_3" class="telepon_3" size="25" value="" onkeypress="return checkIt(event)" readonly="1" /></td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Cara Pembayaran 1</td><td>:</td><td>&nbsp;</td>
            <td>
            	<select name="id_cara_pembayaran1" class="cara_bayar1">
                	<option value="0">.:Pembayaran:.</option>
                    <?php 
					foreach($list_cara_bayar->result_array() as $row)
					{
						?>
						<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php 
					}
					?>
                </select>
            </td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Cara Pembayaran 2</td><td>:</td><td>&nbsp;</td>
            <td>
            	<select name="id_cara_pembayaran2" class="cara_bayar2">
                	<option value="0">.:Pembayaran:.</option>
                    <?php 
					foreach($list_cara_bayar->result_array() as $row)
					{
						?>
						<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php 
					}
					?>
                </select>
            </td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Jumlah Bayar 1</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_bayar1" class="jumlah_bayar1" size="25" value="" onkeypress="return checkIt(event)" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Jumlah Bayar 2</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_bayar2" class="jumlah_bayar2" size="25" value="" onkeypress="return checkIt(event)" /></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    <table id="tabel_jual_detail">
    </table>
</form>
</div>


<div id="mydiv" style="display:none;"></div>

<script>
	$(function(){
		// animasi list
		YUI().use('scrollview', function(Y) {
			// cek apakah ada list di halaman
			if($("#scrollable").html() != null)
			{
				var scrollView = new Y.ScrollView({
					srcNode: '#scrollable',
					height: 300
				});
				scrollView.scrollbars.flash();
				scrollView.render();		
			}
		});
	});
	$('.print-po').click(function(){
		alert('sdf')
	})
</script>