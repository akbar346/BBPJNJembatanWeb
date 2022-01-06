<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kerusakan_m extends CI_Model {
    function get($criteria = "", $keyword = "", $sort = "", $dir = "", $start = "", $limit = "") {
        $this->db->select("
            tk.id_kerusakan, tk.id_user id_input, mu.nip nip_input, mu.nama_lengkap nama_input, mu.no_hp hp_input, mjp.nama_jabatan jabatan_input, tk.id_kategori, mk.kode_kategori, mk.nama_kategori, tk.id_perbaikan, mp.kode_kerusakan, mp.nama_kerusakan, mp.ket_perbaikan, mp.marker, tk.gambar_1, tk.gambar_2, tk.tgl_pengecekan, tk.detail_kerusakan,
            tk.id_user_proses, mu2.nip nip_proses, mu2.nama_lengkap nama_proses, mu2.no_hp hp_proses, mjpp.nama_jabatan jabatan_proses, tk.gambar_proses_1, tk.gambar_proses_2, tk.tgl_proses,
            tk.id_user_selesai, mu3.nip nip_selesai, mu3.nama_lengkap nama_selesai, mu3.no_hp hp_selesai, mjs.nama_jabatan jabatan_selesai, tk.gambar_selesai_1, tk.gambar_selesai_2, tk.tgl_selesai,
            ms2.id_status, ms2.nama_status, tk.id_tingkat, mt.nama_tingkat, ms.id_satker, ms.kode_satker, ms.nama_satker, mp2.id_ppk, mp2.kode_ppk, mp2.nama_ppk, tk.lat, tk.lng
        ");
        $this->db->from("t_kerusakan tk");
        $this->db->join("m_user mu","tk.id_user = mu.id_user","inner");
        $this->db->join("m_jabatan mjp","mu.id_jabatan = mjp.id_jabatan","inner");
        $this->db->join("m_kategori mk","tk.id_kategori = mk.id_kategori","inner");
        $this->db->join("m_perbaikan mp","tk.id_perbaikan = mp.id_perbaikan","inner");
        $this->db->join("m_tingkat mt","tk.id_tingkat = mt.id_tingkat","inner");
        $this->db->join("m_status ms2","tk.status = ms2.id_status","inner");
        $this->db->join("m_user mu2","tk.id_user_proses = mu2.id_user","left");
        $this->db->join("m_jabatan mjpp","mu2.id_jabatan = mjpp.id_jabatan","left");
        $this->db->join("m_user mu3","tk.id_user_selesai = mu3.id_user","left");
        $this->db->join("m_jabatan mjs","mu3.id_jabatan = mjs.id_jabatan","left");
        $this->db->join("m_satker ms","tk.id_satker = ms.id_satker","inner");
        $this->db->join("m_ppk mp2","tk.id_ppk = mp2.id_ppk","inner");
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

    function getCount($criteria = "", $keyword = "") {
        $this->db->select("
            tk.id_kerusakan, tk.id_user id_input, mu.nip nip_input, mu.nama_lengkap nama_input, mu.no_hp hp_input, mjp.nama_jabatan jabatan_input, tk.id_kategori, mk.kode_kategori, mk.nama_kategori, tk.id_perbaikan, mp.kode_kerusakan, mp.nama_kerusakan, mp.ket_perbaikan, mp.marker, tk.gambar_1, tk.gambar_2, tk.tgl_pengecekan, tk.detail_kerusakan,
            tk.id_user_proses, mu2.nip nip_proses, mu2.nama_lengkap nama_proses, mu2.no_hp hp_proses, mjpp.nama_jabatan jabatan_proses, tk.gambar_proses_1, tk.gambar_proses_2, tk.tgl_proses,
            tk.id_user_selesai, mu3.nip nip_selesai, mu3.nama_lengkap nama_selesai, mu3.no_hp hp_selesai, mjs.nama_jabatan jabatan_selesai, tk.gambar_selesai_1, tk.gambar_selesai_2, tk.tgl_selesai,
            ms2.id_status, ms2.nama_status, tk.id_tingkat, mt.nama_tingkat, ms.id_satker, ms.kode_satker, ms.nama_satker, mp2.id_ppk, mp2.kode_ppk, mp2.nama_ppk, tk.lat, tk.lng
        ");
        $this->db->from("t_kerusakan tk");
        $this->db->join("m_user mu","tk.id_user = mu.id_user","inner");
        $this->db->join("m_jabatan mjp","mu.id_jabatan = mjp.id_jabatan","inner");
        $this->db->join("m_kategori mk","tk.id_kategori = mk.id_kategori","inner");
        $this->db->join("m_perbaikan mp","tk.id_perbaikan = mp.id_perbaikan","inner");
        $this->db->join("m_tingkat mt","tk.id_tingkat = mt.id_tingkat","inner");
        $this->db->join("m_status ms2","tk.status = ms2.id_status","inner");
        $this->db->join("m_user mu2","tk.id_user_proses = mu2.id_user","left");
        $this->db->join("m_jabatan mjpp","mu2.id_jabatan = mjpp.id_jabatan","left");
        $this->db->join("m_user mu3","tk.id_user_selesai = mu3.id_user","left");
        $this->db->join("m_jabatan mjs","mu3.id_jabatan = mjs.id_jabatan","left");
        $this->db->join("m_satker ms","tk.id_satker = ms.id_satker","inner");
        $this->db->join("m_ppk mp2","tk.id_ppk = mp2.id_ppk","inner");
        
        if ($criteria && $keyword) {
            $this->db->like($criteria, $keyword);
        }
        return $this->db->count_all_results();
    }
}