<script>
	$(function(){
		//jQuery.noConflict(); // biar gak conflict :p
		// modal dialog box
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 300,
			width: 450,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id_produksi				= $("#id_produksi_tamp").val();
					var nama_transaksi			= $(".input_nama_transaksi").val();
					var jumlah_pengeluaran		= $(".input_jumlah_pengeluaran").val();
					var tgl_operasional			= $(".input_tgl_operasional").val();
					
					if(id_produksi != '' && nama_transaksi!='' && jumlah_pengeluaran!='')
					{
						cls = 'yes';
						editoperasional(id_produksi, nama_transaksi, jumlah_pengeluaran, tgl_operasional);
						$( this ).dialog( "close" );
					}
					else if(nama_transaksi!='' && jumlah_pengeluaran!='')
					{
						cls = 'yes';
						
						addoperasional(nama_transaksi, jumlah_pengeluaran, tgl_operasional);
						$( this ).dialog( "close" );
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},			
			close: function()
			{
				$("#id_produksi_tamp").val('');
				$(".input_nama_transaksi").val('');
				$(".input_jumlah_pengeluaran").val('');
			}
		});
		
		$( ".add" ).click(function(){
			$( "#dialog-hapus" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
				
		$( "#datepicker2" ).change(function(){
			var tgl 	= $(this).val();
			findOperasional(tgl);
		});
	});
	
	function addoperasional(nama_transaksi, jumlah_pengeluaran, tgl_operasional)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/operasional/add_operasional",
			data: "nama_transaksi="+nama_transaksi+"&jumlah_pengeluaran="+jumlah_pengeluaran+"&tgl_operasional="+tgl_operasional,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function findOperasional(tgl)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/operasional/find_operasional",
			data: "tgl="+tgl,
			cache: false,
			success: function(data){
				window.location.href=(data);
			}
		});
	}
	
	function findOperasional_perID(id_produksi)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/operasional/findOperasional_perID",
			data: "id_produksi="+id_produksi,
			cache: false,
			success: function(data){
				tampungData(data);			
			}
		});
		
		$( "#dialog-hapus" ).dialog({
			title: 'Edit Data'
		});
		$( "#dialog-hapus" ).dialog( "open" );
	}
	
	function tampungData(mydata)
	{
		var dataArr 				= mydata.split(",");
		var id_produksi 			= dataArr[0];
		var tanggal_pengeluaran 	= dataArr[1];
		var nama_transaksi			= dataArr[2];
		var jumlah_pengeluaran	 	= parseFloat(dataArr[3]);
		
		$(document).ready(function(){
			$("#id_produksi_tamp").val(id_produksi);
			$(".input_nama_transaksi").val(nama_transaksi);
			$(".input_jumlah_pengeluaran").val(jumlah_pengeluaran);
		});
	}
	
	function editoperasional(id_produksi, nama_transaksi, jumlah_pengeluaran, tgl_operasional)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/operasional/edit_operasional",
			data: "id_produksi="+id_produksi+"&nama_transaksi="+nama_transaksi+"&jumlah_pengeluaran="+jumlah_pengeluaran+"&tgl_operasional="+tgl_operasional,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function bataloperasional(id_produksi)
	{
		var tgl_operasional			= $(".input_tgl_operasional").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/operasional/batal_operasional",
			data: "id_produksi="+id_produksi+"&tgl_operasional="+tgl_operasional,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Pengeluaran Produksi</legend>
            <table>
                <tr>
                    <td style="width: 150px;">Tanggal Transaksi</td>
                    <td><input style="color:#0000FF;" type="text" id="datepicker2" name="tgl_operasional" class="input_tgl_operasional" size="10" maxlength="10" readonly="readonly" value="<?php 
                        echo explode_date($date,1);?>" /></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table id="gridview">
                <tr>
                    <td class="labels_dbyr">Nama Transaksi</td>
                    <td class="labels_dbyr">Jumlah Pengeluaran</td>
                    <td class="labels_dbyr">Edit</td>
                    <td class="labels_dbyr">Batal</td>
                </tr>
                <?php
				$total = 0;
				foreach($list->result_array() as $listoperasional)
				{
					$total = $total + $listoperasional['jumlah_pengeluaran'];
                ?>
                <tr class="isi_list">
                    <td class="labelss_dbyr" id="search1"><?php echo $listoperasional['nama_transaksi']; ?></td>
                    <td class="labelss_dbyr" id="search2"><?php echo currency_format($listoperasional['jumlah_pengeluaran'],0); ?></td>
                    <td class="labelss_dbyr" id="search3"><a href="javascript:void(0)" onclick="findOperasional_perID('<?php echo $listoperasional['id_produksi']?>')"><span style="display:block">Edit</span></a></td>
                    <td class="labelss_dbyr"><a href="javascript:void(0)" onclick="bataloperasional('<?php echo $listoperasional['id_produksi']?>')"><span style="display:block">Batal</span></a></td>
                </tr>
                <?php
				}
                ?>
                <tr>
                    <td class="labelss_dbyr">Total</td>
                    <td class="labelss_dbyr"><?php echo currency_format($total,0);?></td>
                    <td class="labelss_dbyr" colspan="2"></td>
                </tr>
            </table>
            <div class="add">
                <a href="javascript:void(0)">+</a>
            </div>
    </fieldset>
</div>

<!--modal dialog box-->
<div id="dialog-hapus" title="Batalkan Barang">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM PENGELUARAN PRODUKSI
    </p>
    <table>
    	<tr><td>&nbsp;</td></tr>
        <tr>
            <td>Nama Transaksi</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_transaksi" class="input_nama_transaksi" size="40" /></td>
        </tr>
        <tr>
            <td>Jumlah Pengeluaran</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="jumlah_pengeluaran" class="input_jumlah_pengeluaran" size="40" onkeypress="return checkIt(event)" /></td>
        </tr>
    </table>
	<input type="hidden" id="id_produksi_tamp" value="" />
</div>