<h2><?= $page_title ?></h2>

<?php echo form_open('admin/c_user/update_user'); ?>
<input type="hidden" name="id_pengguna" value="<?= $hasil->id_pengguna ?>" /> 
<legend></legend>
    <div class="form-group">
    	 <label class="col-md-3 control-label" for="userfile">Username</label>
         <div class="col-md-9"> 
         <input class="form-control input-md" type="text" placeholder="Username" name="username" id="username" size="30" value="<?= $hasil->nama_pengguna ?>" readonly="readonly" /> 
		 <span class="help-block"><?php echo form_error('username', '<p class="field_error">','</p>')?>
        </span>
        </div>
	</div>
    <div class="form-group">
         <label class="col-md-3 control-label" for="userfile">NIK</label>
         <div class="col-md-9"> 
         <span class="help-block">
         <input class="form-control input-md" type="text" name="nik" id="nik" size="30" value="<?= $hasil->nik ?>" readonly="readonly" /> 
        <!-- <?php echo form_error('nik', '<p class="field_error">','</p>')?> -->
        </span>
        </div>
    </div>
    <div class="form-group">
         <label class="col-md-3 control-label" for="userfile">Nama</label>
         <div class="col-md-9"> 
         <span class="help-block">
         <input class="form-control input-md" type="text" name="nama" id="nama" size="30" value="<?= $hasil->nama ?>" readonly="readonly" /> 
        <!-- <?php echo form_error('nama', '<p class="field_error">','</p>')?> -->
        </span>
        </div>
    </div>
	
    <div class="form-group">
    	 <label class="col-md-3 control-label" for="userfile">No. Telepon</label> 
         <div class="col-md-9"> 
		 <input class="form-control input-md" type="text" placeholder="Nomor Telepon" name="telp" id="telp" size="30" value="<?= $hasil->no_telepon ?>" 
		 onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46) )"/> 
         <span class="help-block">
         
		<!-- <?php echo form_error('telp', '<p class="field_error">','</p>')?> -->
        </span>
        </div>
	</div>
	
	
    <div class="form-group">
    	 <label class="col-md-3 control-label" for="userfile">Role</label> 
         <div class="col-md-9"> 
         <span class="help-block">
         <?php $options = array(
						''=>'-- Pilih --',
						'Administrator' => 'Administrator',
						'Pengelola Data' => 'Pengelola Data Desa',
						);
					$id = 'id="role" class="form-control input-md" ';
				echo form_dropdown('role',$options,$hasil->role,$id); ?>
        
		<!-- <?php echo form_error('role', '<p class="field_error">','</p>')?> -->
        </span>
        </div>
	</div>

    <legend></legend>
<div class="form-group">
    <label class="col-md-0 control-label" for="simpan"></label>
    <div class="col-md-9">
    <button type="submit" class="btn btn-success" name="simpan" id="simpan"/>Simpan</button>
    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_user'"/>Batal</button>
    </div>
</div>

<?php echo form_close(); ?>

<script>
function nav_active(){

	var d = document.getElementById("nav-pengguna");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});

</script>

<script>
function nav_active(){
	document.getElementById("a-user").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>