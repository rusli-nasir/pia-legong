<script>
	$(function(){
		//View Date Pemesanan
		$( "#datepicker" ).change(function(){
			var id			= $( ".id_bhn_baku" ).val();
			var tgl 		= $(this).val();
			var arrtgl		= tgl.split("/");
			var tgl_beli	= arrtgl[2]+"-"+arrtgl[1]+"-"+arrtgl[0];
			
			var tgl2		= $( "#datepicker1" ).val();
			var arrtgl2		= tgl2.split("/");
			var tgl_beli2	= arrtgl2[2]+"-"+arrtgl2[1]+"-"+arrtgl2[0];
			window.location.href="<?php echo base_url();?>index.php/produksi/stok_bahan/find_stok_detail/"+id+"/"+tgl_beli+"_"+tgl_beli2;
		});
		
		$( "#datepicker1" ).change(function(){
			var id			= $( ".id_bhn_baku" ).val();
			var tgl 		= $(this).val();
			var arrtgl		= tgl.split("/");
			var tgl_beli	= arrtgl[2]+"-"+arrtgl[1]+"-"+arrtgl[0];
			
			var tgl2		= $( "#datepicker" ).val();
			var arrtgl2		= tgl2.split("/");
			var tgl_beli2	= arrtgl2[2]+"-"+arrtgl2[1]+"-"+arrtgl2[0];
			window.location.href="<?php echo base_url();?>index.php/produksi/stok_bahan/find_stok_detail/"+id+"/"+tgl_beli2+"_"+tgl_beli;
		});
	});
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
    <input type="hidden" name="id_bhn_baku" class="id_bhn_baku" value="<?php echo $detail_head[0]['id_bhn_baku'];?>" />
    <table id="data_po_left">
        <tr>
            <td style="width: 150px;">Periode</td><td>:</td><td>&nbsp;</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker" name="tgl_transaksi" class="tgl_transaksi" size="10" maxlength="10" readonly="readonly" value="<?php echo explode_date($date1,1);?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Sampai</td><td>:</td><td>&nbsp;</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker1" name="tgl_transaksi2" class="tgl_transaksi2" size="10" maxlength="10" readonly="readonly" value="<?php echo explode_date($date,1);?>" /></td>
        </tr>
    </table>
    <table id="data_po_right">
    	<tr>
        	<td style="width: 150px;">Nama Barang</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="nama_barang" class="nama_barang" value="<?php echo $detail_head[0]['nama_bhn_baku'];?>" /></td>
        </tr>
    	<tr>
        	<td style="width: 150px;">Satuan Barang</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="nama_satuan" class="nama_satuan" value="<?php echo $detail_head[0]['nama_satuan'];?>" /></td>
        </tr>
    </table>
    <div class="clear"></div>
</div>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Summary Transaksi Keluar/Masuk Stok</legend>
    <table id="gridview">
        <thead>
        <tr id="id_tr_detail">
            <td class="labels_dpo">No.</td>
            <td class="labels_dpo">Tgl. Transaksi</td>
            <td class="labels_dpo">Stok Masuk</td>
            <td class="labels_dpo">Stok Keluar</td>
        </tr>
        </thead>
        <tbody id="trhide">
        <?php
        $i=0;
        $brs=0;		
        if($detail_list)
        {
            foreach($detail_list as $detail)
            {?>
                <tr class="<?php echo $brs;?>">
                    <input type="hidden" name=id_stok_bhn_baku[] id="id_stok_bhn_baku_<?php echo $brs;?>" value="<?php echo $detail['id_stok_bhn_baku'];?>" />
                    <td class="labelss_dpo"><?php echo $i+1;?></td>
                    <td class="labelss_dpo"><?php echo explode_date($detail['tgl_transaksi'],1);?></td>
                    <td class="labelss_dpo"><?php echo round($detail['stok_masuk']);?></td>
                    <td class="labelss_dpo"><?php echo round($detail['stok_keluar']);?></td>
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