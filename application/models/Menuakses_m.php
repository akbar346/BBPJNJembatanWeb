<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menuakses_m extends CI_Model {

    function getDataComboBox($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();

        $this->db->order_by("a.id_menu", "asc");
        $this->db->from("c_menu a");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                $items[$row->id_menu] = $row->nama_menu;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" multiple="multiple" Class="multi-select" data-placeholder="Pilih Menu..."');
    }

    function getMenuakses($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {

        $this->db->from("t_menu_user a");
        $this->db->join("c_menu b", "b.id_menu=a.id_menu", "left");
        $this->db->join("m_jabatan c", "c.id_jabatan=a.id_jabatan", "left");

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

    function getCountMenuakses($criteria = "", $keyword = "") {

        $this->db->from("t_menu_user a");
        $this->db->join("c_menu b", "b.id_menu=a.id_menu", "left");
        $this->db->join("m_jabatan c", "c.id_jabatan=a.id_jabatan", "left");

        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }

        return $this->db->count_all_results();
    }

    function insert($id_menu = "", $id_jabatan = "") {
        $data = array(
            "id_menu" => $id_menu,
            "id_jabatan" => $id_jabatan
        );

        $this->db->insert("t_menu_user", $data);
    }

    function update($id_menu_user, $id_menu = "", $id_jabatan = "") {
        $data = array(
            "id_menu" => $id_menu,
            "id_jabatan" => $id_jabatan
        );

        $this->db->where('id_menu_user', $id_menu_user);
        $this->db->update('t_menu_user', $data);
    }

    function delete($id_menu_user = "") {
        if ($id_menu_user) {
            $this->db->delete("t_menu_user", array("id_menu_user" => $id_menu_user));
        }
    }

    function delete_all($id_jabatan = "") {
        if ($id_jabatan) {
            $this->db->delete("t_menu_user", array("id_jabatan" => $id_jabatan));
        }
    }

    function Chek_Data($id_menu_user = "", $id_menu = "", $id_jabatan = "") {

        if ($id_menu_user) {
            $this->db->where("id_menu_user", $id_menu_user);
        } else {
            //$this->db->where("id_menu", $id_menu);
            $this->db->where("id_jabatan", $id_jabatan);
        }

        $query = $this->db->get("t_menu_user");

        return $query->num_rows();
    }

    function List_Data($id_menu_user = "") {

        $this->db->from("t_menu_user a");
        $this->db->join("c_menu b", "b.id_menu=a.id_menu", "left");
        $this->db->join("m_jabatan c", "c.id_jabatan=a.id_jabatan", "left");
        $this->db->where("id_menu_user", $id_menu_user);
        $query = $this->db->get();

        return $query->row();
        //return $this->db->get();
    }

}
