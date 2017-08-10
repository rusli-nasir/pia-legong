<script>
	$(function(){
		$( "#dialog-detail" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 500,
			width: 800,
			modal: true,
			closeOnEscape: false,
			buttons: {}
		});
		
		//View Date Pemesanan
		$( "#datepicker" ).change(function(){
			var tgl 		= $(this).val();
			var arrtgl		= tgl.split("/");
			var tgl_beli	= arrtgl[2]+"-"+arrtgl[1]+"-"+arrtgl[0];
			
			var tgl2		= $( "#datepicker2" ).val();
			var arrtgl2		= tgl2.split("/");
			var tgl_beli2	= arrtgl2[2]+"-"+arrtgl2[1]+"-"+arrtgl2[0];
			window.location.href="<?php echo base_url();?>index.php/produksi/beli/index/"+tgl_beli+"_"+tgl_beli2;
		});
		
		$( "#datepicker2" ).change(function(){
			var tgl 		= $(this).val();
			var arrtgl		= tgl.split("/");
			var tgl_beli	= arrtgl[2]+"-"+arrtgl[1]+"-"+arrtgl[0];
			
			var tgl2		= $( "#datepicker" ).val();
			var arrtgl2		= tgl2.split("/");
			var tgl_beli2	= arrtgl2[2]+"-"+arrtgl2[1]+"-"+arrtgl2[0];
			window.location.href="<?php echo base_url();?>index.php/produksi/beli/index/"+tgl_beli2+"_"+tgl_beli;
		});
	});
	
	function get_data_tamp(mydata)
	{
		var dataArr 				= mydata.split(",");
		var id_pembelian 			= dataArr[0];
		var tanggal_pembelian 		= dataArr[1];
		var tanggal_jatuh_tempo 	= dataArr[2];
		var id_cara_pembayaran_bhn	= dataArr[3];
		var dibayar 				= dataArr[4];
		var total_pembelian			= dataArr[5];
	
		$(document).ready(function(){
			$(".id_pembelian").val(id_pembelian);
			$(".tgl_pembelian1").val(tanggal_pembelian);
			$(".tgl_jatuh_tempo").val(tanggal_jatuh_tempo);
			$(".cara_bayar").val(id_cara_pembayaran_bhn);
			$(".total_harga").val(total_pembelian);
			$(".dibayar").val(dibayar);
		});
	}
	
	function hapus_beli(id_pembelian)
	{
		var tgl 		= $("#datepicker").val();
		var arrtgl		= tgl.split("/");
		var tgl_beli	= arrtgl[2]+"-"+arrtgl[1]+"-"+arrtgl[0];
		
		var tgl2		= $( "#datepicker2" ).val();
		var arrtgl2		= tgl.split("/");
		var tgl_beli2	= arrtgl2[2]+"-"+arrtgl2[1]+"-"+arrtgl2[0];
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/beli/hapus_beli",
			data: "id_pembelian="+id_pembelian,
			cache: false,
			success: function(data){
				window.location.href="<?php echo base_url();?>index.php/produksi/beli/index/"+tgl_beli2+"_"+tgl_beli;
			}
		});
	}
	
	function detail_beli(id_pembelian)
	{
		find_beli(id_pembelian);
			
		$( "#dialog-detail" ).dialog({
			title: 'Data Detail Pembelian'
		});
		$( "#dialog-detail" ).dialog( "open" );
	}
	
	function find_beli(id_pembelian)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/beli/find_beli",
			data: "id_pembelian="+id_pembelian,
			cache: false,
			success: function(data){
				get_data_tamp(data);			
			}
		});
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/produksi/beli/find_beli_detail2",
			data: "id_pembelian="+id_pembelian,
			cache: false,
			success: function(data){alert(data);
				get_data_detail(data);			
			}
		});
	}
	
	function get_data_detail(mydata)
	{
		$("#tabel_detail").html(mydata);
	}
</script>

<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
    <legend>Daftar Pembelian</legend>
        <table>
            <tr>
                <td style="width: 100px;">Periode</td>
                <td>
                    <input style="color:#0000FF;" type="text" id="datepicker" name="tgl_pembelian" class="tgl_pembelian" size="10" maxlength="10" readonly="readonly" value="<?php echo explode_date($date1,1);?>" />
                </td>
            </tr>
            <tr>
                <td style="width: 100px;">&nbsp;</td>
                <td>Sampai</td>
            </tr>
            <tr>
                <td style="width: 100px;">&nbsp;</td>
                <td>
                    <input style="color:#0000FF;" type="text" id="datepicker2" name="tgl_pembelian2" class="tgl_pembelian2" size="10" maxlength="10" readonly="readonly" value="<?php echo explode_date($date,1);?>" />
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table id="gridview">
            <tr>
                <td class="labels">No.</td>
                <td class="labels_dpo">Nama Barang</td>
                <td class="labels_dbyr">Supplier</td>
                <td class="labels_dpo">Quantity</td>
                <td class="labels_dpo">Total Harga</td>
                <td class="labels_dpo">Detail</td>
                <td class="labels_dpo">Pembayaran</td>
                <td class="labels_dpo">Stok Masuk</td>
                <td class="labels_dpo">Edit</td>
                <td class="labels_dpo">Hapus</td>
            </tr>
        </table>
        <div id="scrollable" class="yui3-scrollview-loading">
        <table id="gridview">
            <?php
            $no=0; $i=0;
            foreach($list->result_array() as $daftarlistbeli)
            {
                $_SESSION['pembelian_'.$i] = $daftarlistbeli['id_pembelian'];
                $z_nowdate 	= date('z', strtotime("".date('F j').""));
                $ar_date 	= explode('-',$date);
                $z_lastdate = date('z', mktime(0, 0, 0, $ar_date[1], $ar_date[2], $ar_date[0]));
                ?>
                <tr class="isi_list">
                    <td class="labelss" id="search1">
                        <?php 
                        if($i > 0) {
                            if($_SESSION['pembelian_'.$i]!=$_SESSION['pembelian_'.($i-1)]) {
                                echo $no+1;
                                $no++;
                            }
                            else
                                echo '&nbsp;';
                        }
                        else {
                            echo $no+1;
                            $no++;
                        }?>
                    </td>
                    <td class="labelss_dpo" id="search2"><?php echo $daftarlistbeli['nama_bhn_baku']; ?></td>
                    <td class="labelss_dbyr" id="search3"><?php echo $daftarlistbeli['nama_supplier']; ?></td>
                    <td class="labelss_dbyr" id="search4"><?php echo round($daftarlistbeli['quantity']); ?></td>
                    <td class="labelss_dbyr" id="search4"><?php echo $daftarlistbeli['total_harga']; ?></td>
                    <td class="labelss_dpo">
                        <?php 
                        if($i > 0) {
                            if($_SESSION['pembelian_'.$i]!=$_SESSION['pembelian_'.($i-1)]) {
                                ?>
                                <a href="javascript:void(0)" onclick="detail_beli('<?php echo $daftarlistbeli['id_pembelian'];?>')">
                                    <span style="display:block">Detail</span></a>
                                <?php 
                            }
                            else
                                echo '&nbsp;';
                        }
                        else {
                            ?>
                            <a href="javascript:void(0)" onclick="detail_beli('<?php echo $daftarlistbeli['id_pembelian'];?>')">
                                <span style="display:block">Detail</span></a>
                            <?php 
                        }?>
                    </td>
                    <td class="labelss_dpo">
                        <?php 
                        if($i > 0) {
                            if($_SESSION['pembelian_'.$i]!=$_SESSION['pembelian_'.($i-1)]) {
                                ?>
                                <a href="<?php echo site_url(array('produksi','beli','find_pembayaran_detail',$daftarlistbeli['id_pembelian']))?>">
                                    <span style="display:block">Pembayaran</span></a>
                                <?php 
                            }
                            else
                                echo '&nbsp;';
                        }
                        else {
                            ?>
                            <a href="<?php echo site_url(array('produksi','beli','find_pembayaran_detail',$daftarlistbeli['id_pembelian']))?>">
                                <span style="display:block">Pembayaran</span></a>
                            <?php 
                        }?>
                    </td>
                    <td class="labelss_dpo">
                        <?php 
                        if($i > 0) {
                            if($_SESSION['pembelian_'.$i]!=$_SESSION['pembelian_'.($i-1)]) {
                                ?>
                                <a href="<?php echo site_url(array('produksi','stok_bahan','find_stok_pembelian_detail',$daftarlistbeli['id_pembelian']))?>">
                                    <span style="display:block">Stok Masuk</span></a>
                                <?php 
                            }
                            else
                                echo '&nbsp;';
                        }
                        else {
                            ?>
                            <a href="<?php echo site_url(array('produksi','stok_bahan','find_stok_pembelian_detail',$daftarlistbeli['id_pembelian']))?>">
                                <span style="display:block">Stok Masuk</span></a>
                            <?php 
                        }?>
                    </td>
                    <td class="labelss_dpo">
                        <?php 
                        if($i > 0) {
                            if($_SESSION['pembelian_'.$i]!=$_SESSION['pembelian_'.($i-1)]) { 
                                ?>
                                <a href="<?php echo site_url(array('produksi','beli','find_pembelian_detail',$daftarlistbeli['id_pembelian']))?>">
                                    <span style="display:block">Edit</span></a>
                                <?php 
                            }
                            else
                                echo '&nbsp;';
                        }
                        else {
                            ?>
                            <a href="<?php echo site_url(array('produksi','beli','find_pembelian_detail',$daftarlistbeli['id_pembelian']))?>">
                                <span style="display:block">Edit</span></a>
                            <?php 
                        }?>
                    </td>
                    <td class="labelss_dpo">
                        <?php 
                        if($i > 0) {
                            if($_SESSION['pembelian_'.$i]!=$_SESSION['pembelian_'.($i-1)]) { 
                                ?>
                                <a href="javascript:void(0)" onclick="hapus_beli('<?php echo $daftarlistbeli['id_pembelian'];?>')">
                                    <span style="display:block">Hapus</span></a>
                                <?php 
                            }
                            else
                                echo '&nbsp;';
                        }
                        else {
                            ?>
                            <a href="javascript:void(0)" onclick="hapus_beli('<?php echo $daftarlistbeli['id_pembelian'];?>')">
                                <span style="display:block">Hapus</span></a>
                            <?php 
                        }?>
                    </td>
                </tr>
                <?php
                $i++;
            }?>
        </table>
        </div>            
    </fieldset>
</div>

<div id="dialog-detail" title="">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        DETAIL PEMBELIAN
    </p>
    <table>
        <tr>
        	<td style="width: 150px;">Tgl. Akhir Pelunasan</td><td>:</td><td>&nbsp;</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker1" name="tgl_jatuh_tempo1" class="tgl_jatuh_tempo" size="10" maxlength="10" readonly="readonly" value="<?php echo explode_date($date,1);?>" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Total Harga</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="total_harga" class="total_harga" value="0" readonly="readonly" /></td>
        </tr>
    	<tr>
            <td style="width: 150px;">Cara Pembayaran</td><td>:</td><td>&nbsp;</td>
            <td>
            	<select name="id_cara_pembayaran" class="cara_bayar">
                	<option value="0">.:Pembayaran:.</option>
                    <?php 
					foreach($list_cara_bayar->result_array() as $row)
					{
						?>
						<option value="<?php echo $row['id_cara_pembayaran'];?>"><?php echo $row['nama_cara_pembayaran'];?></option>
						<?php 
					}
					?>
                </select>
            </td>
            <td style="width: 50px;">&nbsp;</td>
        	<td style="width: 150px;">Dibayar</td><td>:</td><td>&nbsp;</td>
            <td><input type="text" name="dibayar" class="dibayar" value="0" readonly="readonly" /></td>
        </tr>
    </table>
    <table id="tabel_detail"></table>
</div>

<script>
	$(function(){
		// animasi list
		YUI().use('scrollview', function(Y) {
			// cek apakah ada list di halaman
			if($("#scrollable").html() != null)
			{
				var scrollView = new Y.ScrollView({
					srcNode: '#scrollable',
					height: 300
				});
				scrollView.scrollbars.flash();
				scrollView.render();		
			}
		});
	});
</script>