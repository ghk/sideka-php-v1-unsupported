<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('apbdes/c_apbdes/update'); ?>

<fieldset>
	<legend></legend>
	<!-- Text input-->
	<div class="form-group">
		<div class="col-md-9">
			<input  value="<?= $hasil->id_pekerjaan?>" id="id_pekerjaan" name="id_pekerjaan" type="hidden" placeholder="id" class="form-control input-md">
			<span class="help-block"><?php echo form_error('id_pekerjaan', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>


	<!-- Text input-->
	<div class="form-group">
		<label  class="col-md-3 control-label" for="deskripsi">Deskripsi</label>
		<div class="col-md-9">
			<input  value="<?= $hasil->deskripsi?>" id="deskripsi" name="deskripsi" type="text" 
			placeholder="Deskripsi" class="form-control input-md">
			<span class="help-block"><?php echo form_error('deskripsi', '<p class="field_error">','</p>')?></span>  
		</div>
	</div>
	<legend></legend>
</fieldset>
<p>
<input type="submit" value="Simpan" id="simpan"class="btn btn-success"/>
<input type="button" value="Batal" id="batal" class="btn btn-danger"onclick="location.href='<?= base_url() ?>apbdes/c_apbdes'"/>
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
