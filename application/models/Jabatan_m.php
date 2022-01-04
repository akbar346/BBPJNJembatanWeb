<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jabatan_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_jabatan", "asc");
        $query = $this->db->get('m_jabatan');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_jabatan] = $row->nama_jabatan;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Jabatan..."');
    }

    function getJabatan($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->from("m_jabatan a");
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

    function getCountJabatan($criteria = "", $keyword = "") {
        $this->db->from("m_jabatan a");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($nama_jabatan = "") {
        $data = array(
            "nama_jabatan" => $nama_jabatan
        );
        $this->db->insert("m_jabatan", $data);
    }

    function update($id_jabatan = "", $nama_jabatan = "") {
        $data = array(
            "nama_jabatan" => $nama_jabatan
        );
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->update('m_jabatan', $data);
    }

    function delete($id_jabatan = "") {
        if ($id_jabatan) {
            $this->db->delete("m_jabatan", array("id_jabatan" => $id_jabatan));
        }
    }

    function Chek_Data($id_jabatan = "", $nama_jabatan = "") {
        if ($id_jabatan) {
            $this->db->where("id_jabatan", $id_jabatan);
        } else {
            $this->db->where("nama_jabatan", $nama_jabatan);
        }
        $query = $this->db->get("m_jabatan");
        return $query->num_rows();
    }

    function List_Data($id_jabatan = "") {
        $query = $this->db->get_where('m_jabatan', array('id_jabatan' => $id_jabatan));
        return $query->row();
    }

}
