<div <?php echo isset($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
    	<?php $leveluser = $this->session->userdata('level_user');
		if($leveluser == 1)
		{?>
        <li id="tab_form_po"><a href="<?php echo site_url('login/user/'.$tab);?>">Form Jabatan</a></li>
        <li id="tab_daftar_po"><a href="<?php echo site_url(array('login','user','akses_user','karyawan_daftar'));?>">Form Karyawan</a></li>
        <?php 
		}?>
        <li id="tab_form_user"><a href="<?php echo site_url(array('login','user','akses_user','form_user'));?>">Form User</a></li>
        <li id="tab_form_user"><a href="<?php echo site_url(array('login','user','akses_user',$tab_user));?>">User Management</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_user">
    <?php
        switch($menu)
        {
            case "karyawan_daftar":
            $this->load->view('karyawan_daftar');
            break;
			
			case "form_user":
            $this->load->view('form_user');
            break;
			
			case "user_menu":
            $this->load->view('user_menu');
            break;
			
            default:
            $this->load->view('jabatan_daftar');
            break;
        }
    ?>
</div>