<div class="">
	<fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
		<legend>Notifikasi Stok</legend>
		<?php
		$arr=0;
		foreach($notification['bahan_baku'] as $row)
		{?>
			<p style="font-size:14px;">Jumlah stok <font color="#FF0000"><?php echo $notification['nama_bahan_baku'][$arr];?></font> di bawah batas minimal, sisa stok adalah <font color="#FF0000"><?php echo round($notification['stok_kurang'][$arr]);?></font>&nbsp;<?php echo $notification['satuan_barang'][$arr];?></p>
			<?php $arr++;
		}
        ?>
	</fieldset>
</div>