<script>
$(function(){
	$('.dibayar').keyup(function(){
		var total = $('.sisa_bayar').val();
		var dibayar = $(this).val();
		
		if(Number(dibayar) > Number(total))
			$(this).val(Number(total));
		if(dibayar > 0)
			$(this).val(Number(dibayar));
		if(dibayar == "" || dibayar < 0)
			$(this).val(0);
	});
});
</script>

<?php 
$total_sudah_bayar = 0;
foreach($detail_list as $list)
{
	$total_sudah_bayar = $total_sudah_bayar + $list['jumlah_bayar'];
}

$sisa_bayar = $detail_head[0]['total_pembelian'] - $total_sudah_bayar;
?>
<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
    <input type="hidden" name="id_pembelian" class="id_pembelian" value="<?php if($detail_head == 0){echo '0';}else{echo $detail_head[0]['id_pembelian'];}?>" />
    <table id="data_po_left">
        <tr>
            <td style="width: 150px;">Tgl. Pembayaran</td><td>:</td><td>&nbsp;</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker" name="tgl_pembayaran" class="tgl_pembayaran" size="10" maxlength="10" value="<?php echo explode_date($date,1);?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Cara Pembayaran</td><td>:</td><td>&nbsp;</td>
            <td>
                <select name="id_cara_pembayaran_bhn" class="cara_bayar">
                    <option value="0">.:Pembayaran:.</option>
                    <?php 
                    foreach($list_cara_bayar->result_array() as $row)
                    {?>
                        <option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
					<?php }
                    ?>
                </select>
            </td>
        </tr>
        <?php 
		if($this->session->userdata('message_cara_bayar')) {
		?><tr class="warning"><td colspan="4" style="color:#FF0000"><?php 
			echo $this->session->userdata('message_cara_bayar');
			$this->session->unset_userdata('message_cara_bayar');
		?></td></tr><?php 
		}?>
    </table>
    <table id="data_po_right">
        <tr>
            <td style="width: 150px;">Total Harga</td><td>:</td><td>&nbsp;</td>
            <td>
            	<input type="text" name="total_harga" class="total_harga" value="<?php if($detail_head == 0){echo '0';}else{echo $detail_head[0]['total_pembelian'];}?>" />
			</td>
        </tr>
        <tr>
            <td style="width: 150px;">Sisa Pembayaran</td><td>:</td><td>&nbsp;</td>
            <td>
            	<input type="text" name="sisa_bayar" class="sisa_bayar" value="<?php echo $sisa_bayar;?>" />
			</td>
        </tr>
        <tr>
            <td style="width: 150px;">Dibayar</td><td>:</td><td>&nbsp;</td>
            <td>
            	<input type="text" name="dibayar" class="dibayar" value="0" onkeypress="return checkIt(event)" />
            </td>
        </tr>
        <?php 
		if($this->session->userdata('message_dibayar')) {
		?><tr class="warning"><td colspan="3" style="color:#FF0000"><?php 
			echo $this->session->userdata('message_dibayar');
			$this->session->unset_userdata('message_dibayar');
		?></td></tr><?php 
		}?>
    </table>
    <div class="clear"></div>
</div>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Daftar Pembayaran</legend>
    <table id="gridview">
        <thead>
        <tr id="id_tr_detail">
            <td class="labels_dbyr">No.</td>
            <td class="labels_dbyr">Tgl. Pembayaran</td>
            <td class="labels_dbyr">Jumlah Pembayaran</td>
            <td class="labels_dbyr">Cara Pembayaran</td>
            <td class="labels_dbyr">Batal</td>
        </tr>
        </thead>
        <tbody id="trhide">
        <?php
        $i=0;
        $brs=0;		
		if($detail_list)
		{
			foreach($detail_list as $detail)
			{
				$arrtgl = explode('-',$detail['tgl_pembayaran']);
				$tgl = $arrtgl[2].'/'.$arrtgl[1].'/'.$arrtgl[0];
				?>
				<tr class="<?php echo $brs;?>">
                    <input type="hidden" name=id_pembayaran_bhn[] id="id_pembayaran_bhn_<?php echo $brs;?>" value="<?php echo $detail['id_pembayaran_bhn'];?>" />
                    <input type="hidden" name=id_cara_pembayaran_bhn_list[] id="id_cara_pembayaran_bhn_list_<?php echo $brs;?>" value="<?php echo $detail['id_cara_pembayaran_bhn'];?>" />
                    <input type="hidden" name=dp_type[] id="dp_type_<?php echo $brs;?>" value="<?php echo $detail['dp_type'];?>" />
                    <td class="labelss_dbyr"><?php echo $i+1;?></td>
                    <td class="labelss_dbyr"><?php echo $tgl;?></td>
                    <td class="labelss_dbyr"><?php echo currency_format($detail['jumlah_bayar']);?></td>
                    <td class="labelss_dbyr"><?php echo $detail['nama_cara_pembayaran'];?></td>
                    <td class="labelss_dbyr"><a href="<?php echo site_url(array('produksi','beli','hapus_pembayaran',$detail['id_pembayaran_bhn']));?>">
                    	<span id="batal" class="<?php echo $brs;?>" style="display:block">Batal</span></a></td>
                </tr>
				<?php 
                $i++;
                $brs++;
			}
		}?>
        </tbody>
    </table>
    </fieldset>
</div>