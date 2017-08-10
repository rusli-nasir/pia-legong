<script>
$(function(){
	//Show Or Hide Row
	var cek = $(this).find('input#index_ke').attr('value');
	$('#trhide').find('tr').hide();
	for(var index=0 ; index<=cek ; index++){
		$('tr.'+index).show();
	}
	
	$('.dibayar').keyup(function(){
		var total = $('.total_harga').val();
		var dibayar = $(this).val();
		
		if(Number(dibayar) > Number(total))
			$(this).val(Number(total));
		if(dibayar > 0)
			$(this).val(Number(dibayar));
		if(dibayar == "" || dibayar < 0)
			$(this).val(0);
	});
	
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
			$('#id_detail_pembelian_'+n).val($('#id_detail_pembelian_'+tamp_n).val());
			$('#id_bhn_baku_'+n).val($('#id_bhn_baku_'+tamp_n).val());
			$('#id_supplier_'+n).val($('#id_supplier_'+tamp_n).val());
			$('#nama_bhn_baku_'+n).val($('#nama_bhn_baku_'+tamp_n).val());
			$('#nama_supplier_'+n).val($('#nama_supplier_'+tamp_n).val());
			$('#telepon_'+n).val($('#telepon_'+tamp_n).val());
			$('#no_rekening_'+n).val($('#no_rekening_'+tamp_n).val());
			$('#harga_bahan_'+n).val($('#harga_bahan_'+tamp_n).val());
			$('#quantity_'+n).val($('#quantity_'+tamp_n).val());
			$('#total_per_barang_'+n).val($('#total_per_barang_'+tamp_n).val());
			n = tamp_n;
		}
		
		$('#id_detail_pembelian_'+m).val('');
		$('#id_bhn_baku_'+m).val('');
		$('#id_supplier_'+m).val('');
		$('#nama_bhn_baku_'+m).val('');
		$('#nama_supplier_'+m).val('');
		$('#telepon_'+m).val('');
		$('#no_rekening_'+m).val('');
		$('#harga_bahan_'+m).val(0);
		$('#quantity_'+m).val(0);
		$('#total_per_barang_'+m).val(0);
		
		if(m > 0)
		{
			$('tr.'+m).fadeOut();
			$('#index_ke').val(m - 1);
		}
		
		var limit_index = $('#index_ke').val();
		var jml_total = 0;
		var jml_order_barang = 0;
		for(i=0; i<=limit_index; i++)
		{
			var jml_subtotal = $('#total_per_barang_'+i).val();
			jml_total = Number(jml_total) + Number(jml_subtotal);
			
			var jml_suborder_barang = $('#quantity_'+i).val();
			jml_order_barang = Number(jml_order_barang) + Number(jml_suborder_barang);
		}
		
		//============ Untuk Jumlah Total ============
		$('.total_pesan').val(jml_order_barang);
		$('.total_harga').val(jml_total);
	});
	
	$( "#dialog-supplier" ).dialog({
		autoOpen: false,
		resizable: false,
		height: 500,
		width: 900,
		modal: true,
		closeOnEscape: false,
		buttons: {}
	});
});

function nilai(data, arr)
{
	$(function(){
		$('#nama_bhn_baku_'+arr).autocomplete("<?php echo base_url();?>index.php/produksi/bahan_baku/find_this_barang", 
			{
				parse: function(data){ 
					var parsed = [];
					for (var i=0; i < data.length; i++) {
						parsed[i] = {
							data: data[i],
							value: data[i].nama_bhn_baku
						};
					}
					return parsed;
				},
				formatItem: function(data,i,max){
					var str = '<div class="search_content">';
					str += '<u>'+data.nama_bhn_baku+'</u>';
					str += '</div>';
					return str;
				},
				width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
				dataType: 'json'
			}
		).result(
			function(event,data,formated){
				$('#nama_bhn_baku_'+arr).val(data.nama_bhn_baku);
				$('#id_bhn_baku_'+arr).val(data.id_bhn_baku);
			}
		);
	});
}

function supplier(data, arr)
{
	var id_bhn_baku = $('#id_bhn_baku_'+arr).val();
	if(id_bhn_baku != "") {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/beli/find_supplier",
			data: "id_bhn_baku="+id_bhn_baku+"&array="+arr,
			cache: false,
			success: function(data){
				show_supplier(data);			
			}
		});
	}
	
	$(function(){
		$( "#dialog-supplier" ).dialog({
			title: 'List Data Supplier'
		});
		$( "#dialog-supplier" ).dialog( "open" );
	});
}

function show_supplier(mydata)
{
	$("#tabel_detail_supplier").html(mydata);
}

function pilih_supplier(mydata)
{
	var arrdata = mydata.split("_");
	var id_supplier = arrdata[0];
	var array = arrdata[1];
	var id_bhn_baku = $('#id_bhn_baku_'+array).val();
	
	$.ajax({
		type: "POST",
		url: "<?php echo base_url();?>index.php/produksi/beli/find_supplier_spesifik",
		data: "id_bhn_baku="+id_bhn_baku+"&id_supplier="+id_supplier+"&array="+array,
		cache: false,
		success: function(data){
			var arr_data = data.split(",");
			
			$("#id_supplier_"+arr_data[0]).val(arr_data[1]);
			$("#nama_supplier_"+arr_data[0]).val(arr_data[2]);
			$("#telepon_"+arr_data[0]).val(arr_data[3]);
			$("#no_rekening_"+arr_data[0]).val(arr_data[4]);
			$("#harga_bahan_"+arr_data[0]).val(arr_data[5]);
			$("#quantity_"+arr_data[0]).val(1);
			
			detail_count(arr_data[1], arr_data[0]);
		}
	});
	
	$( "#dialog-supplier" ).dialog( "close" );
}

function detail_count(thisval, arrval)
{
	$(document).ready(function(){
		var quantity			= $('#quantity_'+arrval).val();
		var harga_satuan		= $('#harga_bahan_'+arrval).val();
		
		sub_total = quantity * harga_satuan;
		
		$('#total_per_barang_'+arrval).val(sub_total);
		
		var limit_index = $('#index_ke').val();
		jml_total = 0;
		var jml_order_barang = 0;
		for(i=0; i<=limit_index; i++)
		{
			var jml_subtotal = $('#total_per_barang_'+i).val();
			jml_total = Number(jml_total) + Number(jml_subtotal);
			
			var jml_suborder_barang = $('#quantity_'+i).val();
			jml_order_barang = Number(jml_order_barang) + Number(jml_suborder_barang);
		}
		
		//============ Untuk Jumlah Total ============
		$('.total_pesan').val(jml_order_barang);
		$('.total_harga').val(jml_total);
	});
}
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
	<?php 
    if($this->session->userdata('message')) {
    ?><div class="status_error"><?php 
        echo $this->session->userdata('message');
        $this->session->unset_userdata('message');
    ?></div><?php 
    }?>
    <input type="hidden" name="id_pembelian" class="id_pembelian" value="<?php if($detail_head == 0){echo '0';}else{echo $detail_head[0]['id_pembelian'];}?>" />
    <table id="data_po_left">
        <tr>
            <input style="color:#0000FF;" type="hidden" name="tgl_pembelian1" class="tgl_pembelian1" value="<?php echo explode_date($date,1);?>" />
            <td style="width: 150px;">Tgl. Akhir Pelunasan</td><td>:</td><td>&nbsp;</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker2" name="tgl_jatuh_tempo" class="tgl_jatuh_tempo" size="10" maxlength="10" value="<?php echo explode_date($date,1);?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Cara Pembayaran</td><td>:</td><td>&nbsp;</td>
            <td>
                <select name="id_cara_pembayaran_bhn" class="cara_bayar">
                    <option value="0">.:Pembayaran:.</option>
                    <?php 
                    foreach($list_cara_bayar->result_array() as $row)
                    {
						if($row['id_cara_pembayaran'] == $detail_head[0]['id_cara_pembayaran'])
						{?>
                            <option value="<?php echo $row['id_cara_pembayaran'];?>" selected="selected"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php }
						else
						{?>
                        	<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <table id="data_po_right">
        <tr>
            <td style="width: 150px;">Total Harga</td><td>:</td><td>&nbsp;</td>
            <td>
            	<input type="text" name="total_harga" class="total_harga" value="<?php if($detail_head == 0){echo '0';}else{echo $detail_head[0]['total_pembelian'];}?>" />
			</td>
        </tr>
        <tr>
            <td style="width: 150px;">Dibayar</td><td>:</td><td>&nbsp;</td>
            <td>
            	<input type="text" name="dibayar" class="dibayar" value="<?php if($detail_head == 0){echo '0';}else{echo $detail_head[0]['jumlah_bayar'];}?>" onkeypress="return checkIt(event)" />
            </td>
        </tr>
    </table>
    <div class="clear"></div>
</div>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Form Pembelian</legend>
    <table id="gridview">
        <thead>
        <tr id="id_tr_detail">
            <td class="labels_dpo">Nama Barang</td>
            <td class="labels_dpo">Supplier</td>
            <td class="labels_dpo">Telepon</td>
            <td class="labels_dpo">No. Rekening</td>
            <td class="labels_dpo">Harga Barang</td>
            <td class="labels_dpo">Quantity</td>
            <td class="labels_dpo">Total Per Barang</td>
            <td class="labels_dpo">Batal</td>
        </tr>
        </thead>
        <tbody id="trhide">
        <?php
        $i=0;
        $brs=0;
		$total_pesan=0;
		
		if($detail_list)
		{
			foreach($detail_list as $detail)
			{?>
				<tr class="<?php echo $brs;?>">
                    <input type="hidden" name=id_detail_pembelian[] id="id_detail_pembelian_<?php echo $brs;?>" value="<?php echo $detail['id_detail_pembelian'];?>" />
                    <input type="hidden" name=id_bhn_baku[] id="id_bhn_baku_<?php echo $brs;?>" value="<?php echo $detail['id_bhn_baku'];?>" />
                    <input type="hidden" name=id_supplier[] id="id_supplier_<?php echo $brs;?>" value="<?php echo $detail['id_supplier'];?>" />
                    <td class="labelss_dpo">
                        <input type="text" name=nama_bhn_baku[] id="nama_bhn_baku_<?php echo $brs;?>" value="<?php echo $detail['nama_bhn_baku'];?>" onclick="nilai(this.value, <?php echo $brs;?>)" /></td>
                    <td class="labelss_dpo">
                        <input type="text" name=nama_supplier[] id="nama_supplier_<?php echo $brs;?>" value="<?php echo $detail['nama_supplier'];?>" onclick="supplier(this.value, <?php echo $brs;?>)" /></td>
                    <td class="labelss_dpo"><input type="text" name=telepon[] id="telepon_<?php echo $brs;?>" value="<?php echo $detail['telepon_1'];?>" /></td>
                    <td class="labelss_dpo"><input type="text" name=no_rekening[] id="no_rekening_<?php echo $brs;?>" value="<?php echo $detail['no_rekening'];?>" /></td>
                    <td class="labelss_dpo"><input type="text" name=harga_bahan[] id="harga_bahan_<?php echo $brs;?>" value="<?php echo round($detail['harga_bhn_baku']);?>" /></td>
                    <td class="labelss_dpo"><input type="text" name=quantity[] id="quantity_<?php echo $brs;?>" value="<?php echo round($detail['quantity']);?>" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss_dpo"><input type="text" name=total_per_barang[] id="total_per_barang_<?php echo $brs;?>" value="<?php echo round($detail['total_harga']);?>" /></td>
                    <td class="labelss_dpo"><a href="javascript:void(0)"><span id="batal" class="<?php echo $brs;?>" style="display:block">Batal</span></a></td>
                </tr>
				<?php 
                $i++;
                $brs++;
				$total_pesan = $total_pesan + $detail['quantity'];
			}
		}
		
        for($ind=$brs ; $ind<=50 ; $ind++)
        {?>
            <tr class="<?php echo $ind;?>">
                <input type="hidden" name=id_detail_pembelian[] id="id_detail_pembelian_<?php echo $ind;?>" value="" />
                <input type="hidden" name=id_bhn_baku[] id="id_bhn_baku_<?php echo $ind;?>" value="" />
                <input type="hidden" name=id_supplier[] id="id_supplier_<?php echo $ind;?>" value="" />
                <td class="labelss_dpo">
                    <input type="text" name=nama_bhn_baku[] id="nama_bhn_baku_<?php echo $ind;?>" value="" onclick="nilai(this.value, <?php echo $ind;?>)" /></td>
                <td class="labelss_dpo">
                    <input type="text" name=nama_supplier[] id="nama_supplier_<?php echo $ind;?>" value="" onclick="supplier(this.value, <?php echo $ind;?>)" /></td>
                <td class="labelss_dpo"><input type="text" name=telepon[] id="telepon_<?php echo $ind;?>" value="" /></td>
                <td class="labelss_dpo"><input type="text" name=no_rekening[] id="no_rekening_<?php echo $ind;?>" value="" /></td>
                <td class="labelss_dpo"><input type="text" name=harga_bahan[] id="harga_bahan_<?php echo $ind;?>" value="0" /></td>
                <td class="labelss_dpo"><input type="text" name=quantity[] id="quantity_<?php echo $ind;?>" value="0" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                <td class="labelss_dpo"><input type="text" name=total_per_barang[] id="total_per_barang_<?php echo $ind;?>" value="0" /></td>
                <td class="labelss_dpo"><a href="javascript:void(0)"><span id="batal" class="<?php echo $ind;?>" style="display:block">Batal</span></a></td>
            </tr>
            <?php
            $i++;
        }?>
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
            <td><input type="text" name="total_pesan" class="total_pesan" size="10" value="<?php if($detail_list != ''){echo $total_pesan;}else{echo '0';}?>" /></td>
        </tr>
    </table>
    </div>            
    </fieldset>
</div>

<!---------------------------------------------------------------------------List Supplier------------------------------------------------------------------------------>
<div id="dialog-supplier" title="">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        LIST SUPPLIER
    </p>
    <span style="display:none" id="ind"></span>
    <table>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table id="tabel_detail_supplier"></table>
</div>