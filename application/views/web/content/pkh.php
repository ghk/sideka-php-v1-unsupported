<div id="container" style="min-width: 400px; height: 550px; margin: 0 auto;">
</div>


<p></p><hr/>    
<h2><span>Statistik</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
    <tr style = "background-color : #F6F2FC">
        <th width="1%" align="center">No</th>
        <th width="30%" style="text-align:center;">Statistik</th>
        <th width="30%" style="text-align:center;">Menerima Program Keluarga Harapan</th>
        <th width="30%" style="text-align:center;">Jumlah Kepala Keluarga</th>
    </tr>
	
	<tr style = "background-color : #FBF9FF">	
		<td>1</td>
		<td style="text-align:center;">Sangat Miskin</td>
		<td style="text-align:center;"><?php echo $menerimaSangatMiskin  ;?></td>
		<td style="text-align:center;"><?php echo $totalSangatMiskin  ;?></td>
	<tr>
	<tr style = "background-color : #FDFBFF">	
		<td>2</td>
		<td style="text-align:center;">Miskin</td>
		<td style="text-align:center;"><?php echo $menerimaMiskin  ;?></td>
		<td style="text-align:center;"><?php echo $totalMiskin  ;?></td>
	<tr>
	<tr style = "background-color : #FBF9FF">	
		<td>3</td>
		<td style="text-align:center;">Sedang</td>
		<td style="text-align:center;"><?php echo $menerimaSedang  ;?></td>
		<td style="text-align:center;"><?php echo $totalSedang  ;?></td>
	<tr>
	<tr style = "background-color : #FDFBFF">	
		<td>4</td>
		<td style="text-align:center;">Kaya</td>
		<td style="text-align:center;"><?php echo $menerimaKaya  ;?></td>
		<td style="text-align:center;"><?php echo $totalKaya  ;?></td>
	<tr>
                 
	<tr style = "background-color : #F6F2FC">
	  <td colspan="2" style="text-align:right;">Total Kepala Keluarga</td>	  
	  <td style="text-align:center;"><?php echo $menerimaSangatMiskin+$menerimaMiskin+$menerimaSedang+$menerimaKaya;	?></td>
	  <td style="text-align:center;"><?php echo $totalKepalaKeluarga;	?></td>
	</tr>
</table>
