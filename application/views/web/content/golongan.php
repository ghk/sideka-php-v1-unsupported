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
	<tr>	
	    <td align="center" width="2">1</td>
		<td align="center">A</td>
		
		<td align="center"><?php 
		echo $dataA;
		?></td>
		
		<td align="center"><?php 
		echo $dataAL;
		?></td>
		<td align="center"><?php 
		echo $dataAP;
		?></td>
	<tr>
	
	<tr style = "background-color : #FBF9FF">	
	    <td align="center" width="2">2</td>
		<td align="center">B</td>
		
		<td align="center"><?php 
		echo $dataB;
		?></td>
		
		<td align="center"><?php 
		echo $dataBL;
		?></td>
		<td align="center"><?php 
		echo $dataBP;
		?></td>
	<tr>
	
	<tr>	
	    <td align="center" width="2">3</td>
		<td align="center">AB</td>
		
		<td align="center"><?php 
		echo $dataAB;
		?></td>
		
		<td align="center"><?php 
		echo $dataABL;
		?></td>
		<td align="center"><?php 
		echo $dataABP;
		?></td>
	<tr>
	
	<tr style = "background-color : #FBF9FF">	
	    <td align="center" width="2">4</td>
		<td align="center">O</td>
		
		<td align="center"><?php 
		echo $dataO;
		?></td>
		
		<td align="center"><?php 
		echo $dataOL;
		?></td>
		<td align="center"><?php 
		echo $dataOP;
		?></td>
	<tr>
	
	
	
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