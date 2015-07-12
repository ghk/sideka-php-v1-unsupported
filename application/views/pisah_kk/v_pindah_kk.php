<h2><?= $page_title ?></h2>

<div class="row">
                <div class="col-lg-12">

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		


<?php echo form_open_multipart('datapenduduk/c_pisah_kk/simpan_pindah_kk'); ?>
	
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

	<div id="lala"></div>
	
	<div class="form-group">
	 <label class="col-md-3 control-label" for="id_kelas_sosial">Status Keluarga Baru</label> 
	<div class="col-md-9">
	<?php $id = 'id="id_status_keluarga" class="form-control input-md" required';
			echo form_dropdown('id_status_keluarga',$id_status_keluarga,'',$id)?>
	<span class="help-block"></span>
	</div>
</div>
<legend></legend>

<!-- Text input-->
	<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Pencarian Data Kartu Keluarga</label>
			 <div class="col-md-9">			 
			 <input type="text" class="form-control" name="nokk_nama" id="nokk_nama" size="50" placeholder="No KK / Nama (min 2 karakter)" /> 
			<span class="help-block"></span>
		</div>
		</div>
		<legend></legend>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nomer Kartu Keluarga Tujuan</label>
			 <div class="col-md-9">			 
				<input type="text" class="form-control" name="no_kk_sementara" id="no_kk_sementara" size="50" readonly="readonly" placeholder="No KK" />
				<input id="no_kk" name="no_kk" type="hidden" placeholder="Nomer Kepala Keluarga" class="form-control input-md" >
			<span class="help-block"><?php echo form_error('no_kk', '<p class="field_error">','</p>')?>
			</span>
		</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nama Kepala Keluarga Tujuan</label>
			 <div class="col-md-9">
			 
				<input type="text" class="form-control" name="nama_sementara" id="nama_sementara_kepala" size="50" readonly="readonly" placeholder="Nama"/>
				<input id="nama_kepala" name="nama" type="hidden" placeholder="Nama" class="form-control" >
			<span class="help-block">	<?php echo form_error('nama', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>



<legend></legend>
   
<div class="form-group">
  <label class="col-md-0 control-label" for="simpan"></label>
  <div class="col-md-9">
	<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
	<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>datapenduduk/c_pisah_kk'">Batal</button>
  </div>
</div>
<br>
	
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
									
			var niklala = {niklala:nik};
			$.ajax({
					type: "POST",
					url : "<?php echo site_url('datapenduduk/c_pisah_kk/cekKepalaKeluarga')?>",
					data: niklala,
					success: function(data){
						if(data)
						{
							var dataKepala = {nama:nama};
							$.ajax({
								type: "POST",
								url : "<?php echo site_url('datapenduduk/c_pisah_kk/getNotifKepalaKeluarga')?>",
								data: dataKepala,
								success: function(msg){
									$('#lala').html(msg);
									document.getElementById("lala").style.display = "block";
								}
							});
						}
						else
						{
							document.getElementById("lala").style.display = "none";
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
			$("#nik_sementara").val(nik);
			$("#nama_sementara").val(nama);
			
        }
    });
  });
  
</script>
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
			$("#nama_kepala").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_sementara_kepala").val(nama);
			document.getElementById("simpan").disabled = false;
        },
        change: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		no_kk = bits[bits.length - 2]
		nama = bits[bits.length - 1]
			$("#no_kk").val(no_kk);
			$("#nama_kepala").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_sementara_kepala").val(nama);
		
        }
    });
  });
  
</script>
<script>
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-pisah_kk");
	d.className = d.className + "active";
	}
  
// very simple to use!
$(document).ready(function() {
	nav_active();
	document.getElementById("simpan").disabled = true;	
});
</script>