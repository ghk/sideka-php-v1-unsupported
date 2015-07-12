<h3><?= $page_title ?></h3>
<legend></legend>
<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open_multipart('peristiwa/c_kelahiran/simpan_kelahiran'); ?>
	<label class="col-md-0 control-label" for="="><h4>Data Bayi</h4></label>
	<legend></legend>
	
		<div class="form-group">
		<label class="col-md-3 control-label" for="nama_bayi">Nama Bayi</label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="nama_bayi" id="nama_bayi" size="30" placeholder="Nama Bayi" required/> 
			<?php echo form_error('nama_bayi', '<p class="field_error">','</p>')?>	
		</span>
		</div>
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="id_jen_kel">Jenis Kelamin</label>
		<div class="col-md-9">
			<div class="radio">
				<?php echo form_radio('id_jen_kel', '1', FALSE); ?> Laki - laki
			</div>
			<div class="radio">
				<?php echo form_radio('id_jen_kel', '2', FALSE); ?> Perempuan
			</div>
			<?php echo form_error('id_jen_kel', '<p class="field_error">','</p>')?>	
		</div>
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_kelahiran">Tanggal Kelahiran</label> 
		<div class="col-md-9">		
			<a href="javascript:NewCssCal('tgl_kelahiran','ddmmyyyy')">
			<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
			<input type="text" class="form-control input-md"  name="tgl_kelahiran" id="tgl_kelahiran" size="20" readonly="readonly"/>
			</div>	</a>
			
		<span class="help-block">	
			<?php echo form_error('tgl_kelahiran', '<p class="field_error">','</p>')?>		
		</span>
		</div>
		</div>
		
		<div class="form-group">
		 <label class="col-md-3 control-label" for="berat_bayi">Berat Bayi </label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="berat_bayi" id="berat_bayi" size="10" placeholder="Berat Bayi (kg)" required/> 
			<?php echo form_error('berat_bayi', '<p class="field_error">','</p>')?>	
		</span>
		</div>
		</div>
		
		<div class="form-group">
		 <label class="col-md-3 control-label" for="panjang_bayi">Panjang Bayi </label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="panjang_bayi" id="panjang_bayi" size="10" placeholder="Panjang Bayi (cm)" required/> 
			<?php echo form_error('panjang_bayi', '<p class="field_error">','</p>')?>
		</span>
		</div>
		</div>
	
		<div class="form-group">
			<label class="col-md-3 control-label" for="is_kembar">Apakah Bayi Kembar?</label>
			<div class="col-md-9">
				<div class="radio">
					<?php echo form_radio('is_kembar', 'Y', FALSE); ?> Ya
				</div>
				<div class="radio">
					<?php echo form_radio('is_kembar', 'N', TRUE); ?> Tidak
				</div>
			</div>
		</div>
	<legend>&nbsp </legend>	
	
	<label class="col-md-0 control-label" for="#"><h4>Data Orang Tua</h4></label>
	<legend></legend>
	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="no_nama_kk">Pencarian Kepala Keluarga</label> 
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="no_nama_kk" id="no_nama_kk" size="50" placeholder="No Kepala Keluarga / Nama (min 2 karakter)"  /> 
			</span>
			<legend></legend>
			 </div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="no_kk">No Kepala Keluarga</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input id="no_kk_sementara" name="no_kk_sementara" type="text" placeholder="No Kepala Keluarga" class="form-control input-md" required="" disabled/>
				<input type="hidden" class="form-control input-md" name="no_kk" id="no_kk" size="50"  /> 
			</span>
			 </div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_kk">Nama Kepala Keluarga</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input id="nama_kk_sementara" name="nama_kk_sementara" type="text" placeholder="Nama Kepala Keluarga" class="form-control input-md" required="" disabled/>
				<input type="hidden" class="form-control input-md" name="nama_kk" id="nama_kk" size="50"  /> 
			</span>
			 </div>
			<?php echo form_error('nama_ayah', '<p class="field_error">','</p>')?>	
		</div>
		
	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_ayah">Nama Ayah</label> 
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nama_ayah" id="nama_ayah" size="50" placeholder="Nama Ayah"  /> 
			 <?php echo form_error('nama_ayah', '<p class="field_error">','</p>')?>
			</span>
			 </div>
		</div>

		<div class="form-group">
			 <label class="col-md-3 control-label" for="nama_ibu">Nama Ibu</label> 
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nama_ibu" id="nama_ibu" size="50" placeholder="Nama Ibu"  /> 
			 <?php echo form_error('nama_ibu', '<p class="field_error">','</p>')?>
			</span>
			 </div>
		</div>
	
	
	<legend>&nbsp </legend>	
	<label class="col-md-0 control-label" for="="><h4>Data Kelahiran</h4></label>
	<legend></legend>
	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="lokasi_lahir">Lokasi Lahir </label>
			 <div class="col-md-9">
			  <span class="help-block">
			 <select type="text" class="form-control input-md" name="lokasi_lahir" id="lokasi_lahir">
				  <option value="Tidak Diketahui">--Pilih--</option>
				  <option value="Rumah Bersalin">Rumah Bersalin</option>
				  <option value="Bukan Rumah Bersalin">Bukan Rumah Bersalin</option>
				  <option value="Lainnya">Lainnya</option>
				</select>
			</span>
			<?php echo form_error('lokasi_lahir', '<p class="field_error">','</p>')?>
		
		</div>	
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="tempat_lahir">Tempat Lahir</label> 
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="tempat_lahir" id="tempat_lahir" size="30" placeholder="Tempat Lahir"/> 
		</span>
			<?php echo form_error('tempat_lahir', '<p class="field_error">','</p>')?>
		</div>	
		</div>
		
		<div class="form-group">
		<label class="col-md-3 control-label" for="penolong">Nama Penolong Kelahiran</label>
		<div class="col-md-9">
		<span class="help-block">
			 <input type="text" class="form-control input-md" name="penolong" id="penolong" size="30" placeholder="Nama Penolong Kelahiran"/>
			<?php echo form_error('penolong', '<p class="field_error">','</p>')?>
		</span>
		</div>	
		</div>
	
	<legend>&nbsp </legend>	
	<label class="col-md-0 control-label" for="="><h4>Data Pelapor</h4></label>
	<legend></legend>
	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="penolong">Pelapor Kelahiran</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor" size="30" placeholder="Nama Pelapor Kelahiran"/> 
			<?php echo form_error('nama_pelapor', '<p class="field_error">','</p>')?>
			</span>
		</div>	
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="penolong">Hubungan Pelapor dengan Ayah</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <?php $id_pelapor = 'id="id_pelapor" class="form-control"';
					echo form_dropdown('id_pelapor',$pelapor,'',$id_pelapor)?> 
			<?php echo form_error('id_pelapor', '<p class="field_error">','</p>')?>
			</span>
		</div>	
		</div>

	<legend>&nbsp </legend>	
	<label class="col-md-0 control-label" for="="><h4>Pencetak Surat Kelahiran</h4></label>
	<legend></legend>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="penolong">Pamong Surat Kelahiran</label>
		<div class="col-md-9">
        <?php $id = 'id="id_perangkat" class="form-control input-md" required';
		echo form_dropdown('id_perangkat',$nama_pamong,'',$id)?>
		<span class="help-block"><?php echo form_error('id_perangkat', '<p class="field_error">','</p>')?> </span> 
		</div>	
	</div>
 
<legend>&nbsp </legend>
<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>peristiwa/c_kelahiran'"/>
</p>
<br>
<?php echo form_close(); ?>

<script>	
  $(function() {
    var nikPenduduk = <?php  echo $json_array_kk; ?> ;
    $("#no_nama_kk" ).autocomplete({
      source: nikPenduduk,
	  minLength: 2,
	  select: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		no_kk = bits[bits.length - 2]
		nama = bits[bits.length - 1]
			$("#no_kk").val(no_kk);
			$("#nama_kk").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_kk_sementara").val(nama);
        },
        change: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		no_kk = bits[bits.length - 2]
		nama = bits[bits.length - 1]
           		$("#no_kk").val(no_kk);
			$("#nama_kk").val(nama);			
			$("#no_kk_sementara").val(no_kk);
			$("#nama_kk_sementara").val(nama);
        }
    });
  });
</script>

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
  
  $('form').submit(function() { 
						
			// always return false to prevent standard browser submit and page navigation 
			$('#simpan').hide();
			return true; 
		}); 
		
});
</script>