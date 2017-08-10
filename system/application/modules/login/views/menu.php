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