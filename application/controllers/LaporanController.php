<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanController extends CI_Controller {
    /**
     * LaporanController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->logged_in){
            redirect(site_url("logincontroller/login"));
            exit;
        }else{
            if ($this->session->user->hak_akses == "Admin"){
                $this->load->view('templates/header_admin');
            }
            else{
                $this->load->view('templates/header_directur');
            }
        }
        $this->load->model("LaporanModel","",TRUE);
    }

   
	function index()
    {
        $data['dataKas'] = $this->LaporanModel->getKas();
        $this->load->view('laporan/list', $data);
        $this->load->view('templates/footer'); 
    }

    function report_mounth()
    {
        $this->load->view('laporan/report');
        $this->load->view('templates/footer'); 
    }

    function readbyid_admin()
    {
        $this->load->view('laporan/admin/read_report');
        $this->load->view('templates/footer'); 
    }

    function get_download()
    {
        $this->load->library('pdf');
        //$data['users'] = $this->UsersModel->getUsers();
        $html = $this->load->view('laporan/generatepdf', [], true);
        $this->pdf->createPDF($html, 'laporan akun', false);
    }

    
}
