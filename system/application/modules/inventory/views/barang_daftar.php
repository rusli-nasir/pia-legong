<script>
	$(function(){
		//jQuery.noConflict(); // biar gak conflict :p
		// modal dialog box
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 300,
			width: 430,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id_barang			= $("#id_barang_tamp").val();
					var nama_barang			= $(".input_nama_barang").val();
					var harga_barang		= $(".input_harga_barang").val();
					var keterangan			= $(".input_keterangan").val();
					
					if(id_barang != '' && nama_barang!='' && harga_barang!='')
					{
						cls = 'yes';
						
						editBarang(id_barang, nama_barang, harga_barang, keterangan);
						$( this ).dialog( "close" );
						//location.reload();
					}
					else if(nama_barang!='' && harga_barang!='')
					{
						cls = 'yes';
						
						addBarang(nama_barang, harga_barang, keterangan);
						$("#id_barang_tamp").val('');
						$( ".input_nama_barang" ).val('');
						$( ".input_harga_barang" ).val('');
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
				$("#id_barang_tamp").val('');
				$( ".input_nama_barang" ).val('');
				$( ".input_harga_barang" ).val('');
				$( ".input_keterangan" ).val('');
			}
		});
		
		$( ".add" ).click(function(){
			$( "#dialog-hapus" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
	});
	
	function addBarang(nama_barang, harga_barang, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/barang/add_barang",
			data: "nama_barang="+nama_barang+"&harga_barang="+harga_barang+"&keterangan="+keterangan, //$("#form_add").serialize(),
			cache: false,
			success: function(msg){
				//window.location.href=msg;
				$( "#trHint" ).html(msg);
			}
		});
	}
	
	function editBarang(id_barang, nama_barang, harga_barang, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/barang/edit_barang",
			data: "id_barang="+id_barang+"&nama_barang="+nama_barang+"&harga_barang="+harga_barang+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapusBarang(id_barang)
	{
		//var id_barang = $( "div.hapus" ).find("span").text();alert(id_barang);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/barang/hapus_barang",
			data: "id_barang="+id_barang,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
	
	function findBarang(id_barang)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/inventory/barang/find_barang",
			data: "id_barang="+id_barang,
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
		var id_barang 			= dataArr[0];
		var nama_barang 		= dataArr[1];
		var harga_barang		= parseFloat(dataArr[2]);
		var keterangan	 		= dataArr[3];
		
		$(document).ready(function(){
			$("#id_barang_tamp").val(id_barang);
			$(".input_nama_barang").val(nama_barang);
			$(".input_harga_barang").val(harga_barang);
			$(".input_keterangan").val(keterangan);
		});
	}
</script>

<div <?php echo isset ($active_menu) ? $active_menu :''?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_barang_master"><a href="">Daftar Barang</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
            <legend>Data Barang</legend>
            <form>
                <table id="gridview">
                	<thead>
                    <tr>
                        <td class="labels_dpo">Nama Barang</td>
                        <td class="labels_dpo">Harga Barang</td>
                        <td class="labels_dpo">Keterangan</td>
                        <td class="labels_dpo">Edit</td>
                        <td class="labels_dpo">Hapus</td>
                    </tr>
                    </thead>
                    <tbody id="trHint">
                    <?php
                    foreach($list->result_array() as $brg_detail)
					{
						?>
						<tr class="isi_list">
							<td class="labelss_dpo" id="search1"><?php echo $brg_detail['nama_barang'];?></td>
							<td class="labelss_dpo" id="search2"><?php echo currency_format($brg_detail['harga_barang'],0);?></td>
							<td class="labelss_dpo" id="search2"><?php echo $brg_detail['keterangan'];?></td>
                            <td class="labelss_dpo"><div class="edit" onclick="findBarang('<?php echo $brg_detail['id_barang'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Edit</span></a>
                            </div></td>
                            <td class="labelss_dpo"><div class="hapus" onclick="hapusBarang('<?php echo $brg_detail['id_barang'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Hapus</span></a>
                            </div></td>
						</tr>
                        <?php
					}
					?>
                    </tbody>
                </table>
                <div class="add">
                    <a href="javascript:void(0)">+</a>
                </div>
            </form>
        </fieldset>
    </div>
</div>

<!--modal dialog box-->
<div id="dialog-hapus" title="Batalkan Barang">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM BARANG
    </p>
    <table>
    	<tr><td>&nbsp;</td></tr>
        <tr>
            <td>Nama Barang</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_barang" class="input_nama_barang" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Harga Jual</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="harga_barang" class="input_harga_barang" size="40" onkeypress="return checkIt(event)" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan" size="40" /></td>
        </tr>
    </table>
</div>
<!--untuk menampung keterngan batal PRA SPK-->
<input type="hidden" id="id_barang_tamp" value="" />
