<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Ganti Kata Sandi</title>
    <link rel="stylesheet" href="<?= base_url() ?>css/login.css" type="text/css" />
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetku/css/bootstrap.min.css">

    <!-- MetisMenu CSS -->	
	<link href="<?php echo base_url(); ?>assetku/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
	
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetku/css/sb-admin-2.css">
	
    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assetku/font/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
	
	<!-- Alertify CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assetku/alertify/themes/alertify.default.css" id="toggleCSS" />	 
</head>
<body>
	<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel">
                    <div class="panel-heading">
						<img src="<?php echo base_url(); ?>assetku/img/logo_sideka.png" class="img-responsive"> 						
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('c_changePass/updatePass'); ?>
                            <legend></legend>
                                <div class="form-group">
                                    <input id ="currentPassword" class="form-control" placeholder="Kata Sandi Lama" name="passlama" type="password" autofocus required>
									<?php echo form_error('passlama', '<p class="field_error">', '</p>'); ?>									
                                </div>
                                <div class="form-group">
                                    <input id ="newPassword" class="form-control" placeholder="Kata Sandi Baru" name="passbaru" type="password" autofocus required>
									<?php echo form_error('passbaru', '<p class="field_error">', '</p>'); ?>
									<div class="help-error">
										<small id="password_strengh_feedback" ></small>
									</div>
                                </div>
                                <div class="form-group">
                                    <input id ="verifyPassword" class="form-control" placeholder="Konfirmasi Kata Sandi Baru" name="password" type="password" required>
									<?php echo form_error('password', '<p class="field_error">', '</p>'); ?>
									<div class="help-error">
										<small id="password_match" ></small>
									</div>
                                </div>
                                <legend></legend>
                                <!-- Change this to a button or input when using this as a form -->
                                <div class="col-md-6">
								<input type="submit" value="Simpan" class="btn btn-lg btn-success btn-block"/>
								</div>
								<div class="col-md-6">
								<input type="submit" value="Kembali" class="btn btn-lg btn-danger btn-block" onclick="location.href='<?= base_url(); ?>c_changePass/back'"/>
								</div>
							<?php echo form_close(); ?>
							</div>
							
							<div class="panel-footer">
								<span align="center">SIDeKa ver 1.3 | Copyleft @2015<span>
							</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
	<!-- jQuery Version 1.11.0 -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/jquery-1.11.0.js"></script>
    
	<!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/plugins/metisMenu/metisMenu.min.js"></script>
	
    <!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/sb-admin-2.js"></script>
	
    <!-- Change Password -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/change-password.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assetku/js/jquery.form.min.js"></script>

	<!-- Alertify JavaScript -->
	<script src="<?php echo base_url(); ?>assetku/alertify/lib/alertify.min.js"></script>
	<!-- Sideka JavaScript -->
	<script src="<?php echo base_url(); ?>assetku/js/sideka.js"></script>
	
	<script>
	$(document).ready(function(){  
		
		$('form').submit(function() {
			// Move cropped image data to hidden input
			var xxx = $('#currentPassword').val();	
			xxx = SIDEKA(xxx);
			xxx = SIDEKA(xxx);
			$('#currentPassword').val(xxx);
			
			var xxx1 = $('#newPassword').val();	
			xxx1 = SIDEKA(xxx1);
			xxx1 = SIDEKA(xxx1);
			$('#newPassword').val(xxx1);
			
			var xxx2 = $('#verifyPassword').val();	
			xxx2 = SIDEKA(xxx2);
			xxx2 = SIDEKA(xxx2);
			$('#verifyPassword').val(xxx2);

			// Prevent the form from actually submitting
			return true;
		});
	
		if(<?php echo $cek;?>=='0')
		{
			alertify.error("Kata Sandi Baru dan Konfirmasi tidak cocok !");
		}
		if(<?php echo $cek;?>=='2')
		{
			alertify.error("Kata Sandi Lama tidak cocok !");
		}
		
		
	}); 
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

<style>
body{
  background:#f8f8f8;
  font-family:tahoma,verdana,arial,sans-serif;
  font-size:14px;
}

.panel-heading{background:rgba(245, 245, 245, 0.09);}
.panel-footer{text-align:center;}

.panel {
  margin-bottom: 20px;
  background-color: #fff;
  border: 3px solid rgb(102, 102, 102);
  border-radius: 5px;
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
  box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
</style>
</html>