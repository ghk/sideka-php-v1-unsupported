<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php

echo form_open_multipart('smart/c_smart/load_data'); 
?>

<legend></legend>	


	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio1">Jenis Kelamin</label>
		
		<div class="col-md-7">
        <?php $id = 'id="id_jen_kel" class="form-control input-md" ';
				echo form_dropdown('id_jen_kel',$id_jen_kel,'',$id)?>
		 <span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio1', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio1', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio2">Tempat Lahir</label>
		
		<div class="col-md-7">
		<input class="form-control input-md" type="text" name="tempat_lahir" id="tempat_lahir" size="30" />
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio2', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio2', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio3">Golongan Darah</label>
		
		<div class="col-md-7">
        <?php $id = 'id="id_goldar" class="form-control input-md" ';
				echo form_dropdown('id_goldar',$id_goldar,'',$id)?>
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio3', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio3', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio4">Kewarganegaraan</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_kewarganegaraan" class="form-control input-md" ';
				echo form_dropdown('id_kewarganegaraan',$id_kewarganegaraan,'',$id)?> 
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio4', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio4', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio5">Pendidikan</label>
		
		<div class="col-md-7">
        <?php $id = 'id="id_pendidikan" class="form-control input-md" ';
				echo form_dropdown('id_pendidikan',$id_pendidikan,'',$id)?>
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio5', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio5', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio6">Agama</label>
		
		<div class="col-md-7">
        <?php $id = 'id="id_agama" class="form-control input-md" ';
				echo form_dropdown('id_agama',$id_agama,'',$id)?>
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio6', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio6', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio7">Pekerjaan</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_pekerjaan" class="form-control input-md" ';
				echo form_dropdown('id_pekerjaan',$id_pekerjaan,'',$id)?> 
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio7', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio7', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio8">Status Perkawinan</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_status_kawin" class="form-control input-md" ';
				echo form_dropdown('id_status_kawin',$id_status_kawin,'',$id)?> 
        <span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio8', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio8', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio9">Status Penduduk</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_status_penduduk" class="form-control input-md" ';
				echo form_dropdown('id_status_penduduk',$id_status_penduduk,'',$id)?> 
         <span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio9', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio9', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>

<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio12">Status Tinggal</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_status_tinggal" class="form-control input-md" ';
				echo form_dropdown('id_status_tinggal',$id_status_tinggal,'',$id)?> 
        <span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio10', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio10', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio11">Penyandang Difabilitas</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_difabilitas" class="form-control input-md" ';
				echo form_dropdown('id_difabilitas',$id_difabilitas,'',$id)?> 
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio11', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio11', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>

<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio16">Kelas Sosial</label>
		
		<div class="col-md-7">
         <?php $id = 'id="id_kelas_sosial" class="form-control input-md" ';
				echo form_dropdown('id_kelas_sosial',$id_kelas_sosial,'',$id)?> 
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio16', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio16', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>

<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio12">Penerima Bantuan Siswa Miskin</label>
		
		<div class="col-md-7">
        <select id="is_bsm" name="is_bsm" class="form-control input-md">
			  <option value="">--Pilih--</option>
			  <option value="Y">Ya</option>
			  <option value="N">Tidak</option>
		</select>		
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio12', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio12', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio13">Penerima Raskin</label>
		
		<div class="col-md-7">
        <select name="is_raskin" id="is_raskin" class="form-control input-md">
			  <option value="">--Pilih--</option>
			  <option value="Y">Ya</option>
			  <option value="N">Tidak</option>
		</select>		
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio13', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio13', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio14">Penerima Jamkesmas</label>
		
		<div class="col-md-7">
        <select name="is_jamkesmas" id="is_jamkesmas" class="form-control input-md">
			  <option value="">--Pilih--</option>
			  <option value="Y">Ya</option>
			  <option value="N">Tidak</option>
		</select>		
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio14', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio14', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>


<legend></legend>
	<div class="form-group">
	 	<label class="col-md-3 control-label" for="radio15">Penerima Program Keluarga Harapan</label>
		
		<div class="col-md-7">
        <select name="is_pkh" id="is_pkh" class="form-control input-md">
			  <option value="">--Pilih--</option>
			  <option value="Y">Ya</option>
			  <option value="N">Tidak</option>
		</select>		
		<span class="help-block"></span>
		</div>
		
		<div class="col-md-1">
        <div class="radio">
		<?php echo form_radio('radio15', 'AND', TRUE); ?> DAN
		</div>
		</div>
		
		<div class="col-md-1">
		<div class="radio">
		<?php echo form_radio('radio15', 'OR', FALSE); ?> ATAU
		</div>
		</div>
	</div>
<legend></legend>

<div class="form-group">
		  <label class="col-md-5 control-label" for="cari"></label>
		  <div class="col-md-7">
			<button id="cari" type="submit" name="cari" class="btn btn-success"><span class="fa fa-search white"></span> Cari</button>
		  </div>
</div>
<br>
<br>
<br>
<br>
<?php echo form_close(); ?>

<script>
$(function() {
  	
$('form').submit(function() {
	  
	var a1 = document.getElementById("id_jen_kel");
	var a2 = document.getElementById("tempat_lahir");
	var a3 = document.getElementById("id_goldar");
	var a4 = document.getElementById("id_kewarganegaraan");
	var a5 = document.getElementById("id_pendidikan");
	var a6 = document.getElementById("id_agama");
	var a7 = document.getElementById("id_pekerjaan");
	var a8 = document.getElementById("id_status_kawin");
	var a9 = document.getElementById("id_status_penduduk");
	var a10 = document.getElementById("id_status_tinggal");
	var a11 = document.getElementById("id_difabilitas");
	var a12 = document.getElementById("is_bsm");
	var a13 = document.getElementById("is_raskin");
	var a14 = document.getElementById("is_jamkesmas");
	var a15 = document.getElementById("is_pkh");
	var a16 = document.getElementById("id_kelas_sosial");
	
	if( a1.value === "" && a2.value === "" && a3.value === "" && a4.value === "" && a5.value === "" && a6.value === "" && a7.value === "" && a8.value === "" && 
	a9.value === "" && a10.value === "" && a11.value === "" && a12.value === "" && a13.value === "" && a14.value === "" && a15.value === "" && a16.value === "" )
	{
		alertify.error('Anda belum mengisi form pencarian !');
		return false;
	}
	else 
	{
		return true;
	}
	  // Prevent the form from actually submitting
	  return true;
	});
  });
</script>


<script>
function nav_active(){
	document.getElementById("a-smart").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>