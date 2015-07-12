<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('peristiwa/c_meninggal/update_meninggal'); ?>

<input id="id_meninggal" name="id_meninggal" type="hidden" placeholder="Nama" value="<?= $hasil->id_meninggal?>" class="form-control" >
<input id="id_surat" name="id_surat" type="hidden" placeholder="Nama" value="<?= $hasil->id_surat?>" class="form-control" >

<legend></legend>
	<!--<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="20" /> -->
	<label class="col-md-0 control-label" for="="><h4>Data Kematian Penduduk</h4></label>
	<legend></legend>	
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nama</label>
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="nama_sementara" id="nama_sementara" size="50" readonly="readonly" placeholder="Nama" value="<?= $penduduk->nama?>"/>
				<input id="nama" name="nama" type="hidden" placeholder="Nama" class="form-control" value="<?= $penduduk->nama?>">
			
			<?php echo form_error('nama', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">NIK Penduduk</label> 
			 <div class="col-md-9">
			 <span class="help-block">
				<input type="text" class="form-control" name="nik_penduduk_sementara" id="nik_penduduk_sementara" size="50" readonly="readonly" placeholder="NIK" value="<?= $penduduk->nik?>"/>
				<input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" value="<?= $penduduk->nik?>">
			
			<?php echo form_error('nik', '<p class="field_error">','</p>')?>
         </span>	
			</div>
		</div>

		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Tanggal Kematian </label>
			<div class="col-md-9">
			 <span class="help-block">
				<a href="javascript:NewCssCal('tm','ddmmyyyy')">
					<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" class="form-control" name="tgl_meninggal" id="tm" size="50" readonly="readonly" placeholder="Tanggal - Bulan - Tahun" value="<?= date('d-m-Y', strtotime($hasil->tgl_meninggal))?>" required/>
							 
					</div>
				</a>
				<?php echo form_error('tgl_meninggal', '<p class="field_error">','</p>')?>		
        </div>
			
			
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Penyebab Kematian </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control"  name="sebab" id="sebab" size="30" placeholder="Penyebab Kematian" value="<?= $hasil->sebab?>" required/> 
			<?php echo form_error('sebab', '<p class="field_error">','</p>')?>	
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Penentu Kematian </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control"  name="penentu_kematian" id="penentu_kematian" size="30" placeholder="Penentu Kematian" value="<?= $hasil->penentu_kematian?>" required/> 
			<?php echo form_error('penentu_kematian', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Tempat Kematian </label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <input type="text" class="form-control"  name="tempat_kematian" id="tempat_kematian" size="30" placeholder="Tempat Kematian" value="<?= $hasil->tempat_kematian?>" required/> 
			<?php echo form_error('tempat_kematian', '<p class="field_error">','</p>')?>	
         </span>
			</div>
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
			 <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor" size="30" placeholder="Pelapor Kematian" value="<?= $hasil->nama_pelapor?>" required/> 
			<?php echo form_error('nama_pelapor', '<p class="field_error">','</p>')?>	
         </span>
			</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Hubungan Pelapor</label>
			 <div class="col-md-9">
			 <span class="help-block">
			 <?php $id_pelapor = 'id="id_pelapor" class="form-control" required';
					echo form_dropdown('id_pelapor',$pelapor,$hasil->id_pelapor,$id_pelapor)?> 
         </span>
			</div>
		</div>
	<legend></legend>
		
		<div class="form-group">
        <label  class="col-md-3 control-label" for="id_perangkat"> Pamong Surat Kematian</label> 
        <div class="col-md-9">		
		<span class="help-block" ><?php $id = 'id="id_perangkat" class="form-control input-md" required';
        echo form_dropdown('id_perangkat',$nama_pamong,$perangkat->id_perangkat,$id);?></span>
        </div>
    </div>

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
			$("#id_penduduk").val(nik);
			$("#nama").val(nama);
			$("#id_penduduk_sementara").val(nik);
			$("#nama_sementara").val(nama);
        },
        change: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		nik = bits[bits.length - 2]
		nama = bits[bits.length - 1]
           		$("#id_penduduk").val(nik);
			$("#nama").val(nama);			
			$("#id_penduduk_sementara").val(nik);
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
});
</script>