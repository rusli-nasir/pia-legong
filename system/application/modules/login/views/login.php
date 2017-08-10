<script>
	$(function(){   
		$( ".login_button" ).click(function(){
			var username = $("#username").val();
			var password = $("#password").val();
			CekLogin(username,password);
		});
	});
	
	function CekLogin(username, password)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/login/cek_login",
			data: "username="+username+"&password="+password,
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
	
	/*function login_button()
	{
		var username = $("#username").val();
		var password = $("#password").val();
		CekLogin(username,password);
	}*/
</script>
<?php echo form_open('login/login/cek_login');?>
<div id="header">
    <div class="content_header">
        <h2>PIA LEGONG SYSTEM INFORMATION</h2>
        <div class="clear"></div>
    </div>
</div>
<div id="wrapper_layout">
	<!--<form method="post" onclick="login_button()">-->
    <div id="login-box">
        <div class="lock"></div>
        <H2>Login</H2>
        <div class="clear"></div>
        <div id="login-box-name">
            Username:
        </div>
        <div id="login-box-field">
            <input name="username" class="form-login" title="Username" value="" size="30" maxlength="2048" id="username"/>
        </div>
        <div id="login-box-name">
            Password:
        </div><div id="login-box-field">
        	<input name="password" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" id="password" />
        </div>
        <div id="login-box-name"></div>
        <div id="login-box-field">
        	<!--<a href="#" class="login_button"><img src="<?php //echo base_url().'image/login-btn.png';?>" width="103" height="42" /></a>-->
            <input type="submit" class="tombol-login" value="" />
        </div>
        <div><?php echo $msg;?></div>
    </div>
    <!--</form>-->
</div>
<?php echo form_close();?>