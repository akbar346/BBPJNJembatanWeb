<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Kerusakan extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Kategori_m');
        $this->load->model('Perbaikan_m');
        $this->load->model('Tingkat_m');
        $this->load->model('Kerusakan_m');
        $this->Layout_m->Check_Login();
    }

    /*
     * Master Kategori
     */

    function kategori() {
        $data['namaMenu'] = "Kategori Kerusakan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/kategori_v', $data);
    }

    function do_Tabel_Kategori() {

        $records["aaData"] = array();
        $aColumns = array('id_kategori', 'kode_kategori', 'nama_kategori');
        //default
        $sort = "kode_kategori";
        $dir = "asc";
        $criteria = "upper(kode_kategori || nama_kategori)";

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
        $iTotalRecords = $this->Kategori_m->getCountKategori($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Kategori_m->getKategori($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    '<center>' . $Fields->kode_kategori . '</center>',
                    $Fields->nama_kategori,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_kategori . '" data-name="' . $Fields->kode_kategori . ' - ' . $Fields->nama_kategori . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_kategori . '" data-name="' . $Fields->kode_kategori . ' - ' . $Fields->nama_kategori . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Kategori() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_kategori = ($this->input->post("id_kategori") != "") ? $this->input->post("id_kategori") : "";
        $kode_kategori = ($this->input->post("kode_kategori") != "") ? $this->input->post("kode_kategori") : "";
        $nama_kategori = ($this->input->post("nama_kategori") != "") ? $this->input->post("nama_kategori") : "";

        if ($mode_form == "Tambah") {
            if ($this->Kategori_m->Chek_Data("", $kode_kategori) == 0) {
                $this->Kategori_m->insert($kode_kategori, $nama_kategori);
            } else {
                $error = "Maaf, Data Kategori Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Kategori_m->Chek_Data($id_kategori) > 0) {
                $this->Kategori_m->update($id_kategori, $kode_kategori, $nama_kategori);
            } else {
                $error = "Maaf, Data Kategori Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Kategori Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Kategori Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Kategori() {
        $id_kategori = ($this->input->post("id_kategori") != "") ? $this->input->post("id_kategori") : "";
        $this->Kategori_m->delete($id_kategori);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Kategori Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Kategori Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Kategori() {
        $return = array();
        $itemList = array();
        $id_kategori = ($this->input->post("id_kategori") != "") ? $this->input->post("id_kategori") : "";
        if ($this->Kategori_m->Chek_Data($id_kategori) > 0) {
            $Fields = $this->Kategori_m->List_Data($id_kategori);
            $item = array(
                "mode_form" => "Ubah",
                "id_kategori" => $Fields->id_kategori,
                "kode_kategori" => $Fields->kode_kategori,
                "nama_kategori" => $Fields->nama_kategori
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Kategori Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Master Perbaikan
     */

    function perbaikan() {
        $data['namaMenu'] = "Jenis Kerusakan dan Perbaikan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/perbaikan_v', $data);
    }

    function do_Tabel_Perbaikan() {

        $records["aaData"] = array();
        $aColumns = array('id_perbaikan', 'kode_kerusakan', 'nama_kerusakan', 'nama_kategori', 'ket_perbaikan');
        //default
        $sort = "kode_kerusakan";
        $dir = "asc";
        $criteria = "upper(kode_kerusakan || nama_kerusakan || nama_kategori || ket_perbaikan)";

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
        $iTotalRecords = $this->Perbaikan_m->getCountPerbaikan($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Perbaikan_m->getPerbaikan($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    '<center>' . $Fields->kode_kerusakan . '</center>',
                    $Fields->nama_kerusakan,
                    $Fields->nama_kategori,
                    $Fields->ket_perbaikan,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_perbaikan . '" data-name="' . $Fields->kode_kerusakan . ' - ' . $Fields->nama_kerusakan . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_perbaikan . '" data-name="' . $Fields->kode_kerusakan . ' - ' . $Fields->nama_kerusakan . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Perbaikan() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_perbaikan = ($this->input->post("id_perbaikan") != "") ? $this->input->post("id_perbaikan") : "";
        $kode_kerusakan = ($this->input->post("kode_kerusakan") != "") ? $this->input->post("kode_kerusakan") : "";
        $nama_kerusakan = ($this->input->post("nama_kerusakan") != "") ? $this->input->post("nama_kerusakan") : "";
        $id_kategori = ($this->input->post("id_kategori") != "") ? $this->input->post("id_kategori") : "";
        $ket_perbaikan = ($this->input->post("ket_perbaikan") != "") ? $this->input->post("ket_perbaikan") : "";

        if ($mode_form == "Tambah") {
            if ($this->Perbaikan_m->Chek_Data("", $id_kategori, $kode_kerusakan, $nama_kerusakan) == 0) {
                $this->Perbaikan_m->insert($kode_kerusakan, $nama_kerusakan, $id_kategori, $ket_perbaikan);
            } else {
                $error = "Maaf, Data Perbaikan Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Perbaikan_m->Chek_Data($id_perbaikan) > 0) {
                $this->Perbaikan_m->update($id_perbaikan, $kode_kerusakan, $nama_kerusakan, $id_kategori, $ket_perbaikan);
            } else {
                $error = "Maaf, Data Perbaikan Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Perbaikan Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Perbaikan Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Perbaikan() {
        $id_perbaikan = ($this->input->post("id_perbaikan") != "") ? $this->input->post("id_perbaikan") : "";
        $this->Perbaikan_m->delete($id_perbaikan);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Perbaikan Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Perbaikan Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Perbaikan() {
        $return = array();
        $itemList = array();
        $id_perbaikan = ($this->input->post("id_perbaikan") != "") ? $this->input->post("id_perbaikan") : "";
        if ($this->Perbaikan_m->Chek_Data($id_perbaikan) > 0) {
            $Fields = $this->Perbaikan_m->List_Data($id_perbaikan);
            $item = array(
                "mode_form" => "Ubah",
                "id_perbaikan" => $Fields->id_perbaikan,
                "kode_kerusakan" => $Fields->kode_kerusakan,
                "nama_kerusakan" => $Fields->nama_kerusakan,
                "id_kategori" => $Fields->id_kategori,
                "ket_perbaikan" => $Fields->ket_perbaikan
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Perbaikan Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Master Tingkat
     */

    function tingkat() {
        $data['namaMenu'] = "Tingkat Kerusakan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('master/tingkat_v', $data);
    }

    function do_Tabel_Tingkat() {

        $records["aaData"] = array();
        $aColumns = array('id_tingkat', 'nama_tingkat');
        //default
        $sort = "nama_tingkat";
        $dir = "asc";
        $criteria = "upper(nama_tingkat)";

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
        $iTotalRecords = $this->Tingkat_m->getCountTingkat($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Tingkat_m->getTingkat($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    $Fields->nama_tingkat,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_tingkat . '" data-name="' . $Fields->nama_tingkat . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_tingkat . '" data-name="' . $Fields->nama_tingkat . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Tingkat() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_tingkat = ($this->input->post("id_tingkat") != "") ? $this->input->post("id_tingkat") : "";
        $nama_tingkat = ($this->input->post("nama_tingkat") != "") ? $this->input->post("nama_tingkat") : "";

        if ($mode_form == "Tambah") {
            if ($this->Tingkat_m->Chek_Data("", $nama_tingkat) == 0) {
                $this->Tingkat_m->insert($nama_tingkat);
            } else {
                $error = "Maaf, Data Tingkat Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Tingkat_m->Chek_Data($id_tingkat) > 0) {
                $this->Tingkat_m->update($id_tingkat, $nama_tingkat);
            } else {
                $error = "Maaf, Data Tingkat Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Tingkat Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Tingkat Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Tingkat() {
        $id_tingkat = ($this->input->post("id_tingkat") != "") ? $this->input->post("id_tingkat") : "";
        $this->Tingkat_m->delete($id_tingkat);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Tingkat Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Tingkat Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Tingkat() {
        $return = array();
        $itemList = array();
        $id_tingkat = ($this->input->post("id_tingkat") != "") ? $this->input->post("id_tingkat") : "";
        if ($this->Tingkat_m->Chek_Data($id_tingkat) > 0) {
            $Fields = $this->Tingkat_m->List_Data($id_tingkat);
            $item = array(
                "mode_form" => "Ubah",
                "id_tingkat" => $Fields->id_tingkat,
                "nama_tingkat" => $Fields->nama_tingkat
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Tingkat Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    /*
     * Daftar Kerusakan Jalan
     */

    function daftar() {
        $data['namaMenu'] = "Daftar Kerusakan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('kerusakan/daftar_v', $data);
    }

    function do_Tabel_Daftar() {

        $records["aaData"] = array();
        $aColumns = array('id_daftar', 'nama_daftar');
        //default
        $sort = "id_daftar";
        $dir = "desc";
        $criteria = "upper(nama_daftar)";

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
        $iTotalRecords = $this->Daftar_m->getCountDaftar($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Daftar_m->getDaftar($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    $Fields->nama_daftar,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_daftar . '" data-name="' . $Fields->nama_daftar . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_daftar . '" data-name="' . $Fields->nama_daftar . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function do_Simpan_Daftar() {
        $return = array();
        $error = "";

        $mode_form = ($this->input->post("mode_form") != "") ? $this->input->post("mode_form") : "";
        $id_daftar = ($this->input->post("id_daftar") != "") ? $this->input->post("id_daftar") : "";
        $nama_daftar = ($this->input->post("nama_daftar") != "") ? $this->input->post("nama_daftar") : "";

        if ($mode_form == "Tambah") {
            if ($this->Daftar_m->Chek_Data("", $nama_daftar) == 0) {
                $this->Daftar_m->insert($nama_daftar);
            } else {
                $error = "Maaf, Data Daftar Sudah ada. !!!";
            }
        } else if ($mode_form == "Ubah") {
            if ($this->Daftar_m->Chek_Data($id_daftar) > 0) {
                $this->Daftar_m->update($id_daftar, $nama_daftar);
            } else {
                $error = "Maaf, Data Daftar Tidak ditemukan. !!!";
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $return["msgServer"] = "Simpan Data Daftar Gagal. !!!";
            $return["success"] = FALSE;
        } else {
            if ($error != "") {
                $return["msgServer"] = $error;
                $return["success"] = FALSE;
            } else {
                $return["msgServer"] = "Simpan Data Daftar Berhasil.";
                $return["success"] = TRUE;
            }
        }

        echo json_encode($return);
    }

    function do_Hapus_Daftar() {
        $id_daftar = ($this->input->post("id_daftar") != "") ? $this->input->post("id_daftar") : "";
        $this->Daftar_m->delete($id_daftar);
        if ($this->db->trans_status() === false) {
            $return["msgServer"] = "Maaf, Hapus Data Daftar Gagal.";
            $return["success"] = false;
        } else {
            $return["msgServer"] = "Hapus Data Daftar Berhasil.";
            $return["success"] = true;
        }

        echo json_encode($return);
    }

    function do_Ubah_Daftar() {
        $return = array();
        $itemList = array();
        $id_daftar = ($this->input->post("id_daftar") != "") ? $this->input->post("id_daftar") : "";
        if ($this->Daftar_m->Chek_Data($id_daftar) > 0) {
            $Fields = $this->Daftar_m->List_Data($id_daftar);
            $item = array(
                "mode_form" => "Ubah",
                "id_daftar" => $Fields->id_daftar,
                "nama_daftar" => $Fields->nama_daftar
            );
            $itemList[] = $item;
            $return["success"] = TRUE;
            $return["results"] = $item;
        } else {
            $return["success"] = FALSE;
            $return["msgServer"] = "Maaf, Data Daftar Tidak Ditemukan.";
        }

        echo json_encode($return);
    }

    function histori(){
        $data['namaMenu'] = "Histori Kerusakan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('kerusakan/histori_v', $data);
    }

    function do_Tabel_Histori() {
        $records["aaData"] = array();
        $aColumns = array('id_kerusakan');
        //default
        $sort = "tk.id_kerusakan";
        $dir = "desc";
        $criteria = "";

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
        $iTotalRecords = $this->Kerusakan_m->getCount($criteria, $sSearch);

        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;

        $records["sEcho"] = $sEcho;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;

        $query = $this->Kerusakan_m->get($criteria, $sSearch, $sort, $dir, $iDisplayStart, $iDisplayLength);

        if ($query->num_rows() > 0) {
            $no = $iDisplayStart;
            foreach ($query->result() as $Fields) {
                $no++;
                $records["aaData"][] = array(
                    '<center>' . $no . '.</center>',
                    $Fields->nip_input,
                    $Fields->nama_input,
                    $Fields->jabatan_input,
                    $Fields->nama_kategori,
                    $Fields->nama_kerusakan,
                    $Fields->ket_perbaikan,
                    '<a href="'.base_url().'assets/upload/perbaikan/'.$Fields->gambar_1.'" target="_blank" class="btn btn-xs yellow">Lihat</a>',
                    '<a href="'.base_url().'assets/upload/perbaikan/'.$Fields->gambar_2.'" target="_blank" class="btn btn-xs yellow">Lihat</a>',
                    $Fields->detail_kerusakan,
                    $Fields->tgl_pengecekan,
                    $Fields->nip_proses,
                    $Fields->nama_proses,
                    $Fields->jabatan_proses,
                    '<a href="'.base_url().'assets/upload/perbaikan/'.$Fields->gambar_proses_1.'" target="_blank" class="btn btn-xs yellow">Lihat</a>',
                    '<a href="'.base_url().'assets/upload/perbaikan/'.$Fields->gambar_proses_2.'" target="_blank" class="btn btn-xs yellow">Lihat</a>',
                    $Fields->tgl_proses,
                    $Fields->nip_selesai,
                    $Fields->nama_selesai,
                    $Fields->jabatan_selesai,
                    '<a href="'.base_url().'assets/upload/perbaikan/'.$Fields->gambar_selesai_1.'" target="_blank" class="btn btn-xs yellow">Lihat</a>',
                    '<a href="'.base_url().'assets/upload/perbaikan/'.$Fields->gambar_selesai_2.'" target="_blank" class="btn btn-xs yellow">Lihat</a>',
                    $Fields->tgl_selesai,
                    $Fields->nama_status,
                    $Fields->nama_tingkat,
                    $Fields->nama_satker,
                    $Fields->nama_ppk,
                    '<center><a href="javascript:;" data-id="' . $Fields->id_kerusakan . '" data-name="' . $Fields->id_kerusakan . '" class="btn btn-xs yellow btn-editable"><i class="fa fa-pencil"></i> Ubah</a> '
                    . '<a href="javascript:;" data-id="' . $Fields->id_kerusakan . '" data-name="' . $Fields->id_kerusakan . '" class="btn btn-xs red btn-removable"><i class="fa fa-times"></i> Hapus</a></center>');
            }
        }
        echo json_encode($records);
    }

    function laporan(){
        $data['namaMenu'] = "Laporan Kerusakan";

        $data['parent_id_menu'] = $this->Layout_m->getMenuParent($data['namaMenu']);
        $data['id_menu_'] = $this->Layout_m->checkMenu($data['namaMenu']);

        $data['setMeta'] = $this->Layout_m->setMeta($data['namaMenu']);
        $data['setHeader'] = $this->Layout_m->setHeader();
        $data['setMenu'] = $this->Layout_m->setMenu();
        $data['setFooter'] = $this->Layout_m->setFooter();
        $data['setJS'] = $this->Layout_m->setJS();

        $this->parser->parse('kerusakan/laporan_v', $data);
    }

    function checkLaporan(){
        $tahun = ($this->input->post('tahun') != "") ? $this->input->post('tahun') : "";
        $hasil = $this->db->query("select * from t_kerusakan where EXTRACT(YEAR FROM tgl_ins) = '$tahun'");

        if($hasil->num_rows() > 0){
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function export($tahun){
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
    
        // title dari pdf
        $data['title_pdf'] = 'Laporan Kerusakan Jembatan tahun '.$tahun;

        $data['hasil'] = $this->db->query("
            select tk.id_kerusakan, tk.id_user id_input, mu.nip nip_input, mu.nama_lengkap nama_input, mu.no_hp hp_input, mjp.nama_jabatan jabatan_input, tk.id_kategori, mk.kode_kategori, mk.nama_kategori, tk.id_perbaikan, mp.kode_kerusakan, mp.nama_kerusakan, mp.ket_perbaikan, mp.marker, tk.gambar_1, tk.gambar_2, tk.tgl_pengecekan, tk.detail_kerusakan,
            tk.id_user_proses, mu2.nip nip_proses, mu2.nama_lengkap nama_proses, mu2.no_hp hp_proses, mjpp.nama_jabatan jabatan_proses, tk.gambar_proses_1, tk.gambar_proses_2, tk.tgl_proses,
            tk.id_user_selesai, mu3.nip nip_selesai, mu3.nama_lengkap nama_selesai, mu3.no_hp hp_selesai, mjs.nama_jabatan jabatan_selesai, tk.gambar_selesai_1, tk.gambar_selesai_2, tk.tgl_selesai,
            ms2.id_status, ms2.nama_status, tk.id_tingkat, mt.nama_tingkat, ms.id_satker, ms.kode_satker, ms.nama_satker, mp2.id_ppk, mp2.kode_ppk, mp2.nama_ppk, tk.lat, tk.lng, tk.tgl_ins 
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
            WHERE EXTRACT(YEAR FROM tgl_ins) = $tahun
        ");
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Laporan Kerusakan Jembatan tahun '.$tahun;
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";
        
        $html = $this->load->view('kerusakan/laporan_pdf', $data, true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);

        header('Content-type: application/pdf');
    }
}