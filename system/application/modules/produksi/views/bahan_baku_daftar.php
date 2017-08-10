<script>
	$(function(){
		//jQuery.noConflict(); // biar gak conflict :p
		// modal dialog box
		$( "#dialog-add" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 500,
			width: 700,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id		= $("#id_bhn_baku_tamp").val();
					var nama	= $(".input_nama_bhn_baku").val();
					var satuan	= $(".input_satuan_bhn_baku").val();
					
					if(id != '' && nama!='' && satuan!='')
					{
						cls = 'yes';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url();?>index.php/produksi/bahan_baku/edit_bahan_baku",
							data: $("#form_add").serialize(),
							cache: false,
							success: function(data){
								if(data != "Data Salah"){
									$( "#trHint" ).html(data);
									$( "#id_bhn_baku_tamp" ).val('');
									$( ".input_nama_bhn_baku" ).val('');
									$( ".input_satuan_bhn_baku" ).val('');
									$( ".input_stok_minimum" ).val('');
									$( ".input_keterangan" ).val('');
									
									var i = $('input#index_ke').attr('value');
									for(var m=0 ; m<=i ; m++)
									{
										$('#id_supplier_'+m).val('');
										$('#nama_supplier_'+m).val('');
										$('#alamat_'+m).val('');
										$('#telepon_'+m).val('');
										$('#harga_bhn_'+m).val('');
										$('#keterangan_detail_'+m).val('');
										$('tr.'+m).hide();
									}
									var ind = 0;
									$('tr.'+ind).show();
									$('#index_ke').val(ind);
								}
								else{
									alert("Input Data Salah atau Masih Ada Field yang Belum Terisi");
									findBarang(id);
								}
							}
						});
						$( this ).dialog( "close" );
					}
					else if(nama!='' && satuan!='')
					{
						cls = 'yes';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url();?>index.php/produksi/bahan_baku/add_bahan_baku",
							data: $("#form_add").serialize(),
							cache: false,
							success: function(data){
								if(data != "Data Salah"){
									$( "#trHint" ).html(data);
									$( "#id_bhn_baku_tamp" ).val('');
									$( ".input_nama_bhn_baku" ).val('');
									$( ".input_satuan_bhn_baku" ).val('');
									$( ".input_stok_minimum" ).val('');
									$( ".input_keterangan" ).val('');
									
									var i = $('input#index_ke').attr('value');
									for(var m=0 ; m<=i ; m++)
									{
										$('#id_supplier_'+m).val('');
										$('#nama_supplier_'+m).val('');
										$('#alamat_'+m).val('');
										$('#telepon_'+m).val('');
										$('#harga_bhn_'+m).val('');
										$('#keterangan_detail_'+m).val('');
										$('tr.'+m).fadeOut();
									}
									var ind = 0;
									$('tr.'+ind).show();
									$('#index_ke').val(ind);
								}
								else{
									alert("Input Data Salah atau Masih Ada Field yang Belum Terisi");
									$( "#dialog-add" ).dialog({
										title: 'Input Data'
									});
									$( "#dialog-add" ).dialog( "open" );
								}
							}
						});
					}
					else
					{
						alert("Input Data Salah atau Masih Ada Field yang Belum Terisi");
						$( "#dialog-add" ).dialog({
							title: 'Input Data'
						});
						$( "#dialog-add" ).dialog( "open" );
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},			
			close: function()
			{
				$( "#id_bhn_baku_tamp" ).val('');
				$( ".input_nama_bhn_baku" ).val('');
				$( ".input_satuan_bhn_baku" ).val('');
				$( ".input_stok_minimum" ).val('');
				$( ".input_keterangan" ).val('');
				
				var i = $('input#index_ke').attr('value');
				for(var m=0 ; m<=i ; m++)
				{
					$('#id_supplier_'+m).val('');
					$('#nama_supplier_'+m).val('');
					$('#alamat_'+m).val('');
					$('#telepon_'+m).val('');
					$('#harga_bhn_'+m).val('');
					$('#keterangan_detail_'+m).val('');
					$('tr.'+m).hide();
				}
				var ind = 0;
				$('tr.'+ind).show();
				$('#index_ke').val(ind);
			}
		});
		
		$( ".add_item" ).click(function(){
			$( "#dialog-add" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-add" ).dialog( "open" );
		});
		
		//============Show Or Hide Row============//
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
				$('#id_detail_bhn_baku_'+n).val($('#id_detail_bhn_baku_'+tamp_n).val());
				$('#id_supplier_'+n).val($('#id_supplier_'+tamp_n).val());
				$('#nama_supplier_'+n).val($('#nama_supplier_'+tamp_n).val());
				$('#alamat_'+n).val($('#alamat_'+tamp_n).val());
				$('#telepon_'+n).val($('#telepon_'+tamp_n).val());
				$('#harga_bhn_'+n).val($('#harga_bhn_'+tamp_n).val());
				$('#keterangan_detail_'+n).val($('#keterangan_detail_'+tamp_n).val());
				n = tamp_n;
			}
			
			$('#id_detail_bhn_baku_'+m).val('');
			$('#id_supplier_'+m).val('');
			$('#nama_supplier_'+m).val('');
			$('#alamat_'+m).val('');
			$('#telepon_'+m).val('');
			$('#harga_bhn_'+m).val('');
			$('#keterangan_detail_'+m).val('');
			
			if(m > 0)
			{
				$('tr.'+m).fadeOut();
				$('#index_ke').val(m - 1);
			}
		});
	});
	
	function hapusBarang(id_bhn_baku)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/bahan_baku/hapus_bahan_baku",
			data: "id="+id_bhn_baku,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
	
	function findBarang(id_bhn_baku)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/bahan_baku/find_bahan_baku",
			data: "id="+id_bhn_baku,
			cache: false,
			success: function(data){
				tampungData(data);			
			}
		});
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/bahan_baku/find_bahan_baku_detail",
			data: "id="+id_bhn_baku,
			cache: false,
			success: function(data){
				tampungDataDetail(data);		
			}
		});
		
		$( "#dialog-add" ).dialog({
			title: 'Edit Data'
		});
		$( "#dialog-add" ).dialog( "open" );
	}
	
	function tampungData(mydata)
	{
		var dataArr 			= mydata.split(",");
		var id_bhn_baku 		= dataArr[0];
		var nama_bhn_baku 		= dataArr[1];
		var id_satuan_barang	= dataArr[2];
		var stok_minimum		= dataArr[3];
		var keterangan	 		= dataArr[4];
		
		$(document).ready(function(){
			$("#id_bhn_baku_tamp").val(id_bhn_baku);
			$(".input_nama_bhn_baku").val(nama_bhn_baku);
			$(".input_satuan_bhn_baku").val(id_satuan_barang);
			$(".input_stok_minimum").val(stok_minimum);
			$(".input_keterangan").val(keterangan);
		});
	}
	
	function tampungDataDetail(mydata)
	{
		var arr_data 		= mydata.split("___");
		var jum_data 		= arr_data.length;
		
		var cek = jum_data-1;
		$('#index_ke').val(cek);
		$('#trhide').find('tr').hide();
		for(var index=0 ; index<=cek ; index++){
			$('tr.'+index).show();
		}
		
		for(var i=0 ; i<jum_data ; i++)
		{
			var dataArr 			= arr_data[i].split(",");
			var id_detail_bhn_baku 	= dataArr[0];
			var id_supplier 		= dataArr[1];
			var nama_supplier		= dataArr[2];
			var alamat			 	= dataArr[3];
			var harga_bahan			= dataArr[4];
			var keterangan			= dataArr[5];
			
			$(document).ready(function(){
				$("#id_detail_bhn_baku_"+i).val(id_detail_bhn_baku);
				$("#id_supplier_"+i).val(id_supplier);
				$("#nama_supplier_"+i).val(nama_supplier);
				$("#alamat_"+i).val(alamat);
				$("#harga_bhn_"+i).val(harga_bahan);
				$("#keterangan_detail_"+i).val(keterangan);
			});
		}
	}
	
	//========autocomplete supplier=======//
	function nilai(data, arr)
	{
		$(function(){
			$('#nama_supplier_'+arr).autocomplete("<?php echo base_url();?>index.php/produksi/supplier/find_supplier_spesifik", 
				{
					parse: function(data){ 
						var parsed = [];
						for (var i=0; i < data.length; i++) {
							parsed[i] = {
								data: data[i],
								value: data[i].nama_supplier
							};
						}
						return parsed;
					},
					formatItem: function(data,i,max){
						var str = '<div class="search_content">';
						str += '<u>'+data.nama_supplier+'</u>';
						str += '</div>';
						return str;
					},
					width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
					dataType: 'json'
				}
			).result(
				function(event,data,formated){
					$('#nama_supplier_'+arr).val(data.nama_supplier);
					$('#id_supplier_'+arr).val(data.id_supplier);
					$('#alamat_'+arr).val(data.alamat);
				}
			);
		});
	}
</script>

<div <?php echo isset ($active_menu) ? $active_menu :''?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_barang_master"><a href="">Daftar Bahan Baku</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
<?php 
if($notification != '')
{
	$this->load->view('notifikasi_stok', $notification);
}
?>
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
            <legend>Data Bahan Baku</legend>
            <form>
                <table id="gridview">
                	<thead>
                    <tr>
                        <td class="labels_dpo">Nama Bahan Baku</td>
                        <td class="labels_dpo">Satuan Barang</td>
                        <td class="labels_dpo">Keterangan</td>
                        <td class="labels_dpo">Edit</td>
                        <td class="labels_dpo">Hapus</td>
                    </tr>
                    </thead>
				</table>
                <div id="scrollable" class="yui3-scrollview-loading">
                <table id="gridview">
                    <tbody id="trHint">
                    <?php
                    foreach($list->result_array() as $brg_detail)
					{
						?>
						<tr class="isi_list">
							<td class="labelss_dpo" id="search1"><?php echo $brg_detail['nama_bhn_baku'];?></td>
							<td class="labelss_dpo" id="search2"><?php echo $brg_detail['nama_satuan'];?></td>
							<td class="labelss_dpo" id="search3"><?php echo $brg_detail['keterangan'];?></td>
                            <td class="labelss_dpo"><div class="edit" onclick="findBarang('<?php echo $brg_detail['id_bhn_baku'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Edit</span></a>
                            </div></td>
                            <td class="labelss_dpo"><div class="hapus" onclick="hapusBarang('<?php echo $brg_detail['id_bhn_baku'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Hapus</span></a>
                            </div></td>
						</tr>
                        <?php
					}
					?>
                    </tbody>
                </table>
                </div>
                <!--<div class="add_po">
                    <a href="javascript:void(0)">+</a>
                </div>-->
            </form>
        </fieldset>
    </div>
</div>

<!--modal dialog box-->
<div id="dialog-add" title="Input Bahan Baku">
<form>&nbsp;</form>
<form name="form_pesan" id="form_add">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM BAHAN BAKU
    </p>
    <table>
    	<tr><td>&nbsp;</td></tr>
        <tr>
            <td>Nama Bahan Baku</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_bhn_baku" class="input_nama_bhn_baku" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Satuan Barang</td><td colspan="2">&nbsp;</td>
            <td>
            	<select name="satuan_bhn_baku" class="input_satuan_bhn_baku">
                	<option value="">:Pilih Satuan:</option>
					<?php
                    foreach($satuan->result_array() as $row_satuan){
						echo '<option value="'.$row_satuan['id_satuan_barang'].'">'.$row_satuan['nama_satuan'].'</option>';
					}
					?>
                </select>&nbsp;*
			</td>
        </tr>
        <tr>
            <td>Stok Minimum di Gudang</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="stok_minimum" class="input_stok_minimum" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan" size="40" /></td>
        </tr>
    </table>
    <table id="tabel_detail">
        <thead>
        <tr id="id_tr_detail">
            <td class="labels_dpo">Supplier</td>
            <td class="labels_dpo">Alamat</td>
            <td class="labels_dpo">Harga Bahan Per Satuan</td>
            <td class="labels_dpo">Keterangan</td>
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
                <input type="hidden" name=id_detail_bhn_baku[] id="id_detail_bhn_baku_<?php echo $ind;?>" value="" />
                <input type="hidden" name=id_supplier[] id="id_supplier_<?php echo $ind;?>" value="" />
                <td class="labelss">
                    <input type="text" name=nama_supplier[] id="nama_supplier_<?php echo $ind;?>" value="" onclick="nilai(this.value, <?php echo $ind;?>)" /></td>
                <td class="labelss"><input type="text" name=alamat[] id="alamat_<?php echo $ind;?>" value="" readonly="readonly" /></td>
                <td class="labelss"><input type="text" name=harga_bhn[] id="harga_bhn_<?php echo $ind;?>" value="" onkeypress="return checkIt(event)" /></td>
                <td class="labelss"><input type="text" name=keterangan_detail[] id="keterangan_detail_<?php echo $ind;?>" value="" /></td>
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

<!--untuk menampung id bahan baku-->
<input type="hidden" name="id_bhn_baku_tamp" id="id_bhn_baku_tamp" value="" />
</form>
</div>
