<div <?php echo isset($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_stok_barang"><a href="<?php echo site_url(array('produksi','stok_bahan'));?>">Daftar Stok Bahan</a></li>
        <li id="tab_detail_stok_barang"><a href="<?php echo site_url(array('produksi','stok_bahan'));?>">Detail Stok Bahan</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
	<?php 
		if($notification != '')
			$this->load->view('notifikasi_stok', $notification);
		
        switch($menu)
        {
			case "stok_bahan_daftar":
			$this->load->view('stok_bahan_daftar');
            break;
			
            default:
            $this->load->view('stok_bahan_detail');
            break;
        }
    ?>
</div>