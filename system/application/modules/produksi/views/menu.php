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
                	<li><a href="<?php echo site_url(array('produksi','cara_pembayaran_bhn'));?>">Cara Pembayaran</a></li>
                	<li><a href="<?php echo site_url(array('produksi','supplier'));?>">Supplier</a></li>
                    <li><a href="<?php echo site_url(array('produksi','satuan_barang'));?>">Satuan Barang</a></li>
                    <li class="delete_system"><a href="<?php echo site_url(array('produksi','bahan_baku'));?>">Bahan Produksi</a></li>
                </ul>
            </li>
            <li id="stok_menus"><a href="<?php echo site_url(array('produksi','stok_bahan'));?>">Stok Bahan Produksi</a></li>
            <li id="pembelian_menus"><a href="<?php echo site_url(array('produksi','beli'));?>">Pembelian</a></li>
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
        	<?php echo $add;?>
            <!--<li><input type="submit" name="simpan" id="tombol_simpan" value="Simpan" <?php //echo $simpan;?> /></li>
            <li><input type="submit" name="edit" id="tombol_edit" value="Edit" <?php //echo $edit;?> /></li>
            <li><input type="submit" name="batal" id="tombol_batal" value="Batal" <?php //echo $batal;?> /></li>
            <li><input type="button" name="cetak" value="Cetak" <?php //echo $cetak;?>/></li>-->
        </ul>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>