<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>
<?php
echo $js_grid;
?>

<script type="text/javascript">
var _base_url = '<?= base_url() ?>';

function edit_meninggal(id) {
  window.location = _base_url + 'peristiwa/c_meninggal/edit/' + id;
}

function cetak(id_meninggal) {
  $("#MyModalBody").html('<iframe src="<?php echo base_url();?>peristiwa/c_meninggal/cetakById/'+id_meninggal+'" width="100%" height="350" frameborder="no"></iframe>');
}

function btn(com,grid)
{
    if (com=='Select All')
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com=='DeSelect All')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
	
	if (com=='Add')
    {
		window.location = _base_url + 'peristiwa/c_meninggal/add';
    }
	
	if (com=='Delete Selected Items')
        {
           if($('.trSelected',grid).length>0){
			   if(confirm('Hapus ' + $('.trSelected',grid).length + ' item?')){
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
						itemlist+= items[i].id.substr(3)+",";
					}
					$.ajax({
					   type: "POST",
					   url: "<?=site_url("peristiwa/c_meninggal/delete/");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
					  	alertify.success("Data berhasil dihapus !");
					   } ,
						error: function() {
							alertify.error("Maaf, data yang akan dihapus masih digunakan !");
						}
					});
				}
			} else {
				return false;
			}
        }	
}

$(function(){
  
});
</script>

<h3><?= $page_title ?></h3>
<legend></legend>

<table id="flex1" style="display:none"></table>

<!-- Modal -->
<div class="modal fade" id="dialog-print" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" ><span class="fa fa-print"></span>&nbsp;Pencetakan Surat Kematian</h4>
      </div>
      <div class="modal-body" id="MyModalBody" >
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Tutup</button>
        </div>
    </div>
  </div>
</div>
<!-- akhir kode modal dialog -->


<script>
function nav_active(){
	
	document.getElementById("a-data-peristiwa").className = "collapsed active";
	
	document.getElementById("peristiwa").className = "collapsed";

	var d = document.getElementById("nav-meninggal");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>