<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		
<?php echo form_open('pustaka/c_perangkat/simpan_perangkat/'); ?>

<legend></legend>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_jabatan"> Perangkat Desa</label>
        <div class="col-md-9">        
         <?php $id = 'id="id_jabatan" class="form-control input-md" required';
		echo form_dropdown('id_jabatan',$deskripsi_jabatan,'',$id)?> 
		<span class="help-block"></span>
		</div>
	</div>

	<div class="form-group">
	
	 	<label class="col-md-3 control-label" for="is_aktif">Status Perangkat Desa</label>
        <div class="col-md-9">
        <div class="radio">
		<?php echo form_radio('is_aktif', 'Y', TRUE); ?> Aktif
		</div>
		<div class="radio">
		<?php echo form_radio('is_aktif', 'N', FALSE); ?> Tidak Aktif
		</div>
		</div>
	</div>
	
	<legend></legend>
	<div class="form-group">
	  <label class="col-md-3 control-label" for="nik_nama">Pencarian Data Penduduk </label> 
	  <div class="col-md-9">
	  <input id="nik_nama" name="nik_nama" type="text" placeholder="NIK / Nama Penduduk" class="form-control input-md">
	  <span class="help-block"><?php echo form_error('nik_nama', '<p class="field_error">','</p>')?>
	  </span>
	  </div>
	</div>
	<legend></legend>

   	<div class="form-group">
    	<label class="col-md-3 control-label" for="nik"> NIK</label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="nik_sementara" id="nik_sementara" size="25" placeholder="NIK" disabled/> 
		<input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" >
        <?php echo form_error('nik', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="nama_sementara"> Nama </label>
        <div class="col-md-9">
        <span class="help-block">
		 <input class="form-control input-md" type="text" name="nama_sementara" id="nama_sementara" size="25" placeholder="Nama Penduduk" disabled/> 
		<input type="hidden" name="nama" id="nama" size="25" /> 
		<?php echo form_error('nama', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>
	
	<div class="form-group">
    	<label class="col-md-3 control-label" for="nip"> NIP</label> 
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="nip" id="nip" size="25" placeholder="NIP"/> 
        <?php echo form_error('nip', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>

	<div class="form-group">
    	<label class="col-md-3 control-label" for="niap"> NIAP</label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="niap" id="niap" size="25" placeholder="NIAP"/> 
         <?php echo form_error('niap', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>

	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_pangkat_gol"> Golongan</label>
        <div class="col-md-9">
        <span class="help-block">
         <?php $id = 'id="id_pangkat_gol" class="form-control input-md"';
				echo form_dropdown('id_pangkat_gol',$deskripsi_pangkat_gol,'',$id)?> 
		</span>
		</div>
	</div>

	<div class="form-group">
    	<label class="col-md-3 control-label" for="no_sk_angkat"> No. SK Angkat </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="no_sk_angkat" id="no_sk_angkat" size="25" /> 
          <?php echo form_error('no_sk_angkat', '<p class="field_error">','</p>')?>
		</span>
		</div>
	</div>

	<div class="form-group">
    	 <label class="col-md-3 control-label" for="tgl_angkat">Tanggal Angkat </label> 
        <div class="col-md-9">
        <a href="javascript:NewCssCal('tgl_angkat','ddmmyyyy')">
		<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
        <input class="form-control input-md" type="text" name="tgl_angkat" id="tgl_angkat" size="20" readonly="readonly"/>
		</div></a>
	<span class="help-block"><?php echo form_error('tgl_angkat', '<p class="field_error">','</p>')?></span>
	</div>
	</div>


	<div class="form-group">
    	<label class="col-md-3 control-label" for="no_sk_berhenti"> No. SK Berhenti</label> 
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="no_sk_berhenti" id="no_sk_berhenti" size="25" /> 
		</span>
		</div>
	</div>	
	
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="tgl_berhenti">Tanggal Berhenti</label> 
        <div class="col-md-9">
        <a href="javascript:NewCssCal('tgl_berhenti','ddmmyyyy')">
		<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
        <input class="form-control input-md" type="text" name="tgl_berhenti" id="tgl_berhenti" size="20" readonly="readonly"/>
		</div></a>
	<span class="help-block"><?php echo form_error('tgl_berhenti', '<p class="field_error">','</p>')?></span>
	</div>
	</div>
	

<p>
<input type="submit" value="Simpan" class="btn btn-success" id="simpan"/>
<input type="button" value="Batal" class="btn btn-danger" id="batal" onclick="location.href='<?= base_url() ?>pustaka/c_perangkat'"/>
</p>
<legend></legend>
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
  
</script>

<script>
function nav_active(){
	document.getElementById("a-perangkat").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>