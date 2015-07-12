<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('peristiwa/c_meninggal/simpan_meninggal'); ?>
<legend></legend>
	<!--<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="20" /> -->
	<label class="col-md-0 control-label" for="="><h4>Data Kematian Penduduk</h4></label>
	<legend></legend>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Pencarian Data Kematian</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nik_nama" id="nik_nama" size="50" placeholder="NIK / Nama (min 2 karakter)"/> 
         </span>
			</div>
		</div>
		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nama</label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="nama_sementara" id="nama_sementara" size="50" readonly="readonly" placeholder="Nama" required/>
				<input id="nama" name="nama" type="hidden" placeholder="Nama" class="form-control" >
			
			<?php echo form_error('nama', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">NIK Penduduk</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="nik_penduduk_sementara" id="nik_penduduk_sementara" size="50" readonly="readonly" placeholder="NIK"/>
				<input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" >
			
			<?php echo form_error('nik', '<p class="field_error">','</p>')?>
			</span>	
			</div>
		</div>
		
		<div id="lala"></div>
		

		
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Tanggal Kematian </label>
			<div class="col-md-9">
			 <span class="help-block">
				<a href="javascript:NewCssCal('tm','ddmmyyyy')">
					<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" class="form-control" name="tgl_meninggal" id="tm" size="50" readonly="readonly" placeholder="Tanggal - Bulan - Tahun"/>
							
					</div>
				</a>
			<?php echo form_error('tgl_meninggal', '<p class="field_error">','</p>')?>	
        </div>	
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Penyebab Kematian </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control"  name="sebab" id="sebab" size="30" placeholder="Penyebab Kematian" required/> 
			<?php echo form_error('sebab', '<p class="field_error">','</p>')?>	
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Penentu Kematian </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control"  name="penentu_kematian" id="penentu_kematian" size="30" placeholder="Penentu Kematian" required/> 
			<?php echo form_error('penentu_kematian', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Tempat Kematian </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control"  name="tempat_kematian" id="tempat_kematian" size="30" placeholder="Tempat Kematian"/> 
			<?php echo form_error('tempat_kematian', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		
		
<legend></legend>
	<!--<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="20" /> -->
	<label class="col-md-0 control-label" for="="><h4>Data Pelapor Kematian</h4></label>
	<legend></legend>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nama Pelapor </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor" size="30" placeholder="Pelapor Kematian" required/> 
			<?php echo form_error('nama_pelapor', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Hubungan Pelapor</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <?php $id_pelapor = 'id="id_pelapor" class="form-control" required';
					echo form_dropdown('id_pelapor',$pelapor,'',$id_pelapor)?> 
         </span>
			</div>
		</div>
		
			<legend></legend>	
	<label class="col-md-0 control-label" for="="><h4></h4></label>
	<legend></legend>
	<div class="form-group">
		 <label class="col-md-3 control-label" for="penolong">Pamong Surat Kematian</label>
		<div class="col-md-9">
        <?php $id = 'id="id_perangkat" class="form-control input-md" required';
		echo form_dropdown('id_perangkat',$nama_pamong,'',$id)?>
		<span class="help-block"><?php echo form_error('id_perangkat', '<p class="field_error">','</p>')?> </span> 
		</div>	
	</div>
 
<legend></legend>

<br>
<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>peristiwa/c_meninggal'"/>
</p>
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
			$("#nik_penduduk_sementara").val(nik);
			$("#nama_sementara").val(nama);
			
			 $.ajax
			 ({
					type: "POST",
					url : "<?php echo site_url('peristiwa/c_meninggal/cek_kepala_keluarga')?>",
					data: $("#nik").val(nik),
					success: function(data)
					{
						if(data)
						{
							var niklala = {niklala:nik};
								$.ajax
								({
									type: "POST",
									url : "<?php echo site_url('peristiwa/c_meninggal/get_anggotaKeluarga')?>",
									data: niklala,
									success: function(msg)
									{
										$('#lala').html(msg);
										document.getElementById("lala").style.display = 'block';
									}
								});
						}
						else
						{
							document.getElementById("lala").style.display = 'none';
						}
					}
			});
        },
        change: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		nik = bits[bits.length - 2]
		nama = bits[bits.length - 1]
			$("#nik").val(nik);
			$("#nama").val(nama);
			$("#nik_penduduk_sementara").val(nik);
			$("#nama_sementara").val(nama);
			
			 
						
			
        }
    });
  });
  
</script>

<script>
function nav_active(){
	
	document.getElementById("a-data-peristiwa").className = "collapsed active";
	
	document.getElementById("peristiwa").className = "collapsed";

	var d = document.getElementById("nav-meninggal");
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