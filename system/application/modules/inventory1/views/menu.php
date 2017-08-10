<script>
	$(document).ready(function(){
		
		$('#searchtext').click(function(){
			var searchtext = $('#searchtext').val();
			if(searchtext == 'search..')
				$('#searchtext').val('');
		});
    });
</script>

<div id="content_menu">
    <div <?php echo isset ($active_menus) ? $active_menus : '' ?> class="submenu">
        <ul>
            <li id="master_menus">
            	<a href="javascript:void(0)">Master</a>
                <ul>
                	<li><a href="<?php echo site_url(array('inventory','barang'));?>">Barang</a></li>
                    <li><a href="<?php echo site_url(array('inventory','cara_pembayaran'));?>">Cara Pembayaran</a></li>
                    <li class="delete_system"><a href="<?php echo site_url(array('inventory','operasional','delete_system'));?>">Hapus Data</a></li>
                </ul>
            </li>
            <li id="po_menus"><a href="<?php echo site_url(array('inventory','po'));?>">Pemesanan</a></li>
            <li id="penjualan_menus"><a href="<?php echo site_url(array('inventory','jual'));?>">Penjualan</a></li>
            <li id="operasional_menus"><a href="<?php echo site_url(array('inventory','operasional'));?>">Pengeluaran Produksi</a></li>
            <li id="laporan_menus"><a href="<?php echo site_url(array('inventory','laporan'));?>">Summary</a>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="search">
        <input type="text" name="search" value="search.." id="searchtext" />
        <div class="icon_search"></div>
    </div>
    <div class="menu_action">
        <ul>
            <li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" <?php echo $simpan;?> /></li>
            <li><input type="submit" name="edit" id="tombol_edit" value="Edit" <?php echo $edit;?> /></li>
            <li><input type="submit" name="batal" id="tombol_batal" value="Batal" <?php echo $batal;?> /></li>
            <li><input type="button" name="cetak" value="Cetak" <?php echo $cetak;?>/></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>