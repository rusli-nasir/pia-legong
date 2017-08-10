<div <?php echo isset($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_po"><a href="<?php echo site_url(array('inventory','po'));?>">Daftar Pemesanan</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <?php
        switch($menu)
        {
            default:
            $this->load->view('po_daftar');
            break;
        }
    ?>
</div>