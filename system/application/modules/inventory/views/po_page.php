<div <?php echo isset($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_po"><a href="<?php echo site_url(array('inventory','po'));?>">Daftar Pemesanan</a></li>
        <li id="tab_daftar_po"><a href="<?php echo site_url(array('inventory','po/detail_po'));?>">Detail Pemesanan Harian</a></li>
        <li id="tab_daftar_po"><a href="<?php echo site_url(array('inventory','po/pengambilan_po'));?>">Pengambilan Pemesanan Harian</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <?php
    if($menu){
	    $this->load->view($menu);
    }
//        switch($menu)
//        {
//
//            case 'po_daftar':
//
//            break;
//			case 'po_detail':
//            $this->load->view('po_detail');
//            break;
//
//			case 'po_pengambilan':
//            $this->load->view('po_pengambilan');
//            break;
//
//        }
    ?>
</div>