<div id="container" style="min-width: 400px; height: 550px; margin: 0 auto;">
</div>


<p></p><hr/>    
<h2><span>Statistik</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
    <tr style = "background-color : #F6F2FC">
        <th width="20" align="center">No</th>
        <th style="text-align:center;">Statistik</th>			
        <th style="text-align:center;">Anak Laki Laki Gizi Buruk</th>		
        <th style="text-align:center;">Anak Perempuan Gizi Buruk</th>
        <th style="text-align:center;">Jumlah Anak Gizi Buruk</th>	
		
    </tr>
	
	<tr style = "background-color : #FBF9FF">	
		<td>1</td>
		<td style="text-align:center;">0-4 tahun</td>
		<td style="text-align:center;"><?php echo $jumlah_gizi_buruk_laki_0_4  ;?></td>
		<td style="text-align:center;"><?php echo $jumlah_gizi_buruk_perempuan_0_4  ;?></td>		
		<td style="text-align:center;"><?php echo $jumlah_gizi_buruk_0_4  ;?></td>	
	<tr>
	<tr style = "background-color : #FDFBFF">	
		<td>2</td>
		<td style="text-align:center;">5-9 tahun</td>
		
		<td style="text-align:center;"><?php echo $jumlah_gizi_buruk_laki_5_9  ;?></td>
		<td style="text-align:center;"><?php echo $jumlah_gizi_buruk_perempuan_5_9  ;?></td>
		<td style="text-align:center;"><?php echo $jumlah_gizi_buruk_5_9  ;?></td>
	<tr>
                 
	<tr style = "background-color : #F6F2FC">
	  <td colspan="2" style="text-align:right;">Total Anak</td>
	  
	  <td style="text-align:center;"><?php echo $total_anak_gizi_buruk_laki;	?></td>
	  <td style="text-align:center;"><?php echo $total_anak_gizi_buruk_perempuan;	?></td>
	  <td style="text-align:center;"><?php echo $total_anak_gizi_buruk;	?></td>
	</tr>
</table>
