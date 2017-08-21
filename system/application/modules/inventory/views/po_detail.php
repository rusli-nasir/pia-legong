<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="">
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Pemesanan Harian</legend>
        <table style="width: 100%">
            <tr>
                <td style="width: 150px;">Tanggal Transaksi</td>
                <td>
                    <input style="color:#0000FF;" type="text" id="datepicker" name="tgl_po" size="10" maxlength="10" readonly="readonly" value="<?php
				    echo explode_date($date,1);?>" />
                </td>
                <td width="50px" style="text-align:right;">
                    <a href="javascript:void(0);" onclick="print_po();">
                        <img src="<?php echo base_url().'image/print_icon.png'; ?>" width="30" />
                    </a>
                </td>
                <td style="text-align:right;">
                    Jenis Pemesanan
		            <?php
		            $arrpesanan = array_jenis_pesanan();
		            echo form_dropdown('via_pemesanan',$arrpesanan,$filter,"id='via_pemesanan' class='cari_data'");
		            ?>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table id="gridview">
            <thead>
            <tr>
                <td class="labels_dpo" style="width:100px;">No</td>
                <td class="labels_dpo" style="width:100px !important;">Tgl Pesan</td>
                <td class="labels_dpo" style="width:250px !important;">Nama Customer</td>
                <td class="labels_dpo" style="width:130px;">Phone</td>
                <td class="labels_dpo" style="width:150px;">Email</td>
                <td class="labels_dpo">Total<br /> Transaksi</td>
                <td class="labels_dpo" style="width:150px;">Tgl Diambil</td>
                <td class="labels_dpo">Keterangan</td>
            </tr>
            </thead>
        </table>
        <div id="scrollable" class="yui3-scrollview-loading">
            <table id="gridview">
                <?php
                $i = 1;
                $totalTransaksi = 0;
                if($daftar_list_po){
                    foreach ($daftar_list_po as $row){
	                    ?>
                        <tr class="isi_list">
                            <td class="labelss_dpo" style="width:100px;"><?php echo $i?></td>
                            <td class="labelss_dpo" style="width:100px !important;"><?php
	                            $tmp = explode_date($row->tanggal_pesan, 1);
	                            $arr_date = explode('/', $tmp);
	                            $tgl_pesan = $arr_date[0].'-'.$arr_date[1];
	                            if($tgl_pesan=='00-00'){
		                            $tgl_pesan = '';
	                            }
	                            echo $tgl_pesan;
                                ?></td>
                            <td class="labelss_dpo" style="width:250px !important;"><?php echo $row->nama_customer?></td>
                            <td class="labelss_dpo" style="width:130px;"><?php echo $row->telepon?></td>
                            <td class="labelss_dpo" style="width:150px;"><?php echo $row->email?></td>
                            <td class="labelss_dpo" style="text-align: right !important; padding-right: 10px">
                                <?php echo number_format($row->jumlah_bayar,2,',','.')?>
<!--                        <a href="javascript:void(0)" onclick="detail_po('<?php //echo $row->no_po;?>//')"><span style="display:block">Detail</span></a>
                                -->

                            </td>
                            <td class="labelss_dpo" style="width:150px;"><?php echo ($row->is_diambil)? date('d-m-Y', strtotime($row->tgl_diambil)):'Belum diambil'?></td>
                            <td class="labelss_dpo"><?php echo get_jenis_pesanan($row->via_pemesanan)?></td>
                        </tr>
                        <tr>
                            <td class="labelss_dpo" colspan="8">
                                <h3>Detail PO</h3>
                                <?php
                                    $detailPo = $this->model_po->get_detail_po($row->no_po)->result();
                                    if($detailPo){
	                                    ?>
                                        <table width="100%">
                                            <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Sub Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($detailPo as $row_data){
                                                ?>
                                                <tr>
                                                    <td class="labelss_dpo"><?php
	                                                    $nama_barang = get_nama_barang($row_data->nama_barang);
	                                                    echo $nama_barang['jenis'] . ' ' . $nama_barang['jenis_detail'];
                                                        ?></td>
                                                    <td class="labelss_dpo"><?php echo number_format($row_data->stok_pesan,2,',','.')?></td>
                                                    <td class="labelss_dpo"><?php echo number_format($row_data->harga_barang,2,',','.')?></td>
                                                    <td class="labelss_dpo"><?php echo number_format($row_data->total_harga,2,',','.')?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
	                                    <?php
                                    }
                                ?>
                            </td>
                        </tr>
	                    <?php
                        $totalTransaksi +=$row->jumlah_bayar;
                        $i++;
                    }
                }
                ?>

            </table>
        </div>
        <table id="gridview" style="width: 100%">
            <thead>
            <tr>
                <td class="labels_dpo" style="width:120px;">Total</td>
                <td class="labels_dpo" colspan="6"><?php echo number_format($totalTransaksi,2,',','.')?></td>
            </tr>
            </thead>
        </table>
    </fieldset>
</div>

<!--View Detail Data Pemesanan-->
<div id="dialog-detail" title="">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        DETAIL PEMESANAN
    </p>
    <table>
        <tr>
            <td style="width: 150px;">No. Pemesanan</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="no_po" size="25" readonly="readonly" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Nama Customer</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="nama_customer" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Telepon / HP</td><td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="telepon" size="25" readonly="readonly" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Total Harga</td>
            <td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="jumlah_bayar" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td><input type="text" id="telepon_2" size="25" readonly="readonly" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Status Pengambilan</td>
            <td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="is_diambil" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td><input type="text" id="telepon_3" size="25" readonly="readonly" /></td>
            <td style="width: 50px;">&nbsp;</td>
            <td style="width: 150px;">Tanggal ambil</td>
            <td>&nbsp;</td>
            <td>:</td><td>&nbsp;</td>
            <td><input type="text" id="tgl_diambil" size="25" readonly="readonly" /></td>
        </tr>
        <tr>
            <td colspan="4">Email</td>
            <td><input type="text" id="email" size="25" readonly="readonly" /></td>
        </tr>

    </table>
    <table id="tabel_detail">
    </table>
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
        $( "#datepicker" ).change(function(){
            cari_data();
        });

        $( "#via_pemesanan" ).change(function(){
            cari_data();
        });

        $( "#dialog-detail" ).dialog({
            autoOpen: false,
            resizable: false,
            height: 380,
            width: 600,
            modal: true,
            closeOnEscape: false,
            buttons: {
            },
        });
    });

    function print_po(no_po){
        var tgl = $('#datepicker').val();
        var via_pemesanan = $('#via_pemesanan').val();
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('inventory/po/print_pemesanan_harian');?>",
            data: {
                tanggal: tgl,
                via: via_pemesanan,
            },
            cache: false,
            success: function(data){
                console.log(data);
                var mywindow = window.open('', 'my div', 'height=400,width=600');
                mywindow.document.write('<html><head><title>Laporan Pemesanan Harian</title>');
                /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
                mywindow.document.write('</head><body>');
                mywindow.document.write(data);
                mywindow.document.write('</body></html>');

//                mywindow.print();
//                mywindow.close();
            }
        });
    }

    //View Detail Pemesanan
    function detail_po(no_po)
    {
        find_po(no_po);

        $( "#dialog-detail" ).dialog({
            title: 'Data Detail Pemesanan'
        });
        $( "#dialog-detail" ).dialog( "open" );
    }

    function find_po(no_po)
    {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url();?>index.php/inventory/po/find_po",
            data: "no_po="+no_po,
            cache: false,
            success: function(data){
                get_data(data);
            }
        });
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url();?>index.php/inventory/po/find_po_detail",
            data: "no_po="+no_po,
            cache: false,
            success: function(data){
                get_data_detail(data);
            }
        });
    }

    function get_data_detail(mydata)
    {
        $("#tabel_detail").html(mydata);
    }

    function get_data(mydata)
    {
        var dataArr 				= mydata.split(",");
        console.log(dataArr);
        var no_po 					= dataArr[0];
        var tanggal_po 				= dataArr[1];
        var nama_customer			= dataArr[2];
        var telepon 				= dataArr[3];
        var jumlah_bayar			= dataArr[4];
        var nama_cara_pembayaran 	= dataArr[5];
        var telepon_2	 			= dataArr[6];
        var telepon_3	 			= dataArr[7];
        var email	 			= dataArr[8];
        var tgl_diambil	 			= dataArr[9];
        var is_diambil	 			= dataArr[10];

        $(document).ready(function(){
            $("#no_po").val(no_po);
            $("#tgl_po").val(tanggal_po);
            $("#nama_customer").val(nama_customer);
            $("#telepon").val(telepon);
            $("#telepon_2").val(telepon_2);
            $("#telepon_3").val(telepon_3);
            $("#email").val(email);
            $("#jumlah_bayar").val(jumlah_bayar);
            $("#tgl_diambil").val(tgl_diambil);
            if(is_diambil === 1 ){
                $("#is_diambil").val("Sudah diambil");
            }else{
                $("#is_diambil").val("Belum diambil");
            }

        });
    }

    function cari_data() {
        String.prototype.replaceAll = function(search, replacement) {
            var target = this;
            return target.split(search).join(replacement);
        };
        var tgl 	= $('#datepicker').val();
//        tgl = tgl.replaceAll("/",'-',);
        var via 	= $('#via_pemesanan').val();
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url();?>index.php/inventory/po/view_detail_pemesanan",
            data: {
                tanggal: tgl,
                filter: via
            },
            cache: false,
            success: function(data){
                window.location.href=data;
            }
        });
    }

</script>