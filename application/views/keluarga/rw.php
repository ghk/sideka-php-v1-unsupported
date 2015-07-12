	<?php 
		$id = 'id="id_rw" class="form-control input-md" ';
				echo form_dropdown('id_rw',$nomor_rw,'',$id)
	?>
	<script>
	$("#id_rw").change(function(){
				var cek = document.getElementById("id_rw").value;
				if(cek === "")
				{
					document.getElementById("id_rt_sementara").style.display = 'block';
					document.getElementById("id_rt").style.display = 'none';
				}
				else
				{
					var id_rw = {id_rw:$("#id_rw").val()};
					$.ajax({
							type: "POST",
							url : "<?php echo site_url('datapenduduk/c_keluarga/getRt')?>",
							data: id_rw,
							success: function(tes){
							document.getElementById("id_rt_sementara").style.display = 'none';
								$('#lala').html(tes);
								
							}
						});
				}
        });
		
		 $("#id_dusun").change(function(){
				document.getElementById("id_rt_sementara").style.display = 'block';
				document.getElementById("id_rt").style.display = 'none';
			});
	</script>