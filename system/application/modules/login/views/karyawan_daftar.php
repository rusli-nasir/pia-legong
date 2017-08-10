<script>
	$(function(){
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 450,
			width: 440,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"Simpan Data": function() {
					var id_karyawan				= $("#id_karyawan").val();
					var nama_karyawan			= $(".input_nama_karyawan").val();
					var agama					= $("#id_agama").val();
					var status_perkawinan		= $("#id_status_perkawinan").val();
					var jenis_kelamin			= $("#id_jenis_kelamin").val();
					var id_jabatan				= $("#id_jabatan").val();
					var id_propinsi				= $("#id_propinsi").val();
					var alamat					= $(".input_alamat").val();
					var telepon					= $(".input_telepon").val();
					var hp						= $(".input_hp").val();
					var keterangan				= $(".input_keterangan").val();
					
					if(id_karyawan != '' && nama_karyawan != '' && agama != '0' && status_perkawinan != '0' && jenis_kelamin != '' && id_jabatan != '0' && id_propinsi != '0' && alamat != '' && hp != '')
					{
						editKaryawan(id_karyawan, nama_karyawan, agama, status_perkawinan, jenis_kelamin, id_jabatan, id_propinsi, alamat, telepon, hp, keterangan);
						$( this ).dialog( "close" );
					}
					else if(id_karyawan == '' && nama_karyawan != '' && agama != '0' && status_perkawinan != '0' && jenis_kelamin != '' && id_jabatan != '0' && id_propinsi != '0' && alamat != '' && hp != '')
					{
						addKaryawan(nama_karyawan, agama, status_perkawinan, jenis_kelamin, id_jabatan, id_propinsi, alamat, telepon, hp, keterangan);
						$( this ).dialog( "close" );
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},			
			close: function()
			{
				$("#id_karyawan").val('');
				$(".input_nama_karyawan").val('');
				$("#id_agama").val('');
				$("#id_status_perkawinan").val('');
				$("#id_jenis_kelamin").val('');
				$("#id_jabatan").val('');
				$("#id_propinsi").val('');
				$(".input_alamat").val('');
				$(".input_telepon").val('');
				$(".input_hp").val('');
				$(".input_keterangan").val('');
			}
		});
		
		$( ".add" ).click(function(){
			$( "#dialog-hapus" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
		
		$( ".edit" ).click(function(){
			var id_karyawan = $(this).find("span").text();
			findKaryawan(id_karyawan);
			
			$( "#dialog-hapus" ).dialog({
				title: 'Edit Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
		
		$( ".hapus" ).click(function(){
			var id_karyawan = $(this).find("span").text();
			hapusKaryawan(id_karyawan);
		});
	});
	
	function addKaryawan(nama_karyawan, agama, status_perkawinan, jenis_kelamin, id_jabatan, id_propinsi, alamat, telepon, hp, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/add_karyawan",
			data: "nama_karyawan="+nama_karyawan+"&agama="+agama+"&status_perkawinan="+status_perkawinan+"&jenis_kelamin="+jenis_kelamin+"&id_jabatan="+id_jabatan+"&id_propinsi="+id_propinsi+"&alamat="+alamat+"&telepon="+telepon+"&hp="+hp+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function editKaryawan(id_karyawan, nama_karyawan, agama, status_perkawinan, jenis_kelamin, id_jabatan, id_propinsi, alamat, telepon, hp, keterangan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/edit_karyawan",
			data: "id_karyawan="+id_karyawan+"&nama_karyawan="+nama_karyawan+"&agama="+agama+"&status_perkawinan="+status_perkawinan+"&jenis_kelamin="+jenis_kelamin+"&id_jabatan="+id_jabatan+"&id_propinsi="+id_propinsi+"&alamat="+alamat+"&telepon="+telepon+"&hp="+hp+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapusKaryawan(id_karyawan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/hapus_karyawan",
			data: "id_karyawan="+id_karyawan,
			cache: false,
			success: function(msg){
				window.location.href=msg;			
			}
		});
	}
	
	function findKaryawan(id_karyawan)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/find_karyawan",
			data: "id_karyawan="+id_karyawan,
			cache: false,
			success: function(data){
				tampungData(data);			
			}
		});
	}
	
	function tampungData(mydata)
	{
		var dataArr 			= mydata.split(",");
		var id_karyawan 		= dataArr[0];
		var nama_karyawan		= dataArr[1];
		var agama 				= dataArr[2];
		var status_perkawinan	= dataArr[3];
		var jenis_kelamin		= dataArr[4];
		var id_jabatan 			= dataArr[5];
		var id_propinsi 		= dataArr[6];
		var alamat 				= dataArr[7];
		var telepon 			= dataArr[8];
		var hp 					= dataArr[9];
		var keterangan 			= dataArr[10];
		
		$(document).ready(function(){
			$("#id_karyawan").val(id_karyawan);
			$(".input_nama_karyawan").val(nama_karyawan);
			$("#id_agama").val(agama);
			$("#id_status_perkawinan").val(status_perkawinan);
			$("#id_jenis_kelamin").val(jenis_kelamin);
			$("#id_jabatan").val(id_jabatan);
			$("#id_propinsi").val(id_propinsi);
			$(".input_alamat").val(alamat);
			$(".input_telepon").val(telepon);
			$(".input_hp").val(hp);
			$(".input_keterangan").val(keterangan);
		});
	}
	
</script>

<div id="content_form_po">
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
            <legend>Data Karyawan</legend>
            <form>
                <table id="gridview">
                    <tr>
                        <td class="labels_dpo">Nama Karyawan</td>
                        <td class="labels_dpo">Handphone</td>
                        <td class="labels_dpo">Keterangan</td>
                        <?php if($user_status[4]['status']==2){?>
                        <td class="labels_dpo">Edit</td>
                        <td class="labels_dpo">Hapus</td>
                        <?php }?>
                    </tr>
                    <?php
                    foreach($list->result_array() as $karyawan)
					{
					?>
						<tr>
							<td class="labelss_dpo"><?php echo $karyawan['nama_karyawan'];?></td>
							<td class="labelss_dpo"><?php echo $karyawan['hp'];?></td>
							<td class="labelss_dpo"><?php echo $karyawan['keterangan'];?></td>
                        <?php if($user_status[4]['status']==2){?>
							<td class="labelss_dpo"><div class="edit">
                            	<a href="javascript:void(0)">Edit<span style="display:none"><?php echo $karyawan['id_karyawan']; ?>
                                </span></a>
                            </div></td>
							<td class="labelss_dpo"><div class="hapus">
                            	<a href="javascript:void(0)">Hapus<span style="display:none"><?php echo $karyawan['id_karyawan'];?>
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
            </form>
        </fieldset>
    </div>
</div>

<div id="dialog-hapus" title="Batalkan Karyawan">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM KARYAWAN
    </p>
    <table>
        <tr>
            <td>Nama Karyawan</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input type="text" name="nama_karyawan" class="input_nama_karyawan" size="40" /></td>
        </tr>
        <tr>
            <td>Agama</td><td colspan="2">&nbsp;</td>
            <td>
                <select name=id_agama[] id="id_agama" style="width:200px" >
                    <option value="0"> .: Agama :. </option>
					<option value="ISLAM">ISLAM</option>
                    <option value="KATOLIK">KATOLIK</option>
                    <option value="KRISTEN">KRISTEN</option>
                    <option value="HINDU">HINDU</option>
                    <option value="BUDHA">BUDHA</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Status</td><td colspan="2">&nbsp;</td>
            <td>
                <select name=id_status_perkawinan[] id="id_status_perkawinan" style="width:200px" >
                    <option value="0"> .: Status Perkawinan :. </option>
					<option value="BELUM MENIKAH">BELUM MENIKAH</option>
                    <option value="MENIKAH">MENIKAH</option>
                    <option value="JANDA">JANDA</option>
                    <option value="DUDA">DUDA</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td><td colspan="2">&nbsp;</td>
            <td>
                <select name=id_jenis_kelamin[] id="id_jenis_kelamin" style="width:200px" >
                    <option value=""> .: Jenis Kelamin :. </option>
					<option value="0">WANITA</option>
                    <option value="1">PRIA</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jabatan</td><td colspan="2">&nbsp;</td>
            <td>
                <select name=id_jabatan[] id="id_jabatan" style="width:200px" >
                    <option value="0"> .: Jabatan :. </option>
					<?php
                    foreach($other_list->result_array() as $jabatan)
                    {
					?>
						<option value="<?php echo $jabatan['id_jabatan'];?>"><?php echo $jabatan['nama_jabatan'];?></option>
					<?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Propinsi</td><td colspan="2">&nbsp;</td>
            <td>
                <select name=id_propinsi[] id="id_propinsi" style="width:200px" >
                    <option value="0"> .: Propinsi :. </option>
					<?php
                    foreach($list_propinsi->result_array() as $propinsi)
                    {
					?>
						<option value="<?php echo $propinsi['id_propinsi'];?>"><?php echo $propinsi['nama_propinsi'];?></option>
					<?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Alamat</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="alamat" class="input_alamat" size="40" /></td>
        </tr>
        <tr>
            <td>Telepon</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="telepon" class="input_telepon" size="40" onkeypress="return checkIt(event)" /></td>
        </tr>
        <tr>
            <td>HP</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="hp" class="input_hp" size="40" onkeypress="return checkIt(event)" /></td>
        </tr>
        <tr>
            <td>Keterangan</td><td colspan="2">&nbsp;</td>
            <td><input type="text" name="keterangan" class="input_keterangan"  maxlength="200" size="40" /></td>
        </tr>
    </table>
</div>
<input type="hidden" id="id_karyawan" value="" />
