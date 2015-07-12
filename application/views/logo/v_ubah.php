<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php
$attributes = array('name' => 'myform');
echo form_open_multipart('admin/c_logo/update_logo', $attributes); 
?>
<fieldset>
<legend></legend>

		 <div class="col-md-12">
			<input type="hidden"  name="id_logo" value="<?= $konten_logo->id_logo?>"/>
		</div>
	
	
	<div class="form-group"> 	
    	 <label class="col-md-2 control-label" for="logo_desa">Logo Desa</label>
        <div class="col-md-6">		
		<input class="form-control input-md"  type="file" name="logo_desa" id="imgInp" multiple>
         <span class="help-block">
			<div align="right">Gambar harus bertipe .png</div>
		</span>
		</div>
		 <div class="col-md-4">
			<img id="blah" src='<?php echo site_url($konten_logo->konten_logo_desa);?>'  alt="your image"  class="img-responsive img-thumbnail"  width="300px" height="100px"/><br><br>
			<input type="hidden" id="konten_logo_desa" name="konten_logo_desa" value="<?= $konten_logo->konten_logo_desa?>" />	
		</div>
	</div>	
	<legend></legend>
	
		
	  <div class="form-group">
    	 <label class="col-md-2 control-label" for="path_css">Tema Website</label> 
         <div class="col-md-4"> 
         <span class="help-block">
         <?php $options = array(
						'assetku/css/style.css'			=>	'Hijau',
						'assetku/css/style_red.css'		=>	'Merah',
						'assetku/css/style_blue.css'	=>	'Biru',
						'assetku/css/style_grey.css'	=>	'Abu-abu',
						);
					$path_css = 'id="path_css" class="form-control input-md"';
				echo form_dropdown('path_css',$options,$konten_logo->path_css,$path_css); ?>
        
		<?php echo form_error('path_css', '<p class="field_error">','</p>')?>
        </span>
        </div>
	</div>
	
	<div class="form-group"> 
		<div class="image-editor ">	
			<label class="col-md-2 control-label" for="">Logo Kabupaten</label>
			<div class="col-md-4">
				<div id="lihat">
					<div class="cropit-image-preview" ></div>				
					<input type="range" class="cropit-image-zoom-input" style="width: 200px">
					 <span class="help-block">
						<div align="left">Gambar harus bertipe .jpg</div>
					<input type="file" id="userfile" class="cropit-image-input custom" accept="image/*">
					<input type="hidden" name="image-data" class="hidden-image-data" />	
					</span>
				</div>
			</div>
		</div>				
	</div>	
<legend></legend>	
<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_logo'"/>
</p>
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
        background-color: #FFFFFF;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 200px;
        height: 250px;
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
	src: '<?php echo site_url($konten_logo->konten_logo_kabupaten);?>'
  }
});
  
$('form').submit(function() {
	  // Move cropped image data to hidden input
	 var imageData = $('.image-editor').cropit('export', {
		  type: 'image/jpeg',
		  quality: 1,
		  originalSize: false
		});		
	  $('.hidden-image-data').val(imageData);
		
	  // Prevent the form from actually submitting
	  return true;
	});
  });

function nav_active(){

	document.getElementById("a-data-web").className = "collapsed active";
	
	var r = document.getElementById("pengelola_data_web");
	r.className = "collapsed";

	var d = document.getElementById("nav-logo");
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

<script>
function readURL_logoDesa(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }
		
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imgInp").change(function(){
    readURL_logoDesa(this);
	{document.getElementById("blah").style.display = 'block';}
});

$( document ).ready(function() {
   {document.getElementById("blah").style.display = 'show';}
});


function readURL_logoKabupaten(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        }
		
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imgInp1").change(function(){
    readURL_logoKabupaten(this);
	{document.getElementById("blah1").style.display = 'block';}
});

$( document ).ready(function() {
   {document.getElementById("blah1").style.display = 'show';}
   $(".cropit-image-preview").reload();
});
</script>