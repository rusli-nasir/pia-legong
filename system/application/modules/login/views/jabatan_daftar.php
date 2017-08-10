<script>
	$(function(){
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 250,
			width: 370,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id_jabatan			= $("#id_jabatan_tamp").val();
					var nama_jabatan		= $(".input_nama_jabatan").val();
					var keterangan			= $(".input_keterangan").val();
					
					if(id_jabatan != '' && nama_jabatan != '')
					{
						editJabatan(id_jabatan, nama_jabatan, keterangan);
						$( this ).dialog( "close" );
					}
					else if(id_jabatan == '' && nama_jabatan != '')
					{
						addJabatan(id_jabatan, nama_jabatan, keterangan);
						$( this ).dialog( "close" );
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function()
			{
				$("#id_jabatan_tamp").val('');
				$( ".input_nama_jabatan" ).val('');
				$( ".input_keterangan" ).val('');
			}
		});
		
		$( ".add" ).click(function(){
			$( "#dialog-hapus" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
		
		$( ".edit" ).click(function(){
			var id_jabatan = $(this).find("span").text();
			findJabatan(id_jabatan);
			
			$( "#dialog-hapus" ).dialog({
				title: 'Edit Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
		
		$( ".hapus" ).click(function(){
			var id_jabatan = $(this).find("span").text();
			hapusJabatan(id_jabatan);
		});
	});
	
	function addJabatan(id_jabatan, nama_jabatan, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/add_jabatan",
			data: "nama_jabatan="+nama_jabatan+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function editJabatan(id_jabatan, nama_jabatan, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/edit_jabatan",
			data: "id_jabatan="+id_jabatan+"&nama_jabatan="+nama_jabatan+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapusJabatan(id_jabatan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/hapus_jabatan",
			data: "id_jabatan="+id_jabatan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function findJabatan(id_jabatan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/find_jabatan",
			data: "id_jabatan="+id_jabatan,
			cache: false,
			success: function(data){
				tampungData(data);
			}
		});
	}
	
	function tampungData(mydata)
	{
		var dataArr 			= mydata.split(",");
		var id_jabatan 			= dataArr[0];
		var nama_jabatan 		= dataArr[1];
		var keterangan 			= dataArr[2];
		
		$(document).ready(function(){
			$("#id_jabatan_tamp").val(id_jabatan);
			$(".input_nama_jabatan").val(nama_jabatan);
			$(".input_keterangan").val(keterangan);
		});
	}
</script>

<div id="content_form_po">
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
            <legend>Data Jabatan</legend>
                <table id="gridview">
                    <tr>
                        <td class="labels_dpo">Nama Jabatan</td>
                        <td class="labels_dpo">Keterangan</td>
                        <?php if($user_status[4]['status']==2){?>
                        <td class="labels_dpo">Edit</td>
                        <td class="labels_dpo">Hapus</td>
                        <?php }?>
                    </tr>
                    <?php
                    foreach($list->result_array() as $jabatan_detail)
					{
						?>
						<tr class="isi_list">
							<td class="labelss_dpo" id="search1"><?php echo $jabatan_detail['nama_jabatan'];?></td>
							<td class="labelss_dpo" id="search2"><?php echo $jabatan_detail['keterangan'];?></td>
                        <?php if($user_status[4]['status']==2){?>
							<td class="labelss_dpo" id="search3"><div class="edit">
                            	<a href="javascript:void(0)">Edit<span style="display:none"><?php echo $jabatan_detail['id_jabatan'];?>
                                </span></a>
                            </div></td>
							<td class="labelss_dpo"><div class="hapus">
                            	<a href="javascript:void(0)">Hapus<span style="display:none"><?php echo $jabatan_detail['id_jabatan'];?>
                                </span></a>
                            </div></td>
                        <?php }?>
						</tr>
                        <?php
					}
					?>    
                </table>
                <div class="add">
                    <a href="javascript:void(0)">+</a>
                </div>
        </fieldset>
    </div>
</div>

<div id="dialog-hapus" title="Batalkan Jabatan">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM JABATAN
    </p>
    <table>
        <tr>
            <td>Jabatan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="nama_jabatan" class="input_nama_jabatan" size="40" /></td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan" size="40" /></td>
        </tr>
    </table>
</div>
<input type="hidden" id="id_jabatan_tamp" value="" />
