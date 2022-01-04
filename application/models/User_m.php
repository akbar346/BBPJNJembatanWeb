<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_lengkap", "asc");
        $query = $this->db->get('m_user');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_user] = $row->nama_lengkap;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih User..."');
    }

    function getUser($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->select("a.*, b.nama_jabatan");
        $this->db->from("m_user a");
        $this->db->join("m_jabatan b", "a.id_jabatan=b.id_jabatan", "left");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        if ($sort && $dir) {
            $this->db->order_by($sort, $dir);
        }
        if ($start != "" && $limit != "") {
            $this->db->limit($limit, $start);
        }
        return $this->db->get();
    }

    function getCountUser($criteria = "", $keyword = "") {
        $this->db->select("a.*, b.nama_jabatan");
        $this->db->from("m_user a");
        $this->db->join("m_jabatan b", "a.id_jabatan=b.id_jabatan", "left");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($nama_lengkap = "", $email = "", $flag_password_user = "", $passwd = "", $nip = "", $no_hp = "", $status = "", $id_jabatan = "", $foto = "", $tmp_lahir = "", $tgl_lahir = "", $id_jenis_kelamin = "", $alamat = "", $id_satker = "", $id_ppk = "") {
        $data = array(
            "nama_lengkap" => $nama_lengkap,
            "email" => $email,
            "nip" => $nip,
            "no_hp" => $no_hp,
            "id_jabatan" => $id_jabatan,
            "tmp_lahir" => $tmp_lahir,
            "tgl_lahir" => $tgl_lahir,
            "id_jenis_kelamin" => $id_jenis_kelamin,
            "alamat" => $alamat,
            "id_satker" => $id_satker,
            "id_ppk" => $id_ppk
        );
        if ($flag_password_user == 'true') {
            $data['passwd'] = md5($passwd);
        } else {
            $data['passwd'] = md5('123456');
        }
        if ($status == 'on') {
            $data['status'] = TRUE;
        }
        if ($foto != "") {
            $data['foto'] = $foto;
        }
        $this->db->insert("m_user", $data);
    }

    function update($id_user = "", $nama_lengkap = "", $email = "", $flag_password_user = "", $passwd = "", $nip = "", $no_hp = "", $status = "", $id_jabatan = "", $foto = "", $tmp_lahir = "", $tgl_lahir = "", $id_jenis_kelamin = "", $alamat = "", $id_satker = "", $id_ppk = "") {
        $data = array(
            "nama_lengkap" => $nama_lengkap,
            "email" => $email,
            "nip" => $nip,
            "no_hp" => $no_hp,
            "id_jabatan" => $id_jabatan,
            "tmp_lahir" => $tmp_lahir,
            "tgl_lahir" => $tgl_lahir,
            "id_jenis_kelamin" => $id_jenis_kelamin,
            "alamat" => $alamat,
            "id_satker" => $id_satker,
            "id_ppk" => $id_ppk
        );
        if ($flag_password_user == 'true') {
            $data['passwd'] = md5($passwd);
        }
        if ($status == 'on') {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        if ($foto != "") {
            $data['foto'] = $foto;
        } else {
            $data['foto'] = "no_image.png";
        }
        
        $this->db->where('id_user', $id_user);
        $this->db->update('m_user', $data);
    }

    function delete($id_user = "") {
        if ($id_user) {
            $this->db->delete("m_user", array("id_user" => $id_user));
        }
    }

    function Chek_Data($id_user = "", $nip = "") {
        if ($id_user) {
            $this->db->where("id_user", $id_user);
        } else {
            $this->db->where("nip", $nip);
        }
        $query = $this->db->get("m_user");
        return $query->num_rows();
    }

    function List_Data($id_user = "") {
        $query = $this->db->get_where('m_user', array('id_user' => $id_user));
        return $query->row();
    }

}
