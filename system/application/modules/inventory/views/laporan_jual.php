<script>
	$(document).ready(function() {
		$( "#datepicker" ).change(function(){
			var tgl = $(this).val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>index.php/inventory/laporan/view_laporan",
				data: "tgl="+tgl,
				cache: false,
				success: function(data){
					window.location.href=data;
				}
			});
		});
		
		$( "span#kunci" ).click(function(){
			var tamp 		= $(this).attr('class');
			var arr_tamp	= tamp.split('-');
			var saldo		= $("#saldo_awal").val();
			var tanggal		= $("#datepicker" ).val();
			var id_saldo	= arr_tamp[0];
			var status		= arr_tamp[1];
			var str			= $(this).text();
			var test 		= trim(str);
			
			if(test == 'Locked'){
				if(saldo != '' && saldo != 0){
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>index.php/inventory/laporan/add_saldo_awal",
						data: "id_saldo="+id_saldo+"&saldo_awal="+saldo+"&tanggal="+tanggal+"&status="+status+"&string="+test,
						cache: false,
						success: function(msg){
							$("span#kunci").text('Unlocked');
							$("span#kunci").removeClass(id_saldo+'-'+status).addClass(id_saldo+'-1');
							$("input#saldo_awal").attr("readonly","readonly");
						}
					});
				}
				else{
					alert("Saldo belum dimasukkan!");
				}
			}
			else{
				$("span#kunci").text('Locked');
				$("input#saldo_awal").attr("readonly","");
			}
		});
	});
	
	//fungsi menghilangkan spasi
	function trim(s)
	{
		return s.replace(/^\s+|\s+$/g,'');	
	}
	
	function keuangan(saldo)
	{
		var pendapatan = $("span#tot_pndptn").text();
		var pengeluaran = $("span#tot_pnglrn").text();
		var income = parseFloat(saldo) + parseFloat(pendapatan) + parseFloat(pengeluaran);
		
		$("span#income").text(income);
	}
</script>

<div id="toPrint">LAPORAN KESELURUHAN

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
    <div class="cage">   
        <table id="data_po_left">
            <tr>
                <td style="width: 75px;">Tanggal</td>
                <td><input style="color:#0000FF;" type="text" id="datepicker" size="10" name="lap_total" readonly="readonly" value="<?php 
				echo $tanggal;?>" /></td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>
    <div class="cage">
    	<fieldset style="border: 1px solid #CCC; padding:20px 20px; margin-top: 10px;">
        	<legend>Summary Pemesanan Stok</legend>
            <table id="gridview">
                <tr>
                    <td class="labelss_dpo">Pesanan yang belum diambil</td>
                    <td class="labelss_dpo"><?php echo $list_pesan;?></td>
                </tr>
            </table>
            <table id="gridview">
            	<thead>
                	<tr>
                    	<td class="labels_dpo">Nama Barang</td>
                    	<td class="labels_dpo">Total Stok Belum Diambil</td>
                    </tr>
                </thead>
                <tbody>
                <?php 
				$total_belum_diambil = 0;
				foreach($list_barang_pesan->result_array() as $row_list)
				{
					?>
					<tr>
                    	<td class="labelss_dpo"><?php echo $row_list['nama_barang'];?></td>
                    	<td class="labelss_dpo"><?php echo round($row_list['stok_pemesanan']);?></td>
                    </tr>
					<?php
					$total_belum_diambil = $total_belum_diambil + $row_list['stok_pemesanan'];
				}
				?>
                	<tr>
                    	<td class="labelss_dpo">TOTAL</td>
                    	<td class="labelss_dpo"><?php echo $total_belum_diambil;?></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <div class="cage">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Summary Penjualan Stok</legend>
		<div style="margin-bottom:10px; text-align:right;">
			<a href="<?php echo site_url('inventory/laporan/export_to_excel/'.$this->uri->segment(4));?>"><input type="button" value="Export Excel" /></a>
		</div>
        <table id="gridview">
            <thead>
                <tr>
                    <td class="labels_dpo">Nama Barang</td>
                    <td class="labels_dpo">Stok Hari Ini</td>
                    <td class="labels_dpo">Stok Terjual</td>
                    <td class="labels_dpo">Stok Free</td>
                    <td class="labels_dpo">Sisa Stok</td>
                    <td class="labels_dpo">Total Harga</td>
                </tr>
            </thead>
            <tbody>
            <?php 
			$total = 0;
			$total_stok_hari_ini = 0;
			$total_stok_terjual = 0;
			$total_stok_free = 0;
			$total_sisa_stok = 0;
            foreach($list_barang->result_array() as $barang)
            {
                ?>
                <tr id="row_<?php echo $barang['id_barang']?>">
                    <input type="hidden" name="id_barang" class="id_barang_tamp" value="<?php echo $barang['id_barang'];?>" />
                    <input type="hidden" name="harga_satuan" class="harga_satuan_tamp" value="<?php echo $barang['harga_barang'];?>" />
                    <td class="labelss_dpo"><?php echo $barang['nama_barang'];?></td>
                    <td class="labelss_dpo"><?php echo round($barang['stok_awal']);?></td>
                    <td class="labelss_dpo"><?php echo round($barang['stok_terjual']);?></td>
                    <td class="labelss_dpo"><?php echo round($barang['stok_free']);?></td>
                    <?php 
						$sisa_stok = $barang['stok_awal'] - $barang['stok_terjual'] - $barang['stok_free'];
						$total_harga = $barang['harga_barang'] * $barang['stok_terjual'];
					?>
                    <td class="labelss_dpo"><?php echo $sisa_stok;?></td>
                    <td class="labelss_dpo"><?php echo currency_format($total_harga,0);?></td>
                    <?php $total_stok_hari_ini = $total_stok_hari_ini + $barang['stok_awal'];?>
                    <?php $total_stok_terjual = $total_stok_terjual + $barang['stok_terjual'];?>
                    <?php $total_stok_free = $total_stok_free + $barang['stok_free'];?>
                    <?php $total_sisa_stok = $total_sisa_stok + $sisa_stok;?>
					<?php $total = $total + $total_harga;?>
                </tr>
                <?php 
            }?>
            	<tr>
                	<td class="labelss_dpo">TOTAL</td>
                	<td class="labelss_dpo"><?php echo round($total_stok_hari_ini);?></td>
                	<td class="labelss_dpo"><?php echo round($total_stok_terjual);?></td>
                	<td class="labelss_dpo"><?php echo round($total_stok_free);?></td>
                	<td class="labelss_dpo"><?php echo round($total_sisa_stok);?></td>
                    <td class="labelss_dpo"><?php echo currency_format($total,0);?></td>
                </tr>
            </tbody>
        </table>
        </fieldset>
    </div>
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Summary Keuangan</legend>
        <table id="gridview">
        	<tr>
            	<td class="labelss_dpo">Saldo Awal</td>
                <td class="labelss_dpo">
                	<input type="text" name="saldo_awal" id="saldo_awal" <?php if($jumlah_saldo > 0){echo 'readonly="readonly"';}?> value="<?php echo $jumlah_saldo;?>" style="text-align:right" onkeyup="keuangan(this.value)" />
				</td>
                <td class="labelss_dpo"<a href="javascript:void(0)">
                	<span id="kunci" class="<?php echo $id_saldo.'-'.$jumlah_saldo;?>" style="display:block">
                    	<?php if($jumlah_saldo > 0){echo 'Unlocked';}else{echo 'Locked';}?></span>
				</a></td>
            </tr>
        </table>
        <table id="gridview">
            <thead>
                <tr>
                    <td class="labels_dbyr">Jenis Transaksi</td>
                    <td class="labels_dbyr">Pendapatan</td>
                    <td class="labels_dbyr">Pengeluaran</td>
                </tr>
            </thead>
            <tbody>
            <?php 
			$total_pendapatan = 0;
            foreach($list_cara_bayar->result_array() as $cara_bayar)
            {
                ?>
                <tr id="row_<?php echo $cara_bayar['id_cara_pembayaran']?>">
                    <input type="hidden" name="id_barang" class="id_barang_tamp" value="<?php echo $cara_bayar['id_cara_pembayaran'];?>" />
                    <td class="labelss_dbyr"><?php echo $cara_bayar['nama_cara_pembayaran'];?></td>
                    <td class="labelss_dbyr"><?php echo currency_format($cara_bayar['jumlah_bayar'],0);?></td>
                    <td class="labelss_dbyr">-</td>
                    <?php $total_pendapatan = $total_pendapatan + $cara_bayar['jumlah_bayar'];?>
                </tr>
                <?php 
				if($cara_bayar['id_cara_pembayaran']=='CRBY2011020000001')
					$total_cash = $cara_bayar['jumlah_bayar'];
            }
			
			foreach($list_pengeluaran->result_array() as $pengeluaran)
			{
				$total_pengeluaran = $pengeluaran['jml_pengeluaran'];
            	?>
            	<tr>
                	<td class="labelss_dbyr">Pengeluaran Produksi</td>
                    <td class="labelss_dbyr">-</td>
                    <td class="labelss_dbyr"><?php echo currency_format($pengeluaran['jml_pengeluaran'],0);?></td>
                </tr>
                <?php 
			}
			if($total_pengeluaran=='')$total_pengeluaran = 0;
			?>
            	<tr>
                	<td class="labelss_dbyr">TOTAL</td>
                	<td class="labelss_dbyr"><?php echo currency_format($total_pendapatan,0);?>
                    	<span id="tot_pndptn" style="display:none"><?php echo $total_pendapatan;?></span>
					</td>
                	<td class="labelss_dbyr"><?php echo currency_format($total_pengeluaran,0);?>
                    	<span id="tot_pnglrn" style="display:none"><?php echo $total_pengeluaran;?></span>
                    </td>
                    <?php $income = $jumlah_saldo + $total_cash - $total_pengeluaran;?>
                </tr>
                <tr>
                	<td colspan="2" class="labelss_dbyr">CASH ON HAND</td>
                	<td class="labelss_dbyr">
                    	<span id="income"><?php if($income < 0)echo '('.currency_format($income*(-1),0).')';else echo currency_format($income,0);?></span>
					</td>
                </tr>
            </tbody>
        </table>
        </fieldset>
    </div>
</div>