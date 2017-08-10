<span id="image_calendar" style="display:none"><?php echo base_url().'image/calendar.gif';?></span>
<div <?php echo isset ($active_menu) ? $active_menu :''?> id="menu_form_po">
    <ul>
        <li id="tab_form_delete_system"><a href="">Hapus Data Sistem</a></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="content_form_po">
    <div class="">
    <table>
    	<tr>
       	  <td>
            <p><b><font color="#FF0033">PERINGATAN</font></b></p>
            <p>
            	Perlu diperhatikan dengan baik pemilihan tanggal untuk periode waktu data sistem yang akan dihapus. <br />
                Data yang telah dihapus tidak dapat dikembalikan lagi.
            </p>
            </td>
        </tr>
	</table>
    <table style="margin-top:10px;">
        <tr>
            <td style="width: 150px;">Tanggal Awal</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker" name="date_first" size="10" maxlength="10" readonly="readonly" value="<?php 
                echo $date;?>" /></td>
        </tr>
        <tr>
        	<td align="right">Sampai</td>
        </tr>
        <tr>
            <td style="width: 150px;">Tanggal Akhir</td>
            <td><input style="color:#0000FF;" type="text" id="datepicker2" name="date_last" size="10" maxlength="10" readonly="readonly" value="<?php 
                echo $date;?>" /></td>
        </tr>
        <tr>
			<td><input type="submit" class="button_delete" name="submit_delete" value="Hapus" /></td>
        </tr>
    </table>
    </div>
</div>