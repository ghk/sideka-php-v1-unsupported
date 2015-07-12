<div id="container" style="min-width: 400px; height: 550px; margin: 0 auto;">
</div>


<p></p><hr/>    
<h2><span>Statistik</span> dalam Tabel</h2>
<table class="table table-bordered" style="width:100%">
    <tr style = "background-color : #F6F2FC">
        <th width="1%" align="center">No</th>
        <th width="30%" style="text-align:center;">Kelompok Umur</th>
        <th width="20%" style="text-align:center;">Laki-Laki</th>
        <th width="20%" style="text-align:center;">Perempuan</th>
        <th width="20%" style="text-align:center;">Jumlah</th>
    </tr>
	
        	<?php 
			$count = 0;
			$countIndex = 0;
			$umurA = 0;
			$umurB = 4;
			$countLaki = 0;
			$countPerempuan = 0;
			$warna = '';
			
			 foreach ($dataLaki as $row)
				{
					$count ++;
					if($count%2==0){$warna='#FDFBFF';}
					else{$warna='#FBF9FF';}
					if($umurB ==79){$kelompok = '75+';}
					else{$kelompok = $umurA.'-'.$umurB;}
					
					$jumlahLakiPerempuan = $dataLaki[$countIndex] + $dataPerempuan[$countIndex];
					
					echo'
					<tr style = "background-color : '.$warna.'">	
						<td>'.$count.'</td>
						<td style="text-align:center;">'.$kelompok.'</td>
						<td align="center">'.$row.'</td>
						<td align="center">'.$dataPerempuan[$countIndex].'</td>						
						<td align="center">'.$jumlahLakiPerempuan.'</td>
						
					<tr>
					';
					
					$countLaki = $countLaki + $row;
					$countPerempuan = $countPerempuan + $dataPerempuan[$countIndex];
					
					$umurA = $umurA+5;
					$umurB =$umurB+5;
					$countIndex++;
					
				   //echo $row->deskripsi;			
				}
			?>              
              
              
			  <tr style = "background-color : #F6F2FC">
                  <td colspan="2" style="text-align:right;">Total Penduduk</td>				  
                  <td  style="text-align:center;"><?php echo $countLaki;?></td>
                  <td  style="text-align:center;"><?php echo $countPerempuan;?></td>
                  <td  style="text-align:center;"><?php echo $totalPenduduk;?></td>
              </tr>
</table>
