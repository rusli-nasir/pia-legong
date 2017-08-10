<script>
	$(function(){
		//jQuery.noConflict(); // biar gak conflict :p
		// modal dialog box
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 250,
			width: 430,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id_satuan_barang	= $("#id_satuan_barang_tamp").val();
					var kode_satuan			= $(".input_kode_satuan").val();
					var nama_satuan			= $(".input_nama_satuan").val();
					var keterangan			= $(".input_keterangan").val();
					
					if(id_satuan_barang != '' && kode_satuan != '' && nama_satuan!='')
					{
						cls = 'yes';
						
						edit_satuan(id_satuan_barang, kode_satuan, nama_satuan, keterangan);
						$( this ).dialog( "close" );
						//location.reload();
					}
					else if(kode_satuan != '' && nama_satuan!='')
					{
						cls = 'yes';
						
						add_satuan(kode_satuan, nama_satuan, keterangan);
						$("#id_satuan_barang_tamp").val('');
						$( ".input_kode_satuan" ).val('');
						$( ".input_nama_satuan" ).val('');
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
					$("#id_satuan_barang_tamp").val('');
					$( ".input_kode_satuan" ).val('');
					$( ".input_nama_satuan" ).val('');
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
	
	function add_satuan(kode_satuan, nama_satuan, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/satuan_barang/add_satuan_barang",
			data: "kode_satuan="+kode_satuan+"&nama_satuan="+nama_satuan+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				//window.location.href=msg;
				$( "#trHint" ).html(msg);
			}
		});
	}
	
	function edit_satuan(id_satuan_barang, kode_satuan, nama_satuan, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/satuan_barang/edit_satuan_barang",
			data: "id_satuan_barang="+id_satuan_barang+"&kode_satuan="+kode_satuan+"&nama_satuan="+nama_satuan+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapus_satuan(id_satuan_barang)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/satuan_barang/hapus_satuan_barang",
			data: "id_satuan_barang="+id_satuan_barang,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
	
	function find_satuan(id_satuan_barang)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/satuan_barang/find_satuan_barang",
			data: "id_satuan_barang="+id_satuan_barang,
			cache: false,
			success: function(data){
				temporary_data(data);			
			}
		});
		
		$( "#dialog-hapus" ).dialog({
			title: 'Edit Data'
		});
		$( "#dialog-hapus" ).dialog( "open" );
	}
	
	function temporary_data(mydata)
	{
		var dataArr 			= mydata.split(",");
		var id_satuan_barang	= dataArr[0];
		var kode_satuan			= dataArr[1];
		var nama_satuan 		= dataArr[2];
		var keterangan 			= dataArr[3];
		
		$(document).ready(function(){
			$("#id_satuan_barang_tamp").val(id_satuan_barang);
			$(".input_kode_satuan").val(kode_satuan);
			$(".input_nama_satuan").val(nama_satuan);
			$(".input_keterangan").val(keterangan);
		});
	}
	
</script>

<div <?php echo isset ($active_menu) ? $active_menu :''?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_satuan"><a href="">Daftar Satuan</a></li>
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
            <legend>Data Satuan</legend>
            <form>
                <table id="gridview">
                	<thead>
                    <tr>
                        <td class="labels_dpo">Kode Satuan</td>
                        <td class="labels_dpo">Nama Satuan</td>
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
                    foreach($list->result_array() as $satuan_detail)
					{
						?>
						<tr class="isi_list">
							<td class="labelss_dpo" id="search2"><?php echo $satuan_detail['kode_satuan'];?></td>
							<td class="labelss_dpo" id="search1"><?php echo $satuan_detail['nama_satuan'];?></td>
							<td class="labelss_dpo" id="search3"><?php echo $satuan_detail['keterangan'];?></td>
							<td class="labelss_dpo"><div class="edit" onclick="find_satuan('<?php echo $satuan_detail['id_satuan_barang'];?>');">
                            	<a href="javascript:void(0)"><span style="display:block">Edit</span>
                                	<span style="display:none"><?php echo $satuan_detail['id_satuan_barang'];?>
                                </span></a>
                            </div></td>
							<td class="labelss_dpo"><div class="hapus" onclick="hapus_satuan('<?php echo $satuan_detail['id_satuan_barang'];?>');">
                            	<a href="javascript:void(0)"><span style="display:block">Hapus</span>
                                	<span style="display:none"><?php echo $satuan_detail['id_satuan_barang'];?>
                                </span></a>
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
<div id="dialog-hapus" title="Batalkan Satuan">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM SATUAN BARANG
    </p>
    <table>
        <tr>
            <td>Kode Satuan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="kode_satuan" class="input_kode_satuan" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Nama Satuan</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_satuan" class="input_nama_satuan" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan" size="40" /></td>
        </tr>
    </table>
</div>
<input type="hidden" id="id_satuan_barang_tamp" value="" />
<!--<script>
	$(function(){
		// animasi list
		YUI().use('scrollview', function(Y) {
			// cek apakah ada list di halaman
			if($("#scrollable").html() != null)
			{
				var scrollView = new Y.ScrollView({
					srcNode: '#scrollable',
					height: 300
				});
				scrollView.scrollbars.flash();
				scrollView.render();		
			}
		});
	});
</script>-->