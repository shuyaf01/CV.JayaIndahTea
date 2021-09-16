<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PemasukanController extends CI_Controller {
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
        //$this->load->model("ProductModel","",TRUE);
        $this->load->model("KasModel","",TRUE);
    }

    /**
     * Show 
     */
	function index()
    {
        $data['dataPM'] = $this->PemasukanModel->get_Pemasukan();
        $this->load->view("pemasukan/main_page", $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Set common validation rules for products form.
	 */
	protected function setValidationRules()
	{
		$this->form_validation->set_rules('id_pemasukan', 'ID Pemasukan', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required');
		$this->form_validation->set_rules('tujuan_kirim', 'tujuan_kirim', 'trim|required');
		$this->form_validation->set_rules('berat', 'Berat Barang', 'trim|required|max_length[20]');
		$this->form_validation->set_rules('harga_per_kg', 'Nominal', 'trim|required|max_length[20]');

        $this->form_validation->set_message('required','Kosong. Inputkan %s!');
        $this->form_validation->set_message('max_length','Nilai %s melebihi batas.');
	}

    function formCreate()
    {
        $data['new_id'] = $this->setIdPemasukan();
        $data['nama_produk'] = $this->PemasukanModel->getNameProduct();
        $this->load->view('pemasukan/create',$data);
        $this->load->view('templates/footer'); 
    }
 
	public function processCreate()
	{
		$this->setValidationRules();	
		if ($this->form_validation->run()) 
        {
			//Form validation success. Insert Record into database
            $harga = $this->input->post("harga_per_kg");
            $berat = $this->input->post("berat");
            $nominal_pemasukan = $harga * $berat;

            $dataPM = array(
                "id_pemasukan" => $this->input->post("id_pemasukan"),
                "nama_produk" => $this->input->post("nama_produk"),
                "tujuan_kirim" => $this->input->post("tujuan_kirim"),
                "jenis_pemasukan" => 'Penjualan Produk',
                "berat" => $this->input->post("berat"),
                "harga_per_kg" => $this->input->post("harga_per_kg"),
                "nominal_pemasukan" => $nominal_pemasukan,
                "nama_pegawai" => $this->session->user->nama_pegawai
            );
            
			$data['created_at'] = date('Y-m-d H:i:s');
            if($this->PemasukanModel->insert_Pemasukan($dataPM)){  
                $this->addtoKas();
                $this->session->set_flashdata('success', 'Data Pemasukan berhasil ditambahkan');
                redirect(site_url("PemasukanController"));
            }else{
                redirect(site_url("PemasukanController/formcreate"));
            }
		}else{
            $data['new_id'] = $this->setIdPemasukan();
            $data['nama_produk'] = $this->PemasukanModel->getNameProduct();
            $this->load->view('pemasukan/create',$data);
            $this->load->view('templates/footer'); 
        }
    }

    public function formupdate($id){
        $record = $this->PemasukanModel->get_PemasukanById($id)->row();
		$data['record'] = $record;
        $data['nama_produk'] = $this->PemasukanModel->getNameProduct();
        $this->load->view('pemasukan/update',$data);
        $this->load->view('templates/footer'); 
    }

    public function processUpdate($id)
	{   
		$this->setValidationRules();	
		if ($this->form_validation->run()) {
			//Form validation success. Insert Record into database
            $harga = $this->input->post("harga_per_kg");
            $berat = $this->input->post("berat");
            $nominal_pemasukan = $harga * $berat;

            $dataPM = array(
                "id_pemasukan" => $this->input->post("id_pemasukan"),
                "nama_produk" => $this->input->post("nama_produk"),
                "tujuan_kirim" => $this->input->post("tujuan_kirim"),
                "jenis_pemasukan" => 'Penjualan Produk',
                "berat" => $this->input->post("berat"),
                "harga_per_kg" => $this->input->post("harga_per_kg"),
                "nominal_pemasukan" => $nominal_pemasukan,
                "nama_pegawai" => $this->session->user->nama_pegawai
            );

			$dataPM['updated_at'] = date('Y-m-d H:i:s');
                
            if($this->PemasukanModel->update_Pemasukan($id,$dataPM))
            {  
                $this->KasModel->delete_Kas($id);
                $this->addtoKas();
                $this->session->set_flashdata('info', 'Data Pemasukan berhasil diedit');
                redirect(site_url("PemasukanController"));
            }else{
                redirect(site_url("PemasukanController/formupdate"));
            }
		}else{
            $record= $this->PemasukanModel->get_PemasukanById($id)->row();
            $data['record'] = $record;
            $data['new_id'] = $this->setIdPemasukan();
            $this->load->view('pemasukan/create',$data);
            $this->load->view('templates/footer');  
        }
    }

    public function readbyid($id){
        $record = $this->PemasukanModel->get_PemasukanById($id)->row();
		$data['record'] = $record;
        $this->load->view('pemasukan/read',$data);
        $this->load->view('templates/footer'); 
    }
    
    public function setIdPemasukan(){
        
        $new_id = $this->PemasukanModel->get_idmax()->result();
        if($new_id > 0) {
            foreach ($new_id as $key) {
                $auto_id = $key->id_pemasukan;
            }
            return $id_pemasukan = $this->PemasukanModel->get_newid($auto_id,'PM-');
        } 
    }
  
    function get_download_byid($id)
    {
        $record = $this->PemasukanModel->get_PemasukanById($id)->row();
		$data['record'] = $record;
        

        $this->load->library('pdf');
        
        $html = $this->load->view('pemasukan/generatepdf_byid', $data, true);
        $this->pdf->createPDF($html, 'Bukti Pembayaran', false);
    }
 
    public function addtoKas()
	{  
        $harga = $this->input->post("harga_per_kg");
        $berat = $this->input->post("berat");
        $nominal_pemasukan = $harga * $berat;

        //menghitung saldo
        $last_saldo = $this->KasModel->get_lastSaldo()->result();
        if($last_saldo > 0) {
            foreach ($last_saldo as $key) {
                $new_saldo = $key->saldo + $nominal_pemasukan;
            }
        }   

		$dataKas = array(
            "id_pemasukan" => $this->input->post("id_pemasukan"),
            "jenis_pemasukan" => 'Penjualan Produk',
            "nominal_pemasukan" => $nominal_pemasukan,
            "saldo" => $new_saldo
        );
        $this->KasModel->insert_Kas($dataKas);
    }

    public function processDelete($id){
        $this->PemasukanModel->delete_Pemasukan($id);
        $this->session->set_flashdata("info", "Data Pemasukan Berhasil Dihapus!");
        redirect(site_url("PemasukanController"));
    }
}
