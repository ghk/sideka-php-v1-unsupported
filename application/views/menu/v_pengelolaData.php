<br><br>
<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">                      
                        <li> 
                            <a href="<?php echo site_url('c_pengelolaData/');?>" id="a-pengelola_data" class=""><i class="fa fa-home fa-fw "></i> Beranda</a>
                        </li>
						
						<!---------------------DROPDOWN 1--------------------------------------------------------------->
						<li class="dropdownmenu">
						<a id="a-data-kependudukan" class="collapsed" data-toggle="collapse" href="#kependudukan">
						<i class="fa fa-book fa-fw"></i> Kependudukan <span class="fa arrow"></span></a>
						<div id="kependudukan" class="collapse">
						<ul id="" class="nav nav-pills nav-stacked nav-second-level">
							<li id="nav-kk" class="">
								<a href="<?php echo site_url('datapenduduk/c_keluarga/');?>"><i class="fa fa-user fa-fw"></i> Data Kepala Keluarga</a>
							</li>
							
							<li id="nav-penduduk" class="">
								<a href="<?php echo site_url('datapenduduk/c_penduduk/');?>"><i class="fa fa-group fa-fw"></i> Data Penduduk</a>
							</li>
							
							<li id="nav-pisah_kk" class="">
								<a href="<?php echo site_url('datapenduduk/c_pisah_kk/');?>"><i class="fa fa-user-times fa-fw"></i> Pisah Kartu Keluarga</a>
							</li>
							
							<li id="nav-cetak_kk" class="">
								<a href="<?php echo site_url('datapenduduk/c_cetak_kk/');?>"><i class="fa fa-print fa-fw"></i> Cetak Kartu Keluarga</a>
							</li>	
						</ul>
						</div>
						</li>
						<!------------------------------------------------------------------------------------>
						
						<!---------------------DROPDOWN 2--------------------------------------------------------------->
						<li class="dropdownmenu">
						<a id="a-data-perspektif_sosial_penduduk" class="collapsed" data-toggle="collapse" href="#perspektif_sosial_penduduk">
						<i class="fa fa-desktop fa-fw"></i> Perspektif Sosial Penduduk <span class="fa arrow"></span></a>
						<div id="perspektif_sosial_penduduk" class="collapse">
						<ul id="" class="nav nav-pills nav-stacked nav-second-level">
							<li id="nav-penduduk_miskin" class="">
					<a href="<?php echo site_url('datapenduduk/c_penduduk_miskin/');?>"><i class="fa fa-area-chart fa-fw"></i> Penerima Bantuan Sosial</a>
							</li>
							<li id="nav-bsm" class="">
							<a href="<?php echo site_url('datapenduduk/c_bsm/');?>"><i class="fa fa-money fa-fw"></i> Bantuan Siswa Miskin</a>
							</li>	
						</ul>
						</div>
						</li>
						<!------------------------------------------------------------------------------------>
						
						<!---------------------DROPDOWN 3--------------------------------------------------------------->
						<li class="dropdownmenu">
						<a id="a-data-perspektif_kesehatan_penduduk" class="collapsed" data-toggle="collapse" href="#perspektif_kesehatan_penduduk">
						<i class="fa fa-medkit fa-fw"></i> Kesehatan Penduduk <span class="fa arrow"></span></a>
						<div id="perspektif_kesehatan_penduduk" class="collapse">
						<ul id="" class="nav nav-pills nav-stacked nav-second-level">
							<li id="nav-gizi_buruk" class="">
							<a href="<?php echo site_url('datapenduduk/c_gizi_buruk/');?>"><i class="fa fa-child fa-fw"></i> Data Gizi Buruk</a>
							</li>
							<li id="nav-kehamilan" class="">
						<a href="<?php echo site_url('datapenduduk/c_kondisi_kehamilan/');?>"><i class="fa fa-female fa-fw"></i> Data Kehamilan</a>
							</li>
						</ul>
						</div>
						</li>
						<!------------------------------------------------------------------------------------>
						
						<!---------------------DROPDOWN 4--------------------------------------------------------------->
						<li class="dropdownmenu">
						<a id="a-data-pustaka_kependudukan" class="collapsed" data-toggle="collapse" href="#pustaka_kependudukan">
						<i class="fa fa-list fa-fw"></i> Pustaka Kependudukan <span class="fa arrow"></span></a>
						<div id="pustaka_kependudukan" class="collapse">
							<ul id="" class="nav nav-pills nav-stacked nav-second-level">
								<li id="nav-pendidikan" class="">
									<a href="<?php echo site_url('datapenduduk/c_pendidikan/');?>">Pendidikan</a>
								</li>
								<li id="nav-pekerjaan" class="">
									<a href="<?php echo site_url('datapenduduk/c_pekerjaan/');?>">Pekerjaan</a>
								</li>
								<li id="nav-pekerjaan_ped" class="">
									<a href="<?php echo site_url('datapenduduk/c_pekerjaan_ped/');?>">Pekerjaan PED</a>
								</li>
								<li id="nav-goldar" class="">
									<a href="<?php echo site_url('pustaka/c_goldar/');?>">Golongan Darah</a>
								</li>
								<li id="nav-agama" class="">
									<a href="<?php echo site_url('pustaka/c_agama/');?>">Agama</a>
								</li>
								<li id="nav-kewarganegaraan" class="">
									<a href="<?php echo site_url('pustaka/c_kewarganegaraan/');?>">Kewarganegaraan</a>
								</li>
								<li id="nav-kompetensi" class="">
									<a href="<?php echo site_url('pustaka/c_kompetensi/');?>">Kompetensi</a>
								</li>
								<li id="nav-status_keluarga" class="">
									<a href="<?php echo site_url('pustaka/c_status_keluarga/');?>">Status Keluarga</a>
								</li>	
								<li id="nav-status_penduduk" class="">
									<a href="<?php echo site_url('pustaka/c_status_penduduk/');?>">Status Penduduk</a>
								</li>	
							</ul>
						</div>
						</li>
						<!------------------------------------------------------------------------------------>
						
						<!---------------------DROPDOWN 5--------------------------------------------------------------->
						<li class="dropdownmenu">
						<a id="a-data-pustaka_lainnya" class="collapsed" data-toggle="collapse" href="#pustaka_lainnya">
						<i class="fa fa-list fa-fw"></i> Pustaka Lainnya <span class="fa arrow"></span></a>
						<div id="pustaka_lainnya" class="collapse">
							<ul id="yw6" class="nav nav-pills nav-stacked nav-second-level">								
								<li id="nav-difabilitas" class="">	
									<a href="<?php echo site_url('pustaka/c_difabilitas/');?>">Difabilitas</a>
								</li>										
								<li id="nav-kode_surat" class="">
									<a href="<?php echo site_url('pustaka/c_kode_surat/');?>">Kode Surat</a>		
								</li>
								<li id="nav-kontrasepsi" class="">
									<a href="<?php echo site_url('pustaka/c_kontrasepsi/');?>">Kontrasepsi</a>		
								</li>									
								<li id="nav-status_tinggal" class="">
									<a href="<?php echo site_url('pustaka/c_status_tinggal/');?>">Status Tinggal</a>					
								</li>	
								<li id="nav-alasan_pindah" class="">
									<a href="<?php echo site_url('pustaka/c_alasan_pindah');?>">Alasan Pindah</a>		
								</li>	
								<li id="nav-jabatan" class="">
									<a href="<?php echo site_url('pustaka/c_jabatan/');?>">Jabatan</a>
								</li>	
								<li id="nav-jenis_pindah" class="">
									<a href="<?php echo site_url('pustaka/c_jenis_pindah/');?>">Jenis Pindah</a>
								</li>	
								<li id="nav-klasifikasi_pindah" class="">
									<a href="<?php echo site_url('pustaka/c_klasifikasi_pindah/');?>">Klasifikasi Pindah</a>							
								</li>
							</ul>
						</div>
						</li>
						<!------------------------------------------------------------------------------------>
						
						
						<!---------------------DROPDOWN 6--------------------------------------------------------------->
						<li class="dropdownmenu">
						<a id="a-data-peristiwa" class="collapsed" data-toggle="collapse" href="#peristiwa">
						<i class="fa fa-newspaper-o fa-fw"></i> Peristiwa<span class="fa arrow"></span></a>
						<div id="peristiwa" class="collapse">
							<ul id="yw6" class="nav nav-pills nav-stacked nav-second-level">								
								<li id="nav-kelahiran" class="">	
									<a href="<?php echo site_url('peristiwa/c_kelahiran/');?>"><i class="fa fa-venus-mars fa-fw"></i></i> Kelahiran</a>
								</li>										
								<li id="nav-meninggal" class="">
									<a href="<?php echo site_url('peristiwa/c_meninggal/');?>"><i class="fa fa-ambulance fa-fw"></i> Meninggal</a>		
								</li>
								<li class="dropdownmenu">
									<a id="a-data-pindah_penduduk" class="collapsed" data-toggle="collapse" href="#pindah_penduduk">
									<i class="fa fa-exchange fa-fw"></i> Pindah Penduduk<span class="fa arrow"></span></a>
									<div id="pindah_penduduk" class="collapse">
										<ul id="yw6" class="nav nav-pills nav-stacked nav-third-level">								
											<li id="nav-pindah_masuk" class="">	
												<a href="<?php echo site_url('peristiwa/c_pindah_masuk/');?>"><i class="fa fa-long-arrow-right fa-fw"></i> Pindah Masuk</a>
											</li>										
											<li id="nav-pindah_keluar" class="">
												<a href="<?php echo site_url('peristiwa/c_pindah_keluar/');?>"><i class="fa fa-long-arrow-left fa-fw"></i> Pindah Keluar</a>		
											</li>
											
											
										</ul>
									</div>
								</li>
								
							</ul>
						</div>
						</li>		
						<!------------------------------------------------------------------------------------>
						<li>
							<a href="<?php echo site_url('surat/c_surat/');?>" id="a-surat" class="" ><i class="fa fa-envelope fa-fw"></i> Surat Menyurat</a>							
						</li>
						<li>
							<a href="<?php echo site_url('smart/c_smart/');?>" id="a-smart" class="" ><i class="fa fa-search fa-fw"></i> Pencarian Pintar</a>
						</li>
			
					</ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
        <!-- /.navbar-static-side -->
     