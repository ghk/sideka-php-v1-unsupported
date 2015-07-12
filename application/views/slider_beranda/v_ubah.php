<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php
$attributes = array('name' => 'myform');
echo form_open_multipart('admin/c_slider_beranda/update_slider_beranda', $attributes); 
?>
<fieldset>
<legend></legend>

		 <div class="col-md-12">
			<input type="hidden"  id="id_slider_beranda" name="id_slider_beranda" value="<?= $hasil->id_slider_beranda?>"/>
		</div>
		
		<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="konten_teks">Konten Teks</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="text" name="konten_teks" id="konten_teks" placeholder="Konten Teks" value="<?= $hasil->konten_teks?>"/>
		</span>
		</div>
	</div>	
	<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="konten_background">Konten Background</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="file" name="konten_background" id="imgInp" value="<?=$hasil->konten_background ?>" multiple>
			<div align="right">Gambar harus bertipe .jpg atau .jpeg</div>
		</span>
		</div>
		<label class="col-md-3 control-label"></label>
		 <div class="col-md-9">
			<img id="blah" src='<?php echo site_url($hasil->konten_background);?>' alt="your image"  class='img-responsive img-thumbnail' width="640px"/><br><br>
		</div>
	</div>	

	<legend></legend>
	<div class="form-group"> 	
    	 <label class="col-md-3 control-label" for="konten_logo">Konten Logo</label>
        <div class="col-md-9">
         <span class="help-block">
			<input class="form-control input-md"  type="file" name="konten_logo" id="imgInp1" value="<?=$hasil->konten_logo ?>" multiple>
			<div align="right">Gambar harus bertipe .png</div>
		</span>
		</div>
		<label class="col-md-3 control-label"></label>
		 <div class="col-md-3">
			<img id="blah1" src='<?php echo site_url($hasil->konten_logo);?>' alt="your image"  class='img-responsive img-thumbnail' width="150px" height="150px"/><br><br>
		</div>
	</div>	

	<legend></legend>
<p>
<input type="submit" class="btn btn-success" value="Simpan" id="simpan"/>
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_slider_beranda'"/>
</p>
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
});

function nav_active(){

	document.getElementById("a-data-web").className = "collapsed active";
	
	var r = document.getElementById("pengelola_data_web");
	r.className = "collapsed";

	var d = document.getElementById("nav-slider");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
  $(".cropit-image-preview").reload();
});
</script>