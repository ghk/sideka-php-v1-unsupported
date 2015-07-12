<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open_multipart('admin/c_regulasi/simpan_regulasi'); ?>
<legend></legend>
    <div class="form-group">
    	 <label  class="col-md-3 control-label" for="judul_regulasi">Judul Regulasi </label>
        <div class="col-md-9">
         <span class="help-block">
         <input class="form-control input-md" type="text" name="judul_regulasi" id="judul_regulasi" size="30" /> 
		<?php echo form_error('judul_regulasi', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<div class="form-group">
    	 <label  class="col-md-3 control-label" for="isi_regulasi">Isi Regulasi</label>
        <div class="col-md-9">
         <span class="help-block">
		 <textarea class="form-control input-md" rows="5" name="isi_regulasi" id="isi_regulasi"></textarea>
		<?php echo form_error('isi_regulasi', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="file_regulasi">File Regulasi</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="file" name="file_regulasi" id="file_regulasi" />
			<div align="right">File harus bertipe .zip / .doc /.pdf /.xls</div>
		</span>
		</div>
	</div>	

<div class="form-group">
    <label class="col-md-0 control-label" for="simpan"></label>
    <div class="col-md-9">
    <button type="submit" class="btn btn-success" name="simpan" id="simpan"/>Simpan</button>
    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_regulasi'"/>Batal</button>
    </div>
</div>

<?php echo form_close(); ?>

<script>

function nav_active(){

	document.getElementById("a-data-web").className = "collapsed active";
	
	var r = document.getElementById("pengelola_data_web");
	r.className = "collapsed";

	var d = document.getElementById("nav-regulasi");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>