<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ppk_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_ppk", "asc");
        $query = $this->db->get('m_ppk');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_ppk] = $row->nama_ppk;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih PPK..."');
    }

    function getPpk($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->select("a.*, b.kode_satker, b.nama_satker");
        $this->db->from("m_ppk a");
        $this->db->join("m_satker b", "a.id_satker=b.id_satker", "left");
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

    function getCountPpk($criteria = "", $keyword = "") {
        $this->db->select("a.*, b.kode_satker, b.nama_satker");
        $this->db->from("m_ppk a");
        $this->db->join("m_satker b", "a.id_satker=b.id_satker", "left");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($kode_ppk = "", $nama_ppk = "", $alamat = "", $no_telp = "", $id_satker = "") {
        $data = array(
            "kode_ppk" => $kode_ppk,
            "nama_ppk" => $nama_ppk,
            "alamat" => $alamat,
            "id_satker" => $id_satker,
            "no_telp" => $no_telp
        );
        $this->db->insert("m_ppk", $data);
    }

    function update($id_ppk = "", $kode_ppk = "", $nama_ppk = "", $alamat = "", $no_telp = "", $id_satker = "") {
        $data = array(
            "kode_ppk" => $kode_ppk,
            "nama_ppk" => $nama_ppk,
            "alamat" => $alamat,
            "id_satker" => $id_satker,
            "no_telp" => $no_telp
        );
        $this->db->where('id_ppk', $id_ppk);
        $this->db->update('m_ppk', $data);
    }

    function delete($id_ppk = "") {
        if ($id_ppk) {
            $this->db->delete("m_ppk", array("id_ppk" => $id_ppk));
        }
    }

    function Chek_Data($id_ppk = "", $id_satker = "", $kode_ppk = "") {
        if ($id_ppk) {
            $this->db->where("id_ppk", $id_ppk);
        } else {
            $this->db->where("id_satker", $id_satker);
            $this->db->where("kode_ppk", $kode_ppk);
        }
        $query = $this->db->get("m_ppk");
        return $query->num_rows();
    }

    function List_Data($id_ppk = "") {
        $query = $this->db->get_where('m_ppk', array('id_ppk' => $id_ppk));
        return $query->row();
    }

}
