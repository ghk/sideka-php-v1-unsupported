<h2><?= $page_title ?></h2>

<div class="row">
                <div class="col-lg-12">
<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		
<?php echo form_open_multipart('datapenduduk/c_cetak_kk/cetak')?>
<fieldset>
	<legend></legend>
	
	<!-- Text input------------------------------------------------------>
	<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Pencarian Data Kartu Keluarga</label>
			 <div class="col-md-9">			 
			 <input type="text" class="form-control" name="nokk_nama" id="nokk_nama" size="50" placeholder="No KK / Nama Kepala Keluarga / NIK Kepala Keluarga (min 2 karakter)" /> 
			<span class="help-block"></span>
		</div>
		</div>
		<legend></legend>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nomer Kartu Keluarga</label>
			 <div class="col-md-9">			 
				<input type="text" class="form-control" name="no_kk_sementara" id="no_kk_sementara" size="50" readonly="readonly" placeholder="No KK" />
				<input id="no_kk" name="no_kk" type="hidden" placeholder="Nomer Kepala Keluarga" class="form-control input-md" >
			<span class="help-block"><?php echo form_error('no_kk', '<p class="field_error">','</p>')?>
			</span>
		</div>
		</div>
		<div class="form-group">
			 <label class="col-md-3 control-label" for="is_sementara_keluarga">Nama Kepala Keluarga</label>
			 <div class="col-md-9">
			 
				<input type="text" class="form-control" name="nama_sementara" id="nama_sementara_kepala" size="50" readonly="readonly" placeholder="Nama Kepala Keluarga"/>
				<input id="nama_kepala" name="nama" type="hidden" placeholder="Nama" class="form-control" >
			<span class="help-block">	<?php echo form_error('nama', '<p class="field_error">','</p>')?>	
			</span>
			</div>
		</div>
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="nik">NIK Kepala Keluarga</label>  
		  <div class="col-md-9">
		  <input id="nik_sementara" name="nik_sementara" type="text" placeholder="NIK Kepala Keluarga" class="form-control input-md" required="" disabled/>
		  <input id="nik" name="nik" type="hidden" placeholder="NIK" class="form-control input-md" >
		  <span class="help-block"><?php echo form_error('nik', '<p class="field_error">','</p>')?></span>  
		  </div>
		</div>
	
	<div class="col-md-9">
		<input type="button" href="#dialog-print" value="Cetak" id="cetak" class="print_kartu btn btn-success" data-toggle="modal" />
		<input type="button" class="btn btn-danger" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>datapenduduk/c_cetak_kk'"/>
	</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="dialog-print" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" ><span class="glyphicon glyphicon-print"></span>&nbsp;Pencetakan Kartu Keluarga</h4>
      </div>
      <div class="modal-body" id="MyModalBody" >
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Tutup</button>
        </div>
    </div>
  </div>
</div>
<!-- akhir kode modal dialog -->
	
<script>	

	$(document).ready(function() {
		
		document.getElementById("cetak").disabled = true;	
		// ketika tombol print ditekan
		$('.print_kartu').on("click", function(){
		// ambil nilai id dari link print
		no_induk = $("#nik_sementara").val();
		if(no_induk!='')
		{
			$("#MyModalBody").html('<iframe src="<?php echo base_url();?>datapenduduk/c_cetak_kk/cetak/'+no_induk+'" width="100%" height="350" frameborder="no"></iframe>');
		}
		else
		{
			alert('kosong');
			$(".modal-dialog").dialog('close');
		}
		}); 
	});

</script>
<script>	

  $(function() {
    var noKK = <?php  echo $json_array; ?> ;
    $("#nokk_nama" ).autocomplete({
      source: noKK,
	  minLength: 2,
	  select: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		nik = bits[bits.length - 1]		
		nama = bits[bits.length - 2]
		no_kk = bits[bits.length - 3]
			$("#no_kk").val(no_kk);
			$("#nama_kepala").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_sementara_kepala").val(nama);	
			$("#nik_sementara").val(nik);			
			document.getElementById("cetak").disabled = false;
        },
        change: function(event, ui) {
		
		bits = ui.item.value.split(' | ')
		nik = bits[bits.length - 1]		
		nama = bits[bits.length - 2]
		no_kk = bits[bits.length - 3]
			$("#no_kk").val(no_kk);
			$("#nama_kepala").val(nama);
			$("#no_kk_sementara").val(no_kk);
			$("#nama_sementara_kepala").val(nama);
			$("#nik_sementara").val(nik);
		
        }
    });
  });
  
</script>
<script>
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-cetak_kk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>