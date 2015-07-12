<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('pustaka/c_perangkat/update_perangkat'); ?>

<table>
	<input type="hidden" name="id_perangkat" id="id_perangkat" value="<?= $hasil->id_perangkat ?>" size="20" /> 
	<div class="form-group">
        <label class="col-md-3 control-label" for="id_jabatan"> Perangkat Desa</label>
        <div class="col-md-9">
        <span class="help-block">
         <?php $id = 'id="id_jabatan" class="form-control input-md" ';
        echo form_dropdown('id_jabatan',$deskripsi_jabatan,$hasil->id_jabatan,$id)?> 
        </span>
        </div>
    </div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="is_aktif">Status Perangkat Desa</label>
        <div class="col-md-9">
			<div class="radio">
			<input type="radio" name="is_aktif"  value="Y" <?php echo set_radio('is_aktif','Y',$hasil->is_aktif=='Y');?> />Aktif
			</div>
			<div class="radio">
			<input type="radio" name="is_aktif"  value="N" <?php echo set_radio('is_aktif','N',$hasil->is_aktif=='N');?> />Tidak Aktif
			</div>
		</div>
	</div>
	
   	<div class="form-group">
        <label class="col-md-3 control-label" for="nik"> NIK</label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="nik" id="nik" value="<?= $nik ?>" size="25" disabled/> 
        <?php echo form_error('nik', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>

	<div class="form-group">
        <label class="col-md-3 control-label" for="nama_sementara"> Nama </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="nama" id="nama" size="25" value="<?= $nama ?>" disabled/> 
        <input type="hidden" name="nama" id="nama" size="25" /> 
        <?php echo form_error('nama', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-md-3 control-label" for="nip"> NIP</label> 
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="nip" id="nip" value="<?= $hasil->nip ?>" size="25" /> 
        <?php echo form_error('nip', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label" for="niap"> NIAP </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="niap" id="niap" value="<?= $hasil->niap ?>" size="25" /> 
         <?php echo form_error('niap', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label" for="id_pangkat_gol"> Golongan</label>
        <div class="col-md-9">
        <span class="help-block">
         <?php $id = 'id="id_pangkat_gol" class="form-control input-md"';
                echo form_dropdown('id_pangkat_gol',$deskripsi_pangkat_gol,$hasil->id_pangkat_gol,$id)?> 
        </span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label" for="no_sk_angkat"> No. SK Angkat </label>
        <div class="col-md-9">
        <span class="help-block">
         <input class="form-control input-md" type="text" name="no_sk_angkat" id="no_sk_angkat" value="<?= $hasil->no_sk_angkat ?>" size="25" /> 
          <?php echo form_error('no_sk_angkat', '<p class="field_error">','</p>')?>
        </span>
        </div>
    </div>

    <div class="form-group">
        <label  class="col-md-3 control-label" for="tgl_angkat"> Tanggal Angkat </label>
        <div class="col-md-9">
        <a href="javascript:NewCssCal('tgl_angkat','ddmmyyyy')">
        <div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
        <input class="form-control input-md" type="text" name="tgl_angkat" id="tgl_angkat" size="20" readonly="readonly" value="<?= date('d-m-Y',strtotime($hasil->tgl_angkat))?>"/>
        </div></a><span class="help-block"></span>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-3 control-label" for="no_sk_berhenti"> No. SK Berhenti</label> 
        <div class="col-md-9">
        
         <input class="form-control input-md" type="text" name="no_sk_berhenti" id="no_sk_berhenti" value="<?= $hasil->no_sk_berhenti ?>"  size="25" /> 
        <span class="help-block"></span>
        </div>
    </div>  
    
    <div class="form-group">
        <label  class="col-md-3 control-label" for="tgl_berhenti"> Tanggal Berhenti </label>
        <div class="col-md-9">		
        <a href="javascript:NewCssCal('tgl_berhenti','ddmmyyyy')">
        <div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
        <input class="form-control input-md" type="text" name="tgl_berhenti" id="tgl_berhenti" size="20" readonly="readonly" value="<?= date('d-m-Y',strtotime($hasil->tgl_berhenti))?>"/>
        </div></a><span class="help-block"></span>
        </div>
    </div>
 
   <p>
	<input type="submit" value="Simpan" class="btn btn-success" id="simpan"/>
	<input type="button" value="Batal" class="btn btn-danger" id="batal" onclick="location.href='<?= base_url() ?>pustaka/c_perangkat'"/>
   </p>

<?php echo form_close(); ?>

<script>
function nav_active(){
	document.getElementById("a-perangkat").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>