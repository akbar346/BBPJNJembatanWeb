<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("kode_kategori", "asc");
        $query = $this->db->get('m_kategori');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_kategori] = $row->kode_kategori . ' = ' . $row->nama_kategori;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Kategori..."');
    }

    function getKategori($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->from("m_kategori a");
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

    function getCountKategori($criteria = "", $keyword = "") {
        $this->db->from("m_kategori a");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($kode_kategori = "", $nama_kategori = "") {
        $data = array(
            "kode_kategori" => $kode_kategori,
            "nama_kategori" => $nama_kategori
        );
        $this->db->insert("m_kategori", $data);
    }

    function update($id_kategori = "", $kode_kategori = "", $nama_kategori = "") {
        $data = array(
            "kode_kategori" => $kode_kategori,
            "nama_kategori" => $nama_kategori
        );
        $this->db->where('id_kategori', $id_kategori);
        $this->db->update('m_kategori', $data);
    }

    function delete($id_kategori = "") {
        if ($id_kategori) {
            $this->db->delete("m_kategori", array("id_kategori" => $id_kategori));
        }
    }

    function Chek_Data($id_kategori = "", $kode_kategori = "") {
        if ($id_kategori) {
            $this->db->where("id_kategori", $id_kategori);
        } else {
            $this->db->where("kode_kategori", $kode_kategori);
        }
        $query = $this->db->get("m_kategori");
        return $query->num_rows();
    }

    function List_Data($id_kategori = "") {
        $query = $this->db->get_where('m_kategori', array('id_kategori' => $id_kategori));
        return $query->row();
    }

}
