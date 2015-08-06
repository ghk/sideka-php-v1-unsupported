<p></p><hr/>
<h2 align="center">Anggaran <?php echo $type; ?> Desa 2015</h2>
<table class="table table-bordered" style="width:100%">
	<tr style = "background-color : #F6F2FC">
		<th width="10%" style="text-align:left;">Kode Anggaran</th>
		<th width="20%" style="text-align:left;">Nama</th>
		<th width="20%" style="text-align:right;">Jumlah</th>
		<th width="30%" style="text-align:left;">Keterangan</th>
	</tr>

	<?php
	$rows = $result;
	$count = 0;
	$totalLaki = 0;
	$totalPerempuan = 0;
	$total = 0;
	$totalJumlah = 0;
	$warna = '';

	foreach($rows as $row)
	{
		$count++;
		if($count%2==0){$warna='#FDFBFF';}
		else{$warna='#FBF9FF';}
		echo'
			<tr style = "background-color : '.$warna.'">
				<td style="text-align:left;">'.$row->nomor.'</td>
				<td style="text-align:left;">'.$row->nama.'</td>
				<td style="text-align:right;">'.$row->jumlah.'</td>
				<td style="text-align:left;">'.$row->keterangan.'</td>
			<tr>
			';

		$totalJumlah = $totalJumlah + $row->jumlah;
	}

	?>

	<tr style = "background-color : #F6F2FC">
		<td style="text-align:left;">Total</td>
		<td style="text-align:center;"></td>
		<td style="text-align:right;"><?php echo $totalJumlah;	?></td>
		<td style="text-align:center;"></td>

	</tr>
</table>
