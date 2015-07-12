<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php
$attributes = array('name' => 'myform');
echo form_open_multipart('datapenduduk/c_keluarga/simpan_keluarga', $attributes); 
?>
<fieldset>
<legend></legend>
	<!--<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="20" /> -->
	<label class="col-md-0 control-label" for="="><h4>Data Keluarga</h4></label>
	<legend></legend>
	
	<div class="form-group">
	
	 	<label class="col-md-3 control-label" for="is_sementara_keluarga">Status Keluarga Sementara</label>
        <div class="col-md-9">
        <div class="radio">
		<?php echo form_radio('is_sementara_keluarga', 'Y', FALSE); ?> Ya
		</div>
		<div class="radio">
		<?php echo form_radio('is_sementara_keluarga', 'N', TRUE); ?> Tidak
		</div>
		</div>
	</div>
	
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="no_kk">No Kartu Keluarga*</label>
        <div class="col-md-9">
         <span class="help-block">
         <input class="form-control input-md" type="text" name="no_kk" id="no_kk" size="30" />
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
         
         <?php $id = 'id="id_dusun" class="form-control input-md" required';
				echo form_dropdown('id_dusun',$nama_dusun,'',$id)?>
		 <span class="help-block"></span>
	</div>
	</div>
	
	<div class="form-group">
    	 <label  class="col-md-1 control-label" for="nama_rw">RW </label>
        <div class="col-md-2">
		<?php $id = 'id="id_rw_sementara" class="form-control input-md"';
				echo form_dropdown('id_rw_sementara',array('<-- Pilih Dusun'),'',$id)?>
				
		<div id="lala_dusun"></div>
         <span class="help-block">		 
				
		</span>
		</div>		
	</div>	
	
	<div class="form-group">
    	 <label class="col-md-1 control-label" for="id_rt">RT</label> 
        <div class="col-md-2">
        
        <?php
			$id = 'id="id_rt_sementara" class="form-control input-md"';
			echo form_dropdown("id_rt_sementara",array('<-- Pilih RW'),'',$id);	?>
				<div id="lala"></div>
		<span class="help-block"></span>
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


	<label class="col-md-0 control-label" for="="><h4>Data Kepala Keluarga</h4></label>
	<legend></legend>  
 
	<div class="form-group">
		<label class="col-md-3 control-label" for="is_sementara_penduduk">Status Penduduk Sementara</label>
		<div class="col-md-9">
		<div class="radio">
		<?php echo form_radio('is_sementara_penduduk', 'Y', FALSE); ?> Ya
		</div>
		<div class="radio">
		<?php echo form_radio('is_sementara_penduduk', 'N', TRUE); ?> Tidak
		</div>
		</div>
	</div>
	
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="nik">NIK* </label> </span>
        <div class="col-md-9">         
         <input class="form-control input-md" type="text" name="nik" size="30" id="nik" /> 
		 <span class="help-block"></span>
		</div>
	</div>
	
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="nama" >Nama </label> 
        <div class="col-md-9">
         <input class="form-control input-md" type="text" name="nama" id="nama" size="30" style="text-transform: uppercase" required/> 
         <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="tempat_lahir">Tempat/Tgl Lahir </label> 
        <div class="col-md-5">
         <input class="form-control input-md" type="text" name="tempat_lahir" id="tempat_lahir" size="30" style="text-transform: uppercase" required/> 
         <span class="help-block"></span>
		</div>

        <div class="col-md-4">
        <a href="javascript:NewCssCal('ttl','ddmmyyyy')">
		 <div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
        <input class="form-control input-md" type="text" name="tanggal_lahir" id="ttl" size="20" readonly="readonly" placeholder="Tgl-Bln-Thn"/>
		</div>
		</a>
        <span class="help-block"></span>
					
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="id_jen_kel">Jenis Kelamin</label>
		<div class="col-md-9">
			<ul class="kelamin">
			   <li>
				   <input name="id_jen_kel" class="id_jen_kel" type="radio" id="laki" value="1"> Laki Laki      
				</li>       
				<li>
					<input name="id_jen_kel" class="id_jen_kel" type="radio" id="perempuan" value="2"> Perempuan
					<ul id="list-perempuan">
						<li>
							<input type="radio" name="hamil" class="tidakHamil" id="tidakHamil" checked="true" value="N">Tidak Hamil<br>			
						</li>
						<li>
							<input type="radio" name="hamil" class="sedangHamil" id="sedangHamil" value="Y">Sedang Hamil<br>						
							<ul id="list-sedangHamil">
								<li>
									<input type="radio" name="is_resti" checked="true" value="N">Normal<br>
									<input type="radio" name="is_resti" value="Y">Resiko Tinggi<br>									
									<!-- Text input-->
									<div class="form-group">
									  <label class="control-label" for="keterangan">Keterangan</label>  
									  <div>
									  <input id="keterangan" name="keterangan" type="text" placeholder="Keterangan" class="form-control input-md">
									  <span class="help-block"><?php echo form_error('keterangan', '<p class="field_error">','</p>')?></span>  
									  </div>
									</div>
									<!-- Text input-->
									<div class="form-group">
									  <label class="control-label" for="tgl_hpl">Tanggal Perkiraan Lahir</label>  
									  <div>
									  <a href="javascript:NewCssCal('tgl_hpl','ddmmyyyy')">
										 <div class="input-group">
											 <span class="input-group-addon">
												<span class="fa fa-table"></span>
											</span>
										<input class="form-control" type="text"  name="tgl_hpl" id="tgl_hpl" size="20" readonly="readonly" placeholder="Tgl-Bln-Thn" class="form-control input-md"  />
										</div>
										</a>
										<span class="help-block"><?php echo form_error('tgl_hpl', '<p class="field_error">','</p>')?></span>  
									  </div>
									</div>
								</li>
							</ul>
						<li>
					</ul>	
				</li> 
			</ul>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="no_telp">No Telepon </label> 
		<div class="col-md-9">
		<input class="form-control input-md" type="text" name="no_telp" id="no_telp" size="30" onkeypress="return numbersonly(event)"/> 
		<span class="help-block"></span>
		</div>	
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="email">Email </label> 
        <div class="col-md-9">
        <input class="form-control input-md" type="text" name="email" id="email" size="30" style="text-transform: lowercase"/> 
        <span class="help-block"></span>
		</div>	
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="no_kitas">No KITAS</label>  
        <div class="col-md-9">
         <input class="form-control input-md" type="text" name="no_kitas" id="no_kitas" size="30" /> 
         <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="no_paspor">No Paspor</label>
        <div class="col-md-9">
         <input class="form-control input-md" type="text" name="no_paspor" id="no_paspor" size="30" /> 
         <span class="help-block"></span>
		</div>
	</div>
	<?php //ambil reff?>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_agama">Agama </label>
        <div class="col-md-9">
        <?php $id = 'id="id_agama" class="form-control input-md" required';
				echo form_dropdown('id_agama',$id_agama,'',$id)?>
        <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_goldar">Golongan Darah </label>
        <div class="col-md-9">
        <?php $id = 'id="id_goldar" class="form-control input-md" required';
				echo form_dropdown('id_goldar',$id_goldar,'',$id)?>
        <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_pendidikan">Pendidikan </label>
        <div class="col-md-9">
        <?php $id = 'id="id_pendidikan" class="form-control input-md" required';
				echo form_dropdown('id_pendidikan',$id_pendidikan,'',$id)?>
        <span class="help-block"></span>					
		</div>
	</div>
	<div id="bsm" style="display: none">
		<div class="form-group">
			<label class="col-md-3 control-label" for="is_bsm">Menerima Bantuan Siswa Miskin</label>
			<div class="col-md-9">
				<div class="radio">
				<?php echo form_radio('is_bsm', 'Y', FALSE,'id=radio_ya'); ?> Ya
				</div>
				<div class="radio">
				<?php echo form_radio('is_bsm', 'N', TRUE,'id=radio_tidak'); ?> Tidak
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_pendidikan_terakhir">Pendidikan Terakhir </label>
        <div class="col-md-9">
        <?php $id = 'id="id_pendidikan_terakhir" class="form-control input-md" required';
				echo form_dropdown('id_pendidikan_terakhir',$id_pendidikan,'',$id)?>
        <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_pekerjaan">Pekerjaan </label>
        <div class="col-md-3">
         <?php $id = 'id="id_pekerjaan" class="form-control input-md" required';
				echo form_dropdown('id_pekerjaan',$id_pekerjaan,'',$id)?> 
         <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_pekerjaan_ped">Potensi Ekonomi Desa </label>
        <div class="col-md-3">
         <?php $id = 'id="id_pekerjaan_ped" class="form-control input-md"';
				echo form_dropdown('id_pekerjaan_ped',$id_pekerjaan_ped,'',$id)?> 
         <span class="help-block"></span>
		</div>
	</div>
	<!--<div class="form-group">
		<label class="col-md-3 control-label" for="pendapatan_per_bulan">Pendapatan Per Bulan </label> 
		<div class="col-md-9">
		<input class="form-control input-md" type="text" name="pendapatan_per_bulan" id="pendapatan_per_bulan" size="30" onkeypress="return numbersonly(event)"/> 
		<span class="help-block"></span>
		</div>	
	</div>-->
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_kewarganegaraan">Kewarganegaraan </label>
        <div class="col-md-9">
         <?php $id = 'id="id_kewarganegaraan" class="form-control input-md" required';
				echo form_dropdown('id_kewarganegaraan',$id_kewarganegaraan,'',$id)?>
         <span class="help-block"> </span>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_kompetensi">Kompetensi </label>
        <div class="col-md-9">
         <?php $id = 'id="id_kompetensi" class="form-control input-md" required';
				echo form_dropdown('id_kompetensi',$id_kompetensi,'',$id)?> 
         <span class="help-block"></span>
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_status_kawin">Status Kawin </label>
        <div class="col-md-9">
         <?php $id = 'id="id_status_kawin" class="form-control input-md" required';
				echo form_dropdown('id_status_kawin',$id_status_kawin,'',$id)?> 
         <span class="help-block"></span>
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_status_penduduk">Status Penduduk</label>
        <div class="col-md-9">
         <?php $id = 'id="id_status_penduduk" class="form-control input-md" required';
				echo form_dropdown('id_status_penduduk',$id_status_penduduk,'',$id)?> 
         <span class="help-block"></span>
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_status_tinggal">Status Tinggal </label>
        <div class="col-md-9">
         <?php $id = 'id="id_status_tinggal" class="form-control input-md" required';
				echo form_dropdown('id_status_tinggal',$id_status_tinggal,'',$id)?> 
         <span class="help-block"></span>
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_difabilitas">Difabilitas </label>
        <div class="col-md-4">
         <?php $id = 'id="id_difabilitas" class="form-control input-md" required';
				echo form_dropdown('id_difabilitas',$id_difabilitas,'',$id)?> 
         <span class="help-block"></span>
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-2 control-label" for="id_kontrasepsi">Kontrasepsi </label>
        <div class="col-md-3">
         <?php $id = 'id="id_kontrasepsi" class="form-control input-md"';
				echo form_dropdown('id_kontrasepsi',$id_kontrasepsi,'',$id)?> 
         <span class="help-block"></span>
		</div>	
	</div>
	
	<div class="form-group"> 
		<div class="image-editor ">	
			<label class="col-md-3 control-label" for="userfile">Foto</label>
			<div class="col-md-4">
				<div id="lihat">
					<div class="cropit-image-preview" ></div>				
					<input type="range" class="cropit-image-zoom-input" style="width: 350px">
					<br>
				</div>
				<input type="file" id="userfile" class="cropit-image-input custom" accept="image/*">
				<input type="hidden" name="image-data" class="hidden-image-data" />				
			</div>
			
		</div>				
	</div>		
	  
	<legend>
		<br>
	</legend>
	
	<label class="col-md-0 control-label" for="="><h4>Hubungan Keluarga</h4></label>
	<legend></legend>
   <div class="form-group">
    	 <label class="col-md-3 control-label" for="nama_ayah">Status Keluarga </label>
        <div class="col-md-9">  
		<input class="form-control input-md" type="text" id="no_telp" size="30" value="Kepala Keluarga" disabled>
		<span class="help-block"></span> 		
	</div>
	</div>	
   <div class="form-group">
    	 <label class="col-md-3 control-label" for="nama_ayah">Nama Ayah </label> 
        <div class="col-md-9">
         <span class="help-block">
         <input class="form-control input-md" type="text" name="nama_ayah" id="nama_ayah" size="30" style="text-transform: uppercase" required/> 
         </span>
	</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="nama_ibu">Nama Ibu</label>  
        <div class="col-md-9">
         <span class="help-block">
         <input class="form-control input-md" type="text" name="nama_ibu" id="nama_ibu" size="30" style="text-transform: uppercase" required/> 
         </span>
	</div>
	</div>
	<legend></legend>

<div class="form-group">
		  <label class="col-md-0 control-label" for="simpan"></label>
		  <div class="col-md-9">
			<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
			<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>datapenduduk/c_keluarga'">Batal</button>
		  </div>
		</div>
</fieldset>
<br>
<?php echo form_close(); ?>
  

<style>
      .cropit-image-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 350px;
        height: 350px;
        cursor: move;
      }

      .cropit-image-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input {
        display: block;
      }

      button[type="submit"] {
        margin-top: 10px;
      }

      #result {
        margin-top: 10px;
        width: 900px;
      }

      #result-data {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        word-wrap: break-word;
      }
    </style>	
<script src="<?php echo base_url(); ?>assetku/cropit/jquery.cropit.js"></script> 

<script>
$(function() {
  
$('.image-editor').cropit({
  imageState: {
	src: '<?php echo site_url('uploads/defaultFotoPenduduk.jpg');?>'
  }
});
  
$('form').submit(function() {
	  // Move cropped image data to hidden input
	 var imageData = $('.image-editor').cropit('export', {
		  type: 'image/jpeg',
		  quality: 2,
		  originalSize: false
		});		
	  $('.hidden-image-data').val(imageData);
		
	  // Prevent the form from actually submitting
	  return true;
	});
  });

</script>

<script>

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userfile').attr('src', e.target.result);		
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#userfile").change(function(){
    readURL(this);
	{document.getElementById("lihat").style.display = "block";}
});
</script>


<style>
UL > LI > UL{
    margin-left:0px;
    display:none;
	list-style-type: none;
}
.kelamin{list-style-type: none; margin-left:-40px;}

</style>
<script>
$(".id_jen_kel").click(function(){
    var ul = $(this).next(); // Get the UL
    ul.slideDown(200); // Slide down the list
    $("[id^=list-]").not(ul).slideUp(200); // Slide up the other list
});
$(".sedangHamil").click(function(){
   var ul = $(this).next(); // Get the UL
    ul.slideUp(200); // Slide down the list
    $("[id^=list-]").not(ul).slideDown(200); // Slide up the other list
});
$(".tidakHamil").click(function(){
   var ul = $(this).next(); // Get the UL
    //ul.slideUp(200); // Slide down the list
   $("[id^=list-]").not(ul).slideUp(200); // Slide up the other list
});
$("#id_pendidikan").change(function(){
    var e = document.getElementById("id_pendidikan");
	var strUser = e.options[e.selectedIndex].text;
	
	if(strUser=="Sedang SD/Sederajat" || strUser=="Sedang SMP/Sederajat" || strUser=="Sedang SMA/Sederajat")
	{document.getElementById("bsm").style.display = 'block';}
	else
	{
		document.getElementById("bsm").style.display = 'none';
		$("#radio_tidak").prop("checked", true)
	}	
});


$( document ).ready(function() {
   {document.getElementById("lihat").style.display = 'none';}
});

function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-kk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
 $("#id_dusun").change(function(){
				var cek = document.getElementById("id_dusun").value;
				
				 if(cek === "")
				{
					document.getElementById("id_rw_sementara").style.display = 'block';
					document.getElementById("id_rw").style.display = 'none';
					
					document.getElementById("id_rt_sementara").style.display = 'block';
					document.getElementById("id_rt").style.display = 'none';
				}
				else
				{ 
					var id_dusun = {id_dusun:$("#id_dusun").val()};
					$.ajax({
							type: "POST",
							url : "<?php echo site_url('datapenduduk/c_keluarga/getRw')?>",
							data: id_dusun,
							success: function(msg){
							document.getElementById("id_rw_sementara").style.display = 'none';
							
								$('#lala_dusun').html(msg);
							}
						});
				} 
        });
		
	
		
	$("#nik").change(function(){				
				var datanyanik = {nik:$("#nik").val()};
				$.ajax({
						type: "POST",
						url : "<?php echo site_url('datapenduduk/c_keluarga/nikExist')?>",
						data: datanyanik,
						success: function(data){
							if(data)
							{
								alertify.error('<b>NIK</b> telah digunakan oleh penduduk yang terdaftar !');
								$("#nik").focus();
								document.getElementById("simpan").disabled = true;	
							}
							else
							{
								document.getElementById("simpan").disabled = false;
							}
						}
					});
				
        });
		
	$("#no_kk").change(function(){				
				var datanyakk = {no_kk:$("#no_kk").val()};
				$.ajax({
						type: "POST",
						url : "<?php echo site_url('datapenduduk/c_keluarga/noKkExist')?>",
						data: datanyakk,
						success: function(data){
							if(data)
							{
								alertify.error('<b>No Kartu Keluarga</b> telah digunakan oleh penduduk yang terdaftar !');
								$("#no_kk").focus();
								document.getElementById("simpan").disabled = true;	
							}
							else
							{
								document.getElementById("simpan").disabled = false;
							}
						}
					});
				
        });

});

</script>