<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_kabkota/update_kabkota'); ?>
<legend></legend>
        <td> <input type="hidden" name="id_kab_kota" id="id_kab_kota" size="30" value="<?= $hasil->id_kab_kota?>" readonly="readonly"/> </td>	

    <div class="form-group">
        <label class="col-md-3 control-label" for="kode_kab_kota_bps">Kode BPS </label>
        <div class="col-md-9"> 
        <span class="help-block">
        <input class="form-control input-md" type="text" name="kode_kab_kota_bps" id="kode_kab_kota_bps" size="30"  value="<?= $hasil->kode_kab_kota_bps?>" placeholder="Kode Kabupaten Kota BPS (Badan Pusat Statistik)"/> 
        <?php echo form_error('kode_kab_kota_bps', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>
    <div class="form-group">
         <label class="col-md-3 control-label" for="kode_kab_kota_kemendagri">Kode Kemendagri </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="kode_kab_kota_kemendagri" id="kode_kab_kota_kemendagri"  value="<?= $hasil->kode_kab_kota_kemendagri?>" size="30" placeholder="Kode Kabupaten Kota Kemendagri"/> 
        <?php echo form_error('kode_kab_kota_kemendagri', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>
    <div class="form-group">
         <label class="col-md-3 control-label" for="nama_kab_kota">Nama Kabupaten Kota </label>
        <div class="col-md-9">
        <span class="help-block"> 
         <input class="form-control input-md" type="text" name="nama_kab_kota" id="nama_kab_kota" size="30" value="<?= $hasil->nama_kab_kota?>" placeholder="Nama Kabupaten Kota"/>
        </span> 
        <?php echo form_error('nama_kab_kota', '<p class="field_error">','</p>')?>
        </div>
    </div>
    <div class="form-group">
         <label class="col-md-3 control-label" for="luas_wilayah">Luas Wilayah </label>
        <div class="col-md-9">
        <span class="help-block"> 
         <input class="form-control input-md" type="text" name="luas_wilayah" id="luas_wilayah" size="30" value="<?= $hasil->luas_wilayah?>" placeholder="Luas Wilayah (Ha)" /> 
        </span>
        <?php echo form_error('luas_wilayah', '<p class="field_error">','</p>')?>
        </div>
    </div>
    <div class="form-group">
         <label class="col-md-3 control-label" for="nama_provinsi">Provinsi </label>
        <div class="col-md-9">
        <span class="help-block"> 
         <?php $id = 'id="id_provinsi" class="form-control input-md" ';
                echo form_dropdown('id_provinsi',$nama_provinsi,$hasil->id_provinsi,$id)?>
        
        <?php echo form_error('id_provinsi', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>
<legend></legend>

<div class="form-group">
    <label class="col-md-0 control-label" for="simpan"></label>
    <div class="col-md-9">
    <button type="submit" class="btn btn-success" name="simpan" id="simpan"/>Simpan</button>
    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_kabkota'"/>Batal</button>
    </div>
</div>

<?php echo form_close(); ?>

<script>
function nav_active(){
	document.getElementById("a-data-wilayah").className = "collapsed active";
	var r = document.getElementById("pengelola_data_wilayah");
	r.className = "collapsed";

	var d = document.getElementById("nav-kabkot");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});

</script>
