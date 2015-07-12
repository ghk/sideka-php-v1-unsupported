<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_ped_potensi_wisata/update_ped_potensi_wisata'); ?>
<input type="hidden" name="id_ped_potensi_wisata" id="id_ped_potensi_wisata" size="30" value="<?= $hasil->id_ped_potensi_wisata?>" readonly = "readonly"/>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="deskripsi">Deskripsi</label>  
		  <div class="col-md-9">
		  <input id="deskripsi" name="deskripsi" type="text" placeholder="Deskripsi" class="form-control input-md" value="<?= $hasil->deskripsi?>" required >
		  <span class="help-block"><?php echo form_error('deskripsi', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="lokasi">Lokasi</label>  
		  <div class="col-md-9">
		  <input id="lokasi" name="lokasi" type="text" placeholder="Lokasi" class="form-control input-md" value="<?= $hasil->lokasi?>" required>
		  <span class="help-block"><?php echo form_error('lokasi', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>		
			
		<div class="form-group">
			 <label class="col-md-3 control-label" for="id_dusun">Dusun </label>
			<div class="col-md-9">			 
			 <?php $id = 'id="id_dusun" class="form-control input-md" ';
					echo form_dropdown('id_dusun',$nama_dusun,$hasil->id_dusun,$id)?>
			 <span class="help-block"></span>
		</div>
		</div>
		
		<div class="form-group">
				  <label class="col-md-0 control-label" for="simpan"></label>
				  <div class="col-md-9">
					<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
					<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>admin/c_ped_potensi_wisata'">Batal</button>
				  </div>
				</div>
		</fieldset>
		<br>
<?php echo form_close(); ?>
<script>
 function nav_active(){

	document.getElementById("a-data-web").className = "collapsed active";
	
	var r = document.getElementById("pengelola_ekonomi_desa");
	r.className = "collapsed";

	var d = document.getElementById("nav-potensi_wisata");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>