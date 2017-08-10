<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style_login.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css"  />

<script src="<?php echo base_url();?>js/jquery-1.4.4.js"></script>
<script src="<?php echo base_url();?>js/jquery.printElement.min.js" type="text/javascript"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN</title>
</head>

<body>
<div id="wrapper">
        <?php echo form_open($form);?>
        <?php $this->load->view($page);?>
        <?php echo form_close();?>
</div>
</body>
</html>