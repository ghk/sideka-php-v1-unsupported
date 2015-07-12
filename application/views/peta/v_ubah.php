<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php
$attributes = array('name' => 'myform');
echo form_open_multipart('admin/c_peta/update_peta', $attributes); 
?>
	<legend></legend>
	<div class="form-group"> 	
    	<label class="col-md-12 control-label" for="peta_kabupaten">Peta Desa</label>
        <div class="col-md-12">
		<?php echo $peta;?>
        </div>
	</div>	
	<legend></legend>

	<div class="form-group"> 	
    	 <label class="col-md-2 control-label" for="embed">Embed</label>
        <div class="col-md-10">
			<textarea name="embed" placeholder="Salin kode embed disini" class="form-control" rows="2" required>
			<?php echo $peta;?>
			</textarea>
         <span class="help-block">
			<div align="right">Salin kode embed dari <a href="https://www.google.com/maps/d/" target="_blank">google maps</a>, untuk memperbarui peta</div>
		</span>
		</div>
	</div>	
	
	<div class="form-group">
	  <label class="col-md-0 control-label" for="simpan"></label>
	  <div class="col-md-9">
		<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
	  </div>
	</div>
	<br>
<legend></legend>	

<?php echo form_close(); ?>
<script>

function nav_active(){
	
	document.getElementById("a-data-web").className = "collapsed active";
	
	document.getElementById("pengelola_data_web").className = "collapsed";

	var d = document.getElementById("nav-peta");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>
<style>
iframe {width:100%;height:600px;}
</style>