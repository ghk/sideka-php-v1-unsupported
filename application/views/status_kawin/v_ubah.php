<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('pustaka/c_status_kawin/update_status_kawin'); ?>

<table>
	<tr>
    	<td> ID </td>
        <td> : </td>
        <td> <input type="text" name="id_status_kawin" id="id_status_kawin" size="30" value="<?= $hasil->id_status_kawin?>" readonly = "readonly"/> </td>
	</tr>
	<tr>
    	<td> Deskripsi </td>
        <td> : </td>
        <td> <input type="text" name="deskripsi" id="deskripsi" size="30"  value="<?= $hasil->deskripsi?>"/> </td>
		<td><?php echo form_error('deskripsi', '<p class="field_error">','</p>')?></td>
	</tr>
</table>

<p>
<input type="submit" value="Simpan" id="simpan"/>
<input type="button" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>pustaka/c_status_kawin'"/>
</p>