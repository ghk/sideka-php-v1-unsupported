<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>
		
<?php echo form_open('datapenduduk/c_penduduk/simpan_penduduk/'); ?>

<table>
	<input type="hidden" name="iduser" id="iduser" value="<?= $hasil->iduser ?>" size="20" /> 
	
	<tr>
    	<td> Nama Kepala Keluarga</td>
        <td> : </td>
        <td> <?php $id = 'id="kk"';
				echo form_dropdown('kk',$noKK,'',$id)?> </td>
	</tr>
   	<tr>
    	<td> NIK</td>
        <td> : </td>
        <td> <input type="text" name="nik" id="nik" size="30" onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46) )"/> </td>
	</tr>
	<tr>
    	<td> Nama Penduduk </td>
        <td> : </td>
        <td> <input type="text" name="nama" id="nama" size="25" /> </td>
	</tr>
	
	<tr>
    	<td> Dusun </td>
        <td> : </td>
        <td><?php $id = 'id="id_dusun"';
				echo form_dropdown('id_dusun',$nama_dusun,'',$id)?></td>
	</tr>
	<tr>
    	<td> RW  </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'01' => '01',
						'02' => '02',
						'03' => '03',
						'04' => '04',
						'05' => '05',
						'06' => '06',
						'07' => '07'
						);
					$id = 'id="rw"';
				echo form_dropdown('rw',$options,'',$id); ?> </td>
	</tr>
	<tr>
    	<td> RT  </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'01' => '01',
						'02' => '02',
						'03' => '03',
						'04' => '04',
						'05' => '05',
						'06' => '06',
						'07' => '07'
						);
					$id = 'id="rt"';
				echo form_dropdown('rt',$options,'',$id); ?> </td>
	</tr>
	
	<tr>
    	<td> Jenis Kelamin  </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'LAKI-LAKI' => 'LAKI-LAKI',
						'PEREMPUAN' => 'PEREMPUAN'
						);
					$id = 'id="jenis_kelamin"';
				echo form_dropdown('jenis_kelamin',$options,'',$id); ?> </td>
	</tr>
	<tr>
    	<td> Tanggal Lahir </td>
        <td> : </td>
        <td><a href="javascript:NewCssCal('ttl','yyyymmdd')"><input type="text" name="tanggal" id="ttl" size="20" readonly="readonly"/>
			<img src="<?php echo base_url(); ?>datepicker/images/cal.gif" width="16" height="16" alt="Pilih tanggal" />
			</a>
		</td>		
	</tr>
	<tr>
    	<td> Tempat Lahir </td>
        <td> : </td>
        <td> <input type="text" name="tempat" id="tempat" size="25" /> </td>
	</tr>
	<tr>
    	<td> Agama </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'BUDHA' => 'BUDHA',
						'HINDU' => 'HINDU',
						'ISLAM'=> 'ISLAM',
						'KATHOLIK' => 'KATHOLIK',
						'KRISTEN' => 'KRISTEN',
						'KHONGHUCU' => 'KHONGHUCU',
						'KEPERCAYAAN LAIN' => 'KEPERCAYAAN LAIN'
						);
					$id = 'id="agama"';
				echo form_dropdown('agama',$options,'',$id); ?> </td>
	</tr>
	<tr>
    	<td> Golongan Darah </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'A' => 'A',
						'B' => 'B',
						'AB'=> 'AB',
						'O' => 'O'
						);
					$id = 'id="goldar"';
				echo form_dropdown('goldar',$options,'',$id); ?></td>
	</tr>
	<tr>
    	<td> Pendidikan </td>
        <td> : </td>
        <td><?php $id = 'id="id_pendidikan"';
				echo form_dropdown('id_pendidikan',$jenis_pendidikan,'',$id)?></td>
	</tr>
	<tr>
    	<td> Pekerjaan </td>
        <td> : </td>
        <td> <?php $id = 'id="id_pekerjaan"';
				echo form_dropdown('id_pekerjaan',$jenis_pekerjaan,'',$id)?> </td>
	</tr>
	<tr>
    	<td> Pendapatan/Bulan </td>
        <td> : </td>
        <td> Rp <input type="text" name="pendapatan" id="pendapatan" size="30"  onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46) )"/> </td>
		
	</tr>
	<tr>
    	<td> Status Kawin </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'BELUM KAWIN' => 'BELUM KAWIN',
						'KAWIN' => 'KAWIN',
						'CERAI HIDUP' => 'CERAI HIDUP',
						'CERAI MATI' => 'CERAI MATI'
						);
					$id = 'id="status_kawin"';
				echo form_dropdown('status_kawin',$options,'',$id); ?> </td>
	</tr>
	<tr>
    	<td> Kewarganegaraan </td>
        <td> : </td>
        <td> <?php $options = array(
						''=>'-- Pilih --',
						'WNI' => 'Warga Negara Indonesia',
						'WNA' => 'Warga Negara Asing'
						);
					$id = 'id="kewarganegaraan"';
				echo form_dropdown('kewarganegaraan',$options,'',$id); ?> </td>
	</tr>
	
	
	
</table>

<p>
<input type="submit" value="Simpan" id="simpan"/>
<input type="button" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>datapenduduk/c_penduduk'"/>
</p>

<script>
function nav_active(){
	
	document.getElementById("a-data-kependudukan").className = "collapsed active";
	
	document.getElementById("kependudukan").className = "collapsed";

	var d = document.getElementById("nav-penduduk");
	d.className = d.className + "active";
	}
 
// very simple to use!
$(document).ready(function() {
  nav_active();
});
</script>