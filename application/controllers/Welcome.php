<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->Layout_m->Check_Login();
    }

    public function index() {
        $nama_menu = "Dashboard";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($nama_menu);
        $data['id_menu_'] = $this->Layout_m->checkMenu($nama_menu);

        $data['setMeta'] = $this->Layout_m->setMeta($nama_menu);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        date_default_timezone_set('Asia/Jakarta');

        $data['jmlUser'] = $this->db->get("m_user")->num_rows();
        $data['jmlSatker'] = $this->db->get("m_satker")->num_rows();
        $data['jmlPpk'] = $this->db->get("m_ppk")->num_rows();
        
        $data['kategori'] = $this->db->get("m_kategori")->num_rows();
        $data['perbaikan'] = $this->db->get("m_perbaikan")->num_rows();
        $data['tingkat'] = $this->db->get("m_tingkat")->num_rows();

        $this->parser->parse('home_v', $data);
    }

}
