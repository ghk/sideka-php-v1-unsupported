<script src="<?php echo base_url();?>nic/nicEdit.js"  type="text/javascript"></script>
<script type="text/javascript">

	bkLib.onDomLoaded(function() {
		new nicEditor({maxHeight : 500}).panelInstance('xxx');
	});
</script>
<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_lembaga_desa/update_lembaga_desa'); ?>


<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $tempna->id_pengguna ?>" size="20" /> 
<input type="hidden" name="id_lembaga_desa" id="id_lembaga_desa" value="<?= $hasil->id_lembaga_desa ?>" size="20" />
<legend></legend>

<div class="form-group"> 
	<label class="col-md-12 control-label" for="isi_lembaga_desa">Lembaga Desa</label>
	 <div class="col-md-12">
	 <textarea class="form-control input-md" id="xxx"  name="isi_lembaga_desa"  cols="80"> <?= $hasil->isi_lembaga_desa ?> </textarea>
	 <span class="help-block">
	</span>
	</div>
</div>
<legend></legend>

<div class="col-md-9">
<span class="help-block">
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_lembaga_desa'"/>
</span>	
</div>

<script>
function nav_active(){
	document.getElementById("a-data-web").className = "collapsed active";
	var r = document.getElementById("pengelola_data_web");
	r.className = "collapsed";

	var d = document.getElementById("nav-lembaga");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>