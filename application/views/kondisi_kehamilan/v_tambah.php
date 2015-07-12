<h2><?= $page_title ?></h2>

<div class="row">
                <div class="col-lg-12">

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		


<?php echo form_open_multipart('datapenduduk/c_kondisi_kehamilan/simpan_kondisi_kehamilan'); ?>
	<fieldset>
		<!-- Form Name -->
		<legend></legend>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="nik_nama">Pencarian Data Penduduk</label>  
		  <div class="col-md-9">
		  <input id="nik_nama" name="nik_nama" type="text" placeholder="NIK / Nama Penduduk" class="form-control input-md">
		  <span class="help-block"><?php echo form_error('nik_nama', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<legend></legend>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="nik">NIK</label>  
		  <div class="col-md-9">
		  <input id="nik_sementara" name="nik_sementara" type="text" placeholder="NIK" class="form-control input-md" required="" disabled>
		  <input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" >
		  <span class="help-block"><?php echo form_error('nik', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="nama">Nama Penduduk</label>  
		  <div class="col-md-9">
		  <input id="nama_sementara" name="nama_sementara" type="text" placeholder="Nama Penduduk" class="form-control input-md" required="" disabled >
		  <input id="nama" name="nama" type="hidden" placeholder="Nama Penduduk" class="form-control input-md" >
		  <span class="help-block"><?php echo form_error('nama', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
	
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="is_resti">Resiko Tinggi</label>  
		  <div class="col-md-9">
		  <label class="radio-inline">
				<input type="radio" name="is_resti" id="is_resti" value="Y" />Ya
			</label>
			<label class="radio-inline">
				<input type="radio" name="is_resti" id="is_resti" value="N" />Tidak
			</label>
		  <span class="help-block"><?php echo form_error('is_resti', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="keterangan">Keterangan</label>  
		  <div class="col-md-9">
		  <input id="keterangan" name="keterangan" type="text" placeholder="Keterangan" class="form-control input-md" required="">
		  <span class="help-block"><?php echo form_error('keterangan', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="tgl_hpl">Tanggal Perkiraan Lahir</label>  
		  <div class="col-md-9">
		  <a href="javascript:NewCssCal('tgl_hpl','ddmmyyyy')">
			 <div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input readonly="readonly" class="form-control" type="text"  name="tgl_hpl" id="tgl_hpl" size="20" placeholder="Tgl-Bln-Thn" class="form-control input-md"  />
			</div></a>
			<span class="help-block"><?php echo form_error('tgl_hpl', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
		
		<!-- Button (Double) -->
		<legend></legend>
		<div class="form-group">
		  <label class="col-md-0 control-label" for="simpan"></label>
		  <div class="col-md-9">
			<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
			<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>datapenduduk/c_kondisi_kehamilan'">Batal</button>
		  </div>
		</div>

	</fieldset>
<?php echo form_close(); ?>

</div>
</div>

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
	
	document.getElementById("a-data-perspektif_kesehatan_penduduk").className = "collapsed active";
	
	document.getElementById("perspektif_kesehatan_penduduk").className = "collapsed";

	var d = document.getElementById("nav-kehamilan");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>