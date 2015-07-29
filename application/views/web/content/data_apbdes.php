<p></p><hr/>
<h2 align="center"><span>Data Anggaran Pendapatan dan Belanja Desa</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
	<tr style = "background-color : #F6F2FC">
		<th width="2%" align="center">No</th>
		<th width="10%" style="text-align:center;">Nomor Anggaran</th>
		<th width="10%" style="text-align:center;">Nama</th>
		<th width="30%" style="text-align:center;">Jumlah</th>
		<th width="10%" style="text-align:center;">Keterangan</th>
		<th width="10%" style="text-align:center;">Tipe APBDes</th>
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
				<td>'.$count.'</td>
				<td style="text-align:center;">'.$row->nomor.'</td>
				<td style="text-align:center;">'.$row->nama.'</td>
				<td style="text-align:center;">'.$row->jumlah.'</td>
				<td style="text-align:center;">'.$row->keterangan.'</td>
				<td style="text-align:center;">'.($row->tipe_apbdes > 0 ? "Belanja" : "Pendapatan").'</td>
			<tr>
			';

		$totalJumlah = $totalJumlah + $row->jumlah;
	}

	?>

	<tr style = "background-color : #F6F2FC">
		<td colspan="2" style="text-align:center;">Total</td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;"><?php echo $totalJumlah;	?></td>
		<td style="text-align:center;"></td>
		<td style="text-align:center;"></td>

	</tr>
</table>