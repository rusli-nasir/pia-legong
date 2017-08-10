<script>
	$(function(){
		$( "#dialog-hapus" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 330,
			width: 400,
			modal: true,
			closeOnEscape: false,
			buttons: {
				"User Management": function() {
					var id_user	= $("#id_user").val();
					
					Go_User_Management(id_user);
					
					$( this ).dialog( "close" );
					window.location.href=msg;
				},
				"Simpan Data": function() {
					
					var id_user			= $("#id_user").val();
					var nama_user		= $(".input_nama_user").val();
					var id_karyawan		= $("#id_karyawan").val();
					//var nama_karyawan	= $(".input_nama_karyawan").val();
					var id_level_user	= $("#id_level_user").val();
					var pass			= $(".input_pass").val();
					var passconfirm		= $(".input_passconfirm").val();
					
					if(pass==passconfirm && pass!='' && passconfirm!='')
					{
						if(id_user != '' && nama_user != '' && id_karyawan != '' && id_level_user != '0')
						{
							editUser(id_user, nama_user, id_karyawan, id_level_user, pass);
							$( this ).dialog( "close" );
						}
						else if(id_user == '' && nama_user != '' && id_karyawan != '' && id_level_user != '0')
						{
							addUser(nama_user, id_karyawan, id_level_user, pass);
							$( this ).dialog( "close" );
						}
						
						window.location.href=msg;
					}
					else
					{
						alert('Maaf Password yang anda input salah !!..');
						$(".input_pass").val('');
						$(".input_passconfirm").val('');
					}
				},
				"Kembali": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function()
			{
				$("#id_user").val('');
				$(".input_nama_user").val('');
				$("#id_karyawan").val('');
				$(".input_nama_karyawan").val('');
				$("#id_level_user").val('');
				$(".input_pass").val('');
				$(".input_passconfirm").val('');
			}
		});
		
		$( ".add" ).click(function(){
			$( "#dialog-hapus" ).dialog({
				title: 'Input Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
		
		$( ".edit" ).click(function(){
			var id_user = $(this).find("span").text();
			findUser(id_user);
			
			$( "#dialog-hapus" ).dialog({
				title: 'Edit Data'
			});
			$( "#dialog-hapus" ).dialog( "open" );
		});
		
		$( ".hapus" ).click(function(){
			var id_user = $(this).find("span").text();
			hapusUser(id_user);
		});
	});
	
	function addUser(nama_user, id_karyawan, id_level_user, pass)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/add_user",
			data: "nama_user="+nama_user+"&id_karyawan="+id_karyawan+"&level="+id_level_user+"&pass="+pass,
			cache: false,
			success: function(msg){
				//window.location.href=msg;
				window.location.href="<?php echo base_url();?>index.php/login/user/akses_user/user_menu";
			}
		});
	}
	
	function editUser(id_user, nama_user, id_karyawan, id_level_user, pass)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/edit_user",
			data: "id_user="+id_user+"&nama_user="+nama_user+"&id_karyawan="+id_karyawan+"&level="+id_level_user+"&pass="+pass,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function Go_User_Management(id_user)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/go_user_management",
			data: "id_user="+id_user,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function hapusUser(id_user)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/hapus_user",
			data: "id_user="+id_user,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	function findUser(id_user)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/user/find_user",
			data: "id_user="+id_user,
			cache: false,
			success: function(data){
				tampungData(data);
			}
		});
	}
	
	function tampungData(mydata)
	{
		var dataArr 		= mydata.split(",");
		var id_user 		= dataArr[0];
		var nama_user		= dataArr[1];
		var id_karyawan		= dataArr[2];
		var nama_karyawan	= dataArr[3];
		var level			= dataArr[4];
		var pass			= dataArr[5];
		var passconfirm		= dataArr[6];
		
		$(document).ready(function(){
			$("#id_user").val(id_user);
			$(".input_nama_user").val(nama_user);
			$("#id_karyawan").val(id_karyawan);
			$(".input_nama_karyawan").val(nama_karyawan);
			$("#id_level_user").val(level);
			$(".input_pass").val('');
			$(".input_passconfirm").val('');
		});
	}
	
	$(function(){
		$('.input_nama_karyawan').autocomplete("<?php echo base_url(); ?>index.php/login/user/find_all_karyawan",
			{
				parse: function(data){
					var parsed = [];
					for(var i=0; i< data.length; i++){
						parsed[i] = {
								data: data[i],
								value: data[i].nama_karyawan
							};
					}
					return parsed;
				},
				formatItem: function(data,i,max){
					var str = '<div class="search_content">';
					str += '<u>'+data.nama_karyawan+'</u>';
					str += '</div>'
					return str;
				},
				dataType: 'json'
			}
		).result(
			function(event,data,formated){
				$('#id_karyawan').val(data.id_karyawan)
				$('.input_nama_karyawan').val(data.nama_karyawan)
			}
		);
	});
</script>

<div id="content_form_po">
    <div class="">
        <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
            <legend>Data User</legend>
            <table id="gridview">
                <tr>
                    <td class="labels_dpo">Name Karyawan</td>
                    <td class="labels_dpo">Name User</td>
                    <td class="labels_dpo">Level</td>
                    <?php if($user_status[4]['status']==2){?>
                    <td class="labels_dpo">Edit</td>
                    <td class="labels_dpo">Hapus</td>
                    <?php }?>
                </tr>
                <?php
				foreach($list->result_array() as $user)
				{
				?>
                    <tr>
                        <td class="labelss_dpo"><?php echo $user['nama_karyawan'];?></td>
                        <td class="labelss_dpo"><?php echo $user['username'];?></td>
                        <td class="labelss_dpo"><?php echo 'Level '.$user['level'];?></td>
                    <?php if($user_status[4]['status']==2){?>
                        <td class="labelss_dpo" id="search3">
                            <div class="edit">
                                <a href="javascript:void(0)">Edit<span style="display:none"><?php echo $user['id_user'];?></span></a>
                            </div>
                        </td>
                        <td class="labelss_dpo"><div class="hapus">
                            <a href="javascript:void(0)">Hapus<span style="display:none"><?php echo $user['id_user'];?></span></a></div>
                        </td>
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
<div id="dialog-hapus" title="Batalkan User">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        FORM JABATAN
    </p>
		<table>
            <tr>
                <td>Name Karyawan</td><td colspan="2">&nbsp;</td>
                <td><input type="text" name="nama_karyawan" class="input_nama_karyawan" value="" size="40" maxlength="50"/></td>
            </tr>
            <tr>
                <td>Name User</td><td colspan="2">&nbsp;</td>
                <td><input type="text" name="nama_user" class="input_nama_user" value="" size="40" maxlength="20"/></td>
            </tr>
            <tr>
                <td>Level User</td><td colspan="2">&nbsp;</td>
                <td>
                	<select name="level_user" id="id_level_user">
                        <option> .: Level :. </option>
                        <option value="1">Level 1</option>
                        <option value="2">Level 2</option>
                        <option value="3">Level 3</option> 
                        <option value="4">Level 4</option> 
                    </select>
                </td>
            </tr>
             <tr>
                <td>Password</td><td colspan="2">&nbsp;</td>
                <td><input type="password" name="pass" class="input_pass" value="" size="40" maxlength="20"/></td>
            </tr>
            <tr>
                <td>Confirm Password</td><td colspan="2">&nbsp;</td>
                <td><input type="password" name="passconfirm" class="input_passconfirm" value="" size="40" maxlength="20"/></td>
            </tr>
    </table>
</div>
<input type="hidden" name="id_user" id="id_user" value=""/>
<input type="hidden" name="id_karyawan" id="id_karyawan" value=""/>