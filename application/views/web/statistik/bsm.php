	<!DOCTYPE html>
	<!--[if IE 7]>					<html class="ie7 no-js" lang="en">     <![endif]-->
	<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
	<!--[if IE 9]>					<html class="ie9 no-js" lang="en">     <![endif]-->
	<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
	<head>
		<link href='http://fonts.googleapis.com/css?family=Over+the+Rainbow|Open+Sans:300,400,400italic,600,700|Arimo|Oswald|Lato|Ubuntu' rel='stylesheet' type='text/css'>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
			
		<title>SISTEM INFORMASI DESA NGAWU </title>
		
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut" href="images/favicon.ico" />

		<link rel="stylesheet" href="<?php echo base_url();?>assetku/css/old/style.css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url();?>assetku/fancybox/jquery.fancybox.css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url();?>assetku/css/style.css" media="screen" />
		
		<!-- REVOLUTION BANNER CSS SETTINGS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assetku/rs-plugin/css/settings.css" media="screen" />	
		
		<!-- HTML5 SHIV + DETECT TOUCH EVENTS -->
		<script type="text/javascript" src="<?php echo base_url();?>assetku/js/modernizr.custom.js"></script>
		
		<script src="<?php echo base_url();?>assetku/js/nicEdit.js"> </script>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
		</script>
		
		<!-- MAP DAP -->
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script>
		var map;
		function initialize() {
		  map = new google.maps.Map(document.getElementById('map'), {
			zoom: 13,
			center: {lat: -8.037418, lng: 110.464145}
		  });

		  // Load GeoJSON.
		  map.data.loadGeoJson('<?php echo base_url();?>map/google.json');

		  // Add some style.
		  map.data.setStyle(function(feature) {
			return /** @type {google.maps.Data.StyleOptions} */({
			  fillColor: feature.getProperty('color'),
			  strokeWeight: 1
			});
		  });
			
			map.data.setStyle(featureStyle);
			// [END snippet-style]
		}

		google.maps.event.addDomListener(window, 'load', initialize);
	</script>

	<!-- CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/css/style.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/css/flexslider.css" type="text/css" media="screen">
		
		<link href="<?php echo base_url(); ?>assetku/font/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assetku/css/animate.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assetku/css/lightbox.css" rel="stylesheet">

	</head>
	<body>
		
		<!-- - - - - - - - - - - - - Navigation - - - - - - - - - - - - - - -->	
		<nav class="navbar">
			<?php if ( isset($menu))
			{
				echo $menu;
			}
			else
			{
				echo "Content belum diset";
			}?>	
		</nav><!--/ #navigation-->
		<!-- - - - - - - - - - - - end Navigation - - - - - - - - - - - - - -->	

			<!-- - - - - - - - - - - - - Logo - - - - - - - - - - - - - - -->	
		<div class="container">
			<?php if ( isset($logo))
			{
				echo $logo;
			}
			else
			{
				echo "Content belum diset";
			}?>
		</div><!--/ #logo-->
		<!-- - - - - - - - - - - - end Logo - - - - - - - - - - - - - -->	


		<!-- - - - - - - - - - - - - - Main - - - - - - - - - - - - - - - - -->		
			<section class="container">				
			<?php if ( isset($content))
					{
						echo $content;
					}
					else
					{
						echo "Content belum diset";
					}?>
			</section>
		<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
		
		<div class="footer">
		SIMDES &copy; 2015 LPPM - UAJY
		</div>
		
		
		<!-- - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - -->	
		

	<!-- GET JQUERY FROM THE GOOGLE APIS -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script> -->
	<script src="<?php echo base_url();?>nic/jquery.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url();?>js/selectivizr-and-extra-selectors.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url();?>assetku/js/respond.min.js"></script>

	 <!-- JQUERY KENBURN SLIDER  -->	
	<script src="<?php echo base_url();?>assetku/js/custom.js"></script>

	<!--<script src="<?php echo base_url();?>assetku/js/jquery.gmap.min.js"></script>-->


	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(function () {
		Highcharts.setOptions({
		   colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
		});
			$('#container').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Statistik Penduduk Desa NGAWU'
				},
				subtitle: {
					text: 'Berdasarkan Penerima Bantuan Siswa Mandiri'
				},
				xAxis: {
					categories: [
						'Keluarga'
					]
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Jumlah Keluarga'
					}
				},
				tooltip: {
					/* headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y:.f}</b></td></tr>',
					footerFormat: '</table>', */
					shared: true,
					useHTML: true
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},
				series: [{
					name: 'Jumlah Penerima Bantuan Siswa Mandiri',
					data: [<?php echo $jumlah_bsm?>]
		
				}, {
					name: 'Jumlah Penduduk',
					data: [<?php echo $jumlah?>]
		
				}]
			});
		});
		
		
		
	</script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/bootstrap-hover-dropdown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/jquery.flexslider.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/scrolltopcontrol.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/lightbox-2.6.min.js"></script>

	<script>
		// very simple to use!
		$(document).ready(function() {
		  $('.dropdownhover').dropdownHover().dropdown();
		});
	</script>


	<script type="text/javascript">
		$('#navbar-search > a').on('click', function() {
			$('#navbar-search > a > i').toggleClass('fa-search fa-times');
			$("#navbar-search-box").toggleClass('show hidden animated fadeInUp');
			return false;
		});
	</script>


	</body>
	</html>
