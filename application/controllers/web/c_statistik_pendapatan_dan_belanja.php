<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_pendapatan_dan_belanja extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('statistik/m_pendapatan_dan_belanja');
		$this->load->model('m_logo');
	}

	function index()
	{
		//piechart pendapatan
		$pendapatan[] = $this->m_pendapatan_dan_belanja->getDataPiePendapatan();
		$json = json_encode($pendapatan);
		$json =	$this->m_pendapatan_dan_belanja->highchartJson($json);
		$data['json'] = $json;
		//piechart belanja
		$belanja[] = $this->m_pendapatan_dan_belanja->getDataPieBelanja();
		$json2 = json_encode($belanja);
		$json2 =	$this->m_pendapatan_dan_belanja->highchartJson($json2);
		$data['json2'] = $json2;
		//stackchart pendapatan realisasi
		$pendapatanstackrealisasi[] = $this->m_pendapatan_dan_belanja->getDataStackPendapatanRealisasi();
		$jsonstackrealisasi = json_encode($pendapatanstackrealisasi);
		$jsonstackrealisasi =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackrealisasi);
		$data['jsonstackrealisasi'] = $jsonstackrealisasi;
		//stackchart pendapatan belum di realisasi
		$pendapatanstackbelumrealisasi[] = $this->m_pendapatan_dan_belanja->getDataStackPendapatanBelumRealisasi();
		$jsonstackbelumrealisasi = json_encode($pendapatanstackbelumrealisasi);
		$jsonstackbelumrealisasi =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelumrealisasi);
		$data['jsonstackbelumrealisasi'] = $jsonstackbelumrealisasi;
		//stackchart belanja realisasi
		$belanjastackrealisasi[] = $this->m_pendapatan_dan_belanja->getDataStackBelanjaRealisasi();
		$jsonstackbelanjarealisasi = json_encode($belanjastackrealisasi);
		$jsonstackbelanjarealisasi =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjarealisasi);
		$data['jsonstackbelanjarealisasi'] = $jsonstackbelanjarealisasi;
		//stackchart belanja belum di realisasi
		$belanjastackbelumrealisasi[] =  $this->m_pendapatan_dan_belanja->getDataStackBelanjaBelumRealisasi();
		$jsonstackbelanjabelumrealisasi = json_encode($belanjastackbelumrealisasi);
		$jsonstackbelanjabelumrealisasi =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjabelumrealisasi);
		$data['jsonstackbelanjabelumrealisasi'] = $jsonstackbelanjabelumrealisasi;
		$pendapatanaslidesa = 1;
		$pendapatantransfer = 2;
		$pendapatanlainlain = 3;
		//Container Basic Pendapatan Asli Desa per bulan
		$pendapatanaslibasic[] = $this->m_pendapatan_dan_belanja->getDataPendapatanBasic($pendapatanaslidesa);
		$jsonstackpendapatanaslibasic = json_encode($pendapatanaslibasic);
		$jsonstackpendapatanaslibasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackpendapatanaslibasic);
		$data['jsonstackpendapatanaslibasic'] = $jsonstackpendapatanaslibasic;
		//Container Basic Pendapatan Transfer Desa per bulan
		$pendapatantransferbasic[] = $this->m_pendapatan_dan_belanja->getDataPendapatanBasic($pendapatantransfer);
		$jsonstackpendapatantransferbasic = json_encode($pendapatantransferbasic);
		$jsonstackpendapatantransferbasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackpendapatantransferbasic);
		$data['jsonstackpendapatantransferbasic'] = $jsonstackpendapatantransferbasic;
		//Container Basic Pendapatan Lain-lain Desa per bulan
		$pendapatanlainbasic[] = $this->m_pendapatan_dan_belanja->getDataPendapatanBasic($pendapatanlainlain);
		$jsonstackpendapatanlainbasic = json_encode($pendapatanlainbasic);
		$jsonstackpendapatanlainbasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackpendapatanlainbasic);
		$data['jsonstackpendapatanlainbasic'] = $jsonstackpendapatanlainbasic;
		$penyelenggaraan = 4;
		$pelaksanaan     = 5;
		$pembinaan       = 6;
		$pemberdayaan    = 7;
		$takterduga      = 8;
		//Container Basic Belanja Penyelenggaraan per bulan
		$belanjapenyelenggaraanbasic[] = $this->m_pendapatan_dan_belanja->getDataBelanjaBasic($penyelenggaraan);
		$jsonstackbelanjapenyelenggaraanbasic = json_encode($belanjapenyelenggaraanbasic);
		$jsonstackbelanjapenyelenggaraanbasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjapenyelenggaraanbasic);
		$data['jsonstackbelanjapenyelenggaraanbasic'] = $jsonstackbelanjapenyelenggaraanbasic;
		//Container Basic Belanja Pelaksanaan per bulan
		$belanjapelaksanaanbasic[] = $this->m_pendapatan_dan_belanja->getDataBelanjaBasic($pelaksanaan);
		$jsonstackbelanjapelaksanaanbasic = json_encode($belanjapelaksanaanbasic);
		$jsonstackbelanjapelaksanaanbasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjapelaksanaanbasic);
		$data['jsonstackbelanjapelaksanaanbasic'] = $jsonstackbelanjapelaksanaanbasic;
		//Container Basic Belanja Pembinaan per bulan
		$belanjapembinaanbasic[] = $this->m_pendapatan_dan_belanja->getDataBelanjaBasic($pembinaan);
		$jsonstackbelanjapembinaanbasic = json_encode($belanjapembinaanbasic);
		$jsonstackbelanjapembinaanbasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjapembinaanbasic);
		$data['jsonstackbelanjapembinaanbasic'] = $jsonstackbelanjapembinaanbasic;
		//Container Basic Belanja Pemberdayaan per bulan
		$belanjapemberdayaanbasic[] = $this->m_pendapatan_dan_belanja->getDataBelanjaBasic($pemberdayaan);
		$jsonstackbelanjapemberdayaanbasic = json_encode($belanjapemberdayaanbasic);
		$jsonstackbelanjapemberdayaanbasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjapemberdayaanbasic);
		$data['jsonstackbelanjapemberdayaanbasic'] = $jsonstackbelanjapemberdayaanbasic;
		//Container Basic Belanja Tak Terduga per bulan
		$belanjatakterdugabasic[] = $this->m_pendapatan_dan_belanja->getDataBelanjaBasic($takterduga);
		$jsonstackbelanjatakterdugabasic = json_encode($belanjatakterdugabasic);
		$jsonstackbelanjatakterdugabasic =	$this->m_pendapatan_dan_belanja->highchartJson($jsonstackbelanjatakterdugabasic);
		$data['jsonstackbelanjatakterdugabasic'] = $jsonstackbelanjatakterdugabasic;

		//$data['result'] = $this->m_pendapatan_dan_belanja->getDataAkunPendapatan();
		//$data['jumlah'] = $this->m_pendapatan_dan_belanja->getJumlahPekerjaan();

		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/pendapatan', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/pendapatan',$data,TRUE);
		$this->load->view('templateStatistik',$temp);

	}

}