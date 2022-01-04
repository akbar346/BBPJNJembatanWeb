<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_kelamin_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("nama_jenis_kelamin", "asc");
        $query = $this->db->get('m_jenis_kelamin');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->id_jenis_kelamin] = $row->nama_jenis_kelamin;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Jenis Kelamin..."');
    }

    function getJenis_kelamin($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->from("m_jenis_kelamin a");
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

    function getCountJenis_kelamin($criteria = "", $keyword = "") {
        $this->db->from("m_jenis_kelamin a");
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }

    function insert($nama_jenis_kelamin = "") {
        $data = array(
            "nama_jenis_kelamin" => $nama_jenis_kelamin
        );
        $this->db->insert("m_jenis_kelamin", $data);
    }

    function update($id_jenis_kelamin = "", $nama_jenis_kelamin = "") {
        $data = array(
            "nama_jenis_kelamin" => $nama_jenis_kelamin
        );
        $this->db->where('id_jenis_kelamin', $id_jenis_kelamin);
        $this->db->update('m_jenis_kelamin', $data);
    }

    function delete($id_jenis_kelamin = "") {
        if ($id_jenis_kelamin) {
            $this->db->delete("m_jenis_kelamin", array("id_jenis_kelamin" => $id_jenis_kelamin));
        }
    }

    function Chek_Data($id_jenis_kelamin = "", $nama_jenis_kelamin = "") {
        if ($id_jenis_kelamin) {
            $this->db->where("id_jenis_kelamin", $id_jenis_kelamin);
        } else {
            $this->db->where("nama_jenis_kelamin", $nama_jenis_kelamin);
        }
        $query = $this->db->get("m_jenis_kelamin");
        return $query->num_rows();
    }

    function List_Data($id_jenis_kelamin = "") {
        $query = $this->db->get_where('m_jenis_kelamin', array('id_jenis_kelamin' => $id_jenis_kelamin));
        return $query->row();
    }

}
