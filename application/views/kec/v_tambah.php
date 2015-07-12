<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_kec/simpan_kec'); ?>
<legend></legend>
    <div class="form-group">
    	<label class="col-md-3 control-label" for="kode_kecamatan_bps">Kode BPS </label>
        <div class="col-md-9">
        <span class="help-block">
        <input class="form-control input-md" type="text" name="kode_kecamatan_bps" id="kode_kecamatan_bps" size="30" placeholder="Kode Kecamatan BPS (Badan Pusat Statistik)"/> 
		<?php echo form_error('kode_kecamatan_bps', '<p class="field_error">','</p>')?>
		</span>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="kode_kecamatan_kemendagri">Kode Kemendagri </label>
        <div class="col-md-9">
        <span class="help-block">
        <input class="form-control input-md" type="text" name="kode_kecamatan_kemendagri" id="kode_kecamatan_kemendagri" size="30" placeholder="Kode Kemendagri"/> 
		<?php echo form_error('kode_kecamatan_2', '<p class="field_error">','</p>')?>
		</span>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="nama_kecamatan">Nama Kecamatan  </label>
        <div class="col-md-9">
        <span class="help-block">
        <input class="form-control input-md" type="text" name="nama_kecamatan" id="nama_kecamatan" size="30" placeholder="Nama Kecamatan"/> 
		<?php echo form_error('nama_kecamatan', '<p class="field_error">','</p>')?>
		</span>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="luas_wilayah">Luas Wilayah </label>
        <div class="col-md-9">
        <span class="help-block">
        <input class="form-control input-md" type="text" name="luas_wilayah" id="luas_wilayah" size="30" placeholder="Luas Wilayah Kecamatan (km2)"/> 
		<?php echo form_error('luas_wilayah', '<p class="field_error">','</p>')?>
		</span>
	</div>	
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_kab_kota">Kabupaten Kota  </label>
        <div class="col-md-9">
        <span class="help-block">
        <?php $id = 'id="id_kab_kota"class="form-control input-md" ';
				echo form_dropdown('id_kab_kota',$nama_kab_kota,'',$id)?>
				<?php echo form_error('id_kab_kota', '<p class="field_error">','</p>')?>
		</span>
		
	</div>
<legend></legend>

<div class="form-group">
    <label class="col-md-0 control-label" for="simpan"></label>
    <div class="col-md-9">
    <button type="submit" class="btn btn-success" name="simpan" id="simpan"/>Simpan</button>
    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_kec'"/>Batal</button>
    </div>
</div>

<?php echo form_close(); ?>