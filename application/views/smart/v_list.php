<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>


<h3><?= $page_title ?></h3>

		<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<button type="button" class="btn btn-danger" aria-label="Left Align" onclick="location.href='<?= base_url() ?>smart/c_smart'">
							 <span class="fa fa-arrow-circle-left"> Kembali</span>
							</button>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive">
<div class="col-lg-12 col-md-12">

	<table class='table table-striped'>
	 <thead>
      <tr>
        <th>NIK</th>
        <th>NAMA</th>
		<th style="text-align:center;">DUSUN</th>
		<th style="text-align:center;">RW</th>
		<th style="text-align:center;">RT</th>		
		<th style="text-align:center;">AKSI</th>
      </tr>
    </thead>
	
	<tbody>
	<?php 
foreach($js_grid as $row)
{
	echo'
		<tr>
			<td>'.$row->nik.'</td>
			<td>'.$row->nama.'</td>			
			<td style="text-align:center;">'.$row->nama_dusun.'</td>
			<td style="text-align:center;">'.$row->nomor_rw.'</td>
			<td style="text-align:center;">'.$row->nomor_rt.'</td>
			<td style="text-align:center;"><button type="submit" class="btn btn-info btn-xs" title="Detail Penduduk" onclick="detil_penduduk(\''.$row->id_penduduk.'\')"/><i class="fa fa-eye"></i></button></td>
			
		</tr>
	';	
}
?>	
		</tbody>
		
	</table>
</div>
							</div>
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
<script>
var _base_url = '<?= base_url() ?>';
function detil_penduduk(id) {

  window.location = _base_url + 'smart/c_smart/detil/' + id;
}
</script>

<script>
function nav_active(){
	document.getElementById("a-smart").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>