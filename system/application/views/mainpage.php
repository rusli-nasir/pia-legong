<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/typhograpy.css"  />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/custom_search.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.ui.all.css"  />

<script src="<?php echo base_url();?>js/jquery-1.4.4.js"></script>
<script src="<?php echo base_url();?>js/jquery-ui.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>js/jquery.tablesorter.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.tablesorter.pager.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.uitablefilter.js" type="text/javascript"></script>
 
<script src="<?php echo base_url();?>js/jquery.ui.core.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.widget.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.mouse.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.button.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.draggable.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.position.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.dialog.js"></script>
<script src="<?php echo base_url();?>js/jquery.ui.datepicker.js" ></script>
<script src="<?php echo base_url();?>js/jquery.ui.accordion.js"></script>

<script src="<?php echo base_url();?>js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>js/realtime_clock.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.autocomplete.js"></script>

<script src="<?php echo base_url();?>js/build/yui/yui.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.printElement.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/checkit.js" type="text/javascript"></script>

<script>
$(function(){
	// datepicker
	$( "#datepicker" ).datepicker();
	var img = $("#image_calendar").text();
	$( "#datepicker" ).datepicker( "option", "buttonImage", img );
	
	// datepicker
	$( "#datepicker1" ).datepicker();
	var img = $("#image_calendar").text();
	$( "#datepicker1" ).datepicker( "option", "buttonImage", img );
	
	// datepicker
	$( "#datepicker2" ).datepicker();
	var img = $("#image_calendar").text();
	$( "#datepicker2" ).datepicker( "option", "buttonImage", img );
	
	// datepicker
	$( "#datepicker3" ).datepicker();
	var img = $("#image_calendar").text();
	$( "#datepicker3" ).datepicker( "option", "buttonImage", img );
	
	// search list
	$('#searchtext').keyup(function(event) {
		var search_text = $('#searchtext').val();
		var rg = new RegExp(search_text,'i');
		var cek_value = '';
		
		$('.isi_list').each(function(){
			cek_value = 0;
			//alert('');
			var src1 = $(this).find( "#search1" ).text();
			var src2 = $(this).find( "#search2" ).text();
			var src3 = $(this).find( "#search3" ).text();
			var src4 = $(this).find( "#search4" ).text();
			var src5 = $(this).find( "#search5" ).text();
			var src6 = $(this).find( "#search6" ).text();
			var src7 = $(this).find( "#search7" ).text();
			var src8 = $(this).find( "#search8" ).text();
			var srctlp_2 = $(this).find( "#search_tlp_2" ).val();
			var srctlp_3 = $(this).find( "#search_tlp_3" ).val();
			
			if($.trim(src1).search(rg) != -1) {cek_value++;}
			if($.trim(src2).search(rg) != -1) {cek_value++;}
			if($.trim(src3).search(rg) != -1) {cek_value++;}
			if($.trim(src4).search(rg) != -1) {cek_value++;}
			if($.trim(src5).search(rg) != -1) {cek_value++;}
			if($.trim(src6).search(rg) != -1) {cek_value++;}
			if($.trim(src7).search(rg) != -1) {cek_value++;}
			if($.trim(src8).search(rg) != -1) {cek_value++;}
			if($.trim(srctlp_2).search(rg) != -1) {cek_value++;}
			if($.trim(srctlp_3).search(rg) != -1) {cek_value++;}
			
			if(cek_value > 0) $(this).css('display', '');
			else $(this).css('display', 'none');
		});
	});
	
	// accordion customer
	$( "#accordion" ).accordion({
		//event: "mouseover",
		//animated: 'bounceslide',
		/*autoHeight: false,
		navigation: true*/
	});
});
</script>

<style>
	.yui3-js-enabled .yui3-scrollview-loadings {
		display:none;
	}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HOME</title>
</head>

<body>
<div id="wrapper">
    <?php $this->load->view('banner');?>
    <div id="wrapper_layout">
        <?php echo form_open($form);?>
		<?php $this->load->view('menu');?>
        <?php $this->load->view($page);?>
        <?php echo form_close();?>
    </div>
    <div id="footer">
    	<div class="footer_left">
        	<p>Copy &copy; right 2011 Maxsolution.net</p>
            <div class="clear"></div>
        </div>
        <div class="footer_right">
        	<ul>
            	<!--<li><a>asa</a></li>
                <li><a>asa</a></li>
                <li><a>asa</a></li>
                <li><a>asa</a></li>-->
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
</body>
</html>