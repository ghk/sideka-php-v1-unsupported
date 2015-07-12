<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('peristiwa/c_pindah_keluar/simpan_pindah_keluar'); ?>
<legend></legend>
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
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Pencarian Data Kepala Keluarga</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nokk_nama" id="nokk_nama" size="50" placeholder="No KK / Nama (min 2 karakter)" required/> 
			</span>
		</div>
		</div>
		<legend></legend>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="no_kk">Nomer Kepala Keluarga </label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="no_kk_sementara" id="no_kk_sementara" size="50" readonly="readonly" placeholder="No KK"/>
				<input id="no_kk" name="no_kk" type="hidden" placeholder="Nomer Kepala Keluarga" class="form-control input-md" >
			<?php echo form_error('no_kk', '<p class="field_error">','</p>')?>
			</span>
		</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama">Nama Kepala Keluarga</label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="nama_sementara" id="nama_sementara" size="50" readonly="readonly" placeholder="Nama"/>
				<input id="nama" name="nama" type="hidden" placeholder="Nama" class="form-control" >
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
				<input type="text" class="form-control" name="alamat_jalan" id="alamat_jalan" size="30" required/> 
				<?php echo form_error('alamat_jalan', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_provinsi">Provinsi </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_provinsi" id="nama_provinsi" size="30" required/> 
				<?php echo form_error('nama_provinsi', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_kabkota">Kabupaten / Kota </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_kabkota" id="nama_kabkota" size="30" required/> 
				<?php echo form_error('nama_kabkota', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_kecamatan">Kecamatan </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_kecamatan" id="nama_kecamatan" size="30" required/> 
				<?php echo form_error('nama_kecamatan', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_desa">Desa / Kelurahan </label>
			<div class="col-md-9">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_desa" id="nama_desa" size="30" required/> 
				<?php echo form_error('nama_desa', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_dusun">Dusun </label>
			<div class="col-md-3">
			<span class="help-block">
				<input type="text" class="form-control" name="nama_dusun" id="nama_dusun" size="30" required/> 
				<?php echo form_error('nama_dusun', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-1 control-label" for="nomor_rw">RW</label>
			<div class="col-md-2">
			<span class="help-block">
				<input type="text" class="form-control" name="nomor_rw" id="nomor_rw" size="30" required/> 
				<?php echo form_error('nomor_rw', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-1 control-label" for="nomor_rt">RT</label>
			<div class="col-md-2">
			<span class="help-block">
				<input type="text" class="form-control" name="nomor_rt" id="nomor_rt" size="30" required/> 
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
							<input type="text" class="form-control"  name="tgl_pindah_keluar" id="tgl_pindah_keluar" size="20" required readonly="readonly"/>
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
		 <?php $id_jenis_pindah = 'id="id_jenis_pindah" class="form-control" required';
				echo form_dropdown('id_jenis_pindah',$jenis_pindah,'',$id_jenis_pindah)?> 
		
		<?php echo form_error('id_jenis_pindah', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<div class="form-group">
	<label class="col-md-3 control-label" for="id_klasifikasi_pindah">Klasifikasi Pindah</label>
		<div class="col-md-9">
        <span class="help-block">
		 <?php $id_klasifikasi_pindah = 'id="id_klasifikasi_pindah" class="form-control"  required';
				echo form_dropdown('id_klasifikasi_pindah',$klasifikasi_pindah,'',$id_klasifikasi_pindah)?> 
		<?php echo form_error('id_klasifikasi_pindah', '<p class="field_error">','</p>')?>	
		</span>
		</div>
	</div>
	<div class="form-group">
	<label class="col-md-3 control-label" for="id_alasan_pindah">Alasan Pindah</label>
		<div class="col-md-9">
        <span class="help-block">
		 <?php $id_alasan_pindah = 'id="id_alasan_pindah" class="form-control"  required';
				echo form_dropdown('id_alasan_pindah',$alasan_pindah,'',$id_alasan_pindah)?> 
		<?php echo form_error('id_alasan_pindah', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<legend></legend>
<!--
</div>
</div>
-->

<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>peristiwa/c_pindah_keluar'"/>
</p>
<?php echo form_close(); ?>


<script>	

  $(function() {
    var noKK = <?php  echo $json_array; ?> ;
    $("#nokk_nama" ).autocomplete({
      source: noKK,
	  minLength: 2,
	  select: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		no_kk = bits[bits.length - 2]
		nama = bits[bits.length - 1]
			$("#no_kk").val(no_kk);
			$("#nama").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_sementara").val(nama);
        },
        change: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		no_kk = bits[bits.length - 2]
		nama = bits[bits.length - 1]
			$("#no_kk").val(no_kk);
			$("#nama").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_sementara").val(nama);
        }
    });
  });
  
</script>

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