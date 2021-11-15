<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengeluaranController extends CI_Controller {
    /**
     * PengeluaranController constructor.
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
        $this->load->model("PengeluaranModel","",TRUE);
        $this->load->model("KategoriModel","",TRUE);
    }

    
	function index()
    {
        $data['dataPK'] = $this->PengeluaranModel->get_Pengeluaran();
        
        $this->load->view("pengeluaran/main_page", $data);
        $this->load->view('templates/footer'); 
    }

    protected function setValidationRules()
	{
        if($this->input->post("kategori_pengeluaran") == "Pembelian Bahan Baku")
        {  
            $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|max_length[50]');
            $this->form_validation->set_rules('asal_kirim', 'asal_kirim', 'required|max_length[50]');
            $this->form_validation->set_rules('berat', 'Berat Barang', 'numeric|required|max_length[11]');
            $this->form_validation->set_rules('harga_per_kg', 'Nominal', 'numeric|required|max_length[20]');

        } else {
            
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|max_length[150]');
            $this->form_validation->set_rules('nominal', 'Nominal', 'numeric|required|max_length[20]');
        }
        $this->form_validation->set_message('numeric','Input %s! harus berupa angka');
        $this->form_validation->set_message('required','Kosong. Inputkan %s!');
        $this->form_validation->set_message('max_length','Nilai %s melebihi batas.');
	}

   
    function formCreate()
    {
        $data['new_id'] = $this->setIdPengeluaran();
        $data['jenis'] = $this->KategoriModel->get_KategoriPengeluaran()->result();
        $this->load->view('pengeluaran/create',$data);
        $this->load->view('templates/footer'); 
    }

    public function processCreate()
	{
		$this->setValidationRules();	
		if ($this->form_validation->run()) 
        {
			//Form validation success. Insert Record into database
            if($this->input->post("kategori_pengeluaran") == "Pembelian Bahan Baku"){
                $harga = $this->input->post("harga_per_kg");
                $berat = $this->input->post("berat");
                $nominal_pengeluaran = $harga * $berat;
    
                $dataPK = array(
                    "id_pengeluaran" => $this->input->post("id_pengeluaran"),
                    "kategori_pengeluaran" => $this->input->post("kategori_pengeluaran"),
                    "nama_barang" => $this->input->post("nama_barang"),
                    "asal_kirim" => $this->input->post("asal_kirim"),
                    "berat" => $this->input->post("berat"),
                    "harga_per_kg" => $this->input->post("harga_per_kg"),
                    "nominal_pengeluaran" => $nominal_pengeluaran,
                    "nama_pegawai" => $this->session->user->nama_pegawai
                );
   
            } else {
                $dataPK = array(
                    "id_pengeluaran" => $this->input->post("id_pengeluaran"),               
                    "kategori_pengeluaran" => $this->input->post("kategori_pengeluaran"),
                    "keterangan" => $this->input->post("keterangan"),
                    "nominal_pengeluaran" => $this->input->post("nominal"),
                    "nama_pegawai" => $this->session->user->nama_pegawai
                ); 
            }
            
            
			$dataPK['created_at'] = date('Y-m-d H:i:s');
            if ($this->PengeluaranModel->insert_Pengeluaran($dataPK)){  
                //$this->addtoKas();
                $this->session->set_flashdata('success', 'Data Pengeluaran berhasil ditambahkan');
                redirect(site_url("expenditure"));
            }else{
                redirect(site_url("expenditure/formcreate"));
            }
		}else{
            $data['new_id'] = $this->setIdPengeluaran();
            $data['jenis'] = $this->KategoriModel->get_KategoriPengeluaran()->result();
            $this->load->view('pengeluaran/create',$data);
            $this->load->view('templates/footer');
        }
    }

    public function formUpdate($id){
        $record = $this->PengeluaranModel->get_PengeluaranById($id)->row();
        $data['jenis'] = $this->KategoriModel->get_KategoriPengeluaran()->result();
		$data['record'] = $record; 

        if($record->kategori_pengeluaran == "Pembelian Bahan Baku"){
            $this->load->view('pengeluaran/update1',$data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('pengeluaran/update2',$data);
            $this->load->view('templates/footer');
        }   
    }

    public function processUpdate($id)
	{
		$this->setValidationRules();	
		if ($this->form_validation->run()) 
        {
			//Form validation success. Insert Record into database
            if($this->input->post("kategori_pengeluaran") == "Pembelian Bahan Baku"){
                $harga = $this->input->post("harga_per_kg");
                $berat = $this->input->post("berat");
                $nominal_pengeluaran = $harga * $berat;
    
                $dataPK = array(
                    "id_pengeluaran" => $this->input->post("id_pengeluaran"),
                    "kategori_pengeluaran" => $this->input->post("kategori_pengeluaran"),
                    "nama_barang" => $this->input->post("nama_barang"),
                    "asal_kirim" => $this->input->post("asal_kirim"),
                    "berat" => $this->input->post("berat"),
                    "harga_per_kg" => $this->input->post("harga_per_kg"),
                    "nominal_pengeluaran" => $nominal_pengeluaran,
                    "nama_pegawai" => $this->session->user->nama_pegawai
                );
   
            } else {
                $dataPK = array(
                    "id_pengeluaran" => $this->input->post("id_pengeluaran"),               
                    "kategori_pengeluaran" => $this->input->post("kategori_pengeluaran"),
                    "keterangan" => $this->input->post("keterangan"),
                    "nominal_pengeluaran" => $this->input->post("nominal"),
                    "nama_pegawai" => $this->session->user->nama_pegawai
                ); 
            }
            
			$dataPK['created_at'] = date('Y-m-d H:i:s');
            if ($this->PengeluaranModel->update_Pengeluaran($id, $dataPK)){  
                //$this->KasModel->delete_Kas($id);
                //$this->addtoKas();
                $this->session->set_flashdata('success', 'Data Pengeluaran berhasil diedit');
                redirect(site_url("expenditure"));
            }else{
                redirect(site_url("expenditure/formupdate"));
            }
		}else{
            $record = $this->PengeluaranModel->get_PengeluaranById($id)->row();
            $data['jenis'] = $this->KategoriModel->get_KategoriPengeluaran()->result();
            $data['record'] = $record; 

            if($record->kategori_pengeluaran == "Pembelian Bahan Baku"){
                $this->load->view('pengeluaran/update1',$data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('pengeluaran/update2',$data);
                $this->load->view('templates/footer');
            }   
        }
    }

    public function readbyid($id){
        $record = $this->PengeluaranModel->get_PengeluaranById($id)->row();  
		$data['record'] = $record;
        if($record->kategori_pengeluaran == 'Pembelian Bahan Baku'){
            $this->load->view('pengeluaran/read1',$data);
            $this->load->view('templates/footer'); 
        }else{
            $this->load->view('pengeluaran/read2',$data);
            $this->load->view('templates/footer'); 
        }
        
    }

    public function setIdPengeluaran(){
        
        $new_id = $this->PengeluaranModel->get_idmax()->result();
        if($new_id > 0) {
            foreach ($new_id as $key) {
                $auto_id = $key->id_pengeluaran;
            }
            return $id_pengeluaran = $this->PengeluaranModel->get_newid($auto_id,'PK-');
        } 
    }

    public function processDelete($id){
        $this->PengeluaranModel->delete_Pengeluaran($id);
        $this->session->set_flashdata("info", "Data Pengeluaran Berhasil Dihapus!");
        redirect(site_url("expenditure"));
    }
}
