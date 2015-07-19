<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('apbdes/c_apbdes/simpan'); ?>
<fieldset>
	<legend></legend>

	<!-- Text input-->
	<div class="form-group">
		<label  class="col-md-3 control-label" for="tahun">Tahun</label>
		<div class="col-md-9">
			<input   id="tahun" name="tahun" type="number" placeholder="Tahun" class="form-control input-md">
			<span class="help-block"><?php echo form_error('tahun', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="">Perubahan?</label>
		<div class="col-md-9">
			<input   id="is_perubahan" name="is_perubahan" type="checkbox" class="form-control"> 
			<span class="help-block"><?php echo form_error('is_perubahan', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="nama">Nama</label>
		<div class="col-md-9">
			<input   id="nama" name="nama" type="text" placeholder="Nama" class="form-control input-md">
			<span class="help-block"><?php echo form_error('Nama', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<legend></legend>
</fieldset>
<p>
<input type="submit" value="Simpan" id="simpan" class="btn btn-success"/>
<input type="button" value="Batal" id="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>apbdes/c_apbdes'"/>
</p>

<script>
function nav_active(){
	
	document.getElementById("a-data-apbdes").className = "collapsed active";
	
	document.getElementById("apbdes").className = "collapsed";

	var d = document.getElementById("nav-apbdes");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>
