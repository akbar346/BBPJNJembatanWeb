<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Satker_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_satker", "asc");
        $query = $this->db->get('m_satker');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_satker] = '(' . $row->kode_satker . ') ' . $row->nama_satker;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Satker..."');
    }

    function getSatker($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->from("m_satker a");
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

    function getCountSatker($criteria = "", $keyword = "") {
        $this->db->from("m_satker a");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($kode_satker = "", $nama_satker = "", $alamat = "", $no_telp = "") {
        $data = array(
            "kode_satker" => $kode_satker,
            "nama_satker" => $nama_satker,
            "alamat" => $alamat,
            "no_telp" => $no_telp
        );
        $this->db->insert("m_satker", $data);
    }

    function update($id_satker = "", $kode_satker = "", $nama_satker = "", $alamat = "", $no_telp = "") {
        $data = array(
            "kode_satker" => $kode_satker,
            "nama_satker" => $nama_satker,
            "alamat" => $alamat,
            "no_telp" => $no_telp
        );
        $this->db->where('id_satker', $id_satker);
        $this->db->update('m_satker', $data);
    }

    function delete($id_satker = "") {
        if ($id_satker) {
            $this->db->delete("m_satker", array("id_satker" => $id_satker));
        }
    }

    function Chek_Data($id_satker = "", $kode_satker = "") {
        if ($id_satker) {
            $this->db->where("id_satker", $id_satker);
        } else {
            $this->db->where("kode_satker", $kode_satker);
        }
        $query = $this->db->get("m_satker");
        return $query->num_rows();
    }

    function List_Data($id_satker = "") {
        $query = $this->db->get_where('m_satker', array('id_satker' => $id_satker));
        return $query->row();
    }

}
