<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_report');
        $this->load->model('m_logo');
    }  
// --- Fix --- //    
    public function jenis_kelamin()
    {
    		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['dataL'] = $this->m_report->get_dataL();
		$data['dataP'] = $this->m_report->get_dataP();
		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/jenis_kelamin',$data,TRUE);
		
		$this->load->view('web/statistik/jenis_kelamin',$temp);
		
    }
	public function agama()
    {
		$rows = $this->m_report->getAgama();
       
		$jumlahAgama = array();
		$jumlahAgamaLaki = array();
		
		$json_array_penduduk = array();
        foreach ($rows as $row)
		{
			$json_array_penduduk[] = $this->m_report->getPendudukByIdAgama($row->id_agama);
			$jumlahAgama[] = $this->m_report->getJumlahPendudukByIdAgama($row->id_agama);
			$jumlahAgamaLaki[] = $this->m_report->getJumlahLakiLakiByIdAgama($row->id_agama);			
			$jumlahAgamaPerempuan[] = $this->m_report->getJumlahPerempuanByIdAgama($row->id_agama);
			
		}
		
		$json_agama_penduduk = json_encode($json_array_penduduk);		
		$json_agama_penduduk = $this->m_report->highchartJson($json_agama_penduduk);
		
		
		
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['dataL'] = $this->m_report->get_dataL();
		$data['dataP'] = $this->m_report->get_dataP();
		
		$data['json_array'] = $json_agama_penduduk;
		$data['rows'] = $rows;		
		$data['jumlahAgama'] = $jumlahAgama;
		$data['jumlahAgamaLaki'] = $jumlahAgamaLaki;		
		$data['jumlahAgamaPerempuan'] = $jumlahAgamaPerempuan;
		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/agama',$data,TRUE);
		$this->load->view('web/statistik/agama',$temp);
    }
	
	public function status()
    {
		$data['dataBK'] = $this->m_report->get_dataBK();
		$data['dataBKL'] = $this->m_report->get_dataBKlaki();
		$data['dataBKP'] = $this->m_report->get_dataBKperempuan();
		
		$data['dataK'] = $this->m_report->get_dataK();
		$data['dataKL'] = $this->m_report->get_dataKlaki();
		$data['dataKP'] = $this->m_report->get_dataKperempuan();
		
		$data['dataCH'] = $this->m_report->get_dataCH();
		$data['dataCHL'] = $this->m_report->get_dataCHlaki();
		$data['dataCHP'] = $this->m_report->get_dataCHperempuan();
		
		$data['dataCM'] = $this->m_report->get_dataCM();
		$data['dataCML'] = $this->m_report->get_dataCMlaki();
		$data['dataCMP'] = $this->m_report->get_dataCMperempuan();
		
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['dataL'] = $this->m_report->get_dataL();
		$data['dataP'] = $this->m_report->get_dataP();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);		
		$temp['content'] = $this->load->view('web/content/status',$data,TRUE);
		$this->load->view('web/statistik/status',$temp);
		
    }


	public function golongan_darah()
    {
		
		$rows = $this->m_report->getGolDar();
       
		$jumlahGolDar = array();
		$jumlahGolDarLaki = array();
		
		$json_array_penduduk = array();
        foreach ($rows as $row)
		{
			$json_array_penduduk[] = $this->m_report->getPendudukByIdGolDar($row->id_goldar);
			$jumlahGolDar[] = $this->m_report->getJumlahPendudukByIdGolDar($row->id_goldar);
			$jumlahGolDarLaki[] = $this->m_report->getJumlahLakiLakiByIdGoldar($row->id_goldar);			
			$jumlahGolDarPerempuan[] = $this->m_report->getJumlahPerempuanByIdGoldar($row->id_goldar);
			
		}
		
		$json_goldar_penduduk = json_encode($json_array_penduduk);		
		$json_goldar_penduduk = $this->m_report->highchartJson($json_goldar_penduduk);
		
		
		
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['dataL'] = $this->m_report->get_dataL();
		$data['dataP'] = $this->m_report->get_dataP();
		
		$data['json_array'] = $json_goldar_penduduk;
		$data['rows'] = $rows;		
		$data['jumlahGolDar'] = $jumlahGolDar;
		$data['jumlahGolDarLaki'] = $jumlahGolDarLaki;		
		$data['jumlahGolDarPerempuan'] = $jumlahGolDarPerempuan;
		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/golongan_darah',$data,TRUE);
		$this->load->view('web/statistik/golongan_darah',$temp);
		
    }
	
	public function pendidikan()
    {
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['dataL'] = $this->m_report->get_dataL();
		$data['dataP'] = $this->m_report->get_dataP();		
		$data['result'] = $this->m_report->get_dataPendidikanJumlah(); 

		$resultJenisPendidikan = $this->m_report->get_pendidikanPenduduk();
		$resultJumlahPendidikan = $this->m_report->get_jumlahPendidikan();
		
		$jmlPendidikan = $resultJumlahPendidikan;
		$count = 0;
		$countJumlah = 0;
		while($count < $jmlPendidikan)
		{
			$array[$count] = $resultJenisPendidikan[$count];			
			$count++;			
		}
		while($count < $jmlPendidikan*2)
		{
			$arrayJumlah[$countJumlah] = $resultJenisPendidikan[$count];
			$countJumlah++;			
			$count++;			
		}
		
		$data['pendidikan'] = $array;
		$data['c'] = $resultJumlahPendidikan;
		$data['jumlahPenduduk'] = $arrayJumlah;
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/pendidikan',$data,TRUE);
		$this->load->view('web/statistik/pendidikan',$temp);	
    }
	
	public function pekerjaan()
    {
		$data['result'] = $this->m_report->get_dataPekerjaanJumlah();		
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['dataL'] = $this->m_report->get_dataL();
		$data['dataP'] = $this->m_report->get_dataP();
		
		$resultJenisPekerjaan = $this->m_report->get_pekerjaanPenduduk();
		$resultJumlahPekerjaan = $this->m_report->get_jumlahPekerjaan();
		
		$jmlPekerjaan = $resultJumlahPekerjaan;
		$count = 0;
		$countJumlah = 0;
		while($count < $jmlPekerjaan)
		{
			$array[$count] = $resultJenisPekerjaan[$count];			
			$count++;			
		}
		while($count < $jmlPekerjaan*2)
		{
			$arrayJumlah[$countJumlah] = $resultJenisPekerjaan[$count];
			$countJumlah++;			
			$count++;			
		}
		
		$data['pekerjaan'] = $array;
		$data['c'] = $resultJumlahPekerjaan;
		$data['jumlahPenduduk'] = $arrayJumlah;
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/pekerjaan',$data,TRUE);
		$this->load->view('web/statistik/pekerjaan',$temp);	
    }
	
	public function raskin()
    {
		$data['jumlah'] = $this->m_report->getTotalDataKepalaKeluarga(); 
		$data['dRaskinY'] = $this->m_report->get_raskinYa();
		$data['dRaskinT'] = $this->m_report->get_raskinTidak();
		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/raskin',$data,TRUE);
		$this->load->view('web/statistik/raskin',$temp);
		
    }
	
	public function jamkesmas()
    {
		$data['jumlah'] = $this->m_report->getTotalDataKepalaKeluarga(); 
		$data['djamY'] = $this->m_report->get_jamkesmasYa();
		$data['djamT'] = $this->m_report->get_jamkesmasTidak();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/jamkesmas',$data,TRUE);
		$this->load->view('web/statistik/jamkesmas',$temp);
		
    }
	
	public function pkh()
    {
		$data['jumlah'] = $this->m_report->getTotalDataKepalaKeluarga(); 
		$data['dPkhY'] = $this->m_report->get_pkhYa();
		$data['dPkhT'] = $this->m_report->get_pkhTidak();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/pkh',$data,TRUE);
		$this->load->view('web/statistik/pkh',$temp);
		
    }
	
	public function kk_perempuan()
    {
		$data['jumlah'] = $this->m_report->getTotalDataKepalaKeluarga(); 
		$data['jumlah_kk_perempuan'] = $this->m_report->getKkPerempuan();
		$data['jumlah_kk_laki'] = $this->m_report->getKkLaki();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/kk_perempuan',$data,TRUE);
		$this->load->view('web/statistik/kk_perempuan',$temp);
		
    }
	
	public function gizi_buruk()
    {
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['jumlah_gizi_buruk_laki'] = $this->m_report->getGiziBuruk(1);
		$data['jumlah_gizi_buruk_perempuan'] = $this->m_report->getGiziBuruk(2);
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/gizi_buruk',$data,TRUE);
		$this->load->view('web/statistik/gizi_buruk',$temp);
		
    }
	
	public function kehamilan()
    {
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['jumlah_penduduk_perempuan'] = $this->m_report->pendudukPerempuan();
		$data['jumlah_kehamilan'] = $this->m_report->getKehamilan();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/kehamilan',$data,TRUE);
		$this->load->view('web/statistik/kehamilan',$temp);
		
    }
	
	public function migran()
    {
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['jumlah_migran'] = $this->m_report->getMigran();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/migran',$data,TRUE);
		$this->load->view('web/statistik/migran',$temp);
		
    }
	
	public function bsm()
    {
		$data['jumlah'] = $this->m_report->getTotalData(); 
		$data['jumlah_bsm'] = $this->m_report->getBsm();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/bsm',$data,TRUE);
		$this->load->view('web/statistik/bsm',$temp);
		
    }
// -------- //	

// --- dalam proses --- //

	public function kelas_sosial()
    {
		$data['jumlah'] = $this->m_report->getTotalDataKepalaKeluarga(); 
		$data['sangat'] = $this->m_report->get_sangatmiskin();
		$data['miskin'] = $this->m_report->get_miskin();
		$data['sedang'] = $this->m_report->get_sedang();
		$data['kaya'] = $this->m_report->get_kaya();
		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$temp['content'] = $this->load->view('web/content/kelas_sosial',$data,TRUE);
		$this->load->view('web/statistik/kelas_sosial',$temp);
		
    }	
	
	
// ------ //
	
	
	
    
	
	
	
	

}