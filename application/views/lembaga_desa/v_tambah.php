<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_lembaga_desa/simpan_lembaga_desa'); ?>

<table>
	<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="20" /> 
	<tr>
        <td> <textarea id="xxx" name="lembaga_desa" cols="80" ></textarea> </td>
	</tr>
</table>

<p>
<input type="submit" value="Simpan" id="simpan"/>
<input type="button" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_lembaga_desa'"/>
</p>