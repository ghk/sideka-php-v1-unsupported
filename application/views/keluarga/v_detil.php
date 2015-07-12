<h3><?= $page_title ?></h3>

		<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<button type="button" class="btn btn-danger" aria-label="Left Align" onclick="location.href='<?= base_url() ?>datapenduduk/c_keluarga'">
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
        <th>Nama</th>
        <th>Alamat</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Status Keluarga</th>
      </tr>
    </thead>
	
	<tbody>
		<?php
			$i=0;
			foreach($keluarga as $rows)
			{
			$i++;
		?>
		<tr>
			<td><?php echo $rows->nama; ?></td>
			<td><?php echo $rows->alamat_jalan; ?></td>
			<td><?php echo $rows->tempat_lahir; ?></td>
			<td><?php echo date('d-m-Y', strtotime($rows->tanggal_lahir)); ?></td>
			<td><?php echo $rows->deskripsi; ?></td>
		</tr>
		
		<?php
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
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-kk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>