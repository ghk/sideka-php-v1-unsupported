<h3><?= $page_title ?></h3>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('surat/c_surat/update_surat'); ?>

<fieldset>
<legend></legend>   
     <input class="form-control input-md" type="hidden" name="id_surat" id="id_surat" size="30" value="<?= $hasil->id_surat?>" readonly="readonly"/> 
	 
	 <div class="form-group">
        <label  class="col-md-3 control-label" for="nomor_surat">Nomor Surat</label>
        <div class="col-md-9">
        <input class="form-control input-md" type="text" name="nomor_surat_sementara" id="nomor_surat_sementara" size="30" value="<?= $hasil->nomor_surat?>" disabled/> 
        <input class="form-control input-md" type="hidden" name="nomor_surat" id="nomor_surat" size="30" value="<?= $hasil->nomor_surat?>"/> 
        <span class="help-block"><?php echo form_error('nomor_surat', '<p class="field_error">', '</p>'); ?><span class="help-block">	
        </div>
    </div>
	
	 <div class="form-group">
        <label  class="col-md-3 control-label" for="kode_surat"> Kategori Surat</label> 
        <div class="col-md-9">		
		<span class="help-block" ><?php $id = 'id="kode_surat_sementara" class="form-control input-md" disabled';
        echo form_dropdown('kode_surat_sementara',$deskripsi_kode_surat,$hasil->kode_surat,$id);?></span>
		<input class="form-control input-md" type="hidden" name="kode_surat" id="kode_surat" size="30" value="<?= $hasil->kode_surat?>"/>
        </div>
    </div>
	
	<div class="form-group">
    	<label class="col-md-3 control-label" for="judul_surat">Judul Surat</label> 
        <div class="col-md-9">
        <input class="form-control input-md" type="text" name="judul_surat" id="judul_surat" placeholder="Contoh: Izin Membuat KTP (Tanpa Kata 'Surat')" size="30" value="<?= $hasil->judul_surat?>" required/>  
        <span class="help-block"><?php echo form_error('judul_surat', '<p class="field_error">', '</p>'); ?></span>
        </div> 
	</div>
	
	 <div class="form-group">
    	<label class="col-md-3 control-label" for="tgl_surat">Tanggal Surat</label>  
        <div class="col-md-9">
       	<span class="help-block">
       	<input class="form-control input-md" type="text" name="tgl_surat_sementara" id="tgl_surat_sementara" size="30" value="<?= date('j/m/Y',strtotime($hasil->tgl_surat )) ?>" disabled/>  
       	<input class="form-control input-md" type="hidden" name="tgl_surat" id="tgl_surat" size="30" value="<?= date('j/m/Y',strtotime($hasil->tgl_surat )) ?>"/>  
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
	  <input id="nik_sementara" name="nik_sementara" type="text" placeholder="NIK" value="<?= $penduduk->nik?>" class="form-control input-md" required="" disabled/>
	  <input id="nik" name="nik" type="hidden" placeholder="NIK" value="<?= $penduduk->nik?>" class="form-control input-md" >
	  <span class="help-block"><?php echo form_error('nik', '<p class="field_error">','</p>')?></span>  
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-3 control-label" for="nama">Nama Penduduk</label>  
	  <div class="col-md-9">
	  <input id="nama_sementara" name="nama_sementara" type="text" placeholder="Nama Penduduk" value="<?= $penduduk->nama?>" class="form-control input-md" required="" disabled/>
	  <input id="nama" name="nama" type="hidden" placeholder="Nama Penduduk" value="<?= $penduduk->nama?>" class="form-control input-md" >
	  <span class="help-block"><?php echo form_error('nama', '<p class="field_error">','</p>')?></span>  
	  </div>
	</div>
	
	<div class="form-group">
    	<label class="col-md-3 control-label" for="tgl_awal">Tanggal Awal Berlaku</label> 
    	<div class="col-md-9">
        <a href="javascript:NewCssCal('tgl_awal','ddmmyyyy')">
        <div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" name="tgl_awal" id="tgl_awal" size="20" class="form-control  input-md" value="<?= date('d-m-Y',strtotime($hasil->tgl_awal))?>" readonly="readonly"/>
		</div>
		</a>
         <span class="help-block"><?php echo form_error('tgl_awal', '<p class="field_error">','</p>')?></span>  	
	</div>	
	</div>
	
	<div class="form-group">
    	<label class="col-md-3 control-label" for="tgl_akhir">Tanggal Akhir Berlaku</label> 
    <div class="col-md-9">
      	<a href="javascript:NewCssCal('tgl_akhir','ddmmyyyy')">
      	<div class="input-group">
							 <span class="input-group-addon">
								<span class="fa fa-table"></span>
							</span>
							<input type="text" name="tgl_akhir" id="tgl_akhir" size="20" class="form-control input-md" value="<?= date('d-m-Y',strtotime($hasil->tgl_akhir))?>" readonly="readonly"/>
		</div>
		</a>
      	 <span class="help-block"><?php echo form_error('tgl_akhir', '<p class="field_error">','</p>')?></span>  
	</div>		
	</div>
	
    <input class="form-control input-md" type="hidden" name="nomor_registrasi" id="nomor_registrasi" size="30" value="<?= $hasil->nomor_registrasi?>"/> 
    
	<div class="form-group">
        <label  class="col-md-3 control-label" for="id_perangkat"> Pamong</label> 
        <div class="col-md-9">		
		<span class="help-block" ><?php $id = 'id="id_perangkat" class="form-control input-md" required';
        echo form_dropdown('id_perangkat',$nama_pamong,$hasil->id_perangkat,$id);?></span>
        </div>
    </div>
	
    <div class="form-group">
        <label  class="col-md-3 control-label" for="keperluan">Keperluan</label> 
        <div class="col-md-9">		
        <textarea class="form-control input-md" name="keperluan" id="keperluan" size="30" required><?php echo $hasil->keterangan  ?></textarea> 
        <span class="help-block"><?php echo form_error('keperluan', '<p class="field_error">', '</p>'); ?>	</span> 	
        </div>
    </div>
	
	<div class="form-group">
    	<label class="col-md-3 control-label" for="kata_penutup">Kata Penutup</label>  
        <div class="col-md-9">
        <textarea class="form-control input-md" name="kata_penutup" id="kata_penutup" size="30" required><?php echo $hasil->kata_penutup  ?></textarea> 
        <span class="help-block"><?php echo form_error('kata_penutup', '<p class="field_error">', '</p>'); ?> </span>
        </div>
	</div>
   

<legend></legend>
<div class="form-group">
		<label class="col-md-0 control-label" for="simpan"></label>
		<div class="col-md-9">
		<span class="help-block">
			<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
			<input type="button" value="Batal" id="batal" class="btn btn-danger" onclick="location.href='<?= base_url() ?>surat/c_surat'"/>
		</span>
		</div>
	</div>
</fieldset>
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
  
</script>