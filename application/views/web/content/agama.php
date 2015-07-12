<div id="container" style="min-width: 400px; height: 550px; margin: 0 auto;">
</div>


<p></p><hr/>    
<h2><span>Statistik</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
    <tr style = "background-color : #F6F2FC">
        <th width="2%" align="center">No</th>
        <th width="30%" style="text-align:center;">Statistik</th>		
        <th width="10%" style="text-align:center;">Laki-Laki</th>		
        <th width="10%" style="text-align:center;">Perempuan</th>
        <th width="10%" style="text-align:center;">Jumlah Penduduk</th>
    </tr>
	
	<?php
		$rows = $result;
		$count = 0;
		$totalLaki = 0;
		$totalPerempuan = 0;
		$total = 0;
		$warna = '';
		foreach($rows as $row)
		{
			$count++;
			if($count%2==0){$warna='#FDFBFF';}
			else{$warna='#FBF9FF';}
			echo'
			<tr style = "background-color : '.$warna.'">	
				<td>'.$count.'</td>
				<td style="text-align:center;">'.$row->jenis.'</td>				
				<td style="text-align:center;">'.$row->laki.'</td>
				<td style="text-align:center;">'.$row->perempuan.'</td>
				<td style="text-align:center;">'.$row->jumlah.'</td>
			<tr>
			';	
			$totalLaki = $totalLaki + $row->laki;		
			$totalPerempuan = $totalPerempuan + $row->perempuan;		
					
		}
	?>
	                 
	<tr style = "background-color : #F6F2FC">
	  <td colspan="2" style="text-align:right;">Total</td>
	  <td style="text-align:center;"><?php echo $totalLaki;	?></td>
	  <td style="text-align:center;"><?php echo $totalPerempuan;?></td>
	  <td style="text-align:center;"><?php echo $totalLaki+$totalPerempuan;	?></td>
	</tr>
</table>
