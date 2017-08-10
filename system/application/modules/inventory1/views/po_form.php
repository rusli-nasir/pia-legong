<script>
	$(document).ready(function(){
		
		//autocomplete supplier
		$('#nama_supp').autocomplete("<?php echo base_url();?>index.php/inventory/po/find_supplier", 
			{
				parse: function(data){ 
					var parsed = [];
					for (var i=0; i < data.length; i++) {
						parsed[i] = {
							data: data[i],
							value: data[i].nama_supplier
						};
					}
					return parsed;
				},
				formatItem: function(data,i,max){
					var str = '<div class="search_content">';
					str += '<u>'+data.nama_supplier+'</u>';
					str += '</div>';
					return str;
				},
//				width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
				dataType: 'json'
			}
		).result(
			function(event,data,formated){
				$('#nama_supp').val(data.nama_supplier);
				$('#id_supp').val(data.id_supplier);
			}
		);
		
		//hide row
		var cek = $(this).find('input#index_ke').attr('value');
		$('#trhide').find('tr').hide();
		for(var index=0 ; index<=cek ; index++){
			$('tr.'+index).show();
		}
		
		$('.add').click(function(){
			var arr = $(this).find('input#index_ke').attr('value');
			var ind = Number(arr) + 1;
			$('tr.'+ind).show();
			$('#index_ke').val(ind);
		});
		
		$('span#batal').click(function(){
			var n = $(this).attr('class');
			var m = $('input#index_ke').attr('value');
			while(n < m)
			{
				var tamp_n = Number(n) + 1;
				$('#nama_barang_'+n).val($('#nama_barang_'+tamp_n).val());
				$('#type_barang_'+n).val($('#type_barang_'+tamp_n).val());
				$('#id_barang_'+n).val($('#id_barang_'+tamp_n).val());
				$('#id_satuan_barang_'+n).val($('#id_satuan_barang_'+tamp_n).val());
				$('#id_kuantum'+n).val($('#id_kuantum'+tamp_n).val());
				$('#id_harga_satuan'+n).val($('#id_harga_satuan'+tamp_n).val());
				$('#id_diskon_persen'+n).val($('#id_diskon_persen'+tamp_n).val());
				$('#id_diskon_rupiah'+n).val($('#id_diskon_rupiah'+tamp_n).val());
				$('#id_total_harga_barang'+n).val($('#id_total_harga_barang'+tamp_n).val());
				n = tamp_n;
			}
			
			$('#nama_barang_'+m).val('');
			$('#type_barang_'+m).val('');
			$('#id_barang_'+m).val('');
			$('#id_satuan_barang_'+m).val('');
			$('#id_kuantum'+m).val('');
			$('#id_harga_satuan'+m).val('');
			$('#id_diskon_persen'+m).val('');
			$('#id_diskon_rupiah'+m).val('');
			$('#id_total_harga_barang'+m).val('');
			
			if(m > 0)
			{
				$('tr.'+m).fadeOut();
				$('#index_ke').val(m - 1);
			}
			
			var limit_index = $('#index_ke').val();
			jml_total1 = 0;
			for(i=0; i<=limit_index; i++)
			{
				jml_subtotal = 0;
				var jml_subtotal = $('#id_total_harga_barang'+i).val();
				jml_total = Number(jml_total1) + Number(jml_subtotal);
				jml_total1 = 0;
				jml_total1 = jml_total;
			}
			
			//============ Untuk Jumlah Total ============
			$('#total_po').val(jml_total);
		});
    });
	
	//autocomplete barang
	function nilai(data, arr)
	{
		$(function(){
			$('#nama_barang_'+arr).autocomplete("<?php echo base_url();?>index.php/inventory/po/find_all_barang", 
				{
					parse: function(data){ 
						var parsed = [];
						for (var i=0; i < data.length; i++) {
							parsed[i] = {
								data: data[i],
								value: data[i].nama_barang
							};
						}
						return parsed;
					},
					formatItem: function(data,i,max){
						var str = '<div class="search_content">';
						str += '<u>'+data.nama_barang+'</u>';
						str += '</div>';
						return str;
					},
					width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
					dataType: 'json'
				}
			).result(
				function(event,data,formated){
					$('#nama_barang_'+arr).val(data.nama_barang);
					$('#type_barang_'+arr).val(data.kode_barang);
					$('#id_barang_'+arr).val(data.id_barang);
					$('#id_harga_satuan'+arr).val(data.harga_beli);
		
					detail_count(data.id_barang, arr);
				}
			);
		});
	}
</script>

<?php
	if($data_detail['status'] != 'add')
	{
		// edit mode
        #$atr = array('name' => 'po_form');
		//echo form_open('inventory/po/update_po');
        
        $no_po              = $data_detail['no_po'];
		
		$tglbaru 			= $data_detail['tgl_po'];
		$tgl_po 			= explode_date($tglbaru, 1);
        $no_invoice         = $data_detail['no_invoice'];
        $total_po           = $data_detail['total_po'];
        $nama_karyawan      = $data_detail['nama_karyawan'];
        $id_cara_pembayaran	= $data_detail['id_cara_pembayaran'];
        $keterangan         = $data_detail['keterangan'];
        $id_supplier        = $data_detail['id_supplier'];
        $nama_supplier      = $data_detail['nama_supplier'];
		
	}
	else
	{
		// add mode
        $no_po              = $no_po;
        $tgl_po             = '';
        $no_invoice         = '';
        $total_po           = '';
        $nama_karyawan      = '';
        $id_cara_pembayaran	= '';
        $keterangan         = '';
        $id_supplier        = '';
        $nama_supplier      = '';
        
        //$atr = array('name' => 'po_form');
        //echo form_open('inventory/po/add_po', $atr);
	}
?>
<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div class="cage">
    <div class="icon"></div>
    <h3>Data PO</h3>
    <div class="clear"></div>    
        <table id="data_po_left">
            <tr>
                <td style="width: 150px;">No. PO</td>
                <td><input type="text" name="no_po" value="<?php echo $no_po; ?>"  readonly="1" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Tanggal Transaksi</td>
                <td><input style="color:#0000FF;" type="text" id="datepicker" name="tgl_po" size="10" maxlength="10" readonly="readonly" value="<?php if($tgl_po==''){echo date("d/m/Y");}else{echo $tgl_po;} ?>" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">No. Invoice</td>
                <td><input type="text" name="no_invoice" value="<?php echo $no_invoice; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Total Pembayaran</td>
                <td><input type="text" name="total_po" id="total_po" value="<?php echo $total_po; ?>" readonly="readonly" /></td>
            </tr>
        </table>
        <table id="data_po_right">
            <tr>
                <td style="width: 150px;">PO dilakukan oleh</td>
                <td><input type="text" name="nama_karyawan" value="<?php echo $nama_karyawan; ?>" /></td>
            </tr>
            <tr>
                <td style="width: 150px;">Cara Pembayaran</td>
                <td>
                <select name="id_cara_pembayaran" id="update_id_cara_pembayaran">
                    <?php
                        foreach($cara_bayar->result_array() as $carabayar)
						{
				            if($id_cara_pembayaran==$carabayar['id_cara_pembayaran'])
                            {
							     ?>
							         <option value="<?php echo $carabayar['id_cara_pembayaran']; ?>" selected="1"><?php echo $carabayar['nama_cara_pembayaran']; ?></option> 
							     <?php
                            }
                            else
                            {
                                ?>
                                    <option value="<?php echo $carabayar['id_cara_pembayaran']; ?>"><?php echo $carabayar['nama_cara_pembayaran']; ?></option>
                                <?php
                            }
                        }
				    ?>
                </select>
                </td>
            </tr>
            <tr>
                <td style="width: 150px;">Keterangan</td>
                <td><input type="text" name="keterangan" value="<?php echo $keterangan; ?>" /></td>
            </tr>
        </table>
        <div class="clear"></div>
</div>
<div class="">
    <div class="icon"></div>
    <h3>Data Barang</h3>
    <div class="clear"></div>
        <table id="data_po_left">
            <tr>
                <td style="width: 150px;">Supplier</td>
                <td>
                	<input type="text" name="nama_supplier" id="nama_supp" value="<?php echo $nama_supplier; ?>" />
                    <input type="hidden" name="id_supplier" id="id_supp" value="<?php echo $id_supplier; ?>" />
				</td>
            </tr>
        </table>
    <div class="clear"></div>
    <fieldset style="border: 1px solid #CCC; padding: 20px 20px; margin-top: 10px;">
        <legend>Daftar Barang</legend>
            <table id="gridview">
                <thead>
                <tr>
                    <td class="labels">Nama Barang</td>
                    <td class="labels">Satuan</td>
                    <td class="labels">Type Barang</td>
                    <td class="labels">Kuantum</td>
                    <td class="labels">Harga Satuan</td>
                    <td class="labels">Diskon(%)</td>
                    <td class="labels">Diskon(RP)</td>
                    <td class="labels">Total</td>
                    <td class="labels">Batal</td>
                </tr>
                </thead>
                <tbody id="trhide">
                <?php
				$i=0;
				$brs=0;
				foreach($data_detail_po as $recordsetdetail)
                {
				?>
                <tr class="<?php echo $brs;?>">
                	<input type="hidden" name=id_detail_po[] id="id_detail_po_<?php echo $brs;?>" value="<?php echo $recordsetdetail['id_detail_po'];?>" />
                    <input type="hidden" name=id_barang[] id="id_barang_<?php echo $brs;?>" value="<?php echo $recordsetdetail['id_barang'];?>" />
                    <td class="labelss"><input type="text" name=nama_barang[] id="nama_barang_<?php echo $brs;?>" value="<?php echo $recordsetdetail['nama_barang'];?>" onclick="nilai(this.value, <?php echo $brs;?>)" /></td>
                    <td class="labelss">
                        <select name=id_satuan_barang[] id="id_satuan_barang_<?php echo $brs;?>">
                            <option value="0">.:Satuan:.</option>
                            <?php
							foreach($satuan_barang->result_array() as $satuanbarang)
							{
								if($recordsetdetail['id_satuan_barang']==$satuanbarang['id_satuan_barang'])
								{
									?>
									<option value="<?php echo $satuanbarang['id_satuan_barang'];?>" selected="selected"><?php echo $satuanbarang['kode_satuan'];?></option>
									<?php
								}
								else
								{
									?>
									<option value="<?php echo $satuanbarang['id_satuan_barang'];?>"><?php echo $satuanbarang['kode_satuan'];?></option>
									<?php
								}
							}
        				    ?>
                        </select>
                    </td>
                    <td class="labelss"><input type="text" name=type_barang[] id="type_barang_<?php echo $brs;?>" value="<?php echo $recordsetdetail['kode_barang'];?>" readonly="readonly"/></td>
                    <td class="labelss"><input type="text" name=kuantum[] id="id_kuantum<?php echo $brs;?>" value="<?php echo round($recordsetdetail['kuantum'],5);?>" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=harga_satuan[] id="id_harga_satuan<?php echo $brs;?>" value="<?php echo round($recordsetdetail['harga_satuan'],5);?>" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" readonly="readonly" /></td>
                    <td class="labelss"><input type="text" name=diskon_persen[] id="id_diskon_persen<?php echo $brs;?>" value="<?php echo round($recordsetdetail['diskon_persen'],5);?>" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=diskon_rupiah[] id="id_diskon_rupiah<?php echo $brs;?>" value="<?php echo round($recordsetdetail['diskon_rupiah'],5);?>" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=total_harga[] id="id_total_harga_barang<?php echo $brs;?>" value="<?php echo round($recordsetdetail['total_harga'],5);?>" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><a href="javascript:void(0)"><span id="batal" class="<?php echo $brs;?>" style="display:block">Batal</span></a></td>
                </tr>
                <?php
				$i++;
				$brs++;
				}
				
				for($ind=$brs ; $ind<=50 ; $ind++)
				{?>
                <tr class="<?php echo $ind;?>">
                	<input type="hidden" name=id_detail_po[] id="id_detail_po_<?php echo $ind;?>" value="" />
                    <input type="hidden" name=id_barang[] id="id_barang_<?php echo $ind;?>" value="" />
                    <td class="labelss"><input type="text" name=nama_barang[] id="nama_barang_<?php echo $ind;?>" value="" onclick="nilai(this.value, <?php echo $ind;?>)" /></td>
                    <td class="labelss">
                        <select name=id_satuan_barang[] id="id_satuan_barang_<?php echo $ind;?>">
                            <option selected="" value="0">.:Satuan:.</option>
                            <?php
							foreach($satuan_barang->result_array() as $satuanbarang)
							{
								?>
								<option value="<?php echo $satuanbarang['id_satuan_barang'];?>"><?php echo $satuanbarang['kode_satuan'];?></option>
								<?php
							}
							?>
                        </select>
                    </td>
                    <td class="labelss"><input type="text" name=type_barang[] id="type_barang_<?php echo $ind;?>" value="" readonly="readonly" /></td>
                    <td class="labelss"><input type="text" name=kuantum[] id="id_kuantum<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=harga_satuan[] id="id_harga_satuan<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" readonly="readonly" /></td>
                    <td class="labelss"><input type="text" name=diskon_persen[] id="id_diskon_persen<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=diskon_rupiah[] id="id_diskon_rupiah<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><input type="text" name=total_harga[] id="id_total_harga_barang<?php echo $ind;?>" value="" onkeyup="detail_count(this.value, <?php echo $i;?>)" onkeypress="return checkIt(event)" /></td>
                    <td class="labelss"><a href="javascript:void(0)"><span id="batal" class="<?php echo $ind;?>" style="display:block">Batal</span></a></td>
                </tr>
				<?php
				$i++;
				}?>
                </tbody>
            </table>
            <div class="add">
                <input type="hidden" name="index" id="index_ke" value="<?php echo $brs;?>">
                <a href="javascript:void(0)">+</a>
            </div>
    </fieldset>
</div>
<?php //echo form_close();?>
<script>
	function detail_count(thisval, arrval)
	{
		$(document).ready(function(){
			var id_barang			= $('#id_barang_'+arrval).val();
			var id_kuantum			= $('#id_kuantum'+arrval).val();
			var id_harga_satuan		= $('#id_harga_satuan'+arrval).val();
			var id_diskon_persen	= $('#id_diskon_persen'+arrval).val();
			var id_diskon_rupiah    = $('#id_diskon_rupiah'+arrval).val();
			
			hrg_per_item = id_harga_satuan;
			if(id_diskon_persen>0)
			{
				hrg_diskon = (id_diskon_persen/100) * id_harga_satuan;
				hrg_per_item = id_harga_satuan - hrg_diskon;
				$('#id_diskon_rupiah'+arrval).val('');
			}
			if(id_diskon_rupiah>0)
			{
				hrg_diskon = id_harga_satuan - id_diskon_rupiah;
				hrg_per_item = hrg_diskon;
				$('#id_diskon_persen'+arrval).val('');
			}
			sub_total = id_kuantum * hrg_per_item;
			
			$('#id_total_harga_barang'+arrval).val(sub_total);
			
			var limit_index = $('#index_ke').val();
			jml_total1 = 0;
			for(i=0; i<=limit_index; i++)
			{
				jml_subtotal = 0;
				var jml_subtotal = $('#id_total_harga_barang'+i).val();
				//if(id_barang!='')
				//{
					jml_total = Number(jml_total1) + Number(jml_subtotal);
					jml_total1 = 0;
					jml_total1 = jml_total;
				//}
			}
			
			//============ Untuk Jumlah Total ============
			//if(id_barang!='')
			$('#total_po').val(jml_total);
		});
	}
</script>
