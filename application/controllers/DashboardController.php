<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {
    /**
     * DashboardController constructor.
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
        $this->load->model("PemasukanModel","",TRUE);
        $this->load->model("PengeluaranModel","",TRUE);
        $this->load->model("KasModel","",TRUE);
    }

	function index()
    {
        $data['Total_Pemasukan'] = $this->PemasukanModel->count_Pemasukan();
        $data['Total_Pengeluaran'] = $this->PengeluaranModel->count_Pengeluaran();
        $data['dataKas'] = $this->KasModel->get_Kas();
        $data['Jumlah_Saldo'] = $this->get_lastSaldo();
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer'); 
    }
    
    function get_lastSaldo(){
        $get_saldo = $this->KasModel->get_lastSaldo()->result();
        if($get_saldo > 0) {
            foreach ($get_saldo as $key) {
                $last_saldo = $key->saldo;
            }
            return $last_saldo;
        } 
    }
}
