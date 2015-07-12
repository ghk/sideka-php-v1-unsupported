<h3><?= $page_title ?></h3>
<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
<legend></legend>
<?php echo form_open('peristiwa/c_pindah_keluar/update_pindah_keluar'); ?>
<input type="hidden" class="form-control" name="id_pindah_keluar" id="id_pindah_keluar" size="35" value="<?= $pindah_keluar->id_pindah_keluar?>"/> 
<!--
 <div class="panel panel-default">
 <div class="panel-heading"><h4>Data Kepala Keluarga</h4></div>
<div class="panel-body">
-->
<div class="form-group">
	<label class="col-md-0 control-label" for=""><h4>Data Kepala Keluarga</h4></label> 
	  <legend></legend>
</div> 

		<div class="form-group">
			 <label class="col-md-3 control-label" for="no_kk">Nomer KK </label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="no_kk_sementara" id="no_kk_sementara" size="50" readonly="readonly" placeholder="No KK"  value="<?= $pindah_keluar->no_kk?>"/>
				<input id="no_kk" name="no_kk" type="hidden" placeholder="Nomer Kepala Keluarga" class="form-control input-md"  value="<?= $pindah_keluar->no_kk?>">
			<?php echo form_error('no_kk', '<p class="field_error">','</p>')?>
			</span>
		</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama">Nama Kepala Keluarga</label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="nama_sementara" id="nama_sementara" size="50" readonly="readonly" placeholder="Nama"  value="<?= $penduduk->nama?>"/>
				<input id="nama" name="nama" type="hidden" placeholder="Nama" class="form-control"  value="<?= $penduduk->nama?>">
				<?php echo form_error('nama', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		<legend></legend>
<!--
</div>		
</div>
-->
<!--
 <div class="panel panel-default">
 <div class="panel-heading"><h4>Data Daerah Tujuan</h4></div>
<div class="panel-body">	
-->
<div class="form-group">
	<label class="col-md-0 control-label" for=""><h4>Data Daerah Tujuan</h4></label> 
	  <legend></legend>
</div> 	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="alamat_jalan">Alamat </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="alamat_jalan" id="alamat_jalan" size="30"  value="<?= $pindah_keluar->alamat_jalan?>"/> 
				<?php echo form_error('alamat_jalan', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_provinsi">Provinsi </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_provinsi" id="nama_provinsi" size="30"  value="<?= $pindah_keluar->nama_provinsi?>"/> 
				<?php echo form_error('nama_provinsi', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_kabkota">Kabupaten / Kota </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_kabkota" id="nama_kabkota" size="30"  value="<?= $pindah_keluar->nama_kabkota?>"/> 
				<?php echo form_error('nama_kabkota', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_kecamatan">Kecamatan </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_kecamatan" id="nama_kecamatan" size="30"  value="<?= $pindah_keluar->nama_kecamatan?>"/> 
				<?php echo form_error('nama_kecamatan', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_desa">Desa / Kelurahan </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_desa" id="nama_desa" size="30"  value="<?= $pindah_keluar->nama_desa?>"/> 
				<?php echo form_error('nama_desa', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_dusun">Dusun </label>
			<div class="col-md-3">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_dusun" id="nama_dusun" size="30"  value="<?= $pindah_keluar->nama_dusun?>"/> 
				<?php echo form_error('nama_dusun', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-1 control-label" for="nomor_rw">RW</label>
			<div class="col-md-2">
			<span class="help-block">
				<input type="text" class="form-control" name="nomor_rw" id="nomor_rw" size="30"  value="<?= $pindah_keluar->nomor_rw?>"/> 
				<?php echo form_error('nomor_rw', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-1 control-label" for="nomor_rt">RT</label>
			<div class="col-md-2">
			<span class="help-block">
				<input type="text" class="form-control" name="nomor_rt" id="nomor_rt" size="30"  value="<?= $pindah_keluar->nomor_rt?>"/> 
				<?php echo form_error('nomor_rt', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<legend></legend>
<!--
</div>
</div>
 <div class="panel panel-default">
 <div class="panel-heading"><h4>Data Kepindahan</h4></div>
<div class="panel-body">
-->
<div class="form-group">
	<label class="col-md-0 control-label" for=""><h4>Data Kepindahan</h4></label> 
	<legend></legend>
</div> 	
	<div class="form-group">
		 <label class="col-md-3 control-label" for="tgl_pindah_keluar">Tanggal Pindah </label>
		<div class="col-md-9">
        <span class="help-block">
			<a href="javascript:NewCssCal('tgl_pindah_keluar','ddmmyyyy')">
				<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" class="form-control"  name="tgl_pindah_keluar" id="tgl_pindah_keluar" size="20" readonly="readonly"  value="<?= date('d-m-Y', strtotime($pindah_keluar->tgl_pindah_keluar))?>"/>
			</div>
			</a>
		<?php echo form_error('tgl_pindah_keluar', '<p class="field_error">','</p>')?>
		</span>
		</div>		
	</div>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="id_jenis_pindah">Jenis Pindah</label>
		<div class="col-md-9">
        <span class="help-block">
		 <?php $id_jenis_pindah = 'id="id_jenis_pindah" class="form-control"';
				echo form_dropdown('id_jenis_pindah',$jenis_pindah,$pindah_keluar->id_jenis_pindah,$id_jenis_pindah)?> 
		
		<?php echo form_error('id_jenis_pindah', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<div class="form-group">
	<label class="col-md-3 control-label" for="id_klasifikasi_pindah">Klasifikasi Pindah</label>
		<div class="col-md-9">
        <span class="help-block">
		 <?php $id_klasifikasi_pindah = 'id="id_klasifikasi_pindah" class="form-control"';
				echo form_dropdown('id_klasifikasi_pindah',$klasifikasi_pindah,$pindah_keluar->id_klasifikasi_pindah,$id_klasifikasi_pindah)?> 
		<?php echo form_error('id_klasifikasi_pindah', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<div class="form-group">
	<label class="col-md-3 control-label" for="id_alasan_pindah">Alasan Pindah</label>
		<div class="col-md-9">
        <span class="help-block">
		 <?php $id_alasan_pindah = 'id="id_alasan_pindah" class="form-control"';
				echo form_dropdown('id_alasan_pindah',$alasan_pindah,$pindah_keluar->id_alasan_pindah,$id_alasan_pindah)?> 
		<?php echo form_error('id_alasan_pindah', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<legend></legend>
<!--
</div>
</div>
-->

<br>
<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>peristiwa/c_pindah_keluar'"/>
</p>
<?php echo form_close(); ?>

<script>
function nav_active(){
	
	document.getElementById("a-data-peristiwa").className = "collapsed active";
	document.getElementById("peristiwa").className = "collapsed";
	
	document.getElementById("a-data-pindah_penduduk").className = "collapsed active";
	document.getElementById("pindah_penduduk").className = "collapsed";

	var d = document.getElementById("nav-pindah_keluar");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>

<script>
function nav_active(){
	document.getElementById("a-surat").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>