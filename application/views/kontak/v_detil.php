<h3><?= $page_title ?></h3>

		<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<button type="button" class="btn btn-danger" aria-label="Left Align" onclick="location.href='<?= base_url() ?>c_kontak'">
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
        <th>Email</th>
        <th>Pesan</th>
      </tr>
    </thead>
	
	<tbody>
		<?php
			$i=0;
			foreach($kontak as $rows)
			{
			$i++;
		?>
		<tr>
			<td><?php echo $rows->nama; ?></td>
			<td><?php echo $rows->email; ?></td>
			<td><?php echo $rows->pesan; ?></td>
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
	document.getElementById("a-kontak").className = "collapsed active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>