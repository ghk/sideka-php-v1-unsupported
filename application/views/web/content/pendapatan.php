<div class="row">

	<div id="containerpiependapatan" style="height: 550px; margin: 0 auto;" class="col-md-6">
	</div>

	<div id="containerpiebelanja" style="height: 550px; margin: 0 auto;" class="col-md-6">
	</div>

	<div id="containerstackpendapatan" style="height: 550px; margin: 0 auto;" class="col-md-6">
	</div>

	<div id="containerstackbelanja" style="height: 550px; margin: 0 auto;" class="col-md-6">
	</div>

	<div id="containerbasicpendapatan" style="height: 550px; margin: 0 auto;" class="col-md-12">
	</div>

	<div id="containerbasicbelanja" style="height: 550px; margin: 0 auto;" class="col-md-12">
	</div>

</div>

<p></p><hr/>
<h2><span>Statistik</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
	<tr style = "background-color : #F6F2FC">
		<th width="2%" align="center">No</th>
		<th width="30%" style="text-align:center;">nama</th>
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
				<td style="text-align:center;">'.$row->nama.'</td>
			<tr>
			';
	}

	?>

</table>