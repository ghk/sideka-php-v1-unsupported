<h2><?= $page_title ?></h2>

<?php $flashmessage = $this->session->flashdata('exist');
	echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': ''; ?>

<?php echo form_open('admin/c_sejarah/simpan_sejarah'); ?>

	<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $hasil->id_pengguna ?>" size="10" /> 

       <textarea id="xxx" name="sejarah_desa" ></textarea>


<p>
<input type="submit" value="Simpan" id="simpan"/>
<input type="button" value="Batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_sejarah'"/>
</p>