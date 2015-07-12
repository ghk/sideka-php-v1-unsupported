<?php 	
	$logo_desa = $konten_logo->konten_logo_desa;
	//$logo_kabupaten = $konten_logo->konten_logo_kabupaten;
?>
	
<img id="displayPhoto" src='<?php echo site_url($logo_desa);?>' style="float:left; height:100px; width:fixed; margin-top:-10px; margin-bottom:5px;"> 
<!--
<img id="displayPhoto" src='<?php echo site_url($logo_kabupaten);?>' style="float:left; height:100px; width:fixed; margin-top:-10px; margin-bottom:5px;"> 
-->		
<script>
	$(document).ready(function(){  
		document.getElementById("displayPhoto").src = '<?php echo site_url($konten_logo);?>';
	}); 
</script>
