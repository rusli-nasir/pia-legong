<script>
	$(function(){   
		$( ".logout_button" ).click(function(){
			LogoutProses();
		});
	});
	
	function LogoutProses()
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/login/login/logout",
			data: "",
			cache: false,
			success: function(msg){
				window.location.href=msg;
			}
		});
	}
</script>
<?php
	/*$hasil_inventory = 0;
	$hasil_acc = 0;
	if(count($user_status)>0)
	{
		foreach($user_status as $result)
		{
			if($result['id_menu']>=0 and $result['id_menu']<=12 and $result['id_menu']!=5 and $result['status']!=0)
				$hasil_inventory = 1;
			elseif($result['id_menu']>=13 and $result['id_menu']<=18 and $result['status']!=0)
				$hasil_acc = 1;
		}
	}
	$view='';
	if($hasil_inventory!=0)
		$view .='<li><a href="'.site_url(array('inventory','barang')).'">Inventory</a></li>';
	if($hasil_acc!=0)
		$view .='<li><a href="'.site_url(array('accounting','pajak')).'">Accounting</a></li>';*/
?>
<div id="header">
    <div class="content_header">
        <h2>PIA LEGONG SYSTEM INFORMATION</h2>
        <div class="menu_module">
            <ul>
        		<?php /*if($view!=''){
							echo $view;*/	
				?>
                <li><a href="<?php echo site_url(array('inventory','barang'));?>">Inventory</a></li>
                <li><a href="<?php echo site_url(array('produksi','supplier'));?>">Produksi</a></li>
			<li><a href="<?php echo site_url(array('login','user','backup_system'));?>">Backup</a></li>
                <li><div class="logout_button"><a href="javascript:void(0)">Logout</a></div></li>
        		<?php //}?>
            </ul>  
            <div class="clear"></div>  
        </div>
        <div class="clear"></div>
    </div>
</div>