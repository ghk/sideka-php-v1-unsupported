<h2><?= $page_title ?></h2>
		<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<button type="button" class="btn btn-danger" aria-label="Left Align" onclick="location.href='<?= base_url() ?>datapenduduk/c_penduduk'">
							 <span class="fa fa-arrow-circle-left"> Kembali</span>
							</button>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive">
<div class="col-lg-3 col-md-4">	
	<img id="displayPhoto" src='<?php echo site_url($result->foto);?>' class='img-responsive img-thumbnail'/>	<br>	
</div>

<div class="col-lg-9 col-md-7">
	<table class='table table-striped'>
		<tr>
			<th scope='row'>No KK</th>
			<td id=""><?php echo $keluarga->no_kk;?></td>
		</tr>
		<tr>
			<th scope='row'>Alamat</th>
			<td id=""><?php echo $keluarga->alamat_jalan;?></td>
		</tr>
		<tr>
			<th scope='row'>Dusun</th>
			<td id=""><?= $result->nama_dusun	 ?></td>
		</tr>
		<tr>
			<th scope='row'>RW</th>
			<td id=""><?= $result->nomor_rw ?></td>
		</tr>
		<tr>
			<th scope='row'>RT</th>
			<td id=""><?= $result->nomor_rt ?></td>
		</tr>		
	</table>
</div>
<legend></legend>
<div class="col-lg-12 col-md-12">
	<table class='table table-striped'>	
		
		<tr>
			<th scope='row'>NIK</th>
			<td id=""><?= $result->nik ?></td>
		</tr>		
		<tr>
			<th scope='row'>Nama</th>
			<td id=""><?= $result->nama ?></td>
		</tr>
		<tr>
			<th scope='row'>Tempat Lahir</th>
			<td id=""><?= $result->tempat_lahir ?></td>
		</tr>	
		<tr>
			<th scope='row'>Tanggal Lahir</th>
			<td id=""><?= date('j-m-Y ',strtotime($result->tanggal_lahir)); ?></td>
		</tr>
		<tr>
			<th scope='row'>Jenis Kelamin</th>
			<td id=""><?= $result->nama_jen_kel ?></td>
		</tr>		
		<tr>
			<th scope='row'>Agama</th>
			<td id=""><?= $result->nama_agama ?></td>
		</tr>
		<tr>
			<th scope='row'>Kewarganegaraan</th>
			<td id=""><?= $result->nama_kewarganegaraan ?></td>
		</tr>
		<tr>
			<th scope='row'>No Telepon </th>
			<td id=""><?= $result->no_telp ?></td>
		</tr>
		<tr>
			<th scope='row'>Email</th>
			<td id=""><?= $result->email ?></td>
		</tr>		

		<tr>
			<th scope='row'>No Kitas</th>
			<td id=""><?= $result->no_kitas ?></td>
		</tr>
		<tr>
			<th scope='row'>No Paspor</th>
			<td id=""><?= $result->no_paspor ?></td>
		</tr>
		<tr>
			<th scope='row'>Pendidikan</th>
			<td id=""><?= $result->nama_pendidikan ?></td>
		</tr>
		<tr>
			<th scope='row'>Pendidikan Terakhir</th>
			<td id=""><?= $result->nama_pendidikan_terakhir ?></td>
		</tr>
		<tr>
			<th scope='row'>Pekerjaan</th>
			<td id=""><?= $result->nama_pekerjaan ?></td>
		</tr>
		<tr>
			<th scope='row'>Pekerjaan Potensi Ekonomi Desa</th>
			<td id=""><?= $result->nama_pekerjaan_ped ?></td>
		</tr>
		<!--<tr>
			<th scope='row'>Pendapatan Per Bulan</th>
			<td id=""><?//= 'Rp '.$result->pendapatan_per_bulan ?></td>
		</tr>-->
		<tr>
			<th scope='row'>Status Kawin</th>
			<td id=""><?= $result->nama_status_kawin ?></td>
		</tr>
		<tr>
			<th scope='row'>Status Penduduk</th>
			<td id=""><?= $result->nama_status_penduduk ?></td>
		</tr>
		<tr>
			<th scope='row'>Status Tinggal</th>
			<td id=""><?= $result->nama_status_tinggal ?></td>
		</tr>
		<tr>
			<th scope='row'>Difabilitas</th>
			<td id=""><?= $result->nama_difabilitas ?></td>
		</tr>
		<tr>
			<th scope='row'>Kontrasepsi</th>
			<td id=""><?= $result->nama_kontrasepsi ?></td>
		</tr>
		
	</table>
</div>

							</div>
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
<script>
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-penduduk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>