<div id="container" style="min-width: 400px; height: 550px; margin: 0 auto;">
</div>

<div id= "detail" style= "background :#FFF; ">
<style>
table
{
	 border-top : 2px solid #DDB791;
	 padding-top : 5px;
}
table,th,td
{
	color : black;	
	margin : 0px 5px 0px 5px;
}
th
{
	border:1px solid #EFEDFC;
	background-color : #0099CC;
	
}
tr
{
	border:1px solid #EFEDFC;
}
</style>
<table>
	<tr>
		<th align="center" width="80">No</th>
		<th align="center" width="300">Statistik</th>
		<th align="center" width="200">Jumlah</th>
		<th align="center" width="200">Laki-Laki</th>
		<th align="center" width="200">Perempuan</th>
	</tr>
	

	<?php 
	$count = 0;
	 foreach ($rows as $row)
		{
			$count ++;
			echo'
			<tr style = "background-color : #FBF9FF">	
				<td align="center" width="2">'.$count.'</td>
				<td align="center">'.$row->deskripsi.'</td>
				
				<td align="center">'.$jumlahGolDar[$count-1].'</td>
				
				<td align="center">'.$jumlahGolDarLaki[$count-1].'</td>	
				<td align="center">'.$jumlahGolDarPerempuan[$count-1].'</td>
			<tr>
			';
           //echo $row->deskripsi;			
		}
	?>
	
	
	<tr style = "font-weight : bold">
		<td align = "center" width="2">Jumlah</td>
		<td></td>
		
		<td align = "center"><?php 
		echo $jumlah;
		?></td>
		
		<td align = "center"><?php 
		echo $dataL;
		?></td>
		
		<td align = "center"><?php 
		echo $dataP;
		?></td>
	</tr>
</table>
<br>
<br>
<br>
</div>