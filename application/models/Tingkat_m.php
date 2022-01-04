<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tingkat_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_tingkat", "asc");
        $query = $this->db->get('m_tingkat');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_tingkat] = $row->nama_tingkat;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Tingkat..."');
    }

    function getTingkat($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->from("m_tingkat a");
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

    function getCountTingkat($criteria = "", $keyword = "") {
        $this->db->from("m_tingkat a");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($nama_tingkat = "") {
        $data = array(
            "nama_tingkat" => $nama_tingkat
        );
        $this->db->insert("m_tingkat", $data);
    }

    function update($id_tingkat = "", $nama_tingkat = "") {
        $data = array(
            "nama_tingkat" => $nama_tingkat
        );
        $this->db->where('id_tingkat', $id_tingkat);
        $this->db->update('m_tingkat', $data);
    }

    function delete($id_tingkat = "") {
        if ($id_tingkat) {
            $this->db->delete("m_tingkat", array("id_tingkat" => $id_tingkat));
        }
    }

    function Chek_Data($id_tingkat = "", $nama_tingkat = "") {
        if ($id_tingkat) {
            $this->db->where("id_tingkat", $id_tingkat);
        } else {
            $this->db->where("nama_tingkat", $nama_tingkat);
        }
        $query = $this->db->get("m_tingkat");
        return $query->num_rows();
    }

    function List_Data($id_tingkat = "") {
        $query = $this->db->get_where('m_tingkat', array('id_tingkat' => $id_tingkat));
        return $query->row();
    }

}
