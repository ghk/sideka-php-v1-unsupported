<!-- Form to turn layers on/off -->



<div class="col-md-12 map">

<?php echo $peta;?>
</div>



<style>
iframe {width:100%;height:600px;}
</style>
<script type="text/javascript" charset="utf-8">			
			 function nav_active(){
				var r = document.getElementById("nav-home");
				r.className = "";
				
				var d = document.getElementById("nav-peta");
				d.className = "active";
				}
				
			$(document).ready(function(){  
				//doIframe();
			});
		
		
</script>
