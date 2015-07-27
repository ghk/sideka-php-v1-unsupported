<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('apbdes/c_anggaran/update'); ?>

<fieldset>
	<legend></legend>
    <input  value="<?= $hasil->id_anggaran?>" id="id_anggaran" name="id_anggaran" type="hidden" class="form-control input-md">
	<div class="form-group">
		<label  class="col-md-3 control-label" for="id_apbdes">APBDes</label>
		<div class="col-md-9">
			<input  value="<?= $hasil->id_apbdes?>"  id="id_apbdes" name="id_apbdes" type="number" placeholder="ID APBdes" class="form-control input-md">
			<span class="help-block"><?php echo form_error('id_apbdes', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="tahun">Nomor</label>
		<div class="col-md-9">
			<input  value="<?= $hasil->nomor?>"  id="nomor" name="nomor" type="text" placeholder="Nomor" class="form-control input-md">
			<span class="help-block"><?php echo form_error('nomor', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="nama">Nama</label>
		<div class="col-md-9">
			<input  value="<?= $hasil->nama?>"  id="nama" name="nama" type="text" placeholder="Nama" class="form-control input-md">
			<span class="help-block"><?php echo form_error('nama', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="jumlah">Jumlah</label>
		<div class="col-md-9">
			<input   value="<?= $hasil->jumlah?>" id="jumlah" name="jumlah" type="number" placeholder="Jumlah" class="form-control input-md">
			<span class="help-block"><?php echo form_error('jumlah', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="keterangan">Keterangan</label>
		<div class="col-md-9">
			<input  value="<?= $hasil->keterangan?>"  id="keterangan" name="keterangan" type="text" placeholder="Keterangan" class="form-control input-md">
			<span class="help-block"><?php echo form_error('keterangan', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
</fieldset>
<p>
<input type="submit" value="Simpan" id="simpan"class="btn btn-success"/>
<input type="button" value="Batal" id="batal" class="btn btn-danger"onclick="location.href='<?= base_url() ?>apbdes/c_apbdes'"/>
</p>
<script>
function nav_active(){
	
	document.getElementById("a-data-apbdes").className = "collapsed active";
	
	document.getElementById("apbdes").className = "collapsed";

	var d = document.getElementById("nav-anggaran");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>
