<p></p><hr/>
<h2 align="center">Anggaran <?php echo $type; ?> Desa 2015</h2>
<table class="table table-bordered" style="width:100%">
	<tr style = "background-color : #F6F2FC">
		<th width="10%" style="text-align:left;">Kode Anggaran</th>
		<th width="40%" style="text-align:left;">Nama</th>
		<th width="20%" style="text-align:right;">Jumlah</th>
		<th width="20%" style="text-align:left;">Keterangan</th>
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
		$font = 'normal;';
		$nomor = $row->nomor;
		$jumlah = $row->jumlah;
		if($jumlah == 0)
			$jumlah = '-';
		else
			$jumlah = number_format($jumlah, 0, ',', '.');
		if(substr_count($row->nomor, '.') == 1) {
			$font = 'bold';
		} else {
			for ($i = 0; $i < substr_count($nomor, '.'); $i++){
				$nomor = '&nbsp;'.$nomor;
			}
		}
		echo'
			<tr style = "background-color : '.$warna.'; font-weight: '.$font.'">
				<td style="text-align:left;">'.$nomor.'</td>
				<td style="text-align:left;">'.$row->nama.'</td>
				<td style="text-align:right;">'.$jumlah.'</td>
				<td style="text-align:left;">'.$row->keterangan.'</td>
			<tr>
			';

		$totalJumlah = $totalJumlah + $row->jumlah;
	}

	?>

	<tr style = "background-color : #F6F2FC">
		<td style="text-align:left;">Total</td>
		<td style="text-align:center;"></td>
		<td style="text-align:right;"><?php echo number_format($totalJumlah);	?></td>
		<td style="text-align:center;"></td>

	</tr>
</table>
