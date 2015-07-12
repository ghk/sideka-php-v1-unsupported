<h2><?= $page_title ?></h2>

<div class="row">
                <div class="col-lg-12">

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		


<?php echo form_open_multipart('datapenduduk/c_pisah_kk/simpan_tambah_kk'); ?>
	
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

<legend></legend>

<div class="form-group">
	 <label class="col-md-3 control-label" for="no_kk">No Kartu Keluarga*</label>
	<div class="col-md-9">
	 <span class="help-block">
	 <input class="form-control input-md" type="text" name="no_kk" id="no_kk" size="30" required/>
	 </span>
</div>
</div>

<div class="form-group">
	 <label class="col-md-3 control-label" for="alamat_jalan">Alamat</label>
	 <div class="col-md-9">
	 <span class="help-block">
	 <input class="form-control input-md" type="text" name="alamat_jalan" id="alamat_jalan" size="30" style="text-transform: uppercase" required/> 
	 </span>
</div>
</div>

<div class="form-group">
	 <label class="col-md-3 control-label" for="id_dusun">Dusun </label>
	<div class="col-md-3">
	 <span class="help-block">
	 <?php $id = 'id="id_dusun" class="form-control input-md" required';
			echo form_dropdown('id_dusun',$nama_dusun,'',$id)?>
	 </span>
</div>
</div>

<div class="form-group">
	 <label class="col-md-1 control-label" for="id_rw">RW</label> 
	<div class="col-md-2">
	<span class="help-block">
	<?php $id = 'id="id_rw" class="form-control input-md" required';
			echo form_dropdown('id_rw',$nomor_rw,'',$id)?>
	</span>
	</div>	
</div>	

<div class="form-group">
	 <label class="col-md-1 control-label" for="id_rt">RT</label> 
	<div class="col-md-2">
	<span class="help-block">
	<?php
		$id = 'id="id_rt_sementara" class="form-control input-md"';
		echo form_dropdown("id_rt_sementara",array('Pilih RW dahulu'),'',$id);
	?>
			<div id="lala"></div>
	</span>
	</div>
</div>
<div class="form-group">
	 <label class="col-md-3 control-label" for="id_kelas_sosial">Kelas Sosial</label> 
	<div class="col-md-9">
	<span class="help-block"><?php $id = 'id="id_kelas_sosial" class="form-control input-md" required';
			echo form_dropdown('id_kelas_sosial',$id_kelas_sosial,'',$id)?>
	</span>
	</div>
</div>
<div class="form-group">
	 <label class="col-md-3 control-label" for="is_pkh">Menerima Program Keluarga Harapan</label>
	<div class="col-md-2">
	 <div class="radio">
	<?php echo form_radio('is_pkh', 'Y', FALSE); ?> Ya
	</div>
	<div class="radio">
	<?php echo form_radio('is_pkh', 'N', TRUE); ?> Tidak
	</div>
	</div>
</div>	
<div class="form-group">
	 <label class="col-md-1 control-label" for="is_raskin">Raskin</label>
	<div class="col-md-2">
	 <div class="radio">
	<?php echo form_radio('is_raskin', 'Y', FALSE); ?> Ya
	</div>
	<div class="radio">
	<?php echo form_radio('is_raskin', 'N', TRUE); ?> Tidak
	</div>
</div>
</div>
<div class="form-group">
	 <label class="col-md-2 control-label" for="is_jamkesmas">Jamkesmas</label>
	<div class="col-md-2">
	 <div class="radio">
	<?php echo form_radio('is_jamkesmas', 'Y', FALSE); ?> Ya
	</div>
	<div class="radio">
	<?php echo form_radio('is_jamkesmas', 'N', TRUE); ?> Tidak
	</div>
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
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-pisah_kk");
	d.className = d.className + "active";
	}
  
// very simple to use!
$(document).ready(function() {
  nav_active();
  
  $("#id_rw").change(function(){
				var cek = document.getElementById("id_rw").value;
				if(cek === "")
				{
					document.getElementById("id_rt_sementara").style.display = 'block';
					document.getElementById("id_rt").style.display = 'none';
				}
				else
				{
					var id_rw = {id_rw:$("#id_rw").val()};
					$.ajax({
							type: "POST",
							url : "<?php echo site_url('datapenduduk/c_pisah_kk/getRt')?>",
							data: id_rw,
							success: function(msg){
							document.getElementById("id_rt_sementara").style.display = 'none';
								$('#lala').html(msg);
							}
						});
				}
        });
});
</script>