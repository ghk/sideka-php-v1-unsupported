<h1>Berita</h1>	
<legend></legend>
			<div class="row">			
		<?php
			$i=0;
			foreach($berita as $berita)
			{
			$i++;
		?>
			<?php 	
			$idberita = $berita->id_berita;
			$judul = $berita->judul_berita;
			$gbr = $berita->gambar;
			$isi = $berita->isi_berita;
			$tempWaktu = date("d-m-Y G:i", strtotime($berita->waktu));	
			$nama = $berita->nama_pengguna;
			?>

		
		<a href="<?php echo site_url('web/c_berita/get_detail_berita/'.$idberita);?>" class="link-berita">
		<div class="col-sm-4" >
			<div class="bg berita-content">
				<div class="bg img-responsive berita-content-img">
					<?php //echo $gbr;?>
					<img id="displayPhoto" src='<?php echo site_url($gbr);?>'> 
				</div>	
				<div class="bg berita-content-text">
					<h3>
						<?php echo $judul;?>
					</h3>
					 <li class="fa fa-pencil-square-o">  
						Penulis:
						<?php echo $nama;?>,
						<?php echo $tempWaktu ;?>
					 </li>
					<div class="text-berita">
					<?php echo $isi;?>
					</div>
					<h6>Selanjutnya &raquo;</h6>
				</div>		
			</div>
		</div>
		
	</a>
	
		<?php
	}
	?>
	
	<div class="col-sm-12">
	<!-- <button type="button" class="btn btn-berita btn-block">MEMUAT BERITA SELANJUTNYA</button> -->
	<?php echo $this->pagination->create_links(); ?>
	</div>
	</div>
	<script type="text/javascript" charset="utf-8">			
			 function nav_active(){
				var r = document.getElementById("nav-home");
				r.className = "";
				
				var d = document.getElementById("nav-berita");
				d.className = d.className + "active";
				}
		$(document).ready(function(){  
			document.getElementById("displayPhoto").src = <?php echo site_url($berita);?>;
			});
	</script>