<?php 	
	$isi = $demografi->isi_demografi; 	
	$banner = $demografi->foto_banner; 
	$tempWaktu = $demografi->waktu;
	$tanggal = date("d", strtotime($tempWaktu));
	$bulan = date("n", strtotime($tempWaktu));
	$tahun = date("Y", strtotime($tempWaktu));
	$nama = $demografi->id_pengguna;
	$jam = date("G:i:s", strtotime($tempWaktu));
	$namabulan = array("","Januari","Februari","Maret","April","Mei","Juni",
	"Juli","Agustus","September","Oktober","November","Desember");
?>
	<h1>Demografi Desa</h1>
	<img id="displayPhoto" src='<?php echo site_url($banner);?>' style="width:100%; margin-bottom: 10px"> 
	
	<div class="body-content">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="uppercase" style="color:#3C3C3C">1. Keadaan Umum Wilayah Desa</h4>
		</div>
			<div class="panel-body">
				<div class="box">
					<div class="box-header">        

					</div>
					<div class="box-content">
						<div class="col-md-12">
															<?php echo $isi;?>		
						</div>						
					</div>
				</div>
			</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="uppercase" style="color:#3C3C3C">2. Gambaran Demografis Desa</h4>
		</div>
			<div class="panel-body">
				<div class="box">
					<div class="box-header">        

					</div>
					<div class="box-content">
							<div class="col-md-12">
							<span>a. Kependudukan</span>
							<table class="table table-bordered" style="width:100%">
								<tr style = "background-color : #F6F2FC">
									<th width="2%" align="center">No</th>
									<th width="10%" style="text-align:center;">Statistik</th>		
									<th width="10%" style="text-align:center;">Laki-Laki</th>		
									<th width="10%" style="text-align:center;">Perempuan</th>
									<th width="5%" style="text-align:center;">Jumlah</th>
								</tr>
								
								<?php
									$rows = $penduduk;
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
										$total = $total + $row->jumlah;			
									}
								?>
								<tr style = "background-color : #F6F2FC">
								  <td colspan="2" style="text-align:right;">Total</td>
								  <td style="text-align:center;"><?php echo $totalLaki;	?></td>
								  <td style="text-align:center;"><?php echo $totalPerempuan;?></td>
								  <td style="text-align:center;"><?php echo $total;	?></td>
								</tr>
							</table>
						</div>

					<!---------------------------------------->
						<div class="col-md-12">
							<span>B. Kepala Keluarga</span>
							<table class="table table-bordered" style="width:100%">
								<tr style = "background-color : #F6F2FC">
									<th width="2%" align="center">No</th>
									<th width="10%" style="text-align:center;">Statistik</th>		
									<th width="10%" style="text-align:center;">Laki-Laki</th>		
									<th width="10%" style="text-align:center;">Perempuan</th>
									<th width="5%" style="text-align:center;">Jumlah</th>
								</tr>
								
								<?php
									$rows = $keluarga;
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
										$total = $total + $row->jumlah;			
									}
								?>
								<tr style = "background-color : #F6F2FC">
								  <td colspan="2" style="text-align:right;">Total</td>
								  <td style="text-align:center;"><?php echo $totalLaki;	?></td>
								  <td style="text-align:center;"><?php echo $totalPerempuan;?></td>
								  <td style="text-align:center;"><?php echo $total;	?></td>
								</tr>
							</table>
						</div>
							
						</div>
					</div>
				</div>
			</div>
			<p>
<!--
								<br>
								<b>Ditulis Oleh </b>: 
								<?php echo $nama; ?>, 
								<?php echo $tanggal." ".$namabulan[$bulan]." ".$tahun;?>
								<?php echo $jam?> WIB			
-->
							</p>
	</div>
	

<script type="text/javascript" charset="utf-8">			
			 function nav_active(){
				var r = document.getElementById("nav-home");
				r.className = "";
				
				var d = document.getElementById("nav-profil");
				d.className = d.className + "active";
				}

			$(document).ready(function(){  
			document.getElementById("displayPhoto").src = <?php echo site_url($demografi);?>;
			});
</script>	