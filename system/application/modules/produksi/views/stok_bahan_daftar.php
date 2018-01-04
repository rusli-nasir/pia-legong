<script>
	$(function(){		
		//Add Or Edit Pemesanan
		$('.add_item').click(function(){
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
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>index.php/produksi/stok_bahan/add_stok",
						data: $("#form_add").serialize(),
						cache: false,
						success: function(data){
							if(data==0)
							{
								alert("Input Data Salah");
								$( "#dialog-add" ).dialog({
									title: 'Input Data'
								});
								$( "#dialog-add" ).dialog( "open" );
							}
							else
							{
								window.location.href="<?php echo base_url();?>index.php/produksi/stok_bahan/";
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
				$(".tgl_pembelian").val($("#datepicker").val());
				$( ".total_stok_masuk" ).val(0);
				$( ".total_stok_keluar" ).val(0);
				var cek = 0;
				$('#trhide').find('tr').hide();
				for(var index=0 ; index<=cek ; index++){
					$('tr.'+index).show();
				}
				
				for(var i=0;i<=50;i++)
				{
					$( "#id_bhn_baku_"+i ).val('');
					$( "#nama_bhn_baku_"+i ).val('');
					$( "#stok_masuk_"+i ).val(0);
					$( "#stok_keluar_"+i ).val(0);
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
				$('#id_bhn_baku_'+n).val($('#id_bhn_baku_'+tamp_n).val());
				$('#nama_bhn_baku_'+n).val($('#nama_bhn_baku_'+tamp_n).val());
				$('#stok_masuk_'+n).val($('#stok_masuk_'+tamp_n).val());
				$('#stok_keluar_'+n).val($('#stok_keluar_'+tamp_n).val());
				n = tamp_n;
			}
			
			$('#id_bhn_baku_'+m).val('');
			$('#nama_bhn_baku_'+m).val('');
			$('#stok_masuk_'+m).val(0);
			$('#stok_keluar_'+m).val(0);
			
			if(m > 0)
			{
				$('tr.'+m).fadeOut();
				$('#index_ke').val(m - 1);
			}
		});
	});

	//hitung total seluruh
	function detail_count(thisval, arrval)
	{
		$(document).ready(function(){
			var stok_masuk	= $('#stok_masuk_'+arrval).val();
			var stok_keluar	= $('#stok_keluar_'+arrval).val();
			
			var limit_index = $('#index_ke').val();
			var total_stok_masuk = 0;
			var total_stok_keluar = 0;
			for(i=0; i<=limit_index; i++)
			{		
				stok_masuk1	= $('#stok_masuk_'+i).val();
				stok_keluar1	= $('#stok_keluar_'+i).val();
				
				total_stok_masuk = Number(total_stok_masuk) + Number(stok_masuk1);
				total_stok_keluar = Number(total_stok_keluar) + Number(stok_keluar1);;
			}
			
			//============ Untuk Jumlah Total ============
			$('.total_stok_masuk').val(total_stok_masuk);
			$('.total_stok_keluar').val(total_stok_keluar);
		});
	}
	
	//autocomplete barang
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
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Daftar Stok Bahan</legend>
        <div style="margin-bottom:10px; text-align:right;">
            <a target="_blank" href="<?php echo site_url('produksi/stok_bahan/export_to_pdf/'.$this->uri->segment(4));?>"><input type="button" value="Export Pdf" /></a>
        </div>
        <table id="gridview">
            <thead>
            <tr>
                <td class="labels_dbyr">Nama Bahan Baku</td>
                <td class="labels_dbyr">Jumlah Stok</td>
                <td class="labels_dbyr">Stok Minimum</td>
                <td class="labels_dbyr">Satuan</td>
                <td class="labels_dbyr">Detail Stok</td>
            </tr>
            </thead>
        </table>
        <div id="scrollable" class="yui3-scrollview-loading">
        <table id="gridview">
            <?php
            foreach($list->result_array() as $row)
            {?>
                <tr class="isi_list">
                    <td class="labelss_panj" id="search1"><?php echo $row['nama_bhn_baku']; ?></td>
                    <td class="labelss_panj" id="search2"><?php if($row['sisa_stok']==NULL){echo 0;}else{echo round($row['sisa_stok']);} ?></td> 
                    <td class="labelss_panj" id="search3"><?php echo round($row['stok_minimum']); ?></td>
                    <td class="labelss_panj" id="search4"><?php echo $row['nama_satuan']; ?></td>
                    <td class="labelss_panj" id="search5">
                        <a href="<?php echo site_url(array('produksi','stok_bahan','find_stok_detail',$row['id_bhn_baku']))?>">
                            <span style="display:block">Detail</span></a></td>
                </tr>
                <?php
            }?>
        </table>
        </div>            
    </fieldset>
</div>

<!--For Add Or Edit Pemesanan-->
<div id="dialog-add" title="">
<form>&nbsp;</form>
<form name="form_pesan" id="form_add">
	<p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM STOK MASUK/KELUAR
    </p>
    <table>
    	<tr>
        	<td style="width: 150px;">Tgl. Transaksi</td><td>:</td><td>&nbsp;</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker" name="tgl_transaksi" class="tgl_transaksi" size="10" maxlength="10" value="<?php echo explode_date($date,1);?>" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Total Stok Masuk</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_stok_masuk" class="total_stok_masuk" value="0" /></td>
        </tr>
    	<tr>
            <td style="width: 150px;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="width: 50px;">&nbsp;</td>
        	<td style="width: 150px;">Total Stok Keluar</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_stok_keluar" class="total_stok_keluar" value="0" /></td>
        </tr>
    </table>
    <table id="tabel_detail">
        <thead>
        <tr id="id_tr_detail">
            <td class="labels_dpo">Nama Barang</td>
            <td class="labels_dpo">Stok Masuk</td>
            <td class="labels_dpo">Stok Keluar</td>
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
                <input type="hidden" name=id_bhn_baku[] id="id_bhn_baku_<?php echo $ind;?>" value="" />
                <td class="labelss_dpo">
                    <input type="text" name=nama_bhn_baku[] id="nama_bhn_baku_<?php echo $ind;?>" value="" onclick="nilai(this.value, <?php echo $ind;?>)" /></td>
                <td class="labelss_dpo"><input type="text" name=stok_masuk[] id="stok_masuk_<?php echo $ind;?>" value="0" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                <td class="labelss_dpo"><input type="text" name=stok_keluar[] id="stok_keluar_<?php echo $ind;?>" value="0" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                <td class="labelss_dpo"><a href="javascript:void(0)"><span id="batal" class="<?php echo $ind;?>" style="display:block">Batal</span></a></td>
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
					height: 300
				});
				scrollView.scrollbars.flash();
				scrollView.render();		
			}
		});
	});
</script>