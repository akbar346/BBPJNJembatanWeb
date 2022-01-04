<?php

class Utility_m extends CI_Model {

    var $MAX_RECORD = 10;
    var $EXP_TIME = 3600;
    var $BATAS_RETUR = 1;

    function dataPerijinan($tgl_dari = "", $tgl_sampai = "", $jk = "", $status = "") {
        $tglDari = date_format(date_create($tgl_dari), 'Y-m-d');
        $tglSampai = date_format(date_create($tgl_sampai), 'Y-m-d');
        $Sql = "select a.*, b.jk, c.namajenisijin from tijin a
                left join tsantri b on a.noinduk=b.noinduk
                left join mjenisijin c on a.idjenisijin=c.idjenisijin
                where (a.tgldari between '" . $tglDari . "' and '" . $tglSampai . "') or (a.tglsampai between '" . $tglDari . "' and '" . $tglSampai . "')";
        if ($jk != "") {
            $Sql .= " and b.jk='" . $jk . "'";
        }
        if ($status == "Setujui") {
            $Sql .= " and a.tglsetujui is not null";
        } elseif ($status == "Kembali") {
            $Sql .= " and a.stkembali=true";
        } elseif ($status == "Terlambat") {
            $Sql .= " and a.stterlambat=true";
        }

        return $this->db->query($Sql);
    }

    function getDataComboBoxKategori($id_label = "", $id_selected = "") {
        $options = array();
        $items = array();
        $this->db->order_by("idkategori", "asc");
        $query = $this->db->get('mkategori');
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $i++;
                if ($i == 1) {
                    $items[""] = "";
                }
                $items[$row->idkategori] = $row->namakategori;
            }
            $options = $items;
        }
        return form_dropdown($id_label, $options, $id_selected, 'id ="' . $id_label . '" Class="select2me form-control" data-placeholder="Pilih Kategori..."');
    }

    function getIntToTime($angka = "") {
        if (strlen($angka) == 3) {
            $jam = substr($angka, 0, 1) . ":" . substr($angka, 1, 2);
        } else {
            $jam = substr($angka, 0, 2) . ":" . substr($angka, 2, 2);
        }
        return $jam;
    }

    function cek_Kuota($noinduk) {
        $blnSkrang = date('Y-m');
        $Sql = "select a.*, coalesce(b.pakai, 0) as pakai, c.tgl_max::int from tsantri a
                left join (select idsantri, count(idsantri) as pakai from hmakan where to_char(tglins, 'yyyy-mm')='" . $blnSkrang . "' group by idsantri) b on a.idsantri=b.idsantri
                left join (select to_char((date_trunc('month', '" . $blnSkrang . "-01'::date) + interval '1 month' - interval '1 day')::date, 'dd') AS tgl_max) c on 1=1
                where a.noinduk='" . $noinduk . "' or a.rfid='" . $noinduk . "'";
        return $this->db->query($Sql);
    }

    function generate_captcha($parm) {
        $this->load->helper("captcha");

        $vals = array('img_path' => './assets/captcha/',
            'img_url' => base_url() . 'assets/captcha/',
            'img_width' => '200',
            'img_height' => '37',
            // 'font_path' => './system/fonts/verdanab.ttf',
            'expiration' => $this->EXP_TIME
        );
        $cap = create_captcha($vals);

        $data = array(
// "captcha_id" => $this->GenId('captcha_id', 'c_captcha'),
            "capcha_time" => $cap['time'],
            "ip_address" => $this->input->ip_address(),
            "word" => $cap['word'],
        );

        $this->db->insert("c_captcha", $data);

        if ($parm == 'word') {
            return $cap['word'];
        } elseif ($parm == 'image') {
            return $cap['image'];
        }
    }

    function valid_captcha($word) {
        $expiration = time() - $this->EXP_TIME;
        $this->db->where('capcha_time <', $expiration);
        $this->db->delete('c_captcha');

        $this->db->where('word', $word);
        $this->db->where('ip_address', $this->input->ip_address());
        $this->db->where('capcha_time >', $expiration);
        $query = $this->db->get('c_captcha');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getHurufKapital($string) {
        return ucwords(strtolower($string));
    }

    function getTahunComboBox($id_label, $tahun) {

        for ($i = -1; $i < 3; $i++) {
            $items[date("Y", mktime(0, 0, 0, date("m"), date("d"), date("Y") + $i))] = date("Y", mktime(0, 0, 0, date("m"), date("d"), date("Y") + $i));
        }
        $options = $items;

        return form_dropdown($id_label, $options, $tahun, 'id ="' . $id_label . '" Class="select2me form-control"');
    }

    function GenId($nama_field, $nama_tabel) {
        $Id = 0;
        $this->db->select_max($nama_field, 'JML');
        $query = $this->db->get($nama_tabel);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $Id = $row->JML;
            return ($Id + 1);
        }
    }

    function EncryptPasswd($value) {
        $salt = '#*seCrEt!@-*%';
        $str = do_hash($salt . $value);
        $str = do_hash($salt . $str, 'md5');
        return $str;
    }

    function Gen_Kode_Verifikasi($value) {
        $salt = '#*seCrEt!@-*%';
        $str = do_hash($salt . $value);
        $str = substr(do_hash($salt . $str, 'md5'), 0, 4); // 6 digit
        return $str;
    }

    function date_to_dbpostgres($date, $type, $format = "") {
        $new_date = "";
        $tmp_date_format = "";
        $tmp_date = explode(" ", $date);

        if (count($tmp_date) > 1) {  // Format Date Time
            $tmp_date_format = explode("-", $tmp_date[0]);

            if ($format == "dt") {
                if ($type == "db") {
                    $tmp_date = $tmp_date_format[2] . "-" . $tmp_date_format[1] . "-" . $tmp_date_format[0] . " " . $tmp_date[1] . "";
                } elseif ($type == "human") {
                    $tmp_date = $tmp_date_format[2] . "-" . $tmp_date_format[1] . "-" . $tmp_date_format[0] . " " . $tmp_date[1] . "";
                }
            } elseif ($format == "t") {
                if ($type == "db") {
                    $tmp_date = $tmp_date[1];
                } elseif ($type == "human") {
                    $tmp_date = $tmp_date[1];
                }
            } else {
                if ($type == "db") {
                    $tmp_date = $tmp_date_format[2] . "-" . $tmp_date_format[1] . "-" . $tmp_date_format[0];
                } elseif ($type == "human") {
                    $tmp_date = $tmp_date_format[2] . "-" . $tmp_date_format[1] . "-" . $tmp_date_format[0];
                }
            }
        } else {  // Format Date
            $tmp_date_format = explode("-", $tmp_date[0]);
            if ($type == "db") {
                $tmp_date = $tmp_date_format[2] . "-" . $tmp_date_format[1] . "-" . $tmp_date_format[0];
            } elseif ($type == "human") {
                $tmp_date = $tmp_date_format[2] . "-" . $tmp_date_format[1] . "-" . $tmp_date_format[0];
            }
        }
        $new_date = $tmp_date;

        return $new_date;
    }

    function ConvertTGL($valueTgl) {
        $tgl = explode("-", $valueTgl);

        switch ($tgl[1]) {
            case "01" : $bulan = "Januari";
                break;
            case "02" : $bulan = "Februari";
                break;
            case "03" : $bulan = "Maret";
                break;
            case "04" : $bulan = "April";
                break;
            case "05" : $bulan = "Mei";
                break;
            case "06" : $bulan = "Juni";
                break;
            case "07" : $bulan = "Juli";
                break;
            case "08" : $bulan = "Agustus";
                break;
            case "09" : $bulan = "September";
                break;
            case "10" : $bulan = "Oktober";
                break;
            case "11" : $bulan = "November";
                break;
            case "12" : $bulan = "Desember";
                break;
        }
        $str = $tgl[0] . "-" . $bulan . "-" . $tgl[2];
        return $str;
    }

    function ConvertBulan($valuebulan) {

        switch ($valuebulan) {
            case "01" : $bulan = "Januari";
                break;
            case "02" : $bulan = "Februari";
                break;
            case "03" : $bulan = "Maret";
                break;
            case "04" : $bulan = "April";
                break;
            case "05" : $bulan = "Mei";
                break;
            case "06" : $bulan = "Juni";
                break;
            case "07" : $bulan = "Juli";
                break;
            case "08" : $bulan = "Agustus";
                break;
            case "09" : $bulan = "September";
                break;
            case "10" : $bulan = "Oktober";
                break;
            case "11" : $bulan = "November";
                break;
            case "12" : $bulan = "Desember";
                break;
        }
        $str = $bulan;
        return $str;
    }

    function ConvertBulan_Romawi($valuebulan) {

        switch ($valuebulan) {
            case "01" : $bulan = "I";
                break;
            case "02" : $bulan = "II";
                break;
            case "03" : $bulan = "III";
                break;
            case "04" : $bulan = "IV";
                break;
            case "05" : $bulan = "V";
                break;
            case "06" : $bulan = "VI";
                break;
            case "07" : $bulan = "VII";
                break;
            case "08" : $bulan = "VIII";
                break;
            case "09" : $bulan = "IX";
                break;
            case "10" : $bulan = "X";
                break;
            case "11" : $bulan = "XI";
                break;
            case "12" : $bulan = "XII";
                break;
        }
        $str = $bulan;
        return $str;
    }

    function ConvertNamaHari($tanggal) {
//$tanggal = "2014-11-11"; // tgl yang akan dicari nama harinya
        $tmp = explode('-', $tanggal);
        $tmp2 = explode(' ', $tmp[2]);

        $tgl = mktime(0, 0, 0, $tmp[1], $tmp2[0], $tmp[0]);
        $namahari = date("l", $tgl);

        if ($namahari == "Sunday")
            $namahari = "Minggu";
        else if ($namahari == "Monday")
            $namahari = "Senin";
        else if ($namahari == "Tuesday")
            $namahari = "Selasa";
        else if ($namahari == "Wednesday")
            $namahari = "Rabu";
        else if ($namahari == "Thursday")
            $namahari = "Kamis";
        else if ($namahari == "Friday")
            $namahari = "Jumat";
        else if ($namahari == "Saturday")
            $namahari = "Sabtu";

        return $namahari;
    }

    function cetak_header($pdf) {

        $query = $this->db->get_where('c_infosetting', array('id_info' => "1"));

        if ($query->num_rows() > 0) {
            $Fields = $query->row();
            $nama_perusahaan = ($Fields->nama_perusahaan != "") ? $Fields->nama_perusahaan : "";
            $alamat_perusahaan = ($Fields->alamat_perusahaan != "") ? $Fields->alamat_perusahaan : "";
            $no_tlpn = ($Fields->no_tlpn != "") ? "Tlp : " . $Fields->no_tlpn : "";
            $no_fax = ($Fields->no_fax != "") ? "Fax : " . $Fields->no_fax : "";
            $nama_email = ($Fields->nama_email != "") ? $Fields->nama_email : "";
            $nama_website = ($Fields->nama_website != "") ? "\nhttp://" . $Fields->nama_website : "";
            $namafile_logo = ($Fields->namafile_logo != "") ? $Fields->namafile_logo : "";
        }

// set default header data10
        if ($namafile_logo) {
            $pdf->SetHeaderData('../../../../assets/images/' . $namafile_logo . '', 14, NAMA_APLIKASI . ", " . $nama_perusahaan, $alamat_perusahaan . ", " . $no_tlpn . ", " . $no_fax . "\nWeb : " . $nama_website . "   Email : " . $nama_email);
        } else {
            $pdf->SetHeaderData('', '', "" . $nama_perusahaan, $alamat_perusahaan . " " . $no_tlpn . "  " . $no_fax . " " . $nama_website . "    " . $nama_email);
        }
// set header and footer fonts
        $pdf->setHeaderFont(Array('helvetica', '', 10));

//set margins
        $pdf->SetMargins(4, PDF_MARGIN_TOP, 4);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    }

    function print_footer() {
        $query = $this->db->get_where('c_infosetting', array('id_info' => "1"));

        if ($query->num_rows() > 0) {
            $Fields = $query->row();
            $nama_perusahaan = ($Fields->nama_perusahaan != "") ? $Fields->nama_perusahaan : "";
            $alamat_perusahaan = ($Fields->alamat_perusahaan != "") ? $Fields->alamat_perusahaan : "";
            $no_tlpn = ($Fields->no_tlpn != "") ? $Fields->no_tlpn : "";
            $no_fax = ($Fields->no_fax != "") ? $Fields->no_fax : "";
            $nama_email = ($Fields->nama_email != "") ? $Fields->nama_email : "";
            $nama_website = ($Fields->nama_website != "") ? $Fields->nama_website : "";
            $namafile_logo = ($Fields->namafile_logo != "") ? $Fields->namafile_logo : "";
        }

        $html = $nama_perusahaan;
        return $html;
    }

    function setNumberSystem($v) {
        $harga = explode(".", $v);
        if ($harga[0] != "") {
            $ch = str_replace(".", "", $v);
            $har = explode(",", $ch);
            if ($har[0] != "") {
                $ch = str_replace(",", ".", $ch);
            }
            $v = $ch;
        }
        return $v;
    }

    function Chek_Data_Session($Data_Session = "") {
        @session_start();
        if (!isset($_SESSION[$Data_Session])) {
            $status = false;
        } else {

            $DetSession = $_SESSION[$Data_Session];
            $jml = 0;
            foreach ($DetSession as $i => $v) {
                if ($DetSession[$i]["mode_item"] != "D") {
                    $jml++;
                }
            }
            if ($jml > 0) {
                $status = true;
            } else {
                $status = false;
            }
        }

        return $status;
    }

    function Check_Authorisasi() {
        $fleg = false;
        $logged_bpfk = $this->session->userdata("logged_bpfk");
        if ($logged_bpfk === FALSE) {
            redirect(site_url(), "refresh");
        } else {
            $id_akses = $this->session->userdata("id_akses");
            if ($id_akses == "3") {
                $fleg = false;
            } else {
                $fleg = true;
            }
        }
        return $fleg;
    }

    function Terbilang($x) {
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12)
            return " " . $abil[$x];
        elseif ($x < 20)
            return $this->Terbilang($x - 10) . "belas";
        elseif ($x < 100)
            return $this->Terbilang($x / 10) . " puluh" . $this->Terbilang($x % 10);
        elseif ($x < 200)
            return " seratus" . $this->Terbilang($x - 100);
        elseif ($x < 1000)
            return $this->Terbilang($x / 100) . " ratus" . $this->Terbilang($x % 100);
        elseif ($x < 2000)
            return " seribu" . $this->Terbilang($x - 1000);
        elseif ($x < 1000000)
            return $this->Terbilang($x / 1000) . " ribu" . $this->Terbilang($x % 1000);
        elseif ($x < 1000000000)
            return $this->Terbilang($x / 1000000) . " juta" . $this->Terbilang($x % 1000000);
        else
            return $x;
    }

    function FileSizeConvert($bytes) {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    function TambahBoleanString($jml, $array_string) {
        $tmp = "";
        for ($i = 0; $i <= $jml; $i++) {
            $j = false;
            foreach (explode(",", $array_string) as $v) {
                if ($i == $v) {
                    $j = true;
                    if ($i == 0) {
                        $tmp .= 't';
                    } else {
                        $tmp .= ',t';
                    }
                }
            }
            if ($j == false) {
                if ($i == 0) {
                    $tmp .= 'f';
                } else {
                    $tmp .= ',f';
                }
            }
        }
        return $tmp;
    }

    function Format_TglSurat($tgl_ins = "", $format = "") {
        $tgl_surat = "";
        $tmp = explode('-', $tgl_ins);
        $tgl = explode(' ', $tmp[2]);

        if ($format == 'd') {
            $tgl_surat = $tgl[0] . ' ' . $this->ConvertBulan($tmp[1]) . ' ' . $tmp[0];
        } else if ($format == 't') {
            $jam = explode(':', $tgl[1]);
            $tgl_surat = $jam[0] . ':' . $jam[1];
        }

        return $tgl_surat;
    }

    function Format_NIP($nip) {

        $tmp1 = substr($nip, 0, 8);
        $tmp2 = substr($nip, 8, 6);
        $tmp3 = substr($nip, 14, 1);
        $tmp4 = substr($nip, -3);

        return $tmp1 . ' ' . $tmp2 . ' ' . $tmp3 . ' ' . $tmp4;
    }

    function ReadBoleanString($string) {
        $array_string = str_replace(array("{", "}"), "", $string);

        $no = 0;
        $tmp_string = array();
        foreach (explode(",", $array_string) as $v) {

            if ($v == 't') {
                $tmp_string[] = "$no";
            }
            $no++;
        }
        return $tmp_string;
    }

    function Data_Setting() {
        $query = $this->db->get_where('c_setting', array('id_setting' => "1"));

        return $query->row();
    }

    function Format_jabatan($jabatan = "", $unit_kerja = "") {

        if ($jabatan == "WALIKOTA") {
            $tmp_jabatan = "WALIKOTA BATU";
            return $tmp_jabatan;
        }

        if ($jabatan == "WAKIL WALIKOTA") {
            $tmp_jabatan = "WAKIL WALIKOTA BATU";
            return $tmp_jabatan;
        }

        if ($jabatan == "SEKRETARIS" && $unit_kerja == "SEKRETARIS DAERAH") {
            $tmp_jabatan = "SEKRETARIS DAERAH";
            return $tmp_jabatan;
        }

        if ($jabatan == "SEKRETARIS" && $unit_kerja != "SEKRETARIS DAERAH") {
            if ($unit_kerja == "SEKRETARIS") {
                $tmp_jabatan = "SEKRETARIS ";
            } else {
                $tmp_jabatan = "SEKRETARIS " . $unit_kerja;
            }

            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA" && $unit_kerja == "ASISTEN ADMINISTRASI UMUM") {
            $tmp_jabatan = "ASISTEN ADMINISTRASI UMUM";
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA" && $unit_kerja == "ASISTEN PEMERINTAHAN DAN PEMBANGUNAN") {
            $tmp_jabatan = "ASISTEN PEMERINTAHAN DAN PEMBANGUNAN";
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA" && $unit_kerja == "INSPEKTORAT") {
            $tmp_jabatan = "INSPEKTUR";
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA BAGIAN") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA SUB BAGIAN") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA DINAS") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA BIDANG") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA BADAN") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA KANTOR") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        $pieces = explode(" ", $unit_kerja);

        if ($jabatan == "KEPALA LURAH") {
            $tmp_jabatan = "LURAH " . $pieces[1];

            return $tmp_jabatan;
        }

        if ($jabatan == "KEPALA SEKSI") {
            $tmp_jabatan = "KEPALA " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "CAMAT") {
            $tmp_jabatan = "CAMAT " . $pieces[1];
            return $tmp_jabatan;
        }

        if ($jabatan == "SEKRETARIS CAMAT") {
            $tmp_jabatan = "SEKRETARIS CAMAT " . $unit_kerja;
            return $tmp_jabatan;
        }

        if ($jabatan == "SEKSI CAMAT") {
            $tmp_jabatan = "SEKSI CAMAT " . $unit_kerja;
            return $tmp_jabatan;
        }
    }

    function Format_penerima($skpd_penerima) {

        $pieces = explode(" ", $skpd_penerima);

        if ($skpd_penerima == "WALIKOTA BATU") {
            $tmp_penerima = "WALIKOTA";
            return $tmp_penerima;
        } elseif ($skpd_penerima == "SEKRETARIAT DAERAH") {
            $tmp_penerima = "SEKRETARIS DAERAH";
            return $tmp_penerima;
        } elseif ($skpd_penerima == "ASISTEN ADMINISTRASI UMUM") {
            $tmp_penerima = $skpd_penerima;
            return $tmp_penerima;
        } elseif ($skpd_penerima == "ASISTEN PEMERINTAHAN DAN PEMBANGUNAN") {
            $tmp_penerima = $skpd_penerima;
            return $tmp_penerima;
        } elseif ($skpd_penerima == "SEKRETARIAT DEWAN PERWAKILAN RAKYAT DAERAH") {
            $tmp_penerima = "SEKRETARIS DPRD";
            return $tmp_penerima;
        } elseif ($skpd_penerima == "KOMISI PEMILIHAN UMUM (KPU) KOTA BATU") {
            $tmp_penerima = "SEKRETARIS KOMISI PEMILIHAN UMUM (KPU) KOTA BATU";
            return $tmp_penerima;
        } elseif ($skpd_penerima == "INSPEKTORAT") {
            $tmp_penerima = "INSPEKTUR";
            return $tmp_penerima;
        } elseif ($pieces[0] == "KECAMATAN") {
            $tmp_penerima = "CAMAT " . $pieces[1];
            return $tmp_penerima;
        } elseif ($pieces[0] == "KELURAHAN") {
            $tmp_penerima = "LURAH " . $pieces[1];
            return $tmp_penerima;
        } else {
            $tmp_penerima = "Kepala " . $skpd_penerima;
            return $tmp_penerima;
        }
    }

}

/* End of file UtilityM.php */
    /* Location: ./application/models/Utility_m.php */
    








