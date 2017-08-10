<script>
	$(function(){
		//jQuery.noConflict(); // biar gak conflict :p
		// modal dialog box
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 400,
			width: 430,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id_supplier			= $("#id_supplier_tamp").val();
					var nama_supplier		= $(".input_nama_supplier").val();
					var alamat				= $(".input_alamat").val();
					var cp					= $(".input_cp").val();
					var telepon_1			= $(".input_telepon_1").val();
					var telepon_2			= $(".input_telepon_2").val();
					var no_rekening			= $(".input_no_rekening").val();
					var keterangan			= $(".input_keterangan").val();
					
					if(id_supplier != '' && nama_supplier!='' && alamat!='' && telepon_1!='')
					{
						cls = 'yes';
						editSupplier(id_supplier, nama_supplier, alamat, cp, telepon_1, telepon_2, no_rekening, keterangan);
						$( this ).dialog( "close" );
						//location.reload();
					}
					else if(nama_supplier!='' && alamat!='' && telepon_1!='')
					{
						cls = 'yes';
						addSupplier(nama_supplier, alamat, cp, telepon_1, telepon_2, no_rekening, keterangan);
						$("#id_supplier_tamp").val('');
						$( ".input_nama_supplier" ).val('');
						$( ".input_alamat" ).val('');
						$( ".input_cp" ).val('');
						$( ".input_telepon_1" ).val('');
						$( ".input_telepon_2" ).val('');
						$( ".input_no_rekening" ).val('');
						$( ".input_keterangan" ).val('');
						//$( this ).dialog( "close" );
						//location.reload();
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},			
			close: function()
			{
				$("#id_supplier_tamp").val('');
				$( ".input_nama_supplier" ).val('');
				$( ".input_alamat" ).val('');
				$( ".input_cp" ).val('');
				$( ".input_telepon_1" ).val('');
				$( ".input_telepon_2" ).val('');
				$( ".input_no_rekening" ).val('');
				$( ".input_keterangan" ).val('');
			}
		});
		
		$( ".add_item" ).click(function(){
			$( "#dialog-hapus" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
	});
	
	function addSupplier(nama_supplier, alamat, cp, telepon_1, telepon_2, no_rekening, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/supplier/add_supplier",
			data: "nama="+nama_supplier+"&alamat="+alamat+"&cp="+cp+"&tel_1="+telepon_1+"&tel_2="+telepon_2+"&rekening="+no_rekening+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				//window.location.href=msg;
				$( "#trHint" ).html(msg);
			}
		});
	}
	
	function editSupplier(id_supplier, nama_supplier, alamat, cp, telepon_1, telepon_2, no_rekening, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/supplier/edit_supplier",
			data: "id="+id_supplier+"&nama="+nama_supplier+"&alamat="+alamat+"&cp="+cp+"&tel_1="+telepon_1+"&tel_2="+telepon_2+"&rekening="+no_rekening+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapusSupplier(id_supplier)
	{
		//var id_barang = $( "div.hapus" ).find("span").text();alert(id_barang);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/supplier/hapus_supplier",
			data: "id_supplier="+id_supplier,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
	
	function findSupplier(id_supplier)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/supplier/find_supplier",
			data: "id_supplier="+id_supplier,
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
		var dataArr 			= mydata.split(",");
		var id_supplier			= dataArr[0];
		var nama_supplier 		= dataArr[1];
		var alamat				= dataArr[2];
		var cp			 		= dataArr[3];
		var tel_1		 		= dataArr[4];
		var tel_2		 		= dataArr[5];
		var rekening	 		= dataArr[6];
		var keterangan	 		= dataArr[7];
		
		$(document).ready(function(){
			$("#id_supplier_tamp").val(id_supplier);
			$(".input_nama_supplier").val(nama_supplier);
			$(".input_alamat").val(alamat);
			$(".input_cp").val(cp);
			$(".input_telepon_1").val(tel_1);
			$(".input_telepon_2").val(tel_2);
			$(".input_no_rekening").val(rekening);
			$(".input_keterangan").val(keterangan);
		});
	}
</script>

<div <?php echo isset ($active_menu) ? $active_menu :''?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_supplier"><a href="">Daftar Supplier</a></li>
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
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
            <legend>Data Supplier</legend>
            <form>
                <table id="gridview">
                	<thead>
                    <tr>
                        <td class="labels_dpo">Nama Supplier</td>
                        <td class="labels_dpo">Alamat</td>
                        <td class="labels_dpo">Telepon</td>
                        <td class="labels_dpo">Nomor Rekening</td>
                        <td class="labels_dpo">Keterangan</td>
                        <td class="labels_dpo">Edit</td>
                        <td class="labels_dpo">Hapus</td>
                    </tr>
                    </thead>
				</table>
                <div id="scrollable" class="yui3-scrollview-loading">
                <table id="gridview">
                    <tbody id="trHint">
                    <?php
                    foreach($list->result_array() as $sup_detail)
					{
						?>
						<tr class="isi_list">
							<td class="labelss_dpo" id="search1"><?php echo $sup_detail['nama_supplier'];?></td>
							<td class="labelss_dpo" id="search2"><?php echo $sup_detail['alamat'];?></td>
							<td class="labelss_dpo" id="search3"><?php echo $sup_detail['telepon_1'];?>
                            	<input type="hidden" id="search_tlp_2" value="<?php echo $sup_detail['telepon_2'];?>" />
                            </td>
							<td class="labelss_dpo" id="search4"><?php echo $sup_detail['no_rekening'];?></td>
							<td class="labelss_dpo" id="search5"><?php echo $sup_detail['keterangan'];?></td>
                            <td class="labelss_dpo"><div class="edit" onclick="findSupplier('<?php echo $sup_detail['id_supplier'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Edit</span></a>
                            </div></td>
                            <td class="labelss_dpo"><div class="hapus" onclick="hapusSupplier('<?php echo $sup_detail['id_supplier'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Hapus</span></a>
                            </div></td>
						</tr>
                        <?php
					}
					?>
                    </tbody>
                </table>
                </div>
                <!--<div class="add">
                    <a href="javascript:void(0)">+</a>
                </div>-->
            </form>
        </fieldset>
    </div>
</div>

<!--modal dialog box-->
<div id="dialog-hapus" title="Input Supplier">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM SUPPLIER
    </p>
    <table>
    	<tr><td>&nbsp;</td></tr>
        <tr>
            <td>Nama Supplier</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_supplier" class="input_nama_supplier" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Alamat</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="alamat" class="input_alamat" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Contact Person</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="cp" class="input_cp" size="40" /></td>
        </tr>
        <tr>
            <td>Telepon 1</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="telepon_1" class="input_telepon_1" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Telepon 2</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="telepon_2" class="input_telepon_2" size="40" /></td>
        </tr>
        <tr>
            <td>No. Rekening</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="no_rekening" class="input_no_rekening" size="40" /></td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan" size="40" /></td>
        </tr>
    </table>
</div>
<!--untuk menampung id supplier-->
<input type="hidden" id="id_supplier_tamp" value="" />
