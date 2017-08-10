<div id="content_form_user">
    <div class="">
    	<h2 class="title-list">Silahkan memilih menu di bawah ini untuk management user</h2>
<div class="demo">
    <div id="accordion">
        <h3><a href="#section1" class="h3accordion">MASTER</a></h3>
        <div>
            <table>
                <tr>
                	<td width="300">Barang</td><td>:</td>
                    <td>
                    	<input type="radio" name="barang" value="0" <?php if($status[1] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="barang" value="1" <?php if($status[1] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="barang" value="2" <?php if($status[1] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
                <tr>
                	<td>Satuan Barang</td><td>:</td>
                    <td>
                    	<input type="radio" name="satuan_barang" value="0" <?php if($status[2] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="satuan_barang" value="1" <?php if($status[2] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="satuan_barang" value="2" <?php if($status[2] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
                <tr>
                	<td>Supplier</td><td>:</td>
                    <td>
                    	<input type="radio" name="supplier" value="0" <?php if($status[3] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="supplier" value="1" <?php if($status[3] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="supplier" value="2" <?php if($status[3] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
                <tr>
                	<td>Customer</td><td>:</td>
                    <td>
                    	<input type="radio" name="customer" value="0" <?php if($status[4] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="customer" value="1" <?php if($status[4] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="customer" value="2" <?php if($status[4] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
                <tr>
                	<td>User</td><td>:</td>
                    <td>
                    	<input type="radio" name="user" value="0" <?php if($status[5] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="user" value="1" <?php if($status[5] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="user" value="2" <?php if($status[5] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section2" class="h3accordion">PURCHASING ORDER</a></h3>
        <div>
        	<table>
                <tr>
                	<td width="300">Purchase Order (PO)</td><td>:</td>
                    <td>
                    	<input type="radio" name="purchase_order" value="0" <?php if($status[6] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="purchase_order" value="1" <?php if($status[6] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="purchase_order" value="2" <?php if($status[6] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section3" class="h3accordion">PEMBELIAN</a></h3>
        <div>
        	<table>
                <tr>
                	<td width="300">Pembelian Barang</td><td>:</td>
                    <td>
                    	<input type="radio" name="pembelian_barang" value="0" <?php if($status[7] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="pembelian_barang" value="1" <?php if($status[7] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="pembelian_barang" value="2" <?php if($status[7] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
                <tr>
                	<td>Pembayaran Pembelian</td><td>:</td>
                    <td>
                    	<input type="radio" name="pembayaran_pembelian" value="0" <?php if($status[8] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="pembayaran_pembelian" value="1" <?php if($status[8] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="pembayaran_pembelian" value="2" <?php if($status[8] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section4" class="h3accordion">PENJUALAN</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Penjualan Barang</td><td>:</td>
                    <td>
                    	<input type="radio" name="penjualan_barang" value="0" <?php if($status[9] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="penjualan_barang" value="1" <?php if($status[9] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="penjualan_barang" value="2" <?php if($status[9] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
                <tr>
                	<td>Pembayaran Penjualan</td><td>:</td>
                    <td>
                    	<input type="radio" name="pembayaran_penjualan" value="0" <?php if($status[10] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="pembayaran_penjualan" value="1" <?php if($status[10] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="pembayaran_penjualan" value="2" <?php if($status[10] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section5" class="h3accordion">STOCK BARANG</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Stock Barang</td><td>:</td>
                    <td>
                    	<input type="radio" name="stok_barang" value="0" <?php if($status[11] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="stok_barang" value="1" <?php if($status[11] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="stok_barang" value="2" <?php if($status[11] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section6" class="h3accordion">LAPORAN INVENTORY</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Pembelian</td><td>:</td>
                    <td>
                    	<input type="radio" name="laporan_pembelian" value="0" <?php if($status[12] == 0) echo 'checked="checked"';?> />none
                    	<!-- <input type="radio" name="laporan_pembelian" value="1" <?php #if($status[12] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="laporan_pembelian" value="2" <?php #if($status[12] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi  -->
                    </td>
                </tr>
                <tr>
                	<td>Penjualan</td><td>:</td>
                    <td>
                    	<input type="radio" name="laporan_penjualan" value="0" <?php if($status[13] == 0) echo 'checked="checked"';?> />none
                    	<!-- <input type="radio" name="laporan_penjualan" value="1" <?php #if($status[13] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="laporan_penjualan" value="2" <?php #if($status[13] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi -->
                    </td>
                </tr>
            </table>
        </div>
        
        
        <h3><a href="#section7" class="h3accordion">PAJAK</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Pajak</td><td>:</td>
                    <td>
                    	<input type="radio" name="pajak" value="0" <?php if($status[14] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="pajak" value="1" <?php if($status[14] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="pajak" value="2" <?php if($status[14] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section8" class="h3accordion">DAFTAR COA</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Daftar COA</td><td>:</td>
                    <td>
                    	<input type="radio" name="daftar_coa" value="0" <?php if($status[15] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="daftar_coa" value="1" <?php if($status[15] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="daftar_coa" value="2" <?php if($status[15] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section9" class="h3accordion">TRANSAKSI JURNAL</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Transaksi Jurnal</td><td>:</td>
                    <td>
                    	<input type="radio" name="transaksi_jurnal" value="0" <?php if($status[16] == 0) echo 'checked="checked"';?> />none
                    	<input type="radio" name="transaksi_jurnal" value="1" <?php if($status[16] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="transaksi_jurnal" value="2" <?php if($status[16] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi
                    </td>
                </tr>
            </table>
        </div>
        <h3><a href="#section10" class="h3accordion">LAPORAN ACCOUNTING</a></h3>
		<div>
        	<table>
                <tr>
                	<td width="300">Jurnal</td><td>:</td>
                    <td>
                    	<input type="radio" name="laporan_jurnal" value="0" <?php if($status[17] == 0) echo 'checked="checked"';?> />none
                    	<!-- <input type="radio" name="laporan_pembelian" value="1" <?php #if($status[12] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="laporan_pembelian" value="2" <?php #if($status[12] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi  -->
                    </td>
                </tr>
                <tr>
                	<td width="300">Neraca</td><td>:</td>
                    <td>
                    	<input type="radio" name="laporan_neraca" value="0" <?php if($status[18] == 0) echo 'checked="checked"';?> />none
                    	<!-- <input type="radio" name="laporan_pembelian" value="1" <?php #if($status[12] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="laporan_pembelian" value="2" <?php #if($status[12] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi  -->
                    </td>
                </tr>
                <tr>
                	<td width="300">Rugi Laba</td><td>:</td>
                    <td>
                    	<input type="radio" name="laporan_rugi_laba" value="0" <?php if($status[19] == 0) echo 'checked="checked"';?> />none
                    	<!-- <input type="radio" name="laporan_pembelian" value="1" <?php #if($status[12] == 1) echo 'checked="checked"';?> />Tambah Transaksi
                        <input type="radio" name="laporan_pembelian" value="2" <?php #if($status[12] == 2) echo 'checked="checked"';?> />Tambah &amp; edit Transaksi  -->
                    </td>
                </tr>
            </table>
        </div>
        
    </div>
</div>
    </div>
</div>
