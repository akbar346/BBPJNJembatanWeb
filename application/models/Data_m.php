<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Data_m extends CI_Model {
    function GetData($table, $id, $order){
        $this->db->from($table);
		$this->db->order_by($id, $order);
		$query = $this->db->get();
		return $query->result();
    }

    function GetId($table, $id){
		$this->db->from($table);
		$this->db->where($id);
		$query = $this->db->get();
		return $query;
	}

	function Add($table, $data){
		$query = $this->db->insert($table, $data);
		return $query;
	}

	function Update($table, $data, $where){
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	function Delete($table, $id){
		$this->db->where($id);
		$this->db->delete($table);
	}
	
	function GetDataAkun($table){
		$username = $this->session->userdata("username");
		$query = $this->db->query("SELECT * FROM $table WHERE username = '$username'");
		return $query->row();
    }

    function GetCount($tabel, $column, $where){
		$query = $this->db->query("SELECT * FROM $tabel WHERE $column = '$where'");
		return $query;
	}

	function GetDataJalanMaps($id, $where, $limit, $offset, $kondisi = ""){
		$query = "
			select tk.id_kerusakan, tk.id_user id_input, mu.nip nip_input, mu.nama_lengkap nama_input, mu.no_hp hp_input, mjp.nama_jabatan jabatan_input, tk.id_kategori, mk.kode_kategori, mk.nama_kategori, tk.id_perbaikan, mp.kode_kerusakan, mp.nama_kerusakan, mp.ket_perbaikan, mp.marker, tk.gambar_1, tk.gambar_2, tk.tgl_pengecekan, tk.detail_kerusakan,
			tk.id_user_proses, mu2.nip nip_proses, mu2.nama_lengkap nama_proses, mu2.no_hp hp_proses, mjpp.nama_jabatan jabatan_proses, tk.gambar_proses_1, tk.gambar_proses_2, tk.tgl_proses,
			tk.id_user_selesai, mu3.nip nip_selesai, mu3.nama_lengkap nama_selesai, mu3.no_hp hp_selesai, mjs.nama_jabatan jabatan_selesai, tk.gambar_selesai_1, tk.gambar_selesai_2, tk.tgl_selesai,
			ms2.id_status, ms2.nama_status, tk.id_tingkat, mt.nama_tingkat, ms.id_satker, ms.kode_satker, ms.nama_satker, mp2.id_ppk, mp2.kode_ppk, mp2.nama_ppk, tk.lat, tk.lng
			from t_kerusakan tk
			inner join m_user mu on tk.id_user = mu.id_user
			inner join m_jabatan mjp on mu.id_jabatan = mjp.id_jabatan
			inner join m_kategori mk on tk.id_kategori = mk.id_kategori 
			inner join m_perbaikan mp on tk.id_perbaikan = mp.id_perbaikan
			inner join m_tingkat mt on tk.id_tingkat = mt.id_tingkat
			inner join m_status ms2 on tk.status = ms2.id_status 
			left join m_user mu2 on tk.id_user_proses = mu2.id_user
			left join m_jabatan mjpp on mu2.id_jabatan = mjpp.id_jabatan
			left join m_user mu3 on tk.id_user_selesai = mu3.id_user
			left join m_jabatan mjs on mu3.id_jabatan = mjs.id_jabatan
			inner join m_satker ms on tk.id_satker = ms.id_satker 
			inner join m_ppk mp2 on tk.id_ppk = mp2.id_ppk
			WHERE $id = $where 
		";
		if ($kondisi == "hilang"){
			$query .= "AND tk.status != 3";
		}
		$query .= "
			ORDER BY tk.id_kerusakan ASC
		";

		if ($limit != "" && $limit != "") {
            $query .= "LIMIT $limit ";
		}
		
		if ($offset != "" && $offset != "") {
            $query .= "offset $offset";
        }
		
		return $this->db->query($query);
	}
}