<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perbaikan_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_kerusakan", "asc");
        $query = $this->db->get('m_perbaikan');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_perbaikan] = $row->kode_kerusakan . ' - ' . $row->nama_kerusakan;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Perbaikan..."');
    }

    function getPerbaikan($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->from("m_perbaikan a");
        $this->db->join("m_kategori b", "a.id_kategori=b.id_kategori", "left");
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

    function getCountPerbaikan($criteria = "", $keyword = "") {
        $this->db->from("m_perbaikan a");
        $this->db->join("m_kategori b", "a.id_kategori=b.id_kategori", "left");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($kode_kerusakan = "", $nama_kerusakan = "", $id_kategori = "", $ket_perbaikan = "") {
        $data = array(
            "kode_kerusakan" => $kode_kerusakan,
            "nama_kerusakan" => $nama_kerusakan,
            "id_kategori" => $id_kategori,
            "ket_perbaikan" => $ket_perbaikan
        );
        $this->db->insert("m_perbaikan", $data);
    }

    function update($id_perbaikan = "", $kode_kerusakan = "", $nama_kerusakan = "", $id_kategori = "", $ket_perbaikan = "") {
        $data = array(
            "kode_kerusakan" => $kode_kerusakan,
            "nama_kerusakan" => $nama_kerusakan,
            "id_kategori" => $id_kategori,
            "ket_perbaikan" => $ket_perbaikan
        );
        $this->db->where('id_perbaikan', $id_perbaikan);
        $this->db->update('m_perbaikan', $data);
    }

    function delete($id_perbaikan = "") {
        if ($id_perbaikan) {
            $this->db->delete("m_perbaikan", array("id_perbaikan" => $id_perbaikan));
        }
    }

    function Chek_Data($id_perbaikan = "", $id_kategori = "", $kode_kerusakan = "", $nama_kerusakan = "") {
        if ($id_perbaikan) {
            $this->db->where("id_perbaikan", $id_perbaikan);
        } else {
            $this->db->where("id_kategori", $id_kategori);
            $this->db->where("kode_kerusakan", $kode_kerusakan);
            $this->db->where("nama_kerusakan", $nama_kerusakan);
        }
        $query = $this->db->get("m_perbaikan");
        return $query->num_rows();
    }

    function List_Data($id_perbaikan = "") {
        $query = $this->db->get_where('m_perbaikan', array('id_perbaikan' => $id_perbaikan));
        return $query->row();
    }

}
