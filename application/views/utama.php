<!DOCTYPE html>
<html lang="en">

<head>
	<title><?= $page_title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url();?>assetku/img/sideka.ico" type="image/x-icon" />
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assetku/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>assetku/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url(); ?>assetku/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assetku/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assetku/font/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Alertify CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/alertify/themes/alertify.default.css" id="toggleCSS" />	 

	<!-- jQuery Version 1.11.0 -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/jquery-1.11.0.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/plugins/metisMenu/metisMenu.min.js"></script>
	
    <!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/sb-admin-2.js"></script>
	
	 <!-- Auto Complete Library -->
	<link href="<?php echo base_url(); ?>assetku/plugin/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assetku/plugin/ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assetku/plugin/ui/jquery-ui.structure.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assetku/plugin/ui/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/plugin/ui/jquery-ui.js"></script>  
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/plugin/ui/jquery-ui.min.js"></script>  
    

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>assetku/js/sb-admin-2.js"></script>
	
	
    <script src="<?= base_url() ?>js/utility.js" type="text/javascript"></script>
    
	<link href="<?php echo base_url(); ?>datepicker/rfnet.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>datepicker/datetimepicker_css.js"></script> 
	
	
</head>
<body>
    <div id="wrapper">
				<?php 
					$session['hasil'] = $this->session->userdata('logged_in');
					$nama = $session['hasil']->nama_pengguna;
					$role = $session['hasil']->role;
				?>
				
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="col-md-8">
			<div class="navbar-header">
					<a href=" <?php 
					if($role == 'Administrator') 
						{
							echo site_url('admin/c_admin');
						}
					else 
						{
							echo site_url('c_pengelolaData');
						}?>"> 
						<img src="<?php echo base_url(); ?>assetku/img/logo_sideka.png" style="float:left; height:fixed; width:30%; margin-top:2px; margin-bottom:2px;"> 
					</a>
					</div>
	    					
			</div>
			<div class="col-md-4">
				<ul class="nav navbar-top-links navbar-right " style="margin-top:10px;">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i>
							<?php echo $nama ?> | <b><?php echo $role ?></b>
							<i class="fa fa-caret-down"> </i> 
						</a>
						<ul class="dropdown-menu dropdown-user">		
							<li><a href="<?php echo site_url('c_changePass');?>"><i class="fa fa-pencil fa-fw"></i> Ubah Kata Sandi</a>
							</li>
							
						<li class="divider"></li>
							<li><a href="<?php echo site_url('c_login/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
						</li>
						</ul>
					</li>
				</ul> 
			</div>             
            <!-- /.navbar-header -->
			<?= $menu ?>		
		</nav>
		<!-- /.Navigation -->
		
		
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
					<?= $content ?>
                </div>
                <!-- /.col-lg-12 -->
				
                           
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>

	<!-- Alertify JavaScript -->
	<script src="<?php echo base_url(); ?>assetku/alertify/lib/alertify.min.js"></script>

	<script>
	
	function reset () {
		$("#toggleCSS").attr("href", "<?php echo base_url(); ?>assetku/alertify/themes/alertify.default.css");
		alertify.set({
			labels : {
				ok     : "OK",
				cancel : "Cancel"
			},
			delay : 5000,
			buttonReverse : false,
			buttonFocus   : "ok"
		});
	}

	</script>


  
  
  
  
</body>
</html>