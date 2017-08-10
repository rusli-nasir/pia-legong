<script>
	$(document).ready(function(){	
		$('#id_bayar').keyup(function(){
			var id_sisa			= $('#id_sisa').val();
			var id_bayar		= $('#id_bayar').val();
			
			jml_sisa = id_sisa - id_bayar;
			
			$('#id_sisa_bayar').val(jml_sisa);
		});
		
		$('span#batal').click(function(){
			var id_penjualan  = $('input.id_penjualan').val();
			var id_pembayaran = $(this).attr('class');
			var jml_byr		  = $('input#bayar_invoice_'+id_pembayaran).val();
			var dp			  = $('input#id_dp').val();
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>index.php/inventory/jual/cancl_bayar",
				data: "id_jual="+id_penjualan+"&id_bayar="+id_pembayaran+"&jml_byr="+jml_byr+"&dp="+dp,
				cache: false,
				success: function(msg){
					window.location.href=msg;
				}
			});
		});
		
		$( "span#print_kuitansi" ).click(function(){
			id = $(this).attr('class');
			window.open("<?php echo base_url();?>index.php/inventory/jual/kuitansi/"+id+"", "status=1,width=350,height=150");
		});
	});
</script>

<?php
	if($data_bayar['status_bayar'] == 'add_bayar')
	{
		$id_penjualan		= $data_bayar['id_penjualan'];
		$no_invoice			= $data_bayar['no_invoice'];
		$tglbaru			= $data_bayar['tgl_penjualan'];
		$tgl_penjualan		= explode_date($tglbaru, 1);
		$tglbaru			= $data_bayar['tgl_jatuh_tempo'];
		$tgl_jatuh_tempo	= explode_date($tglbaru, 1);
		$total_harga		= $data_bayar['total_harga'];
		$dp					= $data_bayar['dp'];
		$id_cara_pembayaran	= $data_bayar['id_cara_pembayaran'];
		$sisa_bayar 		= $total_harga - $dp;
	}
	else
	{
		$id_penjualan		= '';
		$no_invoice			= '';
		$tgl_penjualan		= '';
		$tgl_jatuh_tempo	= '';
		$total_harga		= '';
		$dp					= '';
		$id_cara_pembayaran	= '';
		$sisa_bayar			= '';
	}
?>
<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
    <div class="icon"></div>
    <h3>Data Pembayaran</h3>
    <div class="clear"></div>
        <table id="data_po_left">
            <tr>
            	<input type="hidden" name="id_penjualan" class="id_penjualan" value="<?php echo $id_penjualan; ?>" />
                <td style="width: 150px;">No. Invoice</td>
                <td><input type="text" name="no_invoice" value="<?php echo $no_invoice; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Tanggal Invoice</td>
                <td><input type="text" name="tgl_penjualan" value="<?php echo $tgl_penjualan; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Tanggal Jatuh Tempo</td>
                <td><input type="text" name="tgl_jatuh_tempo" value="<?php echo $tgl_jatuh_tempo; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Tanggal Pembayaran</td>
                <td><input style="color:#0000FF;" type="text" id="datepicker" size="10" name="tanggal_pembayaran" readonly="readonly" value="<?php echo date("d/m/Y"); ?>" /></td>
            </tr>
        </table>
        <table id="data_po_right">
            <tr>
                <td style="width: 150px;">Total Pembayaran</td>
                <td><input type="text" name="total_harga" value="<?php echo round($total_harga,0);?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Sudah di Bayar</td>
                <td><input type="text" name="dp" id="id_dp" value="<?php echo round($dp,0);?>" readonly="readonly" /></td>
            </tr>
            <tr>
            	<input type="hidden" name="sisa" id="id_sisa" value="<?php echo round($sisa_bayar,0);?>" readonly="readonly" />
                <td style="width: 150px;">Sisa Pembayaran</td>
                <td><input type="text" name="sisa_bayar" id="id_sisa_bayar" value="<?php echo round($sisa_bayar,0);?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Bayar</td>
                <td><input type="text" name="bayar" id="id_bayar" value="" onkeypress="return checkIt(event)" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Cara Pembayaran</td>
                <td>
                <select name="id_cara_pembayaran" id="update_id_cara_pembayaran">
				<?php
                	foreach($cara_bayar->result_array() as $carabayar)
                    {
						if($id_cara_pembayaran==$carabayar['id_cara_pembayaran'])
                        {?>
							<option value="<?php echo $carabayar['id_cara_pembayaran']; ?>" selected="1"><?php echo $carabayar['nama_cara_pembayaran']; ?></option> 
						<?php 
						}else
						{?>
                        	<option value="<?php echo $carabayar['id_cara_pembayaran']; ?>"><?php echo $carabayar['nama_cara_pembayaran']; ?></option>
                        <?php
						}
					}
                ?>
                </select>
                </td>
            </tr>
        </table>
        <div class="clear"></div>
</div>

<div class="">
    <div class="icon"></div>
    <h3>Data Pembayaran Detail</h3>
    <div class="clear"></div> 
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Barang</legend>
            <table id="gridview">
                <tr>
                    <td class="labels_dpo">No.Kuitansi</td>
                    <td class="labels_dpo">Cara Pembayaran</td>
                    <td class="labels_dpo">Tgl Pembayaran</td>
                    <td class="labels_dpo">Bayar Invoice</td>
                    <?php
						if($user_status[9]['status']==2)
						{
					?>
                    <td class="labels_dpo">Batal</td>
                    <?php
						}
					?>
                    <td class="labels_dpo">Print</td>
                </tr>
                <?php
				foreach($data_bayar_detail->result_array() as $recordsetdetailbayar)
				{?>
                <tr class="<?php echo $recordsetdetailbayar['id_pembayaran'];?>">
                	<input type="hidden" name=id_pembayaran[] class="<?php echo $recordsetdetailbayar['id_pembayaran'];?>" value="<?php echo $recordsetdetailbayar['id_pembayaran'];?>" readonly="readonly" />
                    <td class="labelss_dpo"><?php echo $recordsetdetailbayar['no_kuitansi']; ?></td>
                    <td class="labelss_dpo"><?php echo $recordsetdetailbayar['nama_cara_pembayaran']; ?></td>
                    <td class="labelss_dpo"><?php echo $recordsetdetailbayar['tanggal_pembayaran']; ?></td>
                    <td class="labelss_dpo"><?php echo currency_format($recordsetdetailbayar['bayar'],0); ?></td>
                    <?php
						if($user_status[9]['status']==2)
						{
					?>
                    <td class="labelss_dpo"><a href="javascript:void(0)"><span id="batal" class="<?php echo $recordsetdetailbayar['id_pembayaran'];?>" style="display:block">Batal</span></a></td>
                    <?php
						}
					?>
                    <td class="labelss_dpo"><a href="javascript:void(0)"><span id="print_kuitansi" class="<?php echo $recordsetdetailbayar['id_pembayaran'];?>_<?php echo $id_penjualan;?>" style="display:block">Kuitansi</span></a></td>
                </tr>
                <?php
				}?>
            </table>
    </fieldset>
</div>