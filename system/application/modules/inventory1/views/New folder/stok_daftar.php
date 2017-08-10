<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Stok Barang</legend>
            <table id="gridview">
                <tr>
                    <td class="labels_dpo">Kode Barang</td>
                    <td class="labels_dpo">Nama Barang</td>
                    <td class="labels_dpo">Jumlah Stok</td>
                    <td class="labels_dpo">Detail Stok</td>
                </tr>
                <?php
                foreach($daftar_list_stok->result_array() as $daftarliststok)
                {
                ?>
                <tr class="isi_list">
                    <td class="labelss_dpo" id="search1"><?php echo $daftarliststok['kode_barang']; ?></td>
                    <td class="labelss_dpo" id="search2"><?php echo $daftarliststok['nama_barang']; ?></td>
                    <td class="labelss_dpo" id="search3"><?php echo round($daftarliststok['sisa_stok'],5); ?></td>
                    <td class="labelss_dpo"><a href="<?php echo site_url('inventory/stok/index_stok_detail/'.$daftarliststok['id_barang']);?>">Detail</a></td>
                </tr>
                <?php
                }
                ?>
            </table>
    </fieldset>
</div>