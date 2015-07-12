<div id="container" style="min-width: 400px; height: 550px; margin: 0 auto;">
</div>


<p></p><hr/>    
<h2><span>Statistik</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
    <tr style = "background-color : #F6F2FC">
        <th width="20" align="center">No</th>
        <th width="50%" style="text-align:center;">Statistik</th>
        <th width="50%" style="text-align:center;">Jumlah Penerima Bantuan Siswa Miskin</th>
    </tr>
	
	<tr style = "background-color : #FBF9FF">	
		<td>1</td>
		<td style="text-align:center;">Laki	Laki</td>
		<td style="text-align:center;"><?php echo $jumlah_bsm_laki  ;?></td>
	<tr>
	<tr style = "background-color : #FDFBFF">	
		<td>2</td>
		<td style="text-align:center;">Perempuan</td>
		<td style="text-align:center;"><?php echo $jumlah_bsm_perempuan  ;?></td>
	<tr>
                 
	<tr style = "background-color : #F6F2FC">
	  <td colspan="2" style="text-align:right;">Total Siswa</td>
	  <td style="text-align:center;"><?php echo $total_bsm;	?></td>
	</tr>
</table>
