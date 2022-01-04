<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->Layout_m->Check_Login();
    }

    public function index() {
        $nama_menu = "Profil";

        $data['setMeta'] = $this->Layout_m->setMeta($nama_menu);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('profil_v', $data);
    }

    function do_Simpan_Ubah_Password() {
        $return = array();
        $error = "";

        $password_sekarang = ($this->input->post("password_sekarang") != "") ? $this->input->post("password_sekarang") : "";
        $password_baru = ($this->input->post("password_baru") != "") ? $this->input->post("password_baru") : "";
        $re_password_baru = ($this->input->post("re_password_baru") != "") ? $this->input->post("re_password_baru") : "";

        if ($password_baru == $re_password_baru) {
            $id_user = $this->session->userdata("id_user");
            $cek_passwd = $this->db->get_where("m_user", array("id_user" => $id_user, "passwd" => md5($password_sekarang)));
            if ($cek_passwd->num_rows() > 0) {
                $this->db->where("id_user", $id_user);
                $this->db->update("m_user", array("passwd" => md5($password_baru)));
            } else {
                $error = "Maaf, Password Sekarang yang anda masukkan salah. !!!";
            }
        } else {
            $error = "Maaf, Password Baru dan Ulang Password Baru tidak sama. !!!";
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Ubah Password Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Ubah Password Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Simpan_Ubah_Foto() {
        $return = array();
        $error = "";

        $id_user = $this->session->userdata("id_user");
        $foto = '';

        $config['upload_path'] = './assets/upload';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->load->library('upload', $config);
        foreach ($_FILES as $key => $value) {
            if (!empty($value['name'])) {
                if (!$this->upload->do_upload($key)) {
                    $error = $this->upload->display_errors();
                    $return["msgServer"] = $error;
                    $return["success"] = FALSE;
                } else {
                    if ($key == "foto") {
                        $data_upload = $this->upload->data();
                        $foto = $id_user . "_Profil" . $data_upload['file_ext'];

                        rename($data_upload['full_path'], $data_upload['file_path'] . $foto);
                        copy($data_upload['file_path'] . $foto, $data_upload['file_path'] . "foto/" . $foto);
                        unlink($data_upload['file_path'] . $foto);
                    }
                }
            }
        }

        if ($foto != "") {
            $this->db->where("id_user", $id_user);
            $this->db->update("m_user", array("foto" => $foto));
            $newdata = array(
                "foto" => $foto,
            );
            $this->session->set_userdata($newdata);
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Ubah Foto Profil Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Ubah Foto Profil Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Simpan_Ubah_Info() {
        $return = array();
        $error = "";

        $nama_lengkap = ($this->input->post("nama_lengkap") != "") ? $this->input->post("nama_lengkap") : "";
        $no_hp = ($this->input->post("no_hp") != "") ? $this->input->post("no_hp") : "";
        $email = ($this->input->post("email") != "") ? $this->input->post("email") : "";

        $id_user = $this->session->userdata("id_user");
        $this->db->where("id_user", $id_user);
        $this->db->update("m_user", array(
            "nama_lengkap" => $nama_lengkap,
            "no_hp" => $no_hp,
            "email" => $email,
        ));
        $newdata = array(
            "nama_lengkap" => $nama_lengkap,
            "no_hp" => $no_hp,
            "email" => $email,
        );
        $this->session->set_userdata($newdata);

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Ubah Info Akun Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Ubah Info Akun Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

}
