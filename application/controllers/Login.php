<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('login_v');
    }

    function do_login() {
        $return = array();

        $nip = $this->input->post("nip");
        $passwd = $this->input->post("passwd");
        $this->db->select("a.*, b.nama_jabatan, c.kode_satker, c.nama_satker, d.kode_ppk, d.nama_ppk");
        $this->db->join("m_jabatan b", "a.id_jabatan=b.id_jabatan", "left");
        $this->db->join("m_satker c", "a.id_satker=c.id_satker", "left");
        $this->db->join("m_ppk d", "a.id_ppk=d.id_ppk", "left");
        $json = $this->db->get_where("m_user a", array("a.nip" => $nip, "a.passwd" => md5($passwd)));

        if ($json->num_rows() > 0) {
            $fields = $json->row();
            if ($fields->status == "t") {
                $newdata = array(
                    "id_user" => $fields->id_user,
                    "nip" => $fields->nip,
                    "nama_lengkap" => $fields->nama_lengkap,
                    "id_jabatan" => $fields->id_jabatan,
                    "nama_jabatan" => $fields->nama_jabatan,
                    "email" => $fields->email,
                    "no_hp" => $fields->no_hp,
                    "foto" => $fields->foto,
                    "nama_satker" => $fields->kode_satker . ' - ' . $fields->nama_satker,
                    "nama_ppk" => $fields->kode_ppk . ' - ' . $fields->nama_ppk,
                    "logged" => TRUE
                );
                $this->session->set_userdata($newdata);
                $return["page"] = 'welcome';
                $return["success"] = TRUE;
                $return["msgServer"] = "Login Berhasil.";
            } else {
                $return["success"] = FALSE;
                $return["msgServer"] = "Maaf, Akun yang anda gunakan di nonaktifkan..!!";
            }
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Username atau Password salah..!!";
        }

        echo json_encode($return);
    }

    function do_Logout() {
        $this->Layout_m->Check_Logout();
    }

}
