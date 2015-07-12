<div class="row">
	<div class="col-md-9">
	<h3><?= $page_title ?></h3>
	</div>
</div>
<legend></legend>

<div class="form-group">
	<div class="col-md-12">
		<button id="simpan" name="simpan" class="btn btn-success" onclick="location.href='<?= base_url() ?>datapenduduk/c_pisah_kk/tambah_kk'">
			<i class="fa fa-plus fa-fw"></i> Tambah Kartu Keluarga
		</button>
		<span class="help-block">
		<div class="alert alert-info">
			Menu <b>Tambah Kartu Keluarga</b> digunakan untuk membuat kartu keluarga baru menggunakan data penduduk yang telah terdaftar.
						
		</div>		
		</span> 

	</div>
</div>

<div class="form-group">
	<div class="col-md-12"> 
		<button id="batal" name="batal" class="btn btn-success" onclick="location.href='<?= base_url() ?>datapenduduk/c_pisah_kk/pindah_kk'">
			<i class="fa fa-pencil fa-fw"></i> Pindah Kartu Keluarga
		</button>
		<span class="help-block">
		<div class="alert alert-info">
			Menu <b>Pindah Kartu Keluarga</b> digunakan untuk memindahkan penduduk yang telah terdaftar ke Kartu Keluarga lain .
			
		</div>		
		</span> 
	</div>
</div>
		
<script>
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-pisah_kk");
	d.className = d.className + "active";
	}
  
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>