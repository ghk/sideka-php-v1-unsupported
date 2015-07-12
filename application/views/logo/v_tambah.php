<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php
$attributes = array('name' => 'myform');
echo form_open_multipart('admin/c_logo/simpan_logo', $attributes); 
?>
<fieldset>
<legend></legend>
	
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="logo_desa">Logo Desa</label>
        <div class="col-md-6">
         <span class="help-block">
			<input class="form-control input-md"  type="file" name="logo_desa" id="imgInp" multiple>
			<div align="right">Picture must be .jpg or .jpeg</div>
		</span>
		</div>
		 <div class="col-md-3">
			<img id="blah" src="#" alt="your image"  class='img-responsive img-thumbnail' width="300px" height="100px"/><br><br>
		</div>
	</div>	
	<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="logo_kabupaten">Logo Kabupaten</label>
        <div class="col-md-6">
         <span class="help-block">
			<input class="form-control input-md"  type="file" name="logo_kabupaten" id="imgInp1" multiple>
			<div align="right">Picture must be .jpg or .jpeg</div>
		</span>
		</div>
		 <div class="col-md-3">
			<img id="blah1" src="#" alt="your image"  class='img-responsive img-thumbnail' width="300px" height="100px"/><br><br>
		</div>
	</div>	

<div class="form-group">
		  <label class="col-md-0 control-label" for="simpan"></label>
		  <div class="col-md-9">
			<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
			<button id="batal" name="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>admin/c_logo'">Batal</button>
		  </div>
		</div>
</fieldset>
<br>
<?php echo form_close(); ?>

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
   {document.getElementById("blah").style.display = 'none';}
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
   {document.getElementById("blah1").style.display = 'none';}
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