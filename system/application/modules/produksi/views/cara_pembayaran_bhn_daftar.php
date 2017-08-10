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
					var id_cara_bayar		= $("#id_cara_pembayaran_tamp").val();
					var cara_bayar			= $(".input_cara_pembayaran").val();
					var keterangan			= $(".input_keterangan").val();
					
					if(id_cara_bayar != '' && cara_bayar!='')
					{
						cls = 'yes';
						
						editCaraBayar(id_cara_bayar, cara_bayar, keterangan);
						$( this ).dialog( "close" );
						//location.reload();
					}
					else if(cara_bayar!='')
					{
						cls = 'yes';
						
						addCaraBayar(cara_bayar, keterangan);
						$("#id_cara_pembayaran_tamp").val('');
						$( ".input_cara_pembayaran" ).val('');
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
				$("#id_cara_pembayaran_tamp").val('');
				$( ".input_cara_pembayaran" ).val('');
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
	
	function addCaraBayar(cara_bayar, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/cara_pembayaran_bhn/add_cara_pembayaran",
			data: "cara_bayar="+cara_bayar+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				//window.location.href=msg;
				$( "#trHint" ).html(msg);
			}
		});
	}
	
	function editCaraBayar(id_cara_bayar, cara_bayar, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/cara_pembayaran_bhn/edit_cara_pembayaran",
			data: "id_cara_bayar="+id_cara_bayar+"&cara_bayar="+cara_bayar+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapusCaraBayar(id_cara_bayar)
	{
		//var id_barang = $( "div.hapus" ).find("span").text();alert(id_barang);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/cara_pembayaran_bhn/hapus_cara_pembayaran",
			data: "id_cara_bayar="+id_cara_bayar,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
	
	function findCaraBayar(id_cara_bayar)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/cara_pembayaran_bhn/find_cara_pembayaran",
			data: "id_cara_bayar="+id_cara_bayar,
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
		var id_cara_bayar		= dataArr[0];
		var cara_bayar	 		= dataArr[1];
		var keterangan	 		= dataArr[2];
		
		$(document).ready(function(){
			$("#id_cara_pembayaran_tamp").val(id_cara_bayar);
			$(".input_cara_pembayaran").val(cara_bayar);
			$(".input_keterangan").val(keterangan);
		});
	}
</script>

<div <?php echo isset ($active_menu) ? $active_menu :''?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_cara_bayar_master"><a href="">Daftar Cara Pembayaran</a></li>
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
            <legend>Data Cara Pembayaran</legend>
            <form>
                <table id="gridview">
                	<thead>
                    <tr>
                        <td class="labels_dbyr">Cara Pembayaran</td>
                        <td class="labels_dbyr">Keterangan</td>
                        <td class="labels_dbyr">Edit</td>
                        <td class="labels_dbyr">Hapus</td>
                    </tr>
                    </thead>
                    <tbody id="trHint">
                    <?php
                    foreach($list->result_array() as $cara_bayar)
					{
						?>
						<tr class="isi_list">
							<td class="labelss_dbyr" id="search1"><?php echo $cara_bayar['nama_cara_pembayaran'];?></td>
							<td class="labelss_dbyr" id="search2"><?php echo $cara_bayar['keterangan'];?></td>
                            <td class="labelss_dbyr"><div class="edit" onclick="findCaraBayar('<?php echo $cara_bayar['id_cara_pembayaran'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Edit</span></a>
                            </div></td>
                            <td class="labelss_dbyr"><div class="hapus" onclick="hapusCaraBayar('<?php echo $cara_bayar['id_cara_pembayaran'];?>');">
                                <a href="javascript:void(0)"><span style="display:block">Hapus</span></a>
                            </div></td>
						</tr>
                        <?php
					}
					?>
                    </tbody>
                </table>
            </form>
        </fieldset>
    </div>
</div>

<!--modal dialog box-->
<div id="dialog-hapus" title="Batalkan Barang">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM CARA PEMBAYARAN
    </p>
    <table>
    	<tr><td>&nbsp;</td></tr>
        <tr>
            <td>Cara Pembayaran</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_barang" class="input_cara_pembayaran" size="40" />&nbsp;*</td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan" size="40" /></td>
        </tr>
    </table>
</div>
<!--untuk menampung keterngan batal PRA SPK-->
<input type="hidden" id="id_cara_pembayaran_tamp" value="" />
