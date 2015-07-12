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
		<td align="center">KAWIN</td>
		
		<td align="center"><?php 
		echo $dataK;
		?></td>
		
		<td align="center"><?php 
		echo $dataKL;
		?></td>
		<td align="center"><?php 
		echo $dataKP;
		?></td>
	<tr>
	
	<tr style = "background-color : #FBF9FF">	
	    <td align="center" width="2">2</td>
		<td align="center">BELUM KAWIN</td>
		
		<td align="center"><?php 
		echo $dataBK;
		?></td>
		
		<td align="center"><?php 
		echo $dataBKL;
		?></td>
		<td align="center"><?php 
		echo $dataBKP;
		?></td>
	<tr>
	
	<tr>	
	    <td align="center" width="2">3</td>
		<td align="center">CERAI MATI</td>
		
		<td align="center"><?php 
		echo $dataCM;
		?></td>
		
		<td align="center"><?php 
		echo $dataCML;
		?></td>
		<td align="center"><?php 
		echo $dataCMP;
		?></td>
	<tr>
	
	<tr style = "background-color : #FBF9FF">	
	    <td align="center" width="2">4</td>
		<td align="center">CERAI HIDUP</td>
		
		<td align="center"><?php 
		echo $dataCH;
		?></td>
		
		<td align="center"><?php 
		echo $dataCHL;
		?></td>
		<td align="center"><?php 
		echo $dataCHP;
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