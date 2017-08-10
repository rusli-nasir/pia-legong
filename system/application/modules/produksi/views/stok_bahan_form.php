<script>
function total_stok(nilai)
{
	var ind = $('.index_ke').val();
	var total = 0;
	for(var i=0 ; i<ind ; i++)
	{
		var stok = $('#stok_masuk_'+i).val();
		total = Number(total) + Number(stok);
	}
	
	$('.total_stok_masuk').val(total);
}
</script>

<div <?php echo isset($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
        <li id="tab_detail_stok_barang">
        	<a href="<?php echo site_url(array('produksi','stok_bahan','find_stok_pembelian_detail',$detail_head[0]['id_pembelian']));?>">Form Stok Bahan</a></li>
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
    <span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
    <div class="cage">
        <input type="hidden" name="id_pembelian" class="id_pembelian" value="<?php if($detail_head == 0){echo '0';}else{echo $detail_head[0]['id_pembelian'];}?>" />
        <table id="data_po_left">
            <tr>
                <td style="width: 150px;">Tgl. Transaksi</td><td>:</td><td>&nbsp;</td>
                <td><input style="color:#0000FF;" type="text" id="datepicker" name="tgl_transaksi" class="tgl_transaksi" size="10" maxlength="10" value="<?php echo explode_date($date,1);?>" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Total Stok Masuk</td><td>:</td><td>&nbsp;</td>
                <td>
                    <input type="text" name="total_stok_masuk" class="total_stok_masuk" value="0" />
                </td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Barang</legend>
        <table id="gridview">
            <thead>
            <tr id="id_tr_detail">
                <td class="labels_dpo">Nama Barang</td>
                <td class="labels_dpo">Quantity</td>
                <td class="labels_dpo">Stok Masuk</td>
                <td class="labels_dpo">Stok Belum Masuk</td>
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
					$stok_blm_msk = $detail['quantity'] - $detail['total_masuk'];
					?>
                    <tr class="<?php echo $brs;?>">
                        <input type="hidden" name=id_detail_pembelian[] id="id_detail_pembelian_<?php echo $brs;?>" value="<?php echo $detail['id_detail_pembelian'];?>" />
                        <input type="hidden" name=id_bhn_baku[] id="id_bhn_baku_<?php echo $brs;?>" value="<?php echo $detail['id_bhn_baku'];?>" />
                        <td class="labelss_dpo">
                            <input type="text" name=nama_bhn_baku[] id="nama_bhn_baku_<?php echo $brs;?>" value="<?php echo $detail['nama_bhn_baku'];?>" onclick="nilai(this.value, <?php echo $brs;?>)" /></td>
                        <td class="labelss_dpo"><input type="text" name=quantity[] id="quantity_<?php echo $brs;?>" readonly="readonly" value="<?php echo round($detail['quantity']);?>" /></td>
                        <td class="labelss_dpo"><input type="text" name=stok_masuk[] id="stok_masuk_<?php echo $brs;?>" value="0" onkeyup="total_stok(this.value)" onkeypress="return checkIt(event)" /></td>
                        <td class="labelss_dpo"><input type="text" name=stok_blm_msk[] id="stok_blm_msk_<?php echo $brs;?>" value="<?php echo $stok_blm_msk;?>" /></td>
                    </tr>
                    <?php 
                    $i++;
                    $brs++;
                }
            }?>
            </tbody>
        </table>
        <input type="hidden" name="index_ke" class="index_ke" value="<?php echo $brs;?>" />
        </fieldset>
    </div>
    <div class="">
    	<fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Transaksi</legend>
        <table id="gridview">
            <thead>
            <tr id="id_tr_detail">
                <td class="labels_dpo">Tgl. Transaksi</td>
                <td class="labels_dpo">Nama Barang</td>
                <td class="labels_dpo">Stok Masuk</td>
                <td class="labels_dpo">Batal</td>
            </tr>
            </thead>
            <tbody id="trhide">
            <?php
            $i=0;
            $brs=0;		
            if($detail_stok)
            {
                foreach($detail_stok as $stok)
                {
					$tgl = explode('-', $stok['tgl_transaksi']);
					$tgl_baru = $tgl[2].'/'.$tgl[1].'/'.$tgl[0];
					?>
                    <tr class="<?php echo $brs;?>">
                        <input type="hidden" name=id_stok_bhn_baku[] id="id_stok_bhn_baku_<?php echo $brs;?>" value="<?php echo $stok['id_stok_bhn_baku'];?>" />
                        <input type="hidden" name=id_bhn_baku_list[] id="id_bhn_baku_list<?php echo $brs;?>" value="<?php echo $stok['id_bhn_baku'];?>" />
                        <td class="labelss_dpo"><?php echo $tgl_baru;?></td>
                        <td class="labelss_dpo"><?php echo $stok['nama_bhn_baku'];?></td>
                        <td class="labelss_dpo"><?php echo round($stok['stok_masuk']);?></td>
                        <td class="labelss_dpo"><a href="<?php echo site_url(array('produksi','stok_bahan','hapus_stok',$stok['id_stok_bhn_baku']))?>"><span id="batal" class="<?php echo $brs;?>" style="display:block">Batal</span></a></td>
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
</div>