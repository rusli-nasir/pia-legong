<div <?php echo isset ($active_menu) ? $active_menu :''; ?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_stok_barang"><a href="<?php echo site_url(array('inventory','stok','akses_stok','stok_daftar'));?>">Daftar Barang</a></li>
        <li id="tab_detail_stok_barang"><a href="<?php echo site_url(array('inventory','stok','akses_stok','stok_detail'));?>">Detail Stok Barang</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <?php
        switch($menu)
        {	
            case "stok_detail": 
            $this->load->view('stok_detail');
            break;
			
            default: 
            $this->load->view('stok_daftar');
            break;
        }
    ?>
</div>