<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('peristiwa/c_kelahiran/update_kelahiran'); ?>

	<input type="hidden" class="form-control" name="id_kelahiran" id="id_kelahiran" size="30" value="<?= $hasil->id_kelahiran?>"/>		
		
	<label class="col-md-0 control-label" for="="><h4>Data Bayi</h4></label>
	<legend></legend>
	
		<div class="form-group">
		<label class="col-md-3 control-label" for="nama_bayi">Nama Bayi</label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="nama_bayi" id="nama_bayi" size="30" placeholder="Nama Bayi" value="<?= $hasil->nama_bayi?>" required/> 
			<?php echo form_error('nama_bayi', '<p class="field_error">','</p>')?>	
		</span>
		</div>
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="id_jen_kel">Jenis Kelamin</label>
		<div class="col-md-9">
			<div class="radio">
				<input type="radio" name="id_jen_kel" value="1" <?php echo set_radio('id_jen_kel', '1', $hasil->id_jen_kel == '1'); ?>/> Laki - laki
			</div>
			<div class="radio">
				<input type="radio" name="id_jen_kel" value="2" <?php echo set_radio('id_jen_kel', '2', $hasil->id_jen_kel == '2'); ?>/> Perempuan
			</div>
			<?php echo form_error('id_jen_kel', '<p class="field_error">','</p>')?>	
		</div>
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_kelahiran">Tanggal Kelahiran</label> 
		<div class="col-md-9">
		<span class="help-block">
			<a href="javascript:NewCssCal('tgl_kelahiran','ddmmyyyy')">
			<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" class="form-control input-md"  name="tgl_kelahiran" id="tgl_kelahiran" size="20" readonly="readonly" value="<?= date('d-m-Y', strtotime($hasil->tgl_kelahiran))?>"/>
			</div>
			</a>
			
			<?php echo form_error('tgl_kelahiran', '<p class="field_error">','</p>')?>		
		</span>
		</div>
		</div>
		
		<div class="form-group">
		 <label class="col-md-3 control-label" for="berat_bayi">Berat Bayi </label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="berat_bayi" id="berat_bayi" size="10" placeholder="Berat Bayi (kg)" value="<?= $hasil->berat_bayi?>" required/> 
			<?php echo form_error('berat_bayi', '<p class="field_error">','</p>')?>	
		</span>
		</div>
		</div>
		
		<div class="form-group">
		 <label class="col-md-3 control-label" for="panjang_bayi">Panjang Bayi </label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="panjang_bayi" id="panjang_bayi" size="10" placeholder="Panjang Bayi (cm)" value="<?= $hasil->panjang_bayi?>" required/> 
			<?php echo form_error('panjang_bayi', '<p class="field_error">','</p>')?>
		</span>
		</div>
		</div>
	
		<div class="form-group">
			<label class="col-md-3 control-label" for="is_kembar">Apakah Bayi Kembar?</label>
			<div class="col-md-9">
				<div class="radio">
				<input type="radio" name="is_kembar" value="Y" <?php echo set_radio('is_kembar', 'Y', $hasil->is_kembar == 'Y'); ?>/> Ya
			</div>
			<div class="radio">
				<input type="radio" name="is_kembar" value="N" <?php echo set_radio('is_kembar', 'N', $hasil->is_kembar == 'N'); ?>/> Tidak	
			</div>
			</div>
		</div>
		
	<legend></legend>	
	<label class="col-md-0 control-label" for="="><h4>Data Orang Tua</h4></label>
	<legend></legend>
				
		<div class="form-group">
			 <label class="col-md-3 control-label" for="no_kk">Nomer Kepala Keluarga</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input id="no_kk" name="no_kk" type="text" placeholder="Nomer Kepala Keluarga" class="form-control input-md" value="<?= $kk->no_kk?>" required="" disabled/>
			</span>
			 </div>
			<?php echo form_error('nama_ayah', '<p class="field_error">','</p>')?>	
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_kk">Nama Kepala Keluarga</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input id="nama_kk" name="nama_kk" type="text" placeholder="Nama Kepala Keluarga" class="form-control input-md" value="<?= $kk->nama?>" required="" disabled/>
			</span>
			 </div>
			<?php echo form_error('nama_ayah', '<p class="field_error">','</p>')?>	
		</div>
		<legend></legend>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_ayah">Nama Ayah</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input id="nama_ayah" name="nama_ayah" type="text" placeholder="Nama Ayah" class="form-control input-md" value="<?= $hasil->nama_ayah?>">
			</span>
			 </div>
			<?php echo form_error('nama_ayah', '<p class="field_error">','</p>')?>	
		</div>


		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_ibu">Nama Ibu</label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input id="nama_ibu" name="nama_ibu" type="text" placeholder="Nama Ibu" class="form-control" value="<?= $hasil->nama_ibu?>">
			</span>
			 </div>
			<?php echo form_error('nama_ibu', '<p class="field_error">','</p>')?>	
		</div>
	
	<legend></legend>	
	<label class="col-md-0 control-label" for="="><h4>Data Kelahiran</h4></label>
	<legend></legend>
	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="lokasi_lahir">Lokasi Lahir </label>
			 <div class="col-md-9">
			  <span class="help-block">
			 <input type="text" class="form-control input-md" name="lokasi_lahir" id="lokasi_lahir" value="<?= $hasil->lokasi_lahir?>">
			</span>
			<?php echo form_error('lokasi_lahir', '<p class="field_error">','</p>')?>
		
		</div>	
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="tempat_lahir">Tempat Lahir</label> 
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="tempat_lahir" id="tempat_lahir" size="30" placeholder="Tempat Lahir" value="<?= $hasil->tempat_lahir?>"/> 
		</span>
			<?php echo form_error('tempat_lahir', '<p class="field_error">','</p>')?>
		</div>	
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="penolong">Nama Penolong Kelahiran</label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="penolong" id="penolong" size="30" placeholder="Nama Penolong Kelahiran" value="<?= $hasil->penolong?>"/>
			<?php echo form_error('penolong', '<p class="field_error">','</p>')?>
		</span>
		</div>	
		</div>
	
	<legend></legend>	
	<label class="col-md-0 control-label" for="="><h4>Data Pelapor</h4></label>
	<legend></legend>
	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="penolong">Pelapor Kelahiran</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor" size="30" placeholder="Nama Pelapor Kelahiran" value="<?= $hasil->penolong?>"/> 
			<?php echo form_error('nama_pelapor', '<p class="field_error">','</p>')?>
			</span>
		</div>	
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="penolong">Hubungan Pelapor dengan Ayah</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <?php $id_pelapor = 'id="id_pelapor" class="form-control"';
					echo form_dropdown('id_pelapor',$pelapor,$hasil->id_pelapor,$id_pelapor)?> 
			<?php echo form_error('id_pelapor', '<p class="field_error">','</p>')?>
			</span>
		</div>	
		</div>

		<legend></legend>
		
		<div class="form-group">
        <label  class="col-md-3 control-label" for="id_perangkat"> Pamong</label> 
        <div class="col-md-9">		
		<span class="help-block" ><?php $id = 'id="id_perangkat" class="form-control input-md" required';
        echo form_dropdown('id_perangkat',$nama_pamong,$perangkat->id_perangkat,$id);?></span>
        </div>
    </div>
 

<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>peristiwa/c_kelahiran'"/>
</p>
<br>
<?php echo form_close(); ?>
<script>
function nav_active(){
	
	document.getElementById("a-data-peristiwa").className = "collapsed active";
	
	document.getElementById("peristiwa").className = "collapsed";

	var d = document.getElementById("nav-kelahiran");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>