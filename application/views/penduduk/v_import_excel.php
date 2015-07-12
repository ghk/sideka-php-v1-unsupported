<h2><?= $page_title ?></h2>

<?php //$flashmessage = $this->session->flashdata('exist');
	//echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		
<?php echo form_open_multipart('datapenduduk/c_penduduk/import_excel/'); ?>
<div class="form-group">
	<input type="file" id="file_upload" class="" name="userfile" size="20" />
	<span class="help-block">Format berkas harus .xls</span>  
	</div>
</br>
<div>
<input type="submit" class="btn btn-success" value="Unggah" id="submit-btn-file" />
<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>datapenduduk/c_penduduk'"/>
</div>
<?php echo form_close();?>

<script>
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-penduduk");
	d.className = d.className + "active";
	}
	
$(document).ready(function() { 
	nav_active();
	 $('form').submit(function() { 
			if(beforeSubmitFile()==false)
			{
				return false;
			}
			else			
			// always return false to prevent standard browser submit and page navigation 
			return true; 
		}); 
}); 		

//function to check file size before uploading.
function beforeSubmitFile(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#file_upload').val()) //check empty input filed
		{
			alertify.error("Silahkan Pilih Berkas !");
			return false
		}
		
		var fsize = $('#file_upload')[0].files[0].size; //get file size
		var ftype = $('#file_upload')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            
			case 'application/vnd.ms-excel':
			case '"application/excel"':
                break;
            default:
				alertify.error("<b>"+ftype+"</b> <br />Tipe berkas tidak mendukung !");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			
			alertify.error("Ukuran Berkas Maksimal : 1MB !");	
			return false
		}
		
		document.getElementById("submit-btn-file").disabled = true;	
		alertify.log("Proses Import Data sedang dilakukan, harap tunggu hingga proses selesai !")
		//$('#submit-btn-file').hide(); //hide submit button
		//$('#loading-img-file').show(); //hide submit button
		//$("#output-file").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		alertify.error("Silahkan tingkat versi dari piranti lunak browser anda, karena browser anda sekarang tidak mendukung fitur terbaru !");	
		return false;
	}
}


//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
</script>