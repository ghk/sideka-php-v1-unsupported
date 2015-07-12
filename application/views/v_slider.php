

	 <!-- Home Slider -->
      <div class="home-slider">
        <!-- Carousel -->
        <div id="home-slider" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->

          <ol class="carousel-indicators">
<?php	
$count = 0; 
foreach($slider_beranda as $sb)
{	
		  echo'
          <li id="bb'.$count.'" data-target="#home-slider" data-slide-to="'.$count.'" class=""></li>
           '; 
		   $count++;
}      
?>
  </ol>         <!-- Wrapper for slides -->
          <div class="carousel-inner">

 <?php
$count = 0; 
foreach($slider_beranda as $sb)
{	
	
	$teks = $sb->konten_teks;
	$background = $sb->konten_background;
	$logo = $sb->konten_logo;	
	
		echo'
			
			<div id="aaaa'.$count.'" class="item" style="background-image:url('.base_url().''.$background.'); background-position: bottom center;" >
			  <div class="container">
				<div class="row">
				
				  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
					<div class="home-slider__content" style="float:left; margin-top:20px">
					 <div class="animated slideInLeft" style="text-align:center;">
					 <div class="img-responsive">
					<img src="'.base_url().''.$logo.'" alt="..." style="float:center; height:150px; width:fixed; margin-top:;">
					</div>	
					</div>	
					  <h3 class="animated slideInDown delay-3" style="text-align:center;" >'.$teks.'<h3> 
					  
				  
					</div>
				  </div>
				</div> <!-- / .row -->
			  </div> <!-- / .container -->
			</div> <!-- / .item -->
	';
	 $count++;
 }
?>
          </div> <!-- / .carousel -->
          <!-- Controls -->
          <a class="carousel-arrow carousel-arrow-prev" href="#home-slider" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="carousel-arrow carousel-arrow-next" href="#home-slider" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>
      </div> <!-- / .home-slider -->
	  
	 <script>
	 
	  var d = document.getElementById('aaaa0');
	  d.className = "item active";
	  
	  var d = document.getElementById('bb0');
	  d.className = "active";

	 </script>
	  