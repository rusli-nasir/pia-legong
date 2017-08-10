<?php
	if($data_stok['status_stok'] == 'add_stok')
	{
		$id_barang		= $data_stok['id_barang'];
		$kode_barang	= $data_stok['kode_barang'];
		$nama_barang	= $data_stok['nama_barang'];
		$sisa_stok		= $data_stok['sisa_stok'];
	}
	else
	{
		$id_barang		= '';
		$kode_barang	= '';
		$nama_barang	= '';
		$sisa_stok		= '';
	}
?>
<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
    <div class="icon"></div>
    <h3>Data Stok Barang</h3>
    <div class="clear"></div>
        <table id="data_po_left">
            <tr>
            	<input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>" />
                <td style="width: 150px;">Tgl. Transaksi</td>
                <td><input style="color:#0000FF;" type="text" id="datepicker" name="tanggal_transaksi" readonly="readonly" value="<?php echo date("d/m/Y"); ?>" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Kode Barang</td>
                <td><input type="text" name="kode_barang" value="<?php echo $kode_barang; ?>" readonly="readonly"/></td>
            </tr>
            <tr>
                <td style="width: 150px;">Nama Barang</td>
                <td><input type="text" name="nama_barang" value="<?php echo $nama_barang; ?>" readonly="readonly"/></td>
            </tr>
            <tr>
                <td style="width: 150px;">Total Stok</td>
                <td><input type="text" name="sisa_stok" value="<?php echo round($sisa_stok,5); ?>" readonly="readonly"/></td>
            </tr>
        </table>
        <table id="data_po_right">
            <!--<tr>
                <td style="width: 150px;">Total Stok Masuk</td>
                <td><input type="text" name="total_stok_masuk" value="" onkeypress="return checkIt(event)" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Total Stok Keluar</td>
                <td><input type="text" name="total_stok_keluar" value="" onkeypress="return checkIt(event)" /></td>
            </tr>-->
            <!-- <tr>
                <td style="width: 150px;">Satuan Barang</td>
                <td>
                <select>
                    <option selected="" value="0">.:Satuan:.</option>
                    <option value="1">.:Satuan:.</option>
                    <option value="1">.:Satuan:.</option>
                    <option value="1">.:Satuan:.</option>
                    <option value="1">.:Satuan:.</option>
                    <option value="1">.:Satuan:.</option>
                </select>
                </td>
            </tr> -->
            <!--<tr>
                <td style="width: 150px;">Keterangan</td>
                <td><input type="text" name="keterangan_stok" value="" /></td>
            </tr>-->
        </table>
        <div class="clear"></div>
</div>
<div class=""> 
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Data Detail Stok Masuk - Keluar</legend>
            <table id="gridview">
                <tr>
                    <!-- <td class="labels_dpo">No.</td> -->
                    <td class="labels_dpo">Tgl. Transaksi</td>
                    <td class="labels_dpo">Stok masuk</td>
                    <td class="labels_dpo">Stok keluar</td>
                    <!-- <td class="labels_dpo">Sisa Stok</td> -->
                    <td class="labels_dpo">Keterangan</td>
                    <!--<td class="labels_dpo">Batal</td>-->
                </tr>
                <?php
				foreach($data_detail_stok->result_array() as $recordsetdetailstok)
				{
                ?>
                <tr>
                	<input type="hidden" name=id_stok[] value="<?php echo $recordsetdetailstok['id_stok']; ?>" />
                    <td class="labelss_dpo"><?php echo explode_date($recordsetdetailstok['tanggal_transaksi'],1); ?></td>
                    <td class="labelss_dpo"><?php echo round($recordsetdetailstok['stok_masuk'],5); ?></td>
                    <td class="labelss_dpo"><?php echo round($recordsetdetailstok['stok_keluar'],5); ?></td>
                    <td class="labelss_dpo"><?php echo $recordsetdetailstok['keterangan']; ?></td>
                    <!--<td class="labelss_dpo"><input type="checkbox" name=batal_stok[] value="<?php //echo $recordsetdetailstok['id_stok']; ?>" /></td>-->
                </tr>
                <?php
				}
                ?>
            </table>
    </fieldset>
</div>