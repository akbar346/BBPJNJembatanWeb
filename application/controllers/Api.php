<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
    function __construct() {
        parent::__construct();
    }

    function do_login() {
        $nip = ($this->input->post("nip") != "") ? $this->input->post("nip") : "";
        $passwd = ($this->input->post("passwd") != "") ? md5($this->input->post("passwd")) : "";

        $Fields = $this->db->query("
            select mu.id_user, mu.nip, mu.nama_lengkap, mu.email, mu.no_hp, mu.id_jabatan, mj.nama_jabatan, mp.id_ppk, mp.kode_ppk, mp.nama_ppk, ms.id_satker, ms.kode_satker, ms.nama_satker from m_user mu
            inner join m_jabatan mj on mu.id_jabatan = mj.id_jabatan 
            inner join m_ppk mp on mu.id_ppk = mp.id_ppk
            inner join m_satker ms on mu.id_satker = ms.id_satker
            where mu.nip = '$nip' AND passwd = '$passwd'
        ")->row();

        if (!empty($Fields)) {
            $id_jabatan = $Fields->id_jabatan;
            if($id_jabatan == 3 || $id_jabatan == 4 || $id_jabatan == 5){
                $return["success"] = TRUE;
                $return["pesan"] = "Selamat Datang " . $Fields->nama_lengkap;
                $return["id_user"] = $Fields->id_user;
                $return["nama_lengkap"] = $Fields->nama_lengkap;
                $return["email"] = $Fields->email;
                $return["no_hp"] = $Fields->no_hp;
                $return["nip"] = $Fields->nip;
                $return["id_jabatan"] = $id_jabatan;
                $return["nama_jabatan"] = $Fields->nama_jabatan;
                $return["id_ppk"] = $Fields->id_ppk;
                $return["kode_ppk"] = $Fields->kode_ppk;
                $return["nama_ppk"] = $Fields->nama_ppk;
                $return["id_satker"] = $Fields->id_satker;
                $return["kode_satker"] = $Fields->kode_satker;
                $return["nama_satker"] = $Fields->nama_satker;
            }else{
                $return["success"] = FALSE;
                $return["message"] = "Anda tidak memiliki akses diaplikasi ini. !!!";
            }
        } else {
            $return["success"] = FALSE;
            $return["message"] = "NIP dan Password salah. !!!";
        }

        echo json_encode($return);
    }

    function do_ubah_passwd() {
        $id_user = ($this->input->post("id_user") != "") ? $this->input->post("id_user") : "";
        $passwd_lama = ($this->input->post("passwd_lama") != "") ? $this->input->post("passwd_lama") : "";
        $passwd_baru = ($this->input->post("passwd_baru") != "") ? $this->input->post("passwd_baru") : "";

        $do_cek_passwd = $this->Api_m->do_cek_passwd($id_user, $passwd_lama);
        if ($do_cek_passwd->num_rows() > 0) {
            $this->Api_m->do_ubah_passwd($id_user, $passwd_baru);

            $return["success"] = "TRUE";
            $return["pesan"] = "Ubah Password Berhasil.";
        } else {
            $return["success"] = "FALSE";
            $return["pesan"] = "Password Lama yang dimasukkan salah..!!!";
        }

        echo json_encode($return);
    }

    function do_reset() {
        $nip = ($this->input->post("nip") != "") ? $this->input->post("nip") : "";
        $email = ($this->input->post("email") != "") ? $this->input->post("email") : "";

        $do_cek_akun = $this->Api_m->do_cek_akun_reset($nip, $email);
        if ($do_cek_akun->num_rows() > 0) {
            $id_user = $do_cek_akun->row()->id_user;
            $passwd = $this->GenPassword();

            $this->Api_m->do_update_passwd($id_user, $passwd);
            $this->Api_m->send_email_reset($id_user, $passwd);

            $return["success"] = "TRUE";
            $return["pesan"] = "Reset Kata Sandi berhasil. Silahkan cek email untuk password terbaru";
        } else {
            $return["success"] = "FALSE";
            $return["pesan"] = "NIP atau Email yang dimasukkan salah..!!!";
        }

        echo json_encode($return);
    }

    function GenPassword() {
        $length = 6;
        $characters = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    function status(){
        $hasil = $this->Data_m->GetData('m_status','id_status','ASC');

        if (!empty($hasil)) {
            foreach ($hasil as $r) {
                $item[] = array(
                    "id_status" => $r->id_status,
                    "nama_status" => $r->nama_status
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function tingkat(){
        $hasil = $this->Data_m->GetData('m_tingkat','id_tingkat','ASC');

        if (!empty($hasil)) {
            foreach ($hasil as $r) {
                $item[] = array(
                    "id_tingkat" => $r->id_tingkat,
                    "nama_tingkat" => $r->nama_tingkat
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function kategori_kerusakan(){
        $hasil = $this->Data_m->GetData('m_kategori','id_kategori','ASC');

        if (!empty($hasil)) {
            foreach ($hasil as $r) {
                $item[] = array(
                    "id_kategori" => $r->id_kategori,
                    "kode_kategori" => $r->kode_kategori,
                    "nama_kategori" => $r->nama_kategori
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    // Jenis Kerusakann
    function jenis_kerusakan(){
        $id_kategori = ($this->input->post('id_kategori') != "") ? $this->input->post('id_kategori') : "";
        $hasil = $this->Data_m->GetId('m_perbaikan',array('id_kategori'=>$id_kategori));

        if ($hasil->num_rows() > 0) {
            foreach ($hasil->result() as $r) {
                $item[] = array(
                    "id_perbaikan" => $r->id_perbaikan,
                    "kode_kerusakan" => $r->kode_kerusakan,
                    "id_kategori" => $r->id_kategori,
                    "nama_kerusakan" => $r->nama_kerusakan,
                    "ket_perbaikan" => $r->ket_perbaikan
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

     //  Data Post
     function tambah_PenilikJalan(){
        $gambar1 = ($this->input->post("gambar_1") != "") ? $this->input->post("gambar_1") : "";
        $gambar2 = ($this->input->post("gambar_2") != "") ? $this->input->post("gambar_2") : "";
        $lokasi_file = "./assets/upload/perbaikan/";

        date_default_timezone_set('Asia/Jakarta');
        if(!empty($gambar1)){
            $nama_file1 = "rusak1" . date('d_m_Y_h_i_s') . ".jpg";
        }else{
            $nama_file1 = "";
        }
        if(!empty($gambar2)){
            $nama_file2 = "rusak2" . date('d_m_Y_h_i_s') . ".jpg";
        }else{
            $nama_file2 = "";
        }
        $path1 = $lokasi_file . $nama_file1;
        $path2 = $lokasi_file . $nama_file2;

        $data = array(
            'id_user' => ($this->input->post('id_user') != "") ? $this->input->post('id_user') : "",
            'id_kategori' => ($this->input->post('id_kategori') != "") ? $this->input->post('id_kategori') : "",
            'id_perbaikan' => ($this->input->post('id_perbaikan') != "") ? $this->input->post('id_perbaikan') : "",
            'id_tingkat' => ($this->input->post('id_tingkat') != "") ? $this->input->post('id_tingkat') : "",
            'gambar_1' => $nama_file1,
            'gambar_2' => $nama_file2,
            'tgl_pengecekan' => date("Y-m-d H:i"),
            'detail_kerusakan' => ($this->input->post('detail_kerusakan') != "") ? $this->input->post('detail_kerusakan') : "",
            'status' => 1,
            'lat' => ($this->input->post('lat') != "") ? $this->input->post('lat') : "",
            'lng' => ($this->input->post('lng') != "") ? $this->input->post('lng') : "",
            'id_satker' => ($this->input->post('id_satker') != "") ? $this->input->post('id_satker') : "",
            'id_ppk' => ($this->input->post('id_ppk') != "") ? $this->input->post('id_ppk') : ""
        );

        $this->Data_m->Add('t_kerusakan', $data);

        if ($this->db->trans_status() === FALSE) {
            $msg['success'] = FALSE;
            $msg['message'] = 'Data gagal disimpan';
        } else {
            if(!empty($gambar1)){
                file_put_contents($path1, base64_decode($gambar1));
                $msg['success'] = TRUE;
                $msg['message'] = 'Data berhasil disimpan';
            }
            if(!empty($gambar2)){
                file_put_contents($path2, base64_decode($gambar2));
                $msg['success'] = TRUE;
                $msg['message'] = 'Data berhasil disimpan';
            }
            $msg['success'] = TRUE;
            $msg['message'] = 'Data berhasil disimpan';
        }
        echo json_encode($msg);
    }

    function penilikJalanMapsPegawai(){
        $id_user = ($this->input->post('id_user') != "") ? $this->input->post('id_user') : "";
        $limit = ($this->input->post('limit') != "") ? $this->input->post('limit') : "";
        $offset = ($this->input->post('offset') != "") ? $this->input->post('offset') : "";;
        $hasil = $this->Data_m->GetDataJalanMaps('tk.id_user', $id_user, $limit, $offset);
        
        if ($hasil->num_rows() > 0) {
            foreach ($hasil->result() as $r) {
                $item[] = array(
                    "id_kerusakan" => $r->id_kerusakan,
                    "id_input" => $r->id_input,
                    "nip_input" => $r->nip_input,
                    "nama_input" => $r->nama_input,
                    "hp_input" => $r->hp_input,
                    "jabatan_input" => $r->jabatan_input,
                    "id_kategori" => $r->id_kategori,
                    "kode_kategori" => $r->kode_kategori,
                    "nama_kategori" => $r->nama_kategori,
                    "id_perbaikan" => $r->id_perbaikan,
                    "kode_kerusakan" => $r->kode_kerusakan,
                    "nama_kerusakan" => $r->nama_kerusakan,
                    "ket_perbaikan" => $r->ket_perbaikan,
                    "marker" => $r->marker,
                    "gambar_1" => $r->gambar_1,
                    "gambar_2" => $r->gambar_2,
                    "tgl_pengecekan" => $r->tgl_pengecekan,
                    "detail_kerusakan" => $r->detail_kerusakan,
                    "id_user_proses" => $r->id_user_proses,
                    "nip_proses" => $r->nip_proses,
                    "nama_proses" => $r->nama_proses,
                    "hp_proses" => $r->hp_proses,
                    "jabatan_proses" => $r->jabatan_proses,
                    "gambar_proses_1" => $r->gambar_proses_1,
                    "gambar_proses_2" => $r->gambar_proses_2,
                    "tgl_proses" => $r->tgl_proses,
                    "id_user_selesai" => $r->id_user_selesai,
                    "nip_selesai" => $r->nip_selesai,
                    "nama_selesai" => $r->nama_selesai,
                    "hp_selesai" => $r->hp_selesai,
                    "jabatan_selesai" => $r->jabatan_selesai,
                    "gambar_selesai_1" => $r->gambar_selesai_1,
                    "gambar_selesai_2" => $r->gambar_selesai_2,
                    "tgl_selesai" => $r->tgl_selesai,
                    "id_status" => $r->id_status,
                    "nama_status" => $r->nama_status,
                    "id_tingkat" => $r->id_tingkat,
                    "nama_tingkat" => $r->nama_tingkat,
                    "id_satker" => $r->id_satker,
                    "kode_satker" => $r->kode_satker,
                    "nama_satker" => $r->nama_satker,
                    "id_ppk" => $r->id_ppk,
                    "kode_ppk" => $r->kode_ppk,
                    "nama_ppk" => $r->nama_ppk,
                    "lat" => $r->lat,
                    "lng" => $r->lng
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function penilikJalanMapsPpk(){
        $id_ppk = ($this->input->post('id_ppk') != "") ? $this->input->post('id_ppk') : "";
        $limit = ($this->input->post('limit') != "") ? $this->input->post('limit') : "";
        $offset = ($this->input->post('offset') != "") ? $this->input->post('offset') : "";;
        $hasil = $this->Data_m->GetDataJalanMaps('mp2.id_ppk', $id_ppk, $limit, $offset);
        
        if ($hasil->num_rows() > 0) {
            foreach ($hasil->result() as $r) {
                $item[] = array(
                    "id_kerusakan" => $r->id_kerusakan,
                    "id_input" => $r->id_input,
                    "nip_input" => $r->nip_input,
                    "nama_input" => $r->nama_input,
                    "hp_input" => $r->hp_input,
                    "jabatan_input" => $r->jabatan_input,
                    "id_kategori" => $r->id_kategori,
                    "kode_kategori" => $r->kode_kategori,
                    "nama_kategori" => $r->nama_kategori,
                    "id_perbaikan" => $r->id_perbaikan,
                    "kode_kerusakan" => $r->kode_kerusakan,
                    "nama_kerusakan" => $r->nama_kerusakan,
                    "ket_perbaikan" => $r->ket_perbaikan,
                    "marker" => $r->marker,
                    "gambar_1" => $r->gambar_1,
                    "gambar_2" => $r->gambar_2,
                    "tgl_pengecekan" => $r->tgl_pengecekan,
                    "detail_kerusakan" => $r->detail_kerusakan,
                    "id_user_proses" => $r->id_user_proses,
                    "nip_proses" => $r->nip_proses,
                    "nama_proses" => $r->nama_proses,
                    "hp_proses" => $r->hp_proses,
                    "jabatan_proses" => $r->jabatan_proses,
                    "gambar_proses_1" => $r->gambar_proses_1,
                    "gambar_proses_2" => $r->gambar_proses_2,
                    "tgl_proses" => $r->tgl_proses,
                    "id_user_selesai" => $r->id_user_selesai,
                    "nip_selesai" => $r->nip_selesai,
                    "nama_selesai" => $r->nama_selesai,
                    "hp_selesai" => $r->hp_selesai,
                    "jabatan_selesai" => $r->jabatan_selesai,
                    "gambar_selesai_1" => $r->gambar_selesai_1,
                    "gambar_selesai_2" => $r->gambar_selesai_2,
                    "tgl_selesai" => $r->tgl_selesai,
                    "id_status" => $r->id_status,
                    "nama_status" => $r->nama_status,
                    "id_tingkat" => $r->id_tingkat,
                    "nama_tingkat" => $r->nama_tingkat,
                    "id_satker" => $r->id_satker,
                    "kode_satker" => $r->kode_satker,
                    "nama_satker" => $r->nama_satker,
                    "id_ppk" => $r->id_ppk,
                    "kode_ppk" => $r->kode_ppk,
                    "nama_ppk" => $r->nama_ppk,
                    "lat" => $r->lat,
                    "lng" => $r->lng
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function penilikJalanMapsSatker(){
        $id_satker = ($this->input->post('id_satker') != "") ? $this->input->post('id_satker') : "";
        $limit = ($this->input->post('limit') != "") ? $this->input->post('limit') : "";
        $offset = ($this->input->post('offset') != "") ? $this->input->post('offset') : "";;
        $hasil = $this->Data_m->GetDataJalanMaps('ms.id_satker', $id_satker, $limit, $offset);
        
        if ($hasil->num_rows() > 0) {
            foreach ($hasil->result() as $r) {
                $item[] = array(
                    "id_kerusakan" => $r->id_kerusakan,
                    "id_input" => $r->id_input,
                    "nip_input" => $r->nip_input,
                    "nama_input" => $r->nama_input,
                    "hp_input" => $r->hp_input,
                    "jabatan_input" => $r->jabatan_input,
                    "id_kategori" => $r->id_kategori,
                    "kode_kategori" => $r->kode_kategori,
                    "nama_kategori" => $r->nama_kategori,
                    "id_perbaikan" => $r->id_perbaikan,
                    "kode_kerusakan" => $r->kode_kerusakan,
                    "nama_kerusakan" => $r->nama_kerusakan,
                    "ket_perbaikan" => $r->ket_perbaikan,
                    "marker" => $r->marker,
                    "gambar_1" => $r->gambar_1,
                    "gambar_2" => $r->gambar_2,
                    "tgl_pengecekan" => $r->tgl_pengecekan,
                    "detail_kerusakan" => $r->detail_kerusakan,
                    "id_user_proses" => $r->id_user_proses,
                    "nip_proses" => $r->nip_proses,
                    "nama_proses" => $r->nama_proses,
                    "hp_proses" => $r->hp_proses,
                    "jabatan_proses" => $r->jabatan_proses,
                    "gambar_proses_1" => $r->gambar_proses_1,
                    "gambar_proses_2" => $r->gambar_proses_2,
                    "tgl_proses" => $r->tgl_proses,
                    "id_user_selesai" => $r->id_user_selesai,
                    "nip_selesai" => $r->nip_selesai,
                    "nama_selesai" => $r->nama_selesai,
                    "hp_selesai" => $r->hp_selesai,
                    "jabatan_selesai" => $r->jabatan_selesai,
                    "gambar_selesai_1" => $r->gambar_selesai_1,
                    "gambar_selesai_2" => $r->gambar_selesai_2,
                    "tgl_selesai" => $r->tgl_selesai,
                    "id_status" => $r->id_status,
                    "nama_status" => $r->nama_status,
                    "id_tingkat" => $r->id_tingkat,
                    "nama_tingkat" => $r->nama_tingkat,
                    "id_satker" => $r->id_satker,
                    "kode_satker" => $r->kode_satker,
                    "nama_satker" => $r->nama_satker,
                    "id_ppk" => $r->id_ppk,
                    "kode_ppk" => $r->kode_ppk,
                    "nama_ppk" => $r->nama_ppk,
                    "lat" => $r->lat,
                    "lng" => $r->lng
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function penilikJalanMapsId(){
        $id_kerusakan = ($this->input->post('id_kerusakan') != "") ? $this->input->post('id_kerusakan') : "";
        $limit = ($this->input->post('limit') != "") ? $this->input->post('limit') : "";
        $offset = ($this->input->post('offset') != "") ? $this->input->post('offset') : "";;
        $hasil = $this->Data_m->GetDataJalanMaps('tk.id_kerusakan', $id_kerusakan, $limit, $offset);
        
        if ($hasil->num_rows() > 0) {
            foreach ($hasil->result() as $r) {
                $item[] = array(
                    "id_kerusakan" => $r->id_kerusakan,
                    "id_input" => $r->id_input,
                    "nip_input" => $r->nip_input,
                    "nama_input" => $r->nama_input,
                    "hp_input" => $r->hp_input,
                    "jabatan_input" => $r->jabatan_input,
                    "id_kategori" => $r->id_kategori,
                    "kode_kategori" => $r->kode_kategori,
                    "nama_kategori" => $r->nama_kategori,
                    "id_perbaikan" => $r->id_perbaikan,
                    "kode_kerusakan" => $r->kode_kerusakan,
                    "nama_kerusakan" => $r->nama_kerusakan,
                    "ket_perbaikan" => $r->ket_perbaikan,
                    "marker" => $r->marker,
                    "gambar_1" => $r->gambar_1,
                    "gambar_2" => $r->gambar_2,
                    "tgl_pengecekan" => $r->tgl_pengecekan,
                    "detail_kerusakan" => $r->detail_kerusakan,
                    "id_user_proses" => $r->id_user_proses,
                    "nip_proses" => $r->nip_proses,
                    "nama_proses" => $r->nama_proses,
                    "hp_proses" => $r->hp_proses,
                    "jabatan_proses" => $r->jabatan_proses,
                    "gambar_proses_1" => $r->gambar_proses_1,
                    "gambar_proses_2" => $r->gambar_proses_2,
                    "tgl_proses" => $r->tgl_proses,
                    "id_user_selesai" => $r->id_user_selesai,
                    "nip_selesai" => $r->nip_selesai,
                    "nama_selesai" => $r->nama_selesai,
                    "hp_selesai" => $r->hp_selesai,
                    "jabatan_selesai" => $r->jabatan_selesai,
                    "gambar_selesai_1" => $r->gambar_selesai_1,
                    "gambar_selesai_2" => $r->gambar_selesai_2,
                    "tgl_selesai" => $r->tgl_selesai,
                    "id_status" => $r->id_status,
                    "nama_status" => $r->nama_status,
                    "id_tingkat" => $r->id_tingkat,
                    "nama_tingkat" => $r->nama_tingkat,
                    "id_satker" => $r->id_satker,
                    "kode_satker" => $r->kode_satker,
                    "nama_satker" => $r->nama_satker,
                    "id_ppk" => $r->id_ppk,
                    "kode_ppk" => $r->kode_ppk,
                    "nama_ppk" => $r->nama_ppk,
                    "lat" => $r->lat,
                    "lng" => $r->lng
                );
            }
            $data['hasil'] = $item;
            $data['success'] = TRUE;
            $data['message'] = 'Load Sukses';
        }else{
            $data['success'] = FALSE;
            $data['message'] = 'Load Gagal';
        }
		echo json_encode($data);
    }

    function ubah_PenilikJalan(){
        date_default_timezone_set('Asia/Jakarta');
        $id_kerusakan = ($this->input->post('id_kerusakan') != "") ? $this->input->post('id_kerusakan') : "";
        $id_user = ($this->input->post('id_user') != "") ? $this->input->post('id_user') : "";
        $gambar1 = ($this->input->post('gambar1') != "") ? $this->input->post('gambar1') : "";
        $gambar2 = ($this->input->post('gambar2') != "") ? $this->input->post('gambar2') : "";
        $status = ($this->input->post('status') != "") ? $this->input->post('status') : "";
        $lokasi_file = "./assets/upload/perbaikan/";
        $nama_file1 = '';
        $nama_file2 = '';

        if($status == '2'){
            if(!empty($gambar1)){
                $nama_file1 = "proses1" . date('d_m_Y_h_i_s') . ".jpg";
            }else{
                $nama_file1 = "";
            }
            if(!empty($gambar2)){
                $nama_file2 = "proses2" . date('d_m_Y_h_i_s') . ".jpg";
            }else{
                $nama_file2 = "";
            }
            $path1 = $lokasi_file . $nama_file1;
            $path2 = $lokasi_file . $nama_file2;
            $data = array(
                'gambar_proses_1'  => $nama_file1,
                'gambar_proses_2'  => $nama_file2,
                'status'        => $status,
                'id_user'        => $id_user,
                'tgl_proses'      => date("Y-m-d H:i")
            );
        }else if($status == '3'){
            if(!empty($gambar1)){
                $nama_file1 = "baik1" . date('d_m_Y_h_i_s') . ".jpg";
            }else{
                $nama_file1 = "";
            }
            if(!empty($gambar2)){
                $nama_file2 = "baik2" . date('d_m_Y_h_i_s') . ".jpg";
            }else{
                $nama_file2 = "";
            }
            $path1 = $lokasi_file . $nama_file1;
            $path2 = $lokasi_file . $nama_file2;
            $data = array(
                'gambar_selesai_1'  => $nama_file1,
                'gambar_selesai_2'  => $nama_file2,
                'status'        => $status,
                'id_user'        => $id_user,
                'tgl_selesai'      => date("Y-m-d H:i")
            );
        }

		$this->Data_m->Update('t_kerusakan', $data, array('id_kerusakan'=>$id_kerusakan));
        if ($this->db->trans_status() === FALSE) {
            $msg['success'] = FALSE;
            $msg['message'] = 'Data gagal disimpan';
        } else {
            if(!empty($gambar1)){
                file_put_contents($path1, base64_decode($gambar1));
                $msg['success'] = TRUE;
                $msg['message'] = 'Data berhasil disimpan';
            }
            if(!empty($gambar2)){
                file_put_contents($path2, base64_decode($gambar2));
                $msg['success'] = TRUE;
                $msg['message'] = 'Data berhasil disimpan';
            }
            $msg['success'] = TRUE;
            $msg['message'] = 'Data berhasil disimpan';
        }
        echo json_encode($msg);
    }

     // Ubah Foto Profil
     function update_Foto(){
        $id_user = ($this->input->post("id_user") != "") ? $this->input->post("id_user") : "";
		$gambar1 = ($this->input->post("foto") != "") ? $this->input->post("foto") : "";
        $lokasi_file = "./assets/upload/foto/";

        date_default_timezone_set('Asia/Jakarta');
        if(!empty($gambar1)){
            $nama_file1 = "profil" . date('d_m_Y_h_i_s') . ".jpg";
        }else{
            $nama_file1 = "";
        }
        $path1 = $lokasi_file . $nama_file1;

        $where = array(
            'id_user' => $id_user
        );

        //delete file
        $pegawai = $this->Data_m->GetId('m_user', $where)->row();
        if(file_exists($lokasi_file.$pegawai->foto) && $pegawai->foto)
            unlink($lokasi_file.$pegawai->foto);

        $this->Data_m->Update('m_user', array('foto' => $nama_file1), $where);

        if ($this->db->trans_status() === FALSE) {
            $msg['success'] = FALSE;
            $msg['message'] = 'Foto gagal diubah.';
        } else {
            if(!empty($gambar1)){
                file_put_contents($path1, base64_decode($gambar1));
                $msg['success'] = TRUE;
                $msg['message'] = 'Foto berhasil diubah.';
            }
            $msg['success'] = TRUE;
            $msg['message'] = 'Foto berhasil diubah.';
        }
        echo json_encode($msg);
    }

    function data_Pegawai(){
        $where = array(
            'id_user' => ($this->input->post("id_user") != "") ? $this->input->post("id_user") : ""
        );
        $r = $this->Data_m->GetId('m_user', $where)->row();
        if (!empty($r)) {
            $response = array(
                "id_user" => $r->id_user,
                "foto" => $r->foto,
                "success" => TRUE,
                "message" => "Load Sukses"
            );
        }else{
            $response = array(
                "success" => FALSE,
                "message" => "Load Gagal"
            );
        }
		echo json_encode($response);
    }

     // Ubah Password
     function ubah_Password(){
        $id_user = ($this->input->post("id_user") != "") ? $this->input->post("id_user") : "";
        $pw_lama = md5(($this->input->post('pw_lama') != "") ? $this->input->post('pw_lama') : "");
        $pw_baru = md5(($this->input->post('pw_baru') != "") ? $this->input->post('pw_baru') : "");

        $where = array(
            'id_user' => $id_user,
            'pw_lama' => $pw_lama
        );

        $pegawai = $this->Data_m->GetId('m_user', $where);
        if(!empty($pegawai)){
            $this->Data_m->Update('m_user', array('passwd'=>$pw_baru), array('id_user'=>$id_user));
            if ($this->db->trans_status() === FALSE) {
                $msg['success'] = FALSE;
                $msg['message'] = 'Password gagal diubah.';
            } else {
                $msg['success'] = TRUE;
                $msg['message'] = 'Password berhasil diubah.';
            }
        }else{
            $msg['success'] = TRUE;
            $msg['message'] = 'Password berhasil diubah.';
        }
        echo json_encode($msg);
    }
}