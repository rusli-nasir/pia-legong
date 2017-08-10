<script>
	$(document).ready(function(){
		$("#dialog-jual" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 500,
			width: 700,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan": function() {
					var id_penjualan_temp = $(".id_penjualan_temp").val();
					if(id_penjualan_temp=='')
					{
						$.ajax({
							async: false,
							type: "POST",
							url: "<?php echo base_url();?>index.php/inventory/jual/add_jual",
							data: $("#form_add").serialize(),
							cache: false,
							success: function(data){
								if(data==0)
								{
									alert("Input Data Salah");
									$("#dialog-add" ).dialog({
										title: 'Input Data'
									});
									$("#dialog-add" ).dialog( "open" );
								}
								else
								{
									var tgl 	= $("#datepicker").val();
									var ar_tgl 	= tgl.split('/');
									tgl 		= ar_tgl[2]+'-'+ar_tgl[1]+'-'+ar_tgl[0];
									window.location.href="<?php echo base_url();?>index.php/inventory/jual/index/"+tgl;
								}
							}
						});
					}
					else
					{
						$.ajax({
							async: false,
							type: "POST",
							url: "<?php echo base_url();?>index.php/inventory/jual/update_jual",
							data: $("#form_add").serialize(),
							cache: false,
							success: function(data){
								if(data==0)
								{
									alert("Input Data Salah");
									$("#dialog-add" ).dialog({
										title: 'Input Data'
									});
									$("#dialog-add" ).dialog( "open" );
								}
								else
								{
									var tgl 	= $("#datepicker").val();
									var ar_tgl 	= tgl.split('/');
									tgl = ar_tgl[2]+'-'+ar_tgl[1]+'-'+ar_tgl[0];
									window.location.href="<?php echo base_url();?>index.php/inventory/jual/index/"+tgl;
								}
							}
						});
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function()
			{
				$(".tanggal_penjualan_tamp").val('');
				$(".id_penjualan_temp").val('');
				$(".id_penjualan_tamp").val($(".id_penjualan_temp_new").val());
				$(".total_seluruh" ).val('');
				$(".cara_bayar_1" ).val('');
				$(".cara_bayar_2" ).val('');
				$(".jumlah_bayar_1" ).val('');
				$(".jumlah_bayar_2" ).val('');
				$(".total_seluruh" ).val('');
				$(".cls_jumlah_dp").val('');
				$(".cls_jumlah_sisa").val('');
				
				var cek = 0;
				$('#trhide').find('tr').hide();
				for(var index=0 ; index<=cek ; index++){
					$('tr.'+index).show();
				}
				
				for(var i=0;i<=50;i++)
				{
					$("#id_barang_"+i ).val('');
					$("#id_harga_satuan_"+i ).val('');
					$("#nama_barang_"+i ).val('');
					$("#id_kuantum_"+i ).val('');
					$("#id_total_harga_barang_"+i ).val('');
				}
			}
		});
		
		//hide row
		var cek = $('div.add').find('input#index_ke').attr('value');
		$('#trhide').find('tr').hide();
		for(var index=0 ; index<=cek ; index++){
			$('tr.'+index).show();
		}
		
		$(".add_po" ).click(function(){
			$("#dialog-jual" ).dialog({
				title: 'Input Data'
			});
			$("#dialog-jual" ).dialog( "open" );
		});
		
		$('.add').click(function(){
			var arr = $(this).find('input#index_ke').attr('value');
			var ind = Number(arr) + 1;
			$('tr.'+ind).show();
			$('#index_ke').val(ind);
		});
		
		//fungsi menghilangkan spasi
		function trim(s)
		{
			return s.replace(/^\s+|\s+$/g,'');	
		}
		
		$("span#tombol_kunci" ).click(function(){
			var tamp		= $(this).attr("class");
			var arr_tamp	= tamp.split('-');
			var id_barang	= arr_tamp[0];
			var status		= arr_tamp[1];
			var jml_stok	= $(".stok_masuk_"+id_barang ).val();
			var tgl_stok	= $("#datepicker" ).val();
			var str			= $(this).text();
			var test 		= trim(str);
			
			if(test == 'Locked'){
				if(jml_stok != '' && jml_stok != 0){
					$.ajax({
						async: false,
						type: "POST",
						url: "<?php echo base_url();?>index.php/inventory/jual/stok_awal",
						data: "id_barang="+id_barang+"&status="+status+"&jml_stok="+jml_stok+"&tanggal="+tgl_stok+"&string="+test,
						cache: false,
						success: function(msg){
							$("tr#row_"+id_barang).find("span#tombol_kunci").text('Unlocked');
							$("tr#row_"+id_barang).find("span#tombol_kunci").removeClass(id_barang+'-'+status).addClass(id_barang+'-1');
							$("input.stok_masuk_"+id_barang).attr("readonly","readonly");
						}
					});
				}
				else{
					alert("Stok belum dimasukkan!");
				}
			}
			else{
				$("tr#row_"+id_barang).find("span#tombol_kunci").text('Locked');
				$("input.stok_masuk_"+id_barang).attr("readonly","");
			}
		});
		
		$('span#batal').click(function(){
			var n = $(this).attr('class');
			var m = $('input#index_ke').attr('value');
			while(n < m)
			{
				var tamp_n = Number(n) + 1;
				$('#nama_barang_'+n).val($('#nama_barang_'+tamp_n).val());
				$('#id_kuantum_'+n).val($('#id_kuantum_'+tamp_n).val());
				$('#id_total_harga_barang_'+n).val($('#id_total_harga_barang_'+tamp_n).val());
				n = tamp_n;
			}
			
			$('#nama_barang_'+m).val('');
			$('#id_kuantum_'+m).val('');
			$('#id_total_harga_barang_'+m).val('');
			
			if(m > 0)
			{
				$('tr.'+m).fadeOut();
				$('#index_ke').val(m - 1);
			}
			
			var limit_index = $('#index_ke').val();
			jml_total1 = 0;
			for(i=0; i<=limit_index; i++)
			{
				var jml_subtotal = 0;
				jml_subtotal = $('#id_total_harga_barang_'+i).val();
				jml_total = Number(jml_total1) + Number(jml_subtotal);
				jml_total1 = 0;
				jml_total1 = jml_total;
			}
			//============ Untuk Jumlah Total ============
			$('.total_seluruh').val(jml_total);
		});
		
		$('#datepicker').change( function(){
			var date_sale = $('#datepicker').val();
			$.ajax({
				async: false,
				type: "POST",
				url: "<?php echo base_url();?>index.php/inventory/jual/view_jual",
				data: "tgl="+date_sale,
				cache: false,
				success: function(data){
					window.location.href=data;
				}
			});
		});
		
		$(".jumlah_bayar_1" ).keyup(function(){
			var sisa_byr = hitung_sisa();
			$('.cls_jumlah_sisa').val(sisa_byr);
		});
		$(".jumlah_bayar_2" ).keyup(function(){
			var sisa_byr = hitung_sisa();
			$('.cls_jumlah_sisa').val(sisa_byr);
		});
		
	});
	
	function hitung_sisa()
	{
		var jml_byr1	= $(".jumlah_bayar_1" ).val();
		var jml_byr2	= $(".jumlah_bayar_2" ).val();
		var ttl_seluruh	= $(".total_seluruh" ).val();
		var jml_dp		= $(".cls_jumlah_dp" ).val();
		total_sisa = Number(ttl_seluruh)- (Number(jml_dp)+Number(jml_byr1)+Number(jml_byr2));
		return total_sisa;
	}
	
	//Edit Jual
	function edit_jual(id_penjualan)
	{
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/jual/find_jual",
			data: "id_penjualan="+id_penjualan,
			cache: false,
			success: function(data){
				get_data_tamp(data);			
			}
		});
		
		$("#dialog-jual" ).dialog({
			title: 'Edit Data'
		});
		$("#dialog-jual" ).dialog( "open" );
	}
	
	function get_data_tamp(mydata)
	{
		var dataArr 			= mydata.split(",");
		var id_penjualan 		= dataArr[0];
		var tanggal_penjualan	= dataArr[1];
		var cara_pembayaran_1	= dataArr[2];
		var jumlah_bayar_1 		= dataArr[3];
		var cara_pembayaran_2	= dataArr[4];
		var jumlah_bayar_2 		= dataArr[5];
		var no_po		 		= dataArr[6];
		var bayar_dp	 		= dataArr[7];
		
		$(document).ready(function(){
			$(".no_po").val(no_po);
			$(".id_penjualan_temp").val(id_penjualan);
			$(".id_penjualan_tamp").val(id_penjualan);
			$(".tanggal_penjualan_tamp").val(tanggal_penjualan);
			$(".cara_bayar_1").val(cara_pembayaran_1);
			$(".cara_bayar_2").val(cara_pembayaran_2);
			$(".jumlah_bayar_1").val(jumlah_bayar_1);
			$(".jumlah_bayar_2").val(jumlah_bayar_2);
			$(".cls_jumlah_dp").val(bayar_dp);
		});
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/jual/find_jual_detail",
			data: "id_penjualan="+id_penjualan,
			cache: false,
			success: function(data){
				get_data_detail_tamp(data);			
			}
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
		
		for(var i=0;i<jum_data;i++)
		{
			var dataArr 			= arr_data[i].split(",");
			var detail_penjualan	= dataArr[0];
			var id_penjualan 		= dataArr[1];
			var id_barang			= dataArr[2];
			var kuantum		 		= dataArr[3];
			var total_harga			= dataArr[4];
			var nama_barang			= dataArr[5];
			var harga_barang		= dataArr[6];
			var total_keseluruhan	= dataArr[7];
			
			$(document).ready(function(){
				$("#id_penjualan_detail_"+i).val(detail_penjualan);
				$("#id_barang_"+i).val(id_barang);
				$("#id_harga_satuan_"+i).val(harga_barang);
				$("#nama_barang_"+i).val(nama_barang);
				$("#id_kuantum_"+i).val(kuantum);
				$("#id_total_harga_barang_"+i).val(total_harga);
				$(".total_seluruh").val(total_keseluruhan);
			});
		}
		
		var jml_sisa 	= hitung_sisa();
		$(".cls_jumlah_sisa").val(jml_sisa);
	}
	
	//autocomplete barang
	function nilai(data, arr)
	{
		$(function(){
			$('#nama_barang_'+arr).autocomplete("<?php echo base_url();?>index.php/inventory/jual/find_all_barang", 
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
					$('#id_kuantum_'+arr).val('1');
					$('#id_harga_satuan_'+arr).val(data.harga_barang);
					$('#id_total_harga_barang_'+arr).val(data.harga_barang);
					
					detail_count(data.id_barang, arr);
				}
			);
		});
	}
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
    <div class="icon"></div>
    <h3>Input Stok Barang</h3>
    <div class="clear"></div>
    <table>
        <tr>
            <td style="width: 150px;">Tanggal Transaksi</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker" name="tanggal_penjualan" size="10" maxlength="10" readonly="readonly" value="<?php 
                echo $date;?>" /></td>
        </tr>
    </table>
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Barang</legend>
        </table>
        <table id="gridview">
        	<thead>
                <tr>
                    <td class="labels_dbyr">Nama Barang</td>
                    <td class="labels_dbyr">Stok Hari Ini</td>
                    <td class="labels_dbyr">Status</td>
                </tr>
			</thead>
            <tbody>
            <?php 
			foreach($list_barang->result_array() as $barang)
			{
				?>
				<tr id="row_<?php echo $barang['id_barang']?>">
                	<input type="hidden" name="id_barang" class="id_barang_tamp" value="<?php echo $barang['id_barang'];?>" />
                	<input type="hidden" name="harga_satuan" class="harga_satuan_tamp" value="<?php echo $barang['harga_barang'];?>" />
                	<td class="labelss_dbyr"><?php echo $barang['nama_barang'];?></td>
                	<td class="labelss_dbyr">
                    	<input type="text" id="stok_masuk" name=stok_masuk[] class="stok_masuk_<?php echo $barang['id_barang'];?>" <?php 
							if($barang['jumlah'] > 0){echo 'readonly="readonly"';}?> value="<?php echo round($barang['stok'])?>" />
					</td>
                	<td class="labelss_dbyr"><a href="javascript:void(0)">
                    	<span id="tombol_kunci" class="<?php echo $barang['id_barang'].'-'.$barang['jumlah'];?>" style="display:block">
							<?php if($barang['jumlah'] > 0){echo 'Unlocked';}else{echo 'Locked';}?>
						</span>
					</a></td>
                </tr>
				<?php 
			}
			?>
            </tbody>
        </table>
        <div class="clear"></div>
	</fieldset>
</div>
<div class="">
    <div class="icon"></div>
    <h3>Data Penjualan</h3>
    <div class="clear"></div>
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Penjualan</legend>
			<div style="margin-bottom:10px; text-align:right;">
				<a href="<?php echo site_url('inventory/jual/export_to_excel/'.$this->uri->segment(4));?>"><input type="button" value="Export Excel" /></a>
			</div>
            <table id="gridview">
                <tr>
                    <td class="labels_dbyr">No. Penjualan</td>
                    <td class="labels_dbyr">Nama Barang</td>
                    <td class="labels_dbyr">Quantity</td>
                    <td class="labels_dbyr">Total Harga</td>
                    <td class="labels_dbyr">Edit</td>
                    <td class="labels_dbyr">Batal</td>
                </tr>
			</table>
            <div id="scrollable" class="yui3-scrollview-loading">
            <table id="gridview">
                <?php
					$i=1;
                    foreach($list_detail_jual->result_array() as $jual_detail)
					{
						$_SESSION['penjualan_'.$i] = $jual_detail['id_penjualan'];
						?>
                            <tr class="isi_list_jurnal">
                            	<div id="id_penjualan_<?php echo $i;?>" style="display:none"><?php echo $jual_detail['id_penjualan'];?></div>
                                <td class="labelss_dbyr">
								<?php
									if($i > 1)
									{
										if($_SESSION['penjualan_'.$i]!=$_SESSION['penjualan_'.($i-1)])
										{
											if($jual_detail['no_po'] != '0')
												echo $jual_detail['nama_customer'];
											else
												echo $jual_detail['id_penjualan'];
										}
										else
											echo '&nbsp;';
									}
									else
									{
										if($jual_detail['no_po'] != '0')
											echo $jual_detail['nama_customer'];
										else
											echo $jual_detail['id_penjualan'];
									}
								?>
                                </td>
                                <td class="labelss_dbyr"><?php echo $jual_detail['nama_barang']; ?></td>
                                <td class="labelss_dbyr"><?php echo $jual_detail['jumlah_stok']; ?></td>
                                <td class="labelss_dbyr"><?php echo currency_format($jual_detail['total_harga'],0); ?></td>
                                <td class="labelss_dbyr">
								<?php
                                    if($i > 1)
                                    {
                                        if($_SESSION['penjualan_'.$i]!=$_SESSION['penjualan_'.($i-1)])
                                        {
                                            ?>
                                            <a href="javascript:void(0)" onclick="edit_jual('<?php echo $jual_detail['id_penjualan'];?>')">
                                            <span style="display:block">Edit</span>
                                            </a>
                                            <?php 
                                        }
                                        else
                                            echo '&nbsp;';
                                    }
                                    else
                                    {
                                        ?>
                                        <a href="javascript:void(0)" onclick="edit_jual('<?php echo $jual_detail['id_penjualan'];?>')">
                                        <span style="display:block">Edit</span>
                                        </a>
                                        <?php
                                    }
                                ?>
								</td>
                                <td class="labelss_dbyr">
                                <?php
                                    if($i > 1)
                                    {
                                        if($_SESSION['penjualan_'.$i]!=$_SESSION['penjualan_'.($i-1)])
                                        {
                                            ?>
                                            <input type="checkbox" name=batal_list[] value="<?php echo $jual_detail['id_penjualan']; ?>" />
                                            <?php 
                                        }
                                        else
                                            echo '&nbsp;';
                                    }
                                    else
                                    {
                                        ?>
                                        <input type="checkbox" name=batal_list[] value="<?php echo $jual_detail['id_penjualan']; ?>" />
                                        <?php
                                    }
                                ?>
                                </td>
                            </tr>
                		<?php
						$i++;
					}?>
            </table>
            </div>
            <div class="add_po">
                <a href="javascript:void(0)">+</a>
            </div>
    </fieldset>
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Total Stok Penjualan</legend>
        <table id="gridview">
            <tr>
                <td class="labels_dpo">Nama Barang</td>
                <td class="labels_dpo">Total Stok Penjualan</td>
            </tr>
            <?php 
			$total_penjualan_stok = 0;
			foreach($list_barang_jual->result_array() as $row_total)
			{?>
				<tr>
                	<td class="labelss_dpo"><?php echo $row_total['nama_barang'];?></td>
                	<td class="labelss_dpo"><?php echo round($row_total['stok_penjualan']);?></td>
                </tr>
				<?php 
				$total_penjualan_stok = $total_penjualan_stok + $row_total['stok_penjualan'];
			}?>
            <tr>
            	<td class="labelss_dpo">TOTAL</td>
            	<td class="labelss_dpo"><?php echo round($total_penjualan_stok);?></td>
            </tr>
        </table>
	</fieldset>
</div>

<script>
	function hitung(id_barang_, id_kuantum_, id_harga_satuan_, arrval)
	{
		hrg_per_item = id_harga_satuan_;
		sub_total = id_kuantum_ * hrg_per_item;
		
		$('#id_total_harga_barang_'+arrval).val(sub_total);
		
		var limit_index = $('#index_ke').val();
		jml_total1 = 0;
		for(i=0; i<=limit_index; i++)
		{
			jml_subtotal = 0;
			var jml_subtotal = $('#id_total_harga_barang_'+i).val();
			jml_total = Number(jml_total1) + Number(jml_subtotal);
			jml_total1 = 0;
			jml_total1 = jml_total;
		}
		
		//============ Untuk Jumlah Total ============
		$('.total_seluruh').val(jml_total);
		//var new_jml_total = value_total_all1();
		$('#id_total_harga').val(jml_total);
		
		/*==============================*/
		var sisa_byr 		= hitung_sisa();
		$('.cls_jumlah_sisa').val(sisa_byr);
	}
	
	function detail_count(thisval, arrval)
	{
		$(document).ready(function(){
			var id_barang_			= $('#id_barang_'+arrval).val();
			var id_kuantum_			= $('#id_kuantum_'+arrval).val();
			var id_harga_satuan_	= $('#id_harga_satuan_'+arrval).val();
			var tgl_transaksi 		= $('#datepicker').val();
			
			if(id_barang_!="")
			{
				MaxKuantum(id_kuantum_, id_barang_, arrval, id_harga_satuan_, tgl_transaksi);
			}
			else
			{
				$('#id_kuantum_'+arrval).val("");
			}
		});
	}
	
	function MaxKuantum(id_kuantum_, id_barang_, arrval, id_harga_satuan_, tgl_transaksi)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/jual/max_kuantum",
			data: "id_kuantum_="+id_kuantum_+"&id_barang_="+id_barang_+"&tgl_transaksi="+tgl_transaksi,
			cache: true,
			success: function(data_kuantum){
				var ar_data = data_kuantum.split('_');
				if(ar_data[0] == 0)
				{
					$('#id_kuantum_'+arrval).val($('#id_kuantum_'+arrval).val());
					hitung(id_barang_, id_kuantum_, id_harga_satuan_, arrval);
				}
				else
				{
					if(data_kuantum!="")
					{
						$('#id_kuantum_'+arrval).val(ar_data[0]);
						hitung(id_barang_, ar_data[0], id_harga_satuan_, arrval);
					}
					else
					{
						hitung(id_barang_, id_kuantum_, id_harga_satuan_, arrval);
					}	
				}
			}
		});
	}
</script>

<div id="dialog-jual" title="">
<!-- <form>&nbsp;</form> -->
<form>&nbsp;</form>
<form name="form_pesan" id="form_add">
	<p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM PENJUALAN
    </p>
    <table>
    	<tr>
        	<input type="hidden" name="no_po" class="no_po" value="" />
        	<input type="hidden" name="id_penjualan_temp_new" class="id_penjualan_temp_new" value="<?php echo $id_penjualan; ?>" />
        	<input type="hidden" name="id_penjualan_temp" class="id_penjualan_temp" value="" />
        	<input type="hidden" name="tgl_penjualan" class="tanggal_penjualan_tamp" value="<?php echo $date;?>" />
        	<td style="width: 150px;">No. Penjualan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="id_penjualan" class="id_penjualan_tamp" size="25" value="<?php echo $id_penjualan; ?>" readonly="1" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Total Keseluruhan</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_seluruh" class="total_seluruh" size="25" value="" readonly="1" /></td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Cara Pembayaran 1</td><td>:</td><td>&nbsp;</td>
            <td>
            	<select name="id_cara_pembayaran_1" class="cara_bayar_1">
                	<option value="0">.:Pembayaran:.</option>
                    <?php 
					foreach($cara_bayar->result_array() as $row)
					{
						?>
						<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php 
					}
					?>
                </select>
            </td>
            <td>&nbsp;</td>
            <td style="width: 150px;">Sudah di Bayar</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_dp" class="cls_jumlah_dp" size="25" value="" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td style="width: 150px;">Jumlah Bayar 1</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_bayar_1" class="jumlah_bayar_1" size="25" value="" onkeypress="return checkIt(event)" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Sisa Bayar</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_sisa" class="cls_jumlah_sisa" size="25" value="" readonly="readonly" /></td>
        </tr>	
        <tr>
        	<td style="width: 150px;">Cara Pembayaran 2</td><td>:</td><td>&nbsp;</td>
            <td>
            	<select name="id_cara_pembayaran_2" class="cara_bayar_2">
                	<option value="0">.:Pembayaran:.</option>
                    <?php 
					foreach($cara_bayar->result_array() as $row)
					{
						?>
						<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php 
					}
					?>
                </select>
            </td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;"></td><td></td><td>&nbsp;</td>
            <td></td>
        </tr>
        <tr>
        	<td style="width: 150px;">Jumlah Bayar 2</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="jumlah_bayar_2" class="jumlah_bayar_2" size="25" value="" onkeypress="return checkIt(event)" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;"></td><td></td><td>&nbsp;</td>
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
                <input type="hidden" name=id_penjualan_detail[] id="id_penjualan_detail_<?php echo $ind;?>" value="" />
                <input type="hidden" name=id_barang[] id="id_barang_<?php echo $ind;?>" value="" />
                <input type="hidden" name=harga_satuan[] id="id_harga_satuan_<?php echo $ind;?>" value=""/>
                <td class="labelss"><input type="text" name=nama_barang[] id="nama_barang_<?php echo $ind;?>" value="" onclick="nilai(this.value, <?php echo $ind;?>)" /></td>
                <td class="labelss"><input type="text" name=kuantum[] id="id_kuantum_<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                <td class="labelss"><input type="text" name=total_harga[] id="id_total_harga_barang_<?php echo $ind;?>" value="" readonly="readonly" /></td>
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
</form>
</div>

<script>
	$(function(){
		// animasi list
		YUI().use('scrollview', function(Y) {
			// cek apakah ada list di halaman
			if($("#scrollable").html() != null)
			{
				var scrollView = new Y.ScrollView({
					srcNode: '#scrollable',
					height: 200
				});
				scrollView.scrollbars.flash();
				scrollView.render();		
			}
		});
	});
</script>