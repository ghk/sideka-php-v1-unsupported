<h2>Berita Terbaru</h2>	
<div class="owl-carousel carousel">
		<?php
			$i=0;
			foreach($berita as $b)
			{
			$i++;
			
			$idberita = $b->id_berita;
			$judul = $b->judul_berita;
			$gbr = $b->gambar;
			$tempWaktu = $b->waktu;
			$tanggal = date("d", strtotime($tempWaktu));
			$bulan = date("n", strtotime($tempWaktu));
			$tahun = date("Y", strtotime($tempWaktu));
			$nama = $b->id_pengguna;
			$jam = date("G:i:s", strtotime($tempWaktu));
			$namabulan = array("","Januari","Februari","Maret","April","Mei","Juni",
			"Juli","Agustus","September","Oktober","November","Desember");
			?>
			
			
				<div class="image-box">
				
				<div class="image-box-img">
					
						<div class="overlay-container img-responsive">
							<?php //echo $gbr;?>
							<img id="displayPhoto" src='<?php echo site_url($gbr);?>'> 
						</div>
						</div>
					<div class="image-box-body">
						<span class="fa fa-calendar"></span>  
						<?php echo $tanggal;?> - <?php echo $bulan;?> - <?php echo $tahun;?>,
						<span class="fa fa-clock-o"></span>  <?php echo $jam;?>
						<h4 class="title">
						<a href="<?php echo site_url('web/c_home/get_detail_berita/'.$idberita);?>" class="link-berita">
						<?php echo $judul;?>
						</a>
						</h4>
					</div>
					</div>	
				
				<?php
	}
	?>		
	
		</div>	
		
		<script type="text/javascript" charset="utf-8">			
			
				$(document).ready(function(){  
			document.getElementById("displayPhoto").src = <?php echo site_url($berita);?>;
			});
	</script>		