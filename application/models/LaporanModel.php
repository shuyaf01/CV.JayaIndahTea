<?php

class LaporanModel extends CI_Model {

    function getKas(){
        return $this->db->get("tb_kas");
    }
    
}