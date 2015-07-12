<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('peristiwa/c_pindah_masuk/simpan_pindah_masuk'); ?>

<legend></legend>
<!--<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="20" /> -->
<label class="col-md-0 control-label" for="="><h4>Data Keluarga</h4></label>
<legend></legend>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">No Kartu Keluarga </label>
		 <div class="col-md-9">
         <span class="help-block">
			<input type="text" class="form-control control-label" name="no_kk" id="no_kk" size="35" required/> 
		
		<?php echo form_error('no_kk', '<p class="field_error">','</p>')?>	
		</span>
	</div>
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nama Kepala Keluarga </label>
		 <div class="col-md-9">
         <span class="help-block">
			<input type="text" class="form-control control-label" name="nama" id="nama" size="35" style="text-transform: uppercase" required/> 
		
		<?php echo form_error('nama', '<p class="field_error">','</p>')?>
		</span>
	</div>
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">Jenis Kelamin</label>
		 <div class="col-md-9">
			<div class="radio">
				<?php echo form_radio('id_jen_kel', '1', FALSE); ?> Laki - laki
			</div>
			<div class="radio">
				<?php echo form_radio('id_jen_kel', '2', FALSE); ?> Perempuan
			</div>
		  
		<?php echo form_error('id_jen_kel', '<p class="field_error">','</p>')?>	
		</span>
	</div>
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label control-label" for="is_sementara_keluarga">Tempat Lahir </label>
		 <div class="col-md-9">
         <span class="help-block">
			<input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" size="35" style="text-transform: uppercase" required /> 
		
		<?php echo form_error('tempat_lahir', '<p class="field_error">','</p>')?>
		</span>	
	</div>
	</div>
	<div class="form-group">
	  <label class="col-md-3 control-label" for="is_sementara_keluarga">Tanggal Lahir </label>
	  <div class="col-md-9">
         <span class="help-block">
		<a href="javascript:NewCssCal('tanggal_lahir','ddmmyyyy')">
		<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" class="form-control control-label"  name="tanggal_lahir" id="tanggal_lahir" size="20" readonly="readonly" required/>
		</div>
		</a>
	
	<?php echo form_error('tanggal_lahir', '<p class="field_error">','</p>')?>	
		</span>
	</div>	
</div>

<legend></legend>
<label class="col-md-0 control-label" for="="><h4>Data Daerah Tujuan</h4></label>
<legend></legend>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">Alamat</label> 
		 <div class="col-md-9">
         <span class="help-block">
			<input type="text" class="form-control control-label" name="alamat_jalan" id="alamat_jalan" size="30" style="text-transform: uppercase" required/> 
		
		<?php echo form_error('alamat_jalan', '<p class="field_error">','</p>')?>
		</span>
	</div>	
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="is_sementara_keluarga"> Desa</label>
		<div class="col-md-9">
         <span class="help-block">
		 <?php $id_desa = 'id="id_desa" class="form-control control-label" required';
				echo form_dropdown('id_desa',$nama_desa,'',$id_desa)?> 
		<?php echo form_error('id_desa', '<p class="field_error">','</p>')?>
		</span>	
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_dusun">Dusun </label>
        <div class="col-md-3">
         
         <?php $id = 'id="id_dusun" class="form-control input-md" required';
				echo form_dropdown('id_dusun',$nama_dusun,'',$id)?>
		 <span class="help-block"></span>
	</div>
	</div>
	
	<div class="form-group">
    	 <label  class="col-md-1 control-label" for="nama_rw">RW </label>
        <div class="col-md-2">
		<?php $id = 'id="id_rw_sementara" class="form-control input-md"';
				echo form_dropdown('id_rw_sementara',array('<-- Pilih Dusun'),'',$id)?>
				
		<div id="lala_dusun"></div>
         <span class="help-block">		 
				
		</span>
		</div>		
	</div>	
	
	<div class="form-group">
    	 <label class="col-md-1 control-label" for="id_rt">RT</label> 
        <div class="col-md-2">
        
        <?php
			$id = 'id="id_rt_sementara" class="form-control input-md"';
			echo form_dropdown("id_rt_sementara",array('<-- Pilih RW'),'',$id);	?>
				<div id="lala"></div>
		<span class="help-block"></span>
		</div>
	</div>
	
<legend></legend>
<label class="col-md-0 control-label" for="="><h4>Data Kepindahan</h4></label>
<legend></legend>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="is_sementara_keluarga"> Tanggal Pindah </label>
		<div class="col-md-9">
         <span class="help-block">
			<a href="javascript:NewCssCal('tgl_pindah_masuk','ddmmyyyy')">
			<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" class="form-control control-label"  name="tgl_pindah_masuk" id="tgl_pindah_masuk" size="20" readonly="readonly" required/>
			</div>
			</a>
		
		<?php echo form_error('tgl_kelahiran_masuk', '<p class="field_error">','</p>')?>
		</span>
		</div>		
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">Jenis Pindah</label>
			<div class="col-md-9">
         <span class="help-block">
		 <?php $id_jenis_pindah = 'id="id_jenis_pindah" class="form-control control-label"';
				echo form_dropdown('id_jenis_pindah',$jenis_pindah,'',$id_jenis_pindah)?> 
		
		<?php echo form_error('id_jenis_pindah', '<p class="field_error">','</p>')?>
		</span>
		</div>	
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">Klasifikasi Pindah</label>
			<div class="col-md-9">
         <span class="help-block">
		 <?php $id_klasifikasi_pindah = 'id="id_klasifikasi_pindah" class="form-control control-label"';
				echo form_dropdown('id_klasifikasi_pindah',$klasifikasi_pindah,'',$id_klasifikasi_pindah)?> 
		<?php echo form_error('id_klasifikasi_pindah', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="is_sementara_keluarga">Alasan Pindah</label>
			<div class="col-md-9">
         <span class="help-block">
		 <?php $id_alasan_pindah = 'id="id_alasan_pindah" class="form-control control-label"';
				echo form_dropdown('id_alasan_pindah',$alasan_pindah,'',$id_alasan_pindah)?> 
		<?php echo form_error('id_alasan_pindah', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
<legend></legend>
<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>peristiwa/c_pindah_masuk'"/>
</p>
<?php echo form_close(); ?>


<script>
function nav_active(){
	
	document.getElementById("a-data-peristiwa").className = "collapsed active";
	document.getElementById("peristiwa").className = "collapsed";
	
	document.getElementById("a-data-pindah_penduduk").className = "collapsed active";
	document.getElementById("pindah_penduduk").className = "collapsed";

	var d = document.getElementById("nav-pindah_masuk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
  
  $("#id_dusun").change(function(){
				var cek = document.getElementById("id_dusun").value;
				
				 if(cek === "")
				{
					document.getElementById("id_rw_sementara").style.display = 'block';
					document.getElementById("id_rw").style.display = 'none';
					
					document.getElementById("id_rt_sementara").style.display = 'block';
					document.getElementById("id_rt").style.display = 'none';
				}
				else
				{ 
					var id_dusun = {id_dusun:$("#id_dusun").val()};
					$.ajax({
							type: "POST",
							url : "<?php echo site_url('peristiwa/c_pindah_masuk/getRw')?>",
							data: id_dusun,
							success: function(msg){
							document.getElementById("id_rw_sementara").style.display = 'none';
							
								$('#lala_dusun').html(msg);
							}
						});
				} 
        });
});
</script>