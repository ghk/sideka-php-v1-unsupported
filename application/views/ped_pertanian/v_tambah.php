<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_ped_pertanian/simpan_ped_pertanian'); ?>
	<fieldset>
		<!-- Form Name -->
		<legend></legend>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="deskripsi">Deskripsi</label>  
		  <div class="col-md-9">
		  <input id="deskripsi" name="deskripsi" type="text" placeholder="Deskripsi" class="form-control input-md" required >
		  <span class="help-block"><?php echo form_error('deskripsi', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="id_dusun">Penggarap </label>
			<div class="col-md-9">			
			<?php $options = array(
							''=>'-- Pilih --',
							'Pribadi' => 'Pribadi',
							'Buruh' => 'Buruh',
							);
						$id = 'id="penggarap" class="form-control input-md" required';
					echo form_dropdown('penggarap',$options,'',$id); ?>
			  <span class="help-block"><?php echo form_error('penggarap', '<p class="field_error">','</p>')?></span>  
			</div>
		</div>
	
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="jumlah_penggarap">Jumlah Penggarap</label>  
		  <div class="col-md-9">
		  <input id="jumlah_penggarap" name="jumlah_penggarap" type="text" placeholder="Jumlah orang" class="form-control input-md" onkeypress="return numbersonly(event)" required>
		  <span class="help-block"><?php echo form_error('jumlah_penggarap', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="luas">Luas</label>  
		  <div class="col-md-9">
		  <input id="luas" name="luas" type="text" placeholder="Luas" class="form-control input-md" onkeypress="return numbersonly(event)" required>
		  <span class="help-block"><?php echo form_error('luas', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="lokasi">Lokasi</label>  
		  <div class="col-md-9">
		  <input id="lokasi" name="lokasi" type="text" placeholder="Lokasi" class="form-control input-md" required>
		  <span class="help-block"><?php echo form_error('lokasi', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>		
			
		<div class="form-group">
			 <label class="col-md-3 control-label" for="id_dusun">Dusun </label>
			<div class="col-md-9">			 
			 <?php $id = 'id="id_dusun" class="form-control input-md" ';
					echo form_dropdown('id_dusun',$nama_dusun,'',$id)?>
			 <span class="help-block"></span>
		</div>
		</div>
		
		<div class="form-group">
				  <label class="col-md-0 control-label" for="simpan"></label>
				  <div class="col-md-9">
					<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
					<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>admin/c_ped_pertanian'">Batal</button>
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

	var d = document.getElementById("nav-pertanian");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>