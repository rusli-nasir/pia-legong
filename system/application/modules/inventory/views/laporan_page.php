<div <?php echo isset ($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
        <li id="tab_jual_laporan"><a href="<?php echo site_url(array('inventory','laporan'));?>">Laporan Penjualan</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <?php
        switch($menu)
        {
			case "laporan_jual":
            $this->load->view('laporan_jual');
            break;
        }
    ?>
</div>