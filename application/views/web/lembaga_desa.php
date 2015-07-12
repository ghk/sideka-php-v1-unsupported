<h1>Pemerintah Desa</h1>
<legend></legend>	
	<div class="row">	
		
		
		
		<?php
			$i=0;
			foreach($perangkat_desa as $perDes)
			{
			$i++;
		?>
		<?php 	
			$nip_perDes = $perDes->nip;
			$nama_perDes = $perDes->nama;
			$foto_perDes = $perDes->foto;
			$jabatan = $perDes->deskripsi;
		?>
	
		<div class="col-md-3" >
			<div class="lembaga-content">
				<div class="col-lg-12 col-md-12 col-xs-12">	
				<img id="displayPhoto" src='<?php echo site_url($foto_perDes);?>' class='img-responsive img-thumbnail'/>	
				</div>
				<div class="lembaga-title">
					<h3><strong><?php echo $jabatan;?></strong></h3>
					<legend></legend>
				</div>
				<div class="lembaga-content-text">
				<table>
				<h5>
				<tr>
				<td>NIP</td>
				<td>:</td>
				<td><?php echo $nip_perDes;?></td><br>
				</tr>
				<tr>
				<td>Nama</td>
				<td>:</td>
				<td><?php echo $nama_perDes;?></td>
				</h5>
				</tr>
				</table>			
				</div>
			</div>
		</div>
		
		<?php
			}
		?>
	
		<?php
			$i=0;
			foreach($kepala_dusun as $kepdes)
			{
			$i++;
		?>
		<?php 	
			$nik_kepdes = $kepdes->nik;
			$nama_kepdes = $kepdes->nama;
			$foto_kepdes = $kepdes->foto;
			$nama_dusun = $kepdes->nama_dusun;
		?>
		<div class="col-md-3" >
			<div class="lembaga-content">
				<div class="col-lg-12 col-md-12 col-xs-12">	
				<img id="displayPhoto" src='<?php echo site_url($foto_kepdes);?>' class='img-responsive img-thumbnail'/>	
				</div>
				<div class="lembaga-title">
					<h3>Kepala Dusun<br><strong><?php echo $nama_dusun;?></h3></strong>
					<legend></legend>
				</div>
				<div class="lembaga-content-text2">
				<table>
				<h5>
				<tr>
				<td>NIK</td>
				<td>:</td>
				<td><?php echo $nik_kepdes;?></td><br>
				</tr>
				<tr>
				<td>Nama</td>
				<td>:</td>
				<td><?php echo $nama_kepdes;?></td>
				</h5>
				</tr>
				</table>
				</div>
			</div>
		</div>
		<?php
			}
		?>
	</div>
	<script type="text/javascript" charset="utf-8">			
			 function nav_active(){
				var r = document.getElementById("nav-home");
				r.className = "";
				
				var d = document.getElementById("nav-lembaga");
				d.className = d.className + "active";
				}
	</script>
	<script>
		$(document).ready(function(){  
			document.getElementById("displayPhoto").src = <?php echo site_url($foto);?>;
		}); 
	</script>