<div <?php echo isset($active_menu) ? $active_menu : ''; ?> id="menu_form_po">
    <ul>
        <li id="tab_daftar_beli"><a href="<?php echo site_url(array('produksi','beli'));?>">Daftar Pembelian</a></li>
        <li id="tab_form_beli"><a href="<?php echo site_url(array('produksi','beli','akses_beli','beli_form'));?>">Beli Form</a></li>
        <li id="tab_bayar_beli"><a href="<?php echo site_url(array('produksi','beli'));?>">Pembayaran</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <?php 
		if($notification != '')
			$this->load->view('notifikasi_stok', $notification);
		
        switch($menu)
        {
			case "beli_form":
			$this->load->view('beli_form');
            break;
			
			case "beli_bayar":
			$this->load->view('beli_bayar');
            break;
			
            default:
            $this->load->view('beli_daftar');
            break;
        }
    ?>
</div>