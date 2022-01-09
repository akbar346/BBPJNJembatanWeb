<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Jabatan_m');
        $this->load->model('Jenis_kelamin_m');
        $this->load->model('User_m');
        $this->load->model('Satker_m');
        $this->load->model('Ppk_m');
        $this->load->model('Menuakses_m');
        $this->Layout_m->Check_Login();
    }

    /*
     * Master Menu Akses
     */

    function akses() {
        $data['namaMenu'] = "Menu Akses";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $data['id_jabatan'] = $this->Jabatan_m->getDataComboBox('id_jabatan');
        $data['id_menu'] = $this->Menuakses_m->getDataComboBox('id_menu');

        $this->parser->parse('master/akses_v', $data);
    }

    function do_Simpan_Akses() {
        $return = array();
        $error = "";
        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_jabatan = ($this->input->post("id_jabatan") != "") ? $this->input->post("id_jabatan") : "";
        $id_menu = ($this->input->post("id_menu") != "") ? $this->input->post("id_menu") : "";
        if ($mode_form == "Tambah") {
            foreach (explode(",", $id_menu) as $id_menu) {
                $this->Menuakses_m->insert($id_menu, $id_jabatan);
            }
        } else if ($mode_form == "Ubah") {
            $this->Menuakses_m->delete_all($id_jabatan);
            foreach (explode(",", $id_menu) as $id_menu) {
                $this->Menuakses_m->insert($id_menu, $id_jabatan);
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Menu Akses Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Menu Akses Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Tabel_Akses() {

        $records["aaData"] = array();
        $aColumns = array('id_menu_user', 'nama_menu', 'nama_jabatan');
        //default
        $sort = "id_menu_user";
        $dir = "desc";
        $criteria = "upper(nama_menu || nama_jabatan)";

        $sSearch = ($this->input->post("sSearch") != "") ? strtoupper(quotes_to_entities($this->input->post("sSearch"))) : "";
        $iDisplayLength = ($this->input->post("iDisplayLength") != "") ? $this->input->post("iDisplayLength") : "";
        $iDisplayStart = ($this->input->post("iDisplayStart") != "") ? $this->input->post("iDisplayStart") : "";
        $sEcho = ($this->input->post("sEcho") != "") ? $this->input->post("sEcho") : "";

        // Shorting
        $iSortCol_0 = ($this->input->post("iSortCol_0") != "") ? $this->input->post("iSortCol_0") : "";
        $iSortingCols = ($this->input->post("iSortingCols") != "") ? $this->input->post("iSortingCols") : "";
        if ($iSortCol_0) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $sort = $aColumns[intval($this->input->post('iSortCol_' . $i))];
                $dir = ($this->input->post('sSortDir_' . $i) != "") ? $this->input->post('sSortDir_' . $i) : "";
            }
        }
        $iTotalRecords = $this->Menuakses_m->getCountMenuakses($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Menuakses_m->getMenuakses($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    $no,
                    $Fields->nama_menu,
                    $Fields->nama_jabatan,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_menu_user . '" data-name="' . $Fields->nama_menu . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Hapus_Akses() {
        $id_menu_user = ($this->input->post("id_menu_user") != "") ? $this->input->post("id_menu_user") : "";
        $this->Menuakses_m->delete($id_menu_user);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data User Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data User Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    /*
     * Master Jabatan
     */

    function jabatan() {
        $data['namaMenu'] = "Jabatan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/jabatan_v', $data);
    }

    function do_Tabel_Jabatan() {

        $records["aaData"] = array();
        $aColumns = array('id_jabatan', 'nama_jabatan');
        //default
        $sort = "id_jabatan";
        $dir = "desc";
        $criteria = "upper(nama_jabatan)";

        $sSearch = ($this->input->post("sSearch") != "") ? strtoupper(quotes_to_entities($this->input->post("sSearch"))) : "";
        $iDisplayLength = ($this->input->post("iDisplayLength") != "") ? $this->input->post("iDisplayLength") : "";
        $iDisplayStart = ($this->input->post("iDisplayStart") != "") ? $this->input->post("iDisplayStart") : "";
        $sEcho = ($this->input->post("sEcho") != "") ? $this->input->post("sEcho") : "";

        // Shorting
        $iSortCol_0 = ($this->input->post("iSortCol_0") != "") ? $this->input->post("iSortCol_0") : "";
        $iSortingCols = ($this->input->post("iSortingCols") != "") ? $this->input->post("iSortingCols") : "";
        if ($iSortCol_0) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $sort = $aColumns[intval($this->input->post('iSortCol_' . $i))];
                $dir = ($this->input->post('sSortDir_' . $i) != "") ? $this->input->post('sSortDir_' . $i) : "";
            }
        }
        $iTotalRecords = $this->Jabatan_m->getCountJabatan($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Jabatan_m->getJabatan($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    $Fields->nama_jabatan,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_jabatan . '" data-name="' . $Fields->nama_jabatan . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_jabatan . '" data-name="' . $Fields->nama_jabatan . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Jabatan() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_jabatan = ($this->input->post("id_jabatan") != "") ? $this->input->post("id_jabatan") : "";
        $nama_jabatan = ($this->input->post("nama_jabatan") != "") ? $this->input->post("nama_jabatan") : "";

        if ($mode_form == "Tambah") {
            if ($this->Jabatan_m->Chek_Data("", $nama_jabatan) == 0) {
                $this->Jabatan_m->insert($nama_jabatan);
            } else {
                $error = "Maaf, Data Jabatan Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Jabatan_m->Chek_Data($id_jabatan) > 0) {
                $this->Jabatan_m->update($id_jabatan, $nama_jabatan);
            } else {
                $error = "Maaf, Data Jabatan Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Jabatan Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Jabatan Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Jabatan() {
        $id_jabatan = ($this->input->post("id_jabatan") != "") ? $this->input->post("id_jabatan") : "";
        $this->Jabatan_m->delete($id_jabatan);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Jabatan Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Jabatan Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Jabatan() {
        $return = array();
        $itemList = array();
        $id_jabatan = ($this->input->post("id_jabatan") != "") ? $this->input->post("id_jabatan") : "";
        if ($this->Jabatan_m->Chek_Data($id_jabatan) > 0) {
            $Fields = $this->Jabatan_m->List_Data($id_jabatan);
            $item = array(
                "mode_form" => "Ubah",
                "id_jabatan" => $Fields->id_jabatan,
                "nama_jabatan" => $Fields->nama_jabatan
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Jabatan Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Master Satker
     */

    function satker() {
        $data['namaMenu'] = "Satker";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/satker_v', $data);
    }

    function do_Tabel_Satker() {

        $records["aaData"] = array();
        $aColumns = array('id_satker', 'kode_satker', 'nama_satker', 'alamat', 'no_telp');
        //default
        $sort = "id_satker";
        $dir = "desc";
        $criteria = "upper(kode_satker || nama_satker || alamat || no_telp)";

        $sSearch = ($this->input->post("sSearch") != "") ? strtoupper(quotes_to_entities($this->input->post("sSearch"))) : "";
        $iDisplayLength = ($this->input->post("iDisplayLength") != "") ? $this->input->post("iDisplayLength") : "";
        $iDisplayStart = ($this->input->post("iDisplayStart") != "") ? $this->input->post("iDisplayStart") : "";
        $sEcho = ($this->input->post("sEcho") != "") ? $this->input->post("sEcho") : "";

        // Shorting
        $iSortCol_0 = ($this->input->post("iSortCol_0") != "") ? $this->input->post("iSortCol_0") : "";
        $iSortingCols = ($this->input->post("iSortingCols") != "") ? $this->input->post("iSortingCols") : "";
        if ($iSortCol_0) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $sort = $aColumns[intval($this->input->post('iSortCol_' . $i))];
                $dir = ($this->input->post('sSortDir_' . $i) != "") ? $this->input->post('sSortDir_' . $i) : "";
            }
        }
        $iTotalRecords = $this->Satker_m->getCountSatker($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Satker_m->getSatker($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    '<center>' . $Fields->kode_satker . '</center>',
                    $Fields->nama_satker,
                    $Fields->alamat,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_satker . '" data-name="' . $Fields->kode_satker . ' - ' . $Fields->nama_satker . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_satker . '" data-name="' . $Fields->kode_satker . ' - ' . $Fields->nama_satker . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Satker() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_satker = ($this->input->post("id_satker") != "") ? $this->input->post("id_satker") : "";
        $kode_satker = ($this->input->post("kode_satker") != "") ? $this->input->post("kode_satker") : "";
        $nama_satker = ($this->input->post("nama_satker") != "") ? $this->input->post("nama_satker") : "";
        $alamat = ($this->input->post("alamat") != "") ? $this->input->post("alamat") : "";
        $no_telp = ($this->input->post("no_telp") != "") ? $this->input->post("no_telp") : "";

        if ($mode_form == "Tambah") {
            if ($this->Satker_m->Chek_Data("", $kode_satker) == 0) {
                $this->Satker_m->insert($kode_satker, $nama_satker, $alamat, $no_telp);
            } else {
                $error = "Maaf, Data Satker Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Satker_m->Chek_Data($id_satker) > 0) {
                $this->Satker_m->update($id_satker, $kode_satker, $nama_satker, $alamat, $no_telp);
            } else {
                $error = "Maaf, Data Satker Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Satker Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Satker Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Satker() {
        $id_satker = ($this->input->post("id_satker") != "") ? $this->input->post("id_satker") : "";
        $this->Satker_m->delete($id_satker);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Satker Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Satker Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Satker() {
        $return = array();
        $itemList = array();
        $id_satker = ($this->input->post("id_satker") != "") ? $this->input->post("id_satker") : "";
        if ($this->Satker_m->Chek_Data($id_satker) > 0) {
            $Fields = $this->Satker_m->List_Data($id_satker);
            $item = array(
                "mode_form" => "Ubah",
                "id_satker" => $Fields->id_satker,
                "kode_satker" => $Fields->kode_satker,
                "nama_satker" => $Fields->nama_satker,
                "alamat" => $Fields->alamat,
                "no_telp" => $Fields->no_telp
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Satker Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Master PPK
     */

    function ppk() {
        $data['namaMenu'] = "PPK";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/ppk_v', $data);
    }

    function do_Tabel_Ppk() {

        $records["aaData"] = array();
        $aColumns = array('id_ppk', 'kode_ppk', 'nama_ppk', 'alamat', 'no_telp');
        //default
        $sort = "id_ppk";
        $dir = "desc";
        $criteria = "upper(kode_ppk || nama_ppk || alamat || no_telp)";

        $sSearch = ($this->input->post("sSearch") != "") ? strtoupper(quotes_to_entities($this->input->post("sSearch"))) : "";
        $iDisplayLength = ($this->input->post("iDisplayLength") != "") ? $this->input->post("iDisplayLength") : "";
        $iDisplayStart = ($this->input->post("iDisplayStart") != "") ? $this->input->post("iDisplayStart") : "";
        $sEcho = ($this->input->post("sEcho") != "") ? $this->input->post("sEcho") : "";

        // Shorting
        $iSortCol_0 = ($this->input->post("iSortCol_0") != "") ? $this->input->post("iSortCol_0") : "";
        $iSortingCols = ($this->input->post("iSortingCols") != "") ? $this->input->post("iSortingCols") : "";
        if ($iSortCol_0) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $sort = $aColumns[intval($this->input->post('iSortCol_' . $i))];
                $dir = ($this->input->post('sSortDir_' . $i) != "") ? $this->input->post('sSortDir_' . $i) : "";
            }
        }
        $iTotalRecords = $this->Ppk_m->getCountPpk($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Ppk_m->getPpk($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    $Fields->kode_satker . ' - ' . $Fields->nama_satker,
                    '<center>' . $Fields->kode_ppk . '</center>',
                    $Fields->nama_ppk,
                    $Fields->alamat,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_ppk . '" data-name="' . $Fields->kode_ppk . ' - ' . $Fields->nama_ppk . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_ppk . '" data-name="' . $Fields->kode_ppk . ' - ' . $Fields->nama_ppk . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Ppk() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_ppk = ($this->input->post("id_ppk") != "") ? $this->input->post("id_ppk") : "";
        $id_satker = ($this->input->post("id_satker") != "") ? $this->input->post("id_satker") : "";
        $kode_ppk = ($this->input->post("kode_ppk") != "") ? $this->input->post("kode_ppk") : "";
        $nama_ppk = ($this->input->post("nama_ppk") != "") ? $this->input->post("nama_ppk") : "";
        $alamat = ($this->input->post("alamat") != "") ? $this->input->post("alamat") : "";
        $no_telp = ($this->input->post("no_telp") != "") ? $this->input->post("no_telp") : "";

        if ($mode_form == "Tambah") {
            if ($this->Ppk_m->Chek_Data("", $id_satker, $kode_ppk) == 0) {
                $this->Ppk_m->insert($kode_ppk, $nama_ppk, $alamat, $no_telp, $id_satker);
            } else {
                $error = "Maaf, Data PPK Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Ppk_m->Chek_Data($id_ppk) > 0) {
                $this->Ppk_m->update($id_ppk, $kode_ppk, $nama_ppk, $alamat, $no_telp, $id_satker);
            } else {
                $error = "Maaf, Data PPK Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data PPK Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data PPK Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Ppk() {
        $id_ppk = ($this->input->post("id_ppk") != "") ? $this->input->post("id_ppk") : "";
        $this->Ppk_m->delete($id_ppk);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data PPK Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data PPK Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Ppk() {
        $return = array();
        $itemList = array();
        $id_ppk = ($this->input->post("id_ppk") != "") ? $this->input->post("id_ppk") : "";
        if ($this->Ppk_m->Chek_Data($id_ppk) > 0) {
            $Fields = $this->Ppk_m->List_Data($id_ppk);
            $item = array(
                "mode_form" => "Ubah",
                "id_ppk" => $Fields->id_ppk,
                "id_satker" => $Fields->id_satker,
                "kode_ppk" => $Fields->kode_ppk,
                "nama_ppk" => $Fields->nama_ppk,
                "alamat" => $Fields->alamat,
                "no_telp" => $Fields->no_telp
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data PPK Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Master Jenis Kelamin
     */

    function jenis_kelamin() {
        $data['namaMenu'] = "Jenis Kelamin";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/jenis_kelamin_v', $data);
    }

    function do_Tabel_Jenis_kelamin() {

        $records["aaData"] = array();
        $aColumns = array('id_jenis_kelamin', 'nama_jenis_kelamin');
        //default
        $sort = "id_jenis_kelamin";
        $dir = "desc";
        $criteria = "upper(nama_jenis_kelamin)";

        $sSearch = ($this->input->post("sSearch") != "") ? strtoupper(quotes_to_entities($this->input->post("sSearch"))) : "";
        $iDisplayLength = ($this->input->post("iDisplayLength") != "") ? $this->input->post("iDisplayLength") : "";
        $iDisplayStart = ($this->input->post("iDisplayStart") != "") ? $this->input->post("iDisplayStart") : "";
        $sEcho = ($this->input->post("sEcho") != "") ? $this->input->post("sEcho") : "";

        // Shorting
        $iSortCol_0 = ($this->input->post("iSortCol_0") != "") ? $this->input->post("iSortCol_0") : "";
        $iSortingCols = ($this->input->post("iSortingCols") != "") ? $this->input->post("iSortingCols") : "";
        if ($iSortCol_0) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $sort = $aColumns[intval($this->input->post('iSortCol_' . $i))];
                $dir = ($this->input->post('sSortDir_' . $i) != "") ? $this->input->post('sSortDir_' . $i) : "";
            }
        }
        $iTotalRecords = $this->Jenis_kelamin_m->getCountJenis_kelamin($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Jenis_kelamin_m->getJenis_kelamin($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    $Fields->nama_jenis_kelamin,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_jenis_kelamin . '" data-name="' . $Fields->nama_jenis_kelamin . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_jenis_kelamin . '" data-name="' . $Fields->nama_jenis_kelamin . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Jenis_kelamin() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_jenis_kelamin = ($this->input->post("id_jenis_kelamin") != "") ? $this->input->post("id_jenis_kelamin") : "";
        $nama_jenis_kelamin = ($this->input->post("nama_jenis_kelamin") != "") ? $this->input->post("nama_jenis_kelamin") : "";

        if ($mode_form == "Tambah") {
            if ($this->Jenis_kelamin_m->Chek_Data("", $nama_jenis_kelamin) == 0) {
                $this->Jenis_kelamin_m->insert($nama_jenis_kelamin);
            } else {
                $error = "Maaf, Data Jenis Kelamin Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Jenis_kelamin_m->Chek_Data($id_jenis_kelamin) > 0) {
                $this->Jenis_kelamin_m->update($id_jenis_kelamin, $nama_jenis_kelamin);
            } else {
                $error = "Maaf, Data Jenis Kelamin Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Jenis Kelamin Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Jenis Kelamin Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Jenis_kelamin() {
        $id_jenis_kelamin = ($this->input->post("id_jenis_kelamin") != "") ? $this->input->post("id_jenis_kelamin") : "";
        $this->Jenis_kelamin_m->delete($id_jenis_kelamin);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Jenis Kelamin Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Jenis Kelamin Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Jenis_kelamin() {
        $return = array();
        $itemList = array();
        $id_jenis_kelamin = ($this->input->post("id_jenis_kelamin") != "") ? $this->input->post("id_jenis_kelamin") : "";
        if ($this->Jenis_kelamin_m->Chek_Data($id_jenis_kelamin) > 0) {
            $Fields = $this->Jenis_kelamin_m->List_Data($id_jenis_kelamin);
            $item = array(
                "mode_form" => "Ubah",
                "id_jenis_kelamin" => $Fields->id_jenis_kelamin,
                "nama_jenis_kelamin" => $Fields->nama_jenis_kelamin
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Jenis Kelamin Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Master User
     */

    function user() {
        $data['namaMenu'] = "User";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/user_v', $data);
    }

    function do_Tabel_User() {

        $records["aaData"] = array();
        $aColumns = array('id_user', 'nip', 'nama_lengkap', 'no_hp', 'nama_jabatan');
        //default
        $sort = "a.id_user";
        $dir = "desc";
        $criteria = "upper(nip || nama_lengkap || no_hp || nama_jabatan)";

        $sSearch = ($this->input->post("sSearch") != "") ? strtoupper(quotes_to_entities($this->input->post("sSearch"))) : "";
        $iDisplayLength = ($this->input->post("iDisplayLength") != "") ? $this->input->post("iDisplayLength") : "";
        $iDisplayStart = ($this->input->post("iDisplayStart") != "") ? $this->input->post("iDisplayStart") : "";
        $sEcho = ($this->input->post("sEcho") != "") ? $this->input->post("sEcho") : "";

        // Shorting
        $iSortCol_0 = ($this->input->post("iSortCol_0") != "") ? $this->input->post("iSortCol_0") : "";
        $iSortingCols = ($this->input->post("iSortingCols") != "") ? $this->input->post("iSortingCols") : "";
        if ($iSortCol_0) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $sort = $aColumns[intval($this->input->post('iSortCol_' . $i))];
                $dir = ($this->input->post('sSortDir_' . $i) != "") ? $this->input->post('sSortDir_' . $i) : "";
            }
        }
        $iTotalRecords = $this->User_m->getCountUser($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->User_m->getUser($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $status = ($Fields->status == 't' || $Fields->status == '1') ? "Akfif" : "Tidak Aktif";

                $btnTTD = "";
                if ($Fields->foto != "") {
                    $btnTTD = '<a href="javascript:;" data-id="' . $Fields->id_user . '" data-name="' . $Fields->nama_lengkap . '" data-foto="' . $Fields->foto . '" class="btn btn-xs green btn-foto"><i class="fa fa-image"></i> Foto</a>';
                }
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    '<center>' . $Fields->nip . '</center>',
                    $Fields->nama_lengkap,
                    '<center>' . $Fields->no_hp . '</center>',
                    '<center>' . $Fields->nama_jabatan . '</center>',
                    '<center>' . $status . '</center>',
                    '<center><a href="javascript:;" data-id="' . $Fields->id_user . '" data-name="' . $Fields->nip . ' (' . $Fields->nama_lengkap . ')" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_user . '" data-name="' . $Fields->nip . ' (' . $Fields->nama_lengkap . ')" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a> '
                    . $btnTTD . '</center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_User() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_user = ($this->input->post("id_user") != "") ? $this->input->post("id_user") : "";
        $nama_lengkap = ($this->input->post("nama_lengkap") != "") ? $this->input->post("nama_lengkap") : "";
        $email = ($this->input->post("email") != "") ? $this->input->post("email") : "";
        $nip = ($this->input->post("nip") != "") ? $this->input->post("nip") : "";
        $no_hp = ($this->input->post("no_hp") != "") ? $this->input->post("no_hp") : "";
        $status = ($this->input->post("status") != "") ? $this->input->post("status") : "";
        $passwd = ($this->input->post("passwd") != "") ? $this->input->post("passwd") : "";
        $id_jabatan = ($this->input->post("id_jabatan") != "") ? $this->input->post("id_jabatan") : "";
        $flag_password_user = ($this->input->post("flag_password_user") != "") ? $this->input->post("flag_password_user") : "";
        $tmp_lahir = ($this->input->post("tmp_lahir") != "") ? $this->input->post("tmp_lahir") : "";
        $tgl_lahir = ($this->input->post("tgl_lahir") != "") ? $this->input->post("tgl_lahir") : "";
        $id_jenis_kelamin = ($this->input->post("id_jenis_kelamin") != "") ? $this->input->post("id_jenis_kelamin") : null;
        $alamat = ($this->input->post("alamat") != "") ? $this->input->post("alamat") : "";
        $id_satker = ($this->input->post("id_satker") != "") ? $this->input->post("id_satker") : null;
        $id_ppk = ($this->input->post("id_ppk") != "") ? $this->input->post("id_ppk") : null;
        $foto = '';

        if (strlen($no_hp) >= 8 || strlen($no_hp <= 14)) {
            $config['upload_path'] = './assets/upload';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);
            foreach ($_FILES as $key => $value) {
                if (!empty($value['name'])) {
                    if (!$this->upload->do_upload($key)) {
                        $error = $this->upload->display_errors();
                        $return["msgServer"] = $error;
                        $return["success"] = FALSE;
                    } else {
                        if ($key == "foto") {
                            $data_upload = $this->upload->data();
                            $foto = $id_user . "_Profil" . $data_upload['file_ext'];

                            rename($data_upload['full_path'], $data_upload['file_path'] . $foto);
                            copy($data_upload['file_path'] . $foto, $data_upload['file_path'] . "foto/" . $foto);
                            unlink($data_upload['file_path'] . $foto);
                        }
                    }
                }
            }

            if ($mode_form == "Tambah") {
                if ($this->User_m->Chek_Data("", $nip) == 0) {
                    $this->User_m->insert($nama_lengkap, $email, $flag_password_user, $passwd, $nip, $no_hp, $status, $id_jabatan, $foto, $tmp_lahir, $tgl_lahir, $id_jenis_kelamin, $alamat, $id_satker, $id_ppk);
                } else {
                    $error = "Maaf, Data User Sudah ada. !!!";
                }
            } else if ($mode_form == "Ubah") {
                if ($this->User_m->Chek_Data($id_user) > 0) {
                    $this->User_m->update($id_user, $nama_lengkap, $email, $flag_password_user, $passwd, $nip, $no_hp, $status, $id_jabatan, $foto, $tmp_lahir, $tgl_lahir, $id_jenis_kelamin, $alamat, $id_satker, $id_ppk);
                } else {
                    $error = "Maaf, Data User Tidak ditemukan. !!!";
                }
            }
        } else {
            $error = "Maaf, No HP Lebih dari 8 dan kurang dari 14 Digit. !!!";
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data User Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data User Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_User() {
        $id_user = ($this->input->post("id_user") != "") ? $this->input->post("id_user") : "";
        $this->User_m->delete($id_user);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data User Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data User Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_User() {
        $return = array();
        $itemList = array();
        $id_user = ($this->input->post("id_user") != "") ? $this->input->post("id_user") : "";
        if ($this->User_m->Chek_Data($id_user) > 0) {
            $Fields = $this->User_m->List_Data($id_user);
            $item = array(
                "mode_form" => "Ubah",
                "id_user" => $Fields->id_user,
                "nama_lengkap" => $Fields->nama_lengkap,
                "email" => $Fields->email,
                "nip" => $Fields->nip,
                "no_hp" => $Fields->no_hp,
                "id_jabatan" => $Fields->id_jabatan,
                "status" => $Fields->status,
                "tmp_lahir" => $Fields->tmp_lahir,
                "tgl_lahir" => $Fields->tgl_lahir,
                "id_jenis_kelamin" => $Fields->id_jenis_kelamin,
                "alamat" => $Fields->alamat,
                "id_satker" => $Fields->id_satker,
                "id_ppk" => $Fields->id_ppk
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data User Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    function do_cari_ppk() {
        $id_satker = ($this->input->post("id_satker") != "") ? $this->input->post("id_satker") : "";

        $this->db->from("m_satker a");
        $this->db->join("m_ppk b", "b.id_satker=a.id_satker", "left");
        $this->db->where("b.id_satker", $id_satker);
        $this->db->order_by('b.nama_ppk', 'asc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $Fields) {
                $item = array(
                    "id_ppk" => $Fields->id_ppk,
                    "nama_ppk" => $Fields->nama_ppk,
                    "kode_ppk" => $Fields->kode_ppk,
                );
                $itemList[] = $item;
            }

            $return["success"] = TRUE;
            $return["results"] = $itemList;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data PPK Tidak Ditemukan.";
        }
        echo json_encode($return);
    }

}
