<h1>Visi dan Misi Desa</h1>
<legend></legend>
		<?php 	
				$isi = $visimisi->isi_visi_misi; 
				$banner = $visimisi->foto_banner; 
				$tempWaktu = $visimisi->waktu;
				$tanggal = date("d", strtotime($tempWaktu));
				$bulan = date("n", strtotime($tempWaktu));
				$tahun = date("Y", strtotime($tempWaktu));
				$nama = $visimisi->id_pengguna;
				$jam = date("G:i:s", strtotime($tempWaktu));
				$namabulan = array("","Januari","Februari","Maret","April","Mei","Juni",
									"Juli","Agustus","September","Oktober","November","Desember");
				
				
				?>
		
	<img id="displayPhoto" src='<?php echo site_url($banner);?>' style="width:100%; margin-bottom: 10px"> 

	<div class="body-content">
		<p>
			<?php echo $isi;?>		
			<!--<br>
			<b>Ditulis Oleh </b>: 
			<?php echo $nama; ?>, 
			<?php echo $tanggal." ".$namabulan[$bulan]." ".$tahun;?>
			<?php echo $jam?> WIB			
-->
		</p>
	</div>
<script type="text/javascript" charset="utf-8">			
			 function nav_active(){
				var r = document.getElementById("nav-home");
				r.className = "";
				
				var d = document.getElementById("nav-profil");
				d.className = d.className + " active";
				}
				
			$(document).ready(function(){  
			document.getElementById("displayPhoto").src = <?php echo site_url($visimisi);?>;
			});
</script>
	