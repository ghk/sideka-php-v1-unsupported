<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
	
<?php echo form_open('admin/c_user/simpan_user'); ?>

<legend></legend>
    <div class="form-group">
    	 <label  class="col-md-3 control-label" for="username">Nama Pengguna</label>
        <div class="col-md-9">
         <input type="text" class="form-control input-md" name="username" id="username" size="30" placeholder="Nama Pengguna" required/> 
         <span class="help-block">
		<?php echo form_error('username', '<p class="field_error">','</p>')?>
        </span>
        </div>
	</div>
	
    <legend></legend>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="nik_nama">Pencarian Data Penduduk</label>  
      <div class="col-md-9">
      <input id="nik_nama" name="nik_nama" type="text" placeholder="NIK / Nama Penduduk" class="form-control input-md">
      <span class="help-block"><?php echo form_error('nik_nama', '<p class="field_error">','</p>')?></span>  
      </div>
    </div>
    
    <legend></legend>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="nik">NIK</label>  
      <div class="col-md-9">
      <input id="nik_sementara" name="nik_sementara" type="text" placeholder="NIK" class="form-control input-md" required="" disabled/>
      <input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" >
      <span class="help-block"><?php echo form_error('nik', '<p class="field_error">','</p>')?></span>  
      </div>
    </div>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-3 control-label" for="nama">Nama Penduduk</label>  
      <div class="col-md-9">
      <input id="nama_sementara" name="nama_sementara" type="text" placeholder="Nama Penduduk" class="form-control input-md" required="" disabled/>
      <input id="nama" name="nama" type="hidden" placeholder="Nama Penduduk" class="form-control input-md" >
      <span class="help-block"><?php echo form_error('nama', '<p class="field_error">','</p>')?></span>  
      </div>
    </div>
	
    <div class="form-group">
    	 <label  class="col-md-3 control-label" for="telp">No. Telepon</label> 
        <div class="col-md-9">
         <input type="text" class="form-control input-md" name="telp" id="telp" size="30" placeholder="Nomor Telepon" onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46) )" required/> 
         <span class="help-block">
		<?php echo form_error('telp', '<p class="field_error">','</p>')?>
        </span>
        </div>
	</div>
	
	
    <div class="form-group">
    	 <label  class="col-md-3 control-label" for="role">Role</label> 
        <div class="col-md-9">
         <?php $options = array(
						''=>'-- Pilih --',
						'Administrator' => 'Administrator',
						'Pengelola Data' => 'Pengelola Data',
						);
					$id = 'id="role" class="form-control input-md" required';
				echo form_dropdown('role',$options,'',$id); ?>
        
         <span class="help-block">
		<?php echo form_error('role', '<p class="field_error">','</p>')?>
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

  $(function() {
    var nikPenduduk = <?php  echo $json_array_nama; ?> ;
    $("#nik_nama" ).autocomplete({
      source: nikPenduduk,
      minLength: 2,
      select: function(event, ui) {
        
        bits = ui.item.value.split(' | ')
        nik = bits[bits.length - 2]
        nama = bits[bits.length - 1]
            $("#nik").val(nik);
            $("#nama").val(nama);
            $("#nik_sementara").val(nik);
            $("#nama_sementara").val(nama);
        },
        change: function(event, ui) {
        
        bits = ui.item.value.split(' | ')
        nik = bits[bits.length - 2]
        nama = bits[bits.length - 1]
                $("#nik").val(nik);
            $("#nama").val(nama);           
            $("#nik_sementara").val(nik);
            $("#nama_sementara").val(nama);
        }
    });
  });
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