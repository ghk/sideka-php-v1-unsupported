<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open_multipart('datapenduduk/c_penduduk/update_penduduk'); ?>
<legend></legend>
<fieldset>
	<input type="hidden" name="id_penduduk" id="id_penduduk" value="<?= $result->id_penduduk ?>" size="20" /> 
	<input type="hidden" name="foto" id="foto" value="<?= $result->foto ?>" size="20" /> 
	
   <div class="form-group">
	<label class="col-md-0 control-label" for=""><h4>Data Kepala Keluarga</h4></label> 
	  <legend></legend>
   </div> 
 
<div class="form-group">
		<label class="col-md-3 control-label" for="is_sementara"> Status Penduduk Sementara</label>
        <div class="col-md-9">
        <div class="radio">
		<input type="radio" name="is_sementara"  value="Y" <?php echo set_radio('is_sementara','Y',$result->is_sementara=='Y');?> />Ya
		</div>
		<div class="radio">
		<input type="radio" name="is_sementara"  value="N" <?php echo set_radio('is_sementara','N',$result->is_sementara=='N');?> />Tidak
		</div>
	</div></div>
	
   <div class="form-group">
    	 <label class="col-md-3 control-label" for="nik">NIK</label>  
        <div class="col-md-9">
         <input class="form-control input-md"type="text" name="nik" value="<?= $result->nik?>" size="30" autofocus required/> 
         <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="nama">Nama</label>  
        <div class="col-md-9">
         <input class="form-control input-md"type="text" name="nama" value="<?= $result->nama?>" style="text-transform: uppercase" size="30" />
         <span class="help-block">
         </span> </div>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="tempat_lahir">Tempat/Tgl Lahir </label>  
        <div class="col-md-5">
         <input class="form-control input-md" type="text" name="tempat_lahir" value="<?= $result->tempat_lahir?>" size="30" style="text-transform: uppercase"/>
         <span class="help-block"></span> 
		</div>
		
        <div class="col-md-4">         
        <a href="javascript:NewCssCal('ttl','ddmmyyyy')">
         <div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input class="form-control input-md" type="text" name="tanggal_lahir" id="ttl" value="<?= date('d-m-Y', strtotime($result->tanggal_lahir))?>" size="20" readonly="readonly"/>
        </div>
		</a>
		<span class="help-block">
        </span>
			
		</div>		
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="id_jen_kel">Jenis Kelamin</label>
		<div class="col-md-9">
			<ul class="kelamin">
			   <li>
				   <input name="id_jen_kel" class="id_jen_kel" type="radio" id="laki" value="1" <?php echo set_radio('id_jen_kel','1',$result->id_jen_kel=='1');?>> Laki Laki      
				</li>       
				<li>
					<input name="id_jen_kel" class="id_jen_kel" type="radio" id="perempuan" value="2" <?php echo set_radio('id_jen_kel','2',$result->id_jen_kel=='2');?>> Perempuan
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
									  <input id="keterangan" name="keterangan" type="text" placeholder="Keterangan" class="form-control input-md" >
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
											<input class="form-control" type="text" readonly="readonly"  name="tgl_hpl" id="tgl_hpl" size="20" placeholder="Tgl-Bln-Thn" class="form-control input-md"  />
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
         <input class="form-control input-md"type="text" name="no_telp" value="<?= $result->no_telp?>" size="30" /> 
         <span class="help-block">
         </span></div>
	</div>	
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="email">Email  </label>
        <div class="col-md-9">
         <input class="form-control input-md"type="text" name="email" value="<?= $result->email?>" size="30" /> 
         <span class="help-block">
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="no_kitas">No KITAS  </label>
        <div class="col-md-9">
          <input class="form-control input-md" type="text" name="no_kitas" value="<?= $result->no_kitas?>" size="30" />
        <span class="help-block">
         </span> </div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="no_paspor">No Paspor</label>
        <div class="col-md-9">
         <input class="form-control input-md" type="text" name="no_paspor" value="<?= $result->no_paspor?>" size="30" />
         <span class="help-block">
         </span> </div>
	</div>
	
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_agama">Agama </label>
        <div class="col-md-9">
         <?php $id = 'id="id_agama" class="form-control input-md"';
				echo form_dropdown('id_agama',$id_agama,$result->id_agama,$id)?>
        <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_goldar">Golongan Darah </label>
        <div class="col-md-9">
         <?php $id = 'id="id_goldar" class="form-control input-md"';
				echo form_dropdown('id_goldar',$id_goldar,$result->id_goldar,$id)?>
        <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_pendidikan">Pendidikan </label>
        <div class="col-md-9">
         <?php $id = 'id="id_pendidikan" class="form-control input-md"';
				echo form_dropdown('id_pendidikan',$id_pendidikan,$result->id_pendidikan,$id)?>
        <span class="help-block">
         </span></div>
	</div>
	<div id="bsm" style="display: none">
		<div class="form-group">
			<label class="col-md-3 control-label" for="is_bsm">Menerima Bantuan Siswa Miskin</label>
			<div class="col-md-9">
				<div class="radio">
				<input type="radio" name="is_bsm"  value="Y" id="radio_ya" <?php echo set_radio('is_bsm','Y',$result->is_bsm=='Y');?> />Ya
				</div>
				<div class="radio">
				<input type="radio" name="is_bsm"  value="N" id="radio_tidak" <?php echo set_radio('is_bsm','N',$result->is_bsm=='N');?> />Tidak
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_pendidikan_terakhir">Pendidikan Terakhir </label>
        <div class="col-md-9">
         <?php $id = 'id="id_pendidikan_terakhir" class="form-control input-md"';
				echo form_dropdown('id_pendidikan_terakhir',$id_pendidikan,$result->id_pendidikan_terakhir,$id)?>
        <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_pekerjaan">Pekerjaan </label>
        <div class="col-md-3">
         <?php $id = 'id="id_pekerjaan" class="form-control input-md" required';
				echo form_dropdown('id_pekerjaan',$id_pekerjaan,$result->id_pekerjaan,$id)?> 
         <span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_pekerjaan_ped">Potensi Ekonomi Desa </label>
        <div class="col-md-3">
         <?php $id = 'id="id_pekerjaan_ped" class="form-control input-md"';
				echo form_dropdown('id_pekerjaan_ped',$id_pekerjaan_ped,$result->id_pekerjaan_ped,$id)?> 
         <span class="help-block"><br></span>
		</div>
	</div>
	<!--<div class="form-group">
		<label class="col-md-3 control-label" for="pendapatan_per_bulan">Pendapatan Per Bulan </label> 
		<div class="col-md-9">
		<input class="form-control input-md" type="text" name="pendapatan_per_bulan" value="<?= $result->pendapatan_per_bulan?>" id="pendapatan_per_bulan" size="30" onkeypress="return numbersonly(event)"/> 
		<span class="help-block"></span>
		</div>	
	</div>-->
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_kewarganegaraan"> Kewarganegaraan </label>
        <div class="col-md-9">
         <?php $id = 'id="id_kewarganegaraan" class="form-control input-md"';
				echo form_dropdown('id_kewarganegaraan',$id_kewarganegaraan,$result->id_kewarganegaraan,$id)?>
         <span class="help-block">
         </span> </div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_kompetensi">Kompetensi </label>
        <div class="col-md-9">
         <?php $id = 'id="id_kompetensi" class="form-control input-md"';
				echo form_dropdown('id_kompetensi',$id_kompetensi,$result->id_kompetensi,$id)?>
         <span class="help-block">
         </span></div> 
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_status_kawin">Status Kawin </label>
        <div class="col-md-9">
         <?php $id = 'id="id_status_kawin" class="form-control input-md"';
				echo form_dropdown('id_status_kawin',$id_status_kawin,$result->id_status_kawin,$id)?> 
         <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_status_penduduk">Status Penduduk </label>
        <div class="col-md-9">
         <?php $id = 'id="id_status_penduduk" class="form-control input-md"';
				echo form_dropdown('id_status_penduduk',$id_status_penduduk,$result->id_status_penduduk,$id)?>
         <span class="help-block">
         </span></div> 
	</div>
	<div class="form-group">
    	<label class="col-md-3 control-label" for="id_status_tinggal"> Status Tinggal </label>
        <div class="col-md-9">
         <?php $id = 'id="id_status_tinggal" class="form-control input-md"';
				echo form_dropdown('id_status_tinggal',$id_status_tinggal,$result->id_status_tinggal,$id)?> 
         <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_difabilitas">Difabilitas </label>
        <div class="col-md-9">
         <?php $id = 'id="id_difabilitas" class="form-control input-md"';
				echo form_dropdown('id_difabilitas',$id_difabilitas,$result->id_difabilitas,$id)?> 
         <span class="help-block">
         </span></div>
	</div>
	<div class="form-group">
    	 <label class="col-md-3 control-label" for="id_kontrasepsi">Kontrasepsi </label>
        <div class="col-md-9">
         <?php $id = 'id="id_kontrasepsi" class="form-control input-md"';
				echo form_dropdown('id_kontrasepsi',$id_kontrasepsi,$result->id_kontrasepsi,$id)?> 
         <span class="help-block">
         </span></div>
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

	<div class="form-group">
		  <label class="col-md-0 control-label" for="simpan"></label>
		  <div class="col-md-9">		
		<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
		<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>datapenduduk/c_penduduk'">Batal</button>
		 <span class="help-block"></span></div>
		</div>
</fieldset>

<?php echo form_close(); ?>

<style>
		/* Show load indicator when image is being loaded */
		.cropit-image-preview.cropit-image-loading .spinner {
		opacity: 1;
		}

		/* Show move cursor when image has been loaded */
		.cropit-image-preview.cropit-image-loaded {
		cursor: move;
		}

		/* Gray out zoom slider when the image cannot be zoomed */
		.cropit-image-zoom-input[disabled] {
		opacity: .2;
		}

		
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
     }
    </style>	
<script src="<?php echo base_url(); ?>assetku/cropit/jquery.cropit.js"></script> 

<script>
$(function() {
  
$('.image-editor').cropit({
  imageState: {
	src: '<?php echo site_url($result->foto);?>'
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
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-penduduk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
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
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
	{document.getElementById("blah").style.display = 'block';}
	
});


$( document ).ready(function() {
   
   var cek = $('input[name="is_bsm"]:checked').val();  
   if(cek == 'Y') 
   {
		document.getElementById("bsm").style.display = 'block';
   }
   else document.getElementById("bsm").style.display = 'none';
   
   	document.getElementById("lihat").style.display = "block";
	$(".cropit-image-preview").reload();


});
</script>
