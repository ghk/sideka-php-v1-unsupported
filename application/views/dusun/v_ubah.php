<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_dusun/update_dusun'); ?>

<legend></legend>
    <input type="hidden" name="id_dusun" id="id_dusun" size="30" value="<?= $hasil->id_dusun?>" readonly = "readonly"/> </td>

	    <div class="form-group">
    	 <label class="col-md-3 control-label" for="kode_desa_bps"> Kode BPS </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="kode_dusun_bps" id="kode_dusun_bps" size="30" value="<?= $hasil->kode_dusun_bps?>" placeholder="Kode Dusun Badan Pusat Statistik (BPS)" required/> 
		<?php echo form_error('kode_dusun_bps', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="kode_dusun_kemendagri"> Kode Kemendagri </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="kode_dusun_kemendagri" id="kode_dusun_kemendagri" size="30" value="<?= $hasil->kode_dusun_kemendagri?>" placeholder="Kode Kemendagri" required/> 
		<?php echo form_error('kode_dusun_2', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="nama_dusun"> Nama Dusun </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="nama_dusun" id="nama_dusun" size="30" value="<?= $hasil->nama_dusun?>" placeholder="Nama Dusun" required/> 
		<?php echo form_error('nama_dusun', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="luas_wilayah"> Luas Wilayah </label>
        <div class="col-md-9">
        
         <input class="form-control input-md" type="text" name="luas_wilayah" id="luas_wilayah" size="30" value="<?= $hasil->luas_wilayah?>" placeholder="Luas Wilayah Dusun (ha)" required/> 
		<span class="help-block">
			<?php echo form_error('luas_wilayah', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_desa">  Desa </label>
        <div class="col-md-9">        
         <?php $id = 'id="id_desa"class="form-control input-md" required';
				echo form_dropdown('id_desa',$nama_desa,$hasil->id_desa,$id)?>
		<span class="help-block">		
			<?php echo form_error('id_desa', '<p class="field_error">','</p>')?>
		</span>
		</div>
	<legend></legend>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="nik_nama">Pencarian Data Kepala Dusun</label>  
      <div class="col-md-9">
      <input id="nik_nama" name="nik_nama" type="text" placeholder="NIK / Nama Penduduk" class="form-control input-md"value="<?= $nik .' / ' . $nama?>" >
      <span class="help-block"><?php echo form_error('nik_nama', '<p class="field_error">','</p>')?></span>  
      </div>
    </div>
    
    <legend></legend>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="nik">NIK Kepala Dusun</label>  
      <div class="col-md-9">
      <input id="nik_sementara" name="nik_sementara" type="text" placeholder="NIK" class="form-control input-md" required="" disabled value="<?= $nik?>" />
      <input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" value="<?= $nik?>" />
      <span class="help-block"><?php echo form_error('nik', '<p class="field_error">','</p>')?></span>  
      </div>
    </div>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="nama">Nama Kepala Dusun</label>  
      <div class="col-md-9">
      <input id="nama_sementara" name="nama_sementara" type="text" placeholder="Nama Kepala Desa" class="form-control input-md" required="" disabled value="<?= $nama?>" />
      <input id="nama" name="nama" type="hidden" placeholder="Nama Kepala Desa" class="form-control input-md" value="<?= $nama?>"/>
      <span class="help-block"><?php echo form_error('nama', '<p class="field_error">','</p>')?></span>  
      </div>
    </div>

<legend></legend>



<div class="form-group">
    <label class="col-md-0 control-label" for="simpan"></label>
    <div class="col-md-9">
    <button type="submit" class="btn btn-success" name="simpan" id="simpan"/>Simpan</button>
    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_dusun'"/>Batal</button>
    </div>
</div>
<?php echo form_close(); ?>


<script>    

  $(function() {
    var nikPenduduk = <?php  echo $json_array_nama; ?> ;
    $("#nik_nama" ).autocomplete({
      source: nikPenduduk,
      minLength: 2,
      select: function(event, ui) {
        
        bits = ui.item.value.split(' | ')
        nik = bits[bits.length - 2]
        nama = bits[bits.length - 1]
            $("#nik").val(nik);
            $("#nama").val(nama);
            $("#nik_sementara").val(nik);
            $("#nama_sementara").val(nama);
        },
        change: function(event, ui) {
        
        bits = ui.item.value.split(' | ')
        nik = bits[bits.length - 2]
        nama = bits[bits.length - 1]
                $("#nik").val(nik);
            $("#nama").val(nama);           
            $("#nik_sementara").val(nik);
            $("#nama_sementara").val(nama);
        }
    });
  });
  
  function nav_active(){

	document.getElementById("a-data-web").className = "collapsed active";
	
	var r = document.getElementById("pengelola_data_wilayah");
	r.className = "collapsed";

	var d = document.getElementById("nav-dusun");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});

</script>