<div <?php echo isset ($active_menu) ? $active_menu :''; ?> id="menu_form_po">
    <ul>
        <li id="tab_form_jual"><a href="<?php echo site_url('inventory/jual/'.$tab);?>">Data Penjualan</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <?php
        switch($menu)
        {	
            case "jual_daftar": 
            $this->load->view('jual_daftar');
            break;
			
			case "pembayaran_jual_daftar": 
            $this->load->view('pembayaran_jual_daftar');
            break;
			
			case "pembayaran_jual_form":
            $this->load->view('pembayaran_jual_form');
            break;
			
            default: 
            $this->load->view('jual_form');
            break;
        }
    ?>
</div>