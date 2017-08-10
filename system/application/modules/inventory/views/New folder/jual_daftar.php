<script>
$(function(){
		$( "#dialog-detail" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 380,
			width: 600,
			modal: true,
			closeOnEscape: false,
			buttons: {
				/*"Keluar": function() {
					$( this ).dialog( "close" );
				}*/
			},			
		});
		
		$( "span#detail_jual" ).click(function(){
			var id_penjualan = $(this).attr('class');
			find_po(id_penjualan);
			
			$( "#dialog-detail" ).dialog({
				title: 'Data Detail Penjualan'
			});
			$( "#dialog-detail" ).dialog( "open" );
		});
		
		$( "span#faktur_jual" ).click(function(){
			id_penjualan = $(this).attr('class');
			window.open("<?php echo base_url();?>index.php/inventory/jual/faktur/"+id_penjualan+"", "status=1,width=350,height=150");
		});
		
	});


	function find_po(id_penjualan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/jual/find_jual",
			data: "id_penjualan="+id_penjualan,
			cache: false,
			success: function(data){
				get_data(data);			
			}
		});
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/jual/find_jual_detail",
			data: "id_penjualan="+id_penjualan,
			cache: false,
			success: function(data){
				get_data_detail(data);			
			}
		});
	}
	
	function get_data(mydata)
	{
		var dataArr 		= mydata.split(",");
		var no_invoice 		= dataArr[0];
		var no_surat_jalan	= dataArr[1];
		var tgl_penjualan 	= dataArr[2];
		var tgl_jatuh_tempo	= dataArr[3];
		var nama_customer 	= dataArr[0];
		var total_harga		= dataArr[1];
		var dp 				= dataArr[2];
		var keterangan 		= dataArr[4];
		
		$(document).ready(function(){
			$("#no_ivc").val(no_invoice);
			$("#srt_jalan").val(no_surat_jalan);
			$("#tgl_trans").val(tgl_penjualan);
			$("#tgl_tempo").val(tgl_jatuh_tempo);
			$("#customer").val(nama_customer);
			$("#ttl_bayar").val(total_harga);
			$("#sisa_byr").val(dp);
			$("#ket").val(keterangan);
		});
	}
	
	function get_data_detail(mydata)
	{
		$("#tabel_detail").html(mydata);
	}
</script>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Penjualan</legend>
        <?php echo form_open('inventory/jual/add_jual');?>
            <table id="gridview">
                <tr>
                    <td class="labels_dpo">No. Invoice</td>
                    <td class="labels_dpo">Tgl. Penjualan</td>
                    <td class="labels_dpo">No. Surat Jalan</td>
                    <td class="labels_dpo">Customer</td>
                    <td class="labels_dpo">Detail Barang</td>
                    <td class="labels_dpo">Faktur</td>
                    <td class="labels_dpo">Edit</td>
                    <td class="labels_dpo">Batal</td>
                </tr>
                <?php
				foreach($daftar_list_jual->result_array() as $daftarlistjual)
				{
				$tglbaru		= $daftarlistjual['tgl_penjualan'];
				$tgl_penjualan	= explode_date($tglbaru, 1);
                ?>
                <tr class="isi_list">
                    <td class="labelss_dpo" id="search1"><?php echo $daftarlistjual['no_invoice']; ?></td>
                    <td class="labelss_dpo" id="search2"><?php echo $tgl_penjualan; ?></td>
                    <td class="labelss_dpo" id="search3"><?php echo $daftarlistjual['no_surat_jalan']; ?></td>
                    <td class="labelss_dpo" id="search4"><?php echo $daftarlistjual['nama_customer']; ?></td>
                    <td class="labelss_dpo"><a href="javascript:void(0)"><span id="detail_jual" class="<?php echo $daftarlistjual['id_penjualan'];?>" style="display:block">Detail</span></a></td>
                    <td class="labelss_dpo"><a href="javascript:void(0)"><span id="faktur_jual" class="<?php echo $daftarlistjual['id_penjualan'];?>" style="display:block">Faktur</span></a></td>
                    <?php
					if( $daftarlistjual['total_bayar']>0)
					{
                    ?>
                    	<td class="labelss_dpo"></td>
                    <?php
					}
					else
					{
                    ?>
                    	<td class="labelss_dpo"><a href="<?php echo site_url('inventory/jual/index_edit/'.$daftarlistjual['id_penjualan']);?>">Edit</a></td>
                    <?php
					}
                    ?>
                    <td class="labelss_dpo"><input type="checkbox" name=batal_list[] value="<?php echo $daftarlistjual['id_penjualan']; ?>" /></td>
                </tr>
                <?php
				}
                ?>
            </table>
    </fieldset>
</div>
<div id="dialog-detail" title="">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        DETAIL PENJUALAN
    </p>
        <table>
            <tr>
                <td>No. Invoice</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="no_ivc" readonly="readonly" /></td><td>&nbsp;</td>
                <td>Tgl. Transaksi</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="tgl_trans" readonly="readonly" /></td>
            </tr>
            <tr>
                <td>Tgl. Jatuh Tempo</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="tgl_tempo" readonly="readonly" /></td><td>&nbsp;</td>
                <td>Surat Jalan</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="srt_jalan" readonly="readonly" /></td>
            </tr>
            <tr>
                <td>No. Invoice</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="customer" readonly="readonly" /></td><td>&nbsp;</td>
                <td>Total</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="ttl_bayar" readonly="readonly" /></td>
            </tr>
            <tr>
                <td>Sisa Pembayaran</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="sisa_byr" readonly="readonly" /></td><td>&nbsp;</td>
                <td>Keterangan</td><td>&nbsp;</td>
                <td>:</td><td>&nbsp;</td>
                <td><input type="text" id="ket" readonly="readonly" /></td>
            </tr>
        </table>
        <table id="tabel_detail">
		</table>
</div>