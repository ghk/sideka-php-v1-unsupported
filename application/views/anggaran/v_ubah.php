<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('apbdes/c_anggaran/update'); ?>
<fieldset>
	<legend></legend>
    <input  value="<?= $hasil->id_anggaran?>" id="id_anggaran" name="id_anggaran" type="hidden" class="form-control input-md">

	<div class="form-group">
		<label class="col-md-3 control-label" for="id_apbdes">APBDes</label>
		<div class="col-md-9">
        <span class="help-block"><?php $id = 'id="id_apbdes" class="form-control input-md" required';
			echo form_dropdown('id_apbdes',$id_apbdes,$hasil->id_apbdes,$id)?>
		</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="tipe_apbdes">Tipe Anggaran </label>
		<div class="col-md-9">
			  <span class="help-block">
			 <select type="text" class="form-control input-md" name="tipe_apbdes" id="tipe_apbdes">
				 <?php
				 if($hasil->tipe_apbdes == 0){
				 ?>
				 <option value="<?= $hasil->tipe_apbdes?>">Pendapatan</option>
				 <option value="1">Belanja</option>
				 <?php
				 } else{
				 ?>
				 <option value="<?= $hasil->tipe_apbdes?>">Belanja</option>
				 <option value="0">Pendapatan</option>
				 <?php
					 }
				 ?>


			 </select>
			</span>
			<?php echo form_error('tipe_apbdes', '<p class="field_error">','</p>')?>

		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="id_parent">Kepala Anggaran</label>
		<div class="col-md-9">
        <span class="help-block"><?php $id = 'id="id_parent" class="form-control input-md"';
			echo form_dropdown('id_parent',$id_parent,$hasil->id_parent,$id)?>
		</span>
		</div>
	</div>

	<div class="form-group">
		<label  class="col-md-3 control-label" for="tahun">Kode</label>
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
<input type="button" value="Batal" id="batal" class="btn btn-danger"onclick="location.href='<?= base_url() ?>apbdes/c_anggaran'"/>
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
