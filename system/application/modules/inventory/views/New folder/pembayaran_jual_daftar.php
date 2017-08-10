<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Penjualan</legend>
            <table id="gridview">
                <tr>
                    <td class="labels_dpo">No. Invoice</td>
                    <td class="labels_dpo">Tgl. Penjualan</td>
                    <td class="labels_dpo">Tgl. Jatuh Tempo</td>
                    <td class="labels_dpo">Total Pembayaran</td>
                    <td class="labels_dpo">Sudah di Bayar</td>
                    <td class="labels_dpo">Detail Pembayaran</td>
                </tr>
                <?php
				foreach($daftar_list_jual->result_array() as $daftarlistjual)
				{
				$tglbaru			= $daftarlistjual['tgl_penjualan'];
				$tgl_penjualan		= explode_date($tglbaru, 1);
				$tglbaru			= $daftarlistjual['tgl_jatuh_tempo'];
				$tgl_jatuh_tempo	= explode_date($tglbaru, 1);
                ?>
                <tr class="isi_list">
                    <td class="labelss_dpo" id="search1"><?php echo $daftarlistjual['no_invoice']; ?></td>
                    <td class="labelss_dpo" id="search2"><?php echo $tgl_penjualan; ?></td>
                    <td class="labelss_dpo" id="search3"><?php echo $tgl_jatuh_tempo; ?></td>
                    <td class="labelss_dpo" id="search4"><?php echo currency_format($daftarlistjual['total_harga'],0); ?></td>
                    <td class="labelss_dpo" id="search5"><?php echo currency_format($daftarlistjual['dp'],0); ?></td>
                    <td class="labelss_dpo"><a href="<?php echo site_url('inventory/jual/index_form_bayar/'.$daftarlistjual['id_penjualan']);?>">Detail Pembayaran</a></td>
                </tr>
                <?php
				}
                ?>
            </table>
    </fieldset>
</div>