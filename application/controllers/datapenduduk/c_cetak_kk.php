<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_cetak_kk extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_cetak_kk');		
		
		$this->load->helper('url');
		
		$this->load->config('pdf_config');
        $this->load->library('fpdf');
		$this->load->helper('date');
		$this->load->helper('text');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
    }

    function index()    
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$this->add();
		}
		else
			redirect('c_login', 'refresh'); 	
    }
	//Page header
	function Header($data)
	{
		$this->fpdf->Open();
		$this->fpdf->FPDF('L','mm','legal');
		$this->fpdf->SetAutoPageBreak(false);
        	$this->fpdf->AddPage();
		
		//Logo
		$image = base_url().'uploads/web/logo_kk.jpg';
		$this->fpdf->Image($image,15,10); 
		//Arial bold 15
		$this->fpdf->SetFont('Arial','B',28);
		//judul
		$this->fpdf->Cell(0,15,'SALINAN KARTU KELUARGA',0,0,'C');
		//pindah baris
		$this->fpdf->SetFont('Arial','B',16);
		$this->fpdf->Ln(16);
		$i=0;
		foreach($data['KK'] as $rows)
		{
			$i++;
			$this->fpdf->Cell(0,0,'No. '.$rows->no_kk,0,0,'C');
		}
	}
	
	//Page Content
	function Content($data)
	{
		$this->fpdf->SetFont('Arial','B',9);
		///////////////////////////////////////////////////////
		$i=0;
		foreach($data['KK'] as $rows)
		{
			$i++;
			$this->fpdf->Ln(12);
			$this->fpdf->Cell(0,5,'Nama Kepala Keluarga',0,0,'L');
			$this->fpdf->Cell(-288);
			$this->fpdf->Cell(0,5,':  '.strtoupper($rows->nama),0,1,'L');
			$this->fpdf->Cell(0,5,'Alamat',0,0,'L');
			$this->fpdf->Cell(-288);
			$this->fpdf->Cell(0,5,': ','',"L");
			$this->fpdf->Cell(-285);
			$this->fpdf->MultiCell(0,5,strtoupper($rows->alamat_jalan),'','L');
			$this->fpdf->Cell(0,5,'RT / RW',0,0,'L');
			$this->fpdf->Cell(-288);
			$this->fpdf->Cell(0,5,':  '.strtoupper($rows->nomor_rt.' / '.$rows->nomor_rw),0,1,'L');
			$this->fpdf->Cell(0,5,'Kelurahan / Desa',0,0,'L');
			$this->fpdf->Cell(-288);
			$this->fpdf->Cell(0,5,':  '.strtoupper($rows->nama_desa),0,1,'L');
			//////////////////////////////////////////////////////
			$this->fpdf->Ln(-20);
			$this->fpdf->Cell(210);
			$this->fpdf->Cell(0,5,'Kecamatan',0,0,'L');
			$this->fpdf->Cell(-80);
			$this->fpdf->Cell(0,5,':  '.strtoupper($rows->nama_kecamatan),0,1,'L');
			$this->fpdf->Cell(210);
			$this->fpdf->Cell(0,5,'Kabupaten / Kota',0,0,'L');
			$this->fpdf->Cell(-80);
			$this->fpdf->Cell(0,5,':  '.strtoupper($rows->nama_kab_kota),0,1,'L');
			$this->fpdf->Cell(210);
			$this->fpdf->Cell(0,5,'Kode Pos',0,0,'L');
			$this->fpdf->Cell(-80);
			$this->fpdf->Cell(0,5,':  '.$rows->kode_pos,0,1,'L');
			$this->fpdf->Cell(210);
			$this->fpdf->Cell(0,5,'Provinsi',0,0,'L');
			$this->fpdf->Cell(-80);
			$this->fpdf->Cell(0,5,':  '.strtoupper($rows->nama_provinsi),0,1,'L');
		}
		///////////////////////////////////////////////////
		$this->fpdf->SetFont('Arial','B',8);
		$this->fpdf->Ln();
		$this->fpdf->Cell(8,5,'No','LTR',0,'C',0);
		$this->fpdf->Cell(60,5,'Nama Lengkap','LTR',0,'C',0);
		$this->fpdf->Cell(40,5,'NIK','LTR',0,'C',0);
		$this->fpdf->Cell(25,5,'Jenis','LTR',0,'C',0);
		$this->fpdf->Cell(45,5,'Tempat Lahir','LTR',0,'C',0);
		$this->fpdf->Cell(30,5,'Tanggal Lahir','LTR',0,'C',0);
		$this->fpdf->Cell(25,5,'Agama','LTR',0,'C',0);
		$this->fpdf->Cell(50,5,'Pendidikan','LTR',0,'C',0);
		$this->fpdf->Cell(55,5,'Pekerjaan','LTR',0,'C',0);
		
        $this->fpdf->Ln();
		$this->fpdf->Cell(8,5,' ','LRB',0,'C',0); 
		$this->fpdf->Cell(60,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(25,5,'Kelamin','LRB',0,'C',0);
		$this->fpdf->Cell(45,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(30,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(25,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(50,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(55,5,' ','LRB',0,'C',0);
		
		$this->fpdf->Ln();
		$this->fpdf->Cell(8,5,'1','LRB',0,'C',0);
		$this->fpdf->Cell(60,5,'2','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,'3','LRB',0,'C',0);
		$this->fpdf->Cell(25,5,'4','LRB',0,'C',0);
		$this->fpdf->Cell(45,5,'5','LRB',0,'C',0);
		$this->fpdf->Cell(30,5,'6','LRB',0,'C',0);
		$this->fpdf->Cell(25,5,'7','LRB',0,'C',0);
		$this->fpdf->Cell(50,5,'8','LRB',0,'C',0);
		$this->fpdf->Cell(55,5,'9','LRB',0,'C',0);
		///////////////////////////////////////////////////
		//Data Keluarga 1-9
		$j=0;
		foreach($data['Anggota_KK'] as $rows)
		{
			$j++;
			$this->fpdf->Ln();
			$this->fpdf->Cell(8,5,$j,'LR',0,'C',0);//Nomor
			$this->fpdf->Cell(60,5,strtoupper($rows->nama),'LR',0,'L',0);//Nama Lengkap
			$this->fpdf->Cell(40,5,strtoupper($rows->nik),'LR',0,'L',0);//NIK
			$this->fpdf->Cell(25,5,strtoupper($rows->jen_kel),'LR',0,'C',0);//Jenis Kelamin
			$this->fpdf->Cell(45,5,strtoupper($rows->tempat_lahir),'LR',0,'L',0);//Tempat Lahir
			$this->fpdf->Cell(30,5,date('j/m/Y',strtotime($rows->tanggal_lahir)),'LR',0,'C',0);// Tanggal Lahir
			if($rows->is_diakui=='N')
			{
				$agama='-';
			}
			else
			{
				$agama=$rows->agama;
			}
			$this->fpdf->Cell(25,5,strtoupper($agama),'LR',0,'C',0);//Agama
			$this->fpdf->Cell(50,5,strtoupper($rows->pendidikan),'LR',0,'L',0);//Pendidikan
			$this->fpdf->Cell(55,5,strtoupper($rows->pekerjaan),'LR',0,'L',0);//Pekerjaan
		}
		$this->fpdf->Ln();
		$this->fpdf->Cell(8,5,' ','T',0,'C',0); 
		$this->fpdf->Cell(60,5,' ','T',0,'C',0);
		$this->fpdf->Cell(40,5,' ','T',0,'C',0);
		$this->fpdf->Cell(20,5,' ','T',0,'C',0);
		$this->fpdf->Cell(45,5,' ','T',0,'C',0);
		$this->fpdf->Cell(30,5,' ','T',0,'C',0);
		$this->fpdf->Cell(25,5,' ','T',0,'C',0);
		$this->fpdf->Cell(50,5,' ','T',0,'C',0);
		$this->fpdf->Cell(60,5,' ','T',0,'C',0);
		////////////////////////////////////////////
		$this->fpdf->Ln();
		$this->fpdf->Cell(8,5,'No','LTR',0,'C',0);
		$this->fpdf->Cell(40,5,'Status Perkawinan','LTR',0,'C',0);
		$this->fpdf->Cell(40,5,'Status Hubungan','LTR',0,'C',0);
		$this->fpdf->Cell(40,5,'Kewarganegaraan','LTR',0,'C',0);
		$this->fpdf->Cell(90,5,'Dokumen Imigrasi','LTB',0,'C',0);
		$this->fpdf->Cell(120,5,'Nama Orang Tua','LRTB',0,'C',0);
		
        $this->fpdf->Ln();
		$this->fpdf->Cell(8,5,' ','LRB',0,'C',0); 
		$this->fpdf->Cell(40,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,'Dalam Keluarga','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(45,5,'No.Paspor','LRB',0,'C',0);
		$this->fpdf->Cell(45,5,'No. KITAS/KITAP','LRB',0,'C',0);
		$this->fpdf->Cell(60,5,'Ayah','LRB',0,'C',0);
		$this->fpdf->Cell(60,5,'Ibu','LRB',0,'C',0);
		
		$this->fpdf->Ln();
		$this->fpdf->Cell(8,5,' ','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,'10','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,'11','LRB',0,'C',0);
		$this->fpdf->Cell(40,5,'12','LRB',0,'C',0);
		$this->fpdf->Cell(45,5,'13','LRB',0,'C',0);
		$this->fpdf->Cell(45,5,'14','LRB',0,'C',0);
		$this->fpdf->Cell(60,5,'15','LRB',0,'C',0);
		$this->fpdf->Cell(60,5,'16','LRB',0,'C',0);
		
		//Data Keluarga 10-16
		$j=0;
		foreach($data['Anggota_KK'] as $rows)
		{
			$j++;
			$this->fpdf->Ln();
			$this->fpdf->Cell(8,5,$j,'LR',0,'C',0);//No
			$this->fpdf->Cell(40,5,strtoupper($rows->status_kawin),'LR',0,'L',0);//Status Perkawinan
			$this->fpdf->Cell(40,5,strtoupper($rows->status_keluarga),'LR',0,'L',0);//Status Hub Kel
			$this->fpdf->Cell(40,5,strtoupper($rows->kewarganegaraan),'LR',0,'L',0);//Kewarganegaraan
			$this->fpdf->Cell(45,5,strtoupper($rows->no_paspor),'LR',0,'L',0);//No. Paspor
			$this->fpdf->Cell(45,5,strtoupper($rows->no_kitas),'LR',0,'L',0);// No. KITAS/KITAP
			$this->fpdf->Cell(60,5,strtoupper($rows->nama_ayah),'LR',0,'L',0);//Ayah
			$this->fpdf->Cell(60,5,strtoupper($rows->nama_ibu),'LR',0,'L',0);//Ibu
			
		}
		$this->fpdf->Ln();
		$this->fpdf->Cell(8,5,' ','T',0,'C',0);
		$this->fpdf->Cell(40,5,' ','T',0,'C',0);
		$this->fpdf->Cell(40,5,' ','T',0,'C',0);
		$this->fpdf->Cell(40,5,' ','T',0,'C',0);
		$this->fpdf->Cell(45,5,' ','T',0,'C',0);
		$this->fpdf->Cell(45,5,' ','T',0,'C',0);
		$this->fpdf->Cell(60,5,' ','T',0,'C',0);
		$this->fpdf->Cell(60,5,' ','T',0,'C',0);	
	}
	
	//Page footer
	function Footer()
	{
		
	}
	
	function add()
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['page_title'] = 'Cetak Kartu Keluarga';
			$data['json_array'] = $this->autocomplete_KepalaKeluarga();	
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('keluarga/v_cetak_kk', $data, TRUE);		
			$this->load->view('utama', $data);
		}
		else
			redirect('c_login', 'refresh'); 
	}
	
	function cetak($nik) 
	{
			
			$IdKK=$this->m_cetak_kk->GetIdPendudukByNIK($nik);
			$IdKeluarga=$this->m_cetak_kk->GetIdKeluargaByIdKK($IdKK);
			$data['KK']=$this->m_cetak_kk->GetPendudukByIdPenduduk($IdKK);
			$data['Anggota_KK']=$this->m_cetak_kk->GetPendudukByIdKeluarga($IdKeluarga);
			
			$this->Header($data);
			$this->Content($data);
			$this->Footer();
		
			foreach($data['KK'] as $rows)
			{
				$this->fpdf->Output();
			}    

    }
	
	public function autocomplete_KepalaKeluarga()
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_cetak_kk->getKepalaKeluargaLikeNama($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->no_kk.' | '.$row->nama.' | '.$row->nik ;
		}
        return json_encode($json_array);
    }
		
}
?>