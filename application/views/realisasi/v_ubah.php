<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('apbdes/c_anggaran/update'); ?>

<fieldset>
	<legend></legend>
    <input  value="<?= $hasil->id_anggaran?>" id="id_realisasi" name="id_realisasi" type="hidden" class="form-control input-md">
	<div class="form-group">
		<label  class="col-md-3 control-label" for="id_anggaran">Id Anggaran</label>
		<div class="col-md-9">
			<input  value="<?= $hasil->id_realisasi?>"  id="id_anggaran" name="id_anggaran" type="number" placeholder="Id Anggaran" class="form-control input-md">
			<span class="help-block"><?php echo form_error('id_anggaran', '<p class="field_error">','</p>')?></span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_timbang">Tanggal</label>
		<div class="col-md-9">
			<a href="javascript:NewCssCal('tanggal','ddmmyyyy')">
				<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
					<input value="<?= date('j-m-Y ',strtotime($hasil->tanggal))?>" readonly="readonly" class="form-control" type="text"  name="tanggal" id="tanggal" size="20" placeholder="Tgl-Bln-Thn" class="form-control input-md" required="" />
				</div></a>
			<span class="help-block"><?php echo form_error('tanggal', '<p class="field_error">','</p>')?></span>
		</div>
	</div>

	<div class="form-group">
		<label  class="col-md-3 control-label" for="jumlah">Jumlah</label>
		<div class="col-md-9">
			<input   value="<?= $hasil->jumlah?>" id="jumlah" name="jumlah" type="number" placeholder="Jumlah" class="form-control input-md">
			<span class="help-block"><?php echo form_error('jumlah', '<p class="field_error">','</p>')?></span>
		</div>
	</div>

</fieldset>
<p>
<input type="submit" value="Simpan" id="simpan"class="btn btn-success"/>
<input type="button" value="Batal" id="batal" class="btn btn-danger"onclick="location.href='<?= base_url() ?>apbdes/c_realisasi'"/>
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
