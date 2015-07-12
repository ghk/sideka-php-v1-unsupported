<h2>KETUA RW</h2>	
<legend></legend>
	<div class="row">
		<?php
			$i=0;
			foreach($ketua_RW as $rw)
			{
			$i++;
		?>	
		<?php 	
			$nik_RW = $rw->nik;
			$nama_RW = $rw->nama;
			$foto_RW = $rw->foto;
			$jabatan = $rw->nomor_rw;
			$dusun = $rw->nama_dusun;
		?>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
			<div class="rt_rw-content">
				<div class="rt_rw-content-img col-lg-12 col-md-12 col-sm-12 col-xs-12">	
				<img id="displayPhoto" src='<?php echo site_url($foto_RW);?>' class='img-responsive img-thumbnail'/>	
				</div>
				<div class="rt_rw-title">
					<h5>Ketua <strong>RW <?php echo $jabatan;?></strong></h5>
					<h5><strong><?php echo $dusun;?></strong></h5>
					<legend></legend>
				</div>
				<div class="rt_rw-content-text">
				<table>
				<tr>
				<td>NIK</td>
				<td>:</td>
				<td><?php echo $nik_RW;?></td>
				</tr>
				<tr>
				<td>Nama</td>
				<td>:</td>
				<td><?php echo $nama_RW;?></td>
				
				</tr>
				</table>
				</div>
			</div>
		</div>
		
		<?php
			}
		?>
		</div>
<legend></legend>
<h2>KETUA RT</h2>	
<legend></legend>
	<div class="row">
		<?php
			$i=0;
			foreach($ketua_RT as $rt)
			{
			$i++;
		?>	
		<?php 	
			$nik_RT = $rt->nik;
			$nama_RT = $rt->nama;
			$foto_RT = $rt->foto;
			$jabatan = $rt->nomor_rt;
			$dusun = $rt->nama_dusun;
		?>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
			<div class="rt_rw-content">
				<div class="rt_rw-content-img col-lg-12 col-md-12 col-sm-12 col-xs-12">	
				<img id="displayPhoto" src='<?php echo site_url($foto_RT);?>' class='img-responsive img-thumbnail'/>	
				</div>
				<div class="rt_rw-title">
					<h5>Ketua <strong>RT <?php echo $jabatan;?> </strong></h5>
					<h5><strong><?php echo $dusun;?></strong></h5>
					<legend></legend>
				</div>
				<div class="rt_rw-content-text">
				<table>
				<tr>
				<td>NIK</td>
				<td>:</td>
				<td><?php echo $nik_RT;?></td>
				</tr>
				<tr>
				<td>Nama</td>
				<td>:</td>
				<td><?php echo $nama_RT;?></td>
				
				</tr>
				</table>
				</div>
			</div>
		</div>
		<?php
			}
		?>
	</div>
	</div>
	<script type="text/javascript" charset="utf-8">			
			 function nav_active(){
				var r = document.getElementById("nav-home");
				r.className = "";
				
				var d = document.getElementById("nav-rt_rw");
				d.className = d.className + "active";
				}
	</script>
	<script>
		$(document).ready(function(){  
			document.getElementById("displayPhoto").src = <?php echo site_url($foto);?>;
		}); 
	</script>