<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_m extends CI_Model {

    function do_login($nip = "", $passwd = "") {
        $sql = $this->db->get_where("m_user", array("nip" => $nip, "passwd" => md5($passwd)));
        return $sql;
    }

    function do_cek_passwd($id_user = "", $passwd_lama = "") {
        $sql = $this->db->get_where("m_user", array("id_user" => $id_user, "passwd" => md5($passwd_lama)));
        return $sql;
    }

    function do_ubah_passwd($id_user = "", $passwd_baru = "") {
        $this->db->where("id_user", $id_user);
        $this->db->update("m_user", array("passwd" => md5($passwd_baru)));
    }

    function do_cek_akun_reset($nip = "", $email = "") {
        $this->db->where("nip", $nip);
        $this->db->where("email", $email);
        $sql = $this->db->get("m_user");
        return $sql;
    }

    function do_update_passwd($id_user = "", $passwd = "") {
        $this->db->where("id_user", $id_user);
        $this->db->update("m_user", array("passwd" => md5($passwd)));
    }

    function send_email_reset($id_user = "", $passwd = "") {
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.googlemail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "sipekerja.21@gmail.com";
        $config['smtp_pass'] = "SiPekerjaYes";
        $config['mailtype'] = "html";
        $config['charset'] = "iso-8859-1";
        $config['wordwrap'] = TRUE;

        $list_data = $this->db->get_where("m_user", array("id_user" => $id_user))->row();

        $text = '<p>Selamat Datang <b>' . $list_data->nama_lengkap . '</b>.</p>
                <p style="text-align: justify">Anda telah melakukan Reset Kata Sandi. Berikut ini detail Reset Kata Sandi Anda :</p>
                <table celpadding="2">
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>' . $list_data->nip . '</td>
                    </tr>
                    <tr>
                        <td>Nama Langkap</td>
                        <td>:</td>
                        <td>' . $list_data->nama_lengkap . '</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>' . $list_data->email . '</td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td>' . $passwd . '</td>
                    </tr>
                </table>
                <p>Salam Sejahtera<br>Admin Aplikasi</p>';

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('sipekerja.21@gmail.com', 'SIPEKERJA');

        $this->email->to($list_data->email);
        $this->email->subject('Reset Kata Sandi Aplikasi SIPEKERJA');

        $this->email->message($text);
        $this->email->send();
    }

}
