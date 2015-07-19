<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('apbdes/c_anggaran/simpan'); ?>
<fieldset>
	<legend></legend>

	<!-- Text input-->
	<div class="form-group">
		<label  class="col-md-3 control-label" for="id_apbdes">APBDes</label>
		<div class="col-md-9">
			<input   id="id_apbdes" name="id_apbdes" type="number" placeholder="ID APBdes" class="form-control input-md">
			<span class="help-block"><?php echo form_error('id_apbdes', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="tahun">Nomor</label>
		<div class="col-md-9">
			<input   id="nomor" name="nomor" type="text" placeholder="Nomor" class="form-control input-md">
			<span class="help-block"><?php echo form_error('nomor', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="nama">Nama</label>
		<div class="col-md-9">
			<input   id="nama" name="nama" type="text" placeholder="Nama" class="form-control input-md">
			<span class="help-block"><?php echo form_error('nama', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="jumlah">Jumlah</label>
		<div class="col-md-9">
			<input   id="jumlah" name="jumlah" type="number" placeholder="Jumlah" class="form-control input-md">
			<span class="help-block"><?php echo form_error('jumlah', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="keterangan">keterangan</label>
		<div class="col-md-9">
			<input   id="keterangan" name="keterangan" type="text" placeholder="Keterangan" class="form-control input-md">
			<span class="help-block"><?php echo form_error('keterangan', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<legend></legend>
</fieldset>
<p>
<input type="submit" value="Simpan" id="simpan" class="btn btn-success"/>
<input type="button" value="Batal" id="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>apbdes/c_anggaran'"/>
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
