<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();
		header('Content-Type:application/json');
		$this->load->model('mod_user');
        $this->load->model('mod_device');
		require(APPPATH.'\middleware\fpdf.php');
	}

	function verifikasi(){
        if($this->input->post()!=null){
            $data = array(
            "username" => $this->input->post('username'),
            "password" => md5($this->input->post('password')));
            $resultcek = $this->get_user_by_username($data);
            if($resultcek==null){
                $return = array(
                    "status_cek" => "NOT FOUND",
                    "message" => "Username tidak terdaftar",
                    "message_severity" => "danger",
                    "data_user" => null
                );
            }else{
                $return = $this->matching($data,$resultcek);
            } 
        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server",
                "message_severity"  => "danger",
                "data_user" => null
            );
        }
		echo json_encode(array("response"=>$return));
    }
    
    function get_user_by_username($data){
        return $this->mod_user->get_user_by_username($data);
    }
    
    function matching($data,$resultcek){
        if($data["username"] == $resultcek[0]->username && $data["password"] == $resultcek[0]->password){
            if($resultcek[0]->status == 2){
                $status_cek = "NOT MATCH";
                $message = "User Anda diblokir! Anda tidak dapat login";
                $severity = "danger";
                //$this->buat_session($resultcek);
            }else
            if($resultcek[0]->status == 1){
                $status_cek = "MATCH";
                $message = "Username dan password sesuai";
                $severity = "success";
                $this->buat_session($resultcek);
            }
        }else{
            $status_cek = "NOT MATCH";
            $message = "Username dan password tidak sesuai";
            $severity = "warning";
        }
        $return = array(
            "status_cek" => $status_cek,
            "message" => $message,
            "message_severity" => $severity,
            "data_user" => $resultcek
        );
        return $return;
    }

    function buat_session($resultcek){
        $waktu = date("Y-m-d H:i:s");
        $this->update_login_timestamp($resultcek[0]->id,array("last_login" => $waktu));
        $data_session = array(
            "session_appssystem_code"=>"SeCuRe".date("YmdHis")."#".date("YHmids"),
            "session_appssystem_id"=>$resultcek[0]->id,
            "session_appssystem_username"=>$resultcek[0]->username,
            "session_appssystem_nama_lengkap"=>$resultcek[0]->nama,
            "session_appssystem_tipe_user"=>$resultcek[0]->tipe,
            "session_appssystem_api_key"=>$resultcek[0]->API_KEY,
            "session_appssystem_secure_key"=>$resultcek[0]->secure_key,
            "session_appssystem_last_login"=>$waktu
        );
        $this->session->set_userdata($data_session);
    }
    
    function update_login_timestamp($id,$data){
        $this->mod_user->update_login_timestamp($id,$data);
    }

    function verifikasi_daftar(){
        if($this->input->post()!=null){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $nama = $this->input->post('nama');
            $alamat = $this->input->post('alamat');
            $data = array(
                "username" => $username,
                "password" => $password,
                "nama" => $nama,
                "alamat" => $alamat);
            $resultcek = $this->mod_user->verifikasi_daftar($data);
            if($resultcek==null){
                if($this->session->userdata("session_appssystem_tipe_user") == 1 || $this->uri->segment(3) == "1"){
                    $tipe = $this->input->post('tipe_user');
                    $parent = $this->input->post('parent');
                    if($tipe == 2){
                        $API_KEY = md5($username."".$password);
                        $secure_key = $this->random_secure_key();    
                    }else
                    if($tipe == 3){
                        $apikey = $this->mod_user->get_api_key_by_id($parent);
                        $securekey = $this->mod_user->get_secure_key_by_id($parent);
                        $API_KEY = $apikey[0]->API_KEY;
                        $secure_key =$securekey[0]->secure_key;   
                    }
                }else
                if($this->session->userdata("session_appssystem_tipe_user") == 2 || $this->uri->segment(3) == "2"){
                    $tipe = "3";
                    $parent = $this->input->post("parent");
                    $API_KEY = $this->input->post("API_KEY");
                    $secure_key = $this->input->post("secure_key");
                }else
                if($this->session->userdata("session_appssystem_tipe_user") == "" || $this->session->userdata("session_appssystem_tipe_user") == null ){
                    $tipe = "2";
                    $parent = "0";
                    $API_KEY = md5($username."".$password);
                    $secure_key = $this->random_secure_key();
                }
                $data = array(
                    "username" => $username,
                    "password" => md5($password),
                    "nama" => $nama,
                    "alamat" => $alamat,
                    "tipe" => $tipe,
                    "register_datetime" => date("Y-m-d H:i:s"),
                    "status" => "1",
                    "last_login" => date("Y-m-d H:i:s"),
                    "photo" => "",
                    "parent" => $parent,
                    "API_KEY" => $API_KEY,
                    "secure_key" => $secure_key);
                $resultcek = $this->mod_user->daftar($data);
                if($resultcek > 0){
                    $return = array(
                        "status_cek" => "SUCCESS",
                        "message" => "Pendaftaran berhasil",
                        "message_severity" => "success",
                        "data_user" => null);    
                }else{
                    $return = array(
                        "status_cek" => "FAILED",
                        "message" => "Pendaftaran gagal. Silahkan coba lagi.",
                        "message_severity" => "warning",
                        "data_user" => null);  
                }
            }else{
                 $return = array(
                    "status_cek" => "FOUND",
                    "message" => "Userneme sudah digunakan, cari username lainnya!",
                    "message_severity" => "danger",
                    "data_user" => null
                );
            } 
        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server!",
                "message_severity" => "danger",
                "data_user" => null
            );
        }
        echo json_encode(array("response"=>$return));
    }

    function random_secure_key(){
        $validation = false;
        while($validation == false){
            $segment_1 = rand(0,9);
            $segment_2 = rand(0,9);
            $segment_3 = rand(0,9);
            $segment_4 = rand(0,9);
            $key = $segment_1."".$segment_2."".$segment_3."".$segment_4;
            if($this->cek_random_key_to_database($key) == 0){
                $validation = true;
            }else{
                $validation = false;
            }
        }
        return $key;
    }
    
    function cek_random_key_to_database($key){
        $return = $this->mod_user->cek_random_key_to_database($key);
        foreach ($return as $jumlah) {
            return $jumlah->jumlah;
        }
    }

    function update_detail_user(){ //Profile
        if(($this->uri->segment(3) != "" || $this->uri->segment(3) != null ) && $this->input->post() != null ){
            $username = $this->input->post('username');
            $nama = $this->input->post('nama');
            $alamat = $this->input->post('alamat');
            $data = array(
                "username" => $username,
                "nama" => $nama,
                "alamat" => $alamat);
            $resultcek = $this->mod_user->update_detail_user($this->uri->segment(3),$data);
            if($resultcek > 0){
                $this->session->set_userdata("session_appssystem_nama_lengkap",$nama);
                $this->session->set_userdata("session_appssystem_username",$username);
                $return = array(
                    "status_cek" => "SUCCESS",
                    "message" => "Update berhasil",
                    "message_severity" => "success",
                    "data_user" => null);    
            }else{
                $return = array(
                    "status_cek" => "FAILED",
                    "message" => "Update gagal. Silahkan coba lagi.",
                    "message_severity" => "warning",
                    "data_user" => null);  
            }
        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server!",
                "message_severity" => "danger",
                "data_user" => null
            );
        }
        echo json_encode(array("response"=>$return));
    }

    function update_pengguna(){ //user
        if(($this->uri->segment(3) != "" || $this->uri->segment(3) != null ) && $this->input->post() != null ){
            $password = $this->input->post('password');
            $status = $this->input->post('status');
            $nama = $this->input->post('nama');
            $alamat = $this->input->post('alamat');
            $pwd = $this->mod_user->get_password_by_id($this->uri->segment(3));
            if($password == $pwd[0]->password || MD5($password) == $pwd[0]->password){
                $data = array(
                    "nama" => $nama,
                    "status" => $status,
                    "alamat" => $alamat);
            }else{
                $password = MD5($password);
                $data = array(
                    "password" => $password,
                    "nama" => $nama,
                    "status" => $status,
                    "alamat" => $alamat);
            }
            $resultcek = $this->mod_user->update_pengguna($this->uri->segment(3),$data);
            if($resultcek > 0){
                $return = array(
                    "status_cek" => "SUCCESS",
                    "message" => "Update berhasil",
                    "message_severity" => "success",
                    "data_user" => null);    
            }else{
                $return = array(
                    "status_cek" => "FAILED",
                    "message" => "Update gagal. Silahkan coba lagi.",
                    "message_severity" => "warning",
                    "data_user" => null);  
            }
        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server!",
                "message_severity" => "danger",
                "data_user" => null
            );
        }
        echo json_encode(array("response"=>$return,"affected" => $resultcek));
    }

    function update_password(){
        if(($this->uri->segment(3) != "" || $this->uri->segment(3) != null ) && $this->input->post() != null ){
            $password = md5($this->input->post('password'));
            $new_password = md5($this->input->post('new_password'));
            $data = array("password" => $password);
            $cek_password = $this->cek_password($this->uri->segment(3),$data);
            if($cek_password[0]->jumlah == 1){
                $new_data = array("password" => $new_password);
                $resultcek = $this->mod_user->update_password($this->uri->segment(3),$new_data);
                if($resultcek > 0){
                    $return = array(
                        "status_cek" => "SUCCESS",
                        "message" => "Update berhasil",
                        "message_severity" => "success",
                        "data_user" => null);    
                }else{
                    $return = array(
                        "status_cek" => "FAILED",
                        "message" => "Update gagal. Silahkan coba lagi.",
                        "message_severity" => "warning",
                        "data_user" => null);  
                }
            }else 
            if($cek_password[0]->jumlah == 0){
                $return = array(
                    "status_cek" => "NOT MATCH",
                    "message" => "Password lama tidak sesuai.",
                    "message_severity" => "warning",
                    "data_user" => null); 
            }
        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server!",
                "message_severity" => "danger",
                "data_user" => null
            );
        }
        echo json_encode(array("response"=>$return));
    }

    function cek_password($id,$data){
        return $this->mod_user->cek_password($id,$data);
    }

    function load_detail_user(){
		if($this->uri->segment(3) != null || $this->uri->segment(3) != ""){
			$result = $this->mod_user->load_detail_user($this->uri->segment(3));
			$data = array("response" => $result);
			echo json_encode($data,JSON_PRETTY_PRINT);
		}else{
			echo "HTTP GET User Error, Pastikan anda kirim ID";
		}
	}

    function load_all_parent(){
        $return = $this->mod_user->load_all_parent();
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function load_all_user(){
        $return = $this->mod_user->load_all_user();
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function load_all_family(){
        if($this->uri->segment(3) == null){
            $return = array("data" => "null");
        }else{
            // echo $this->uri->segment(3);
            $return = $this->mod_user->load_all_family($this->uri->segment(3)); //API_KEY
            // $return = array("data" => $this->uri->segment(3));
        }
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function delete_user(){
        if($this->uri->segment(3) != null){
            $tipe = $this->cek_tipe_user($this->uri->segment(3)); 
            $jumlah_awal = $this->jumlah_user();
            if($tipe[0]->tipe == "2"){
                if($this->mod_user->delete_family($tipe[0]->API_KEY)){

                }else{
                    $return["affected_rows"] = 0;
                }
            }else
            if($tipe[0]->tipe == "3"){
                if($this->mod_user->delete_single_user($this->uri->segment(3))){

                }else{
                    $return["affected_rows"] = 0;
                }
            }
            $jumlah_akhir = $this->jumlah_user();
            $return["affected_rows"] = $jumlah_awal[0]->jumlah - $jumlah_akhir[0]->jumlah;
        }else{
            $return["affected_rows"] = 0;
        }
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function cek_tipe_user($id){
        return $this->mod_user->get_tipe_user($id);
    }

    function jumlah_user(){
        return $this->mod_user->jumlah_user();
    }


    //-------------------------------- DEVICE -------------------------------------------------
    //                                           1          2         3      4      5      6
    // http://localhost/keamananrumah/index.php/api/post_sensor_data/state/outdoor/indoor/ussrf/
    function post_sensor_data(){
        if($this->uri->segment(3)!=null && $this->uri->segment(4)!=null && $this->uri->segment(5)!=null && $this->uri->segment(6)!=null && $this->uri->segment(7)!=null && $this->uri->segment(8)!=null){
            $data = array(
                "state" => $this->uri->segment(3),
                "outdoor" => $this->uri->segment(4),
                "indoor" => $this->uri->segment(5),
                "ussrf" => $this->uri->segment(6),
                "magnetic" => $this->uri->segment(7),
                "API_KEY" => $this->uri->segment(8),
                "datetime" => date("Y-m-d H:i:s"));
            $status_perangkat = $this->mod_device->status_perangkat_by_api($this->uri->segment(8));     
            if($status_perangkat[0]->status == "1"){
                $this->mod_device->post_sensor_data($data); 
                $perangkat = "KONDISI ON";   
            }else{
                $perangkat = "KONDISI OFF";
            }
            $response = $this->mod_device->itung_rows();
            $secure_key = $this->mod_user->secure_key_by_api($this->uri->segment(8));
            $return = "#".$response[0]->jumlah."-".$secure_key[0]->secure_key."-".$perangkat."^";
        }else{
            $return = "#0^";
        }
        echo $return;
    }

    function recent(){
        $return = $this->mod_device->recent($this->uri->segment(3));
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function dashboard(){
        if($this->uri->segment(3) == null ){
            //admin mode
            $return = array(
                "user" => $this->summary_pengguna_all(),
                "database" => $this->summary_database_all(),
                "jumlah_koordinator" => $this->total_koordinator(), 
                "request_buka_block" => $this->request_buka_block(), 
                "jumlah_sibling" => $this->total_sibling(),
                "total_perangkat_aktif" => $this->total_perangkat_aktif(),
            );
        }else{
            //non-admin mode
            $return = array(
                "user" => $this->summary_pengguna_by_api($this->uri->segment(3)),
                "database" => $this->summary_database_by_api($this->uri->segment(3)) 
            );
        }
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function summary_pengguna_all(){
        return $this->mod_user->summary_pengguna_all();
    }

    function summary_database_all(){
        return $this->mod_device->summary_database_all() ;
    }

    function summary_pengguna_by_api($API_KEY){
        return $this->mod_user->summary_pengguna_by_api($API_KEY);
    }

    function summary_database_by_api($API_KEY){
        return $this->mod_device->summary_database_by_api($API_KEY);
    }

    function total_koordinator(){
        return $this->mod_user->total_koordinator();
    }

    function total_sibling(){
        return $this->mod_user->total_sibling();
    }

    function total_perangkat_aktif(){
        return $this->mod_device->total_perangkat_aktif();
    }

    function request_buka_block(){
        return $this->mod_user->request_buka_block();
    }

    function change_device_status(){
        if($this->uri->segment(3) != null && $this->uri->segment(4) != null && $this->uri->segment(5) != null){
            $data = array(
                "status" => $this->uri->segment(3),
                "datetime" => date("Y-m-d H:i:s"), 
                "user" => $this->uri->segment(5));
            $result = $this->mod_device->change_device_status($this->uri->segment(4),$data);
        }
    }

    function status_perangkat_by_api(){
        if($this->uri->segment(3) != null){
            $return = $this->mod_device->status_perangkat_by_api($this->uri->segment(3));
        }else{
            $return = array(null);
        }
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function load_blocked_user_by_api_key(){
        if($this->uri->segment(3) != null){
            $return = $this->mod_user->load_blocked_user_by_api_key($this->uri->segment(3));
        }else{
            $return = array(null);
        }
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function load_request_block(){
        $return = $this->mod_user->load_request_block();
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function request_open_block(){
        if($this->input->post('user_blocked') != null && $this->input->post('user_request') != null && $this->input->post('status') != null){
            $data = array(
                "user_blocked" => $this->input->post('user_blocked'),
                "user_request" => $this->input->post('user_request'),
                "datetime_request" => date("Y-m-d H:i:s"),
                "status" => $this->input->post('status')
            );
            $resultcek = $this->mod_user->request_open_block($data);
            if($resultcek > 0){
                $return = array(
                    "status_cek" => "SUCCESS",
                    "message" => "Request open block berhasil",
                    "message_severity" => "success",
                    "data_user" => null);    
            }else{
                $return = array(
                    "status_cek" => "FAILED",
                    "message" => "Update gagal. Request open block gagal.",
                    "message_severity" => "warning",
                    "data_user" => null);  
            }
        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server!",
                "message_severity" => "danger",
                "data_user" => null
            );
        }
        echo json_encode(array("response"=>$return));
    }

    function do_approve(){
        if($this->input->post('id_request') != null && $this->input->post('id_user') != null ){
            $approve = $this->mod_user->do_approve($this->input->post('id_request'),array("status"=>"2"));
            $update = $this->mod_user->update_pengguna($this->input->post('id_user'),array("status"=>"1"));
            if($approve > 0 && $update > 0){
                $return = array(
                    "status_cek" => "SUCCESS",
                    "message" => "Approve open block berhasil",
                    "message_severity" => "success",
                    "data_user" => null);    
            }else{
                $return = array(
                    "status_cek" => "FAILED",
                    "message" => "Update gagal. Approve open block gagal.",
                    "message_severity" => "warning",
                    "data_user" => null);  
            }

        }else{
            $return = array(
                "status_cek" => "NO DATA POSTED",
                "message" => "Tidak ada data dikirim ke server!",
                "message_severity" => "danger",
                "data_user" => null
            );
        }
        echo json_encode(array("response"=>$return));
    }

    function cek_download(){
        if($this->uri->segment(3) != null && $this->uri->segment(4) != null && $this->uri->segment(5) != null){
            $return = $this->mod_device->cek_download($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
        }else{
            $return = array();
        }

        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }

    function download_report(){
        if($this->uri->segment(3) != null && $this->uri->segment(4) != null && $this->uri->segment(5) != null){
            $dataset =  $this->mod_device->download_report($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
            $pdf = new FPDF();
            $header = array('No', 'Tanggal Monitoring', 'Outdoor', 'Indoor', 'Magnetic Switch');
            $pdf->SetFont('Arial','',14);
            $pdf->AddPage();
            
            // $pdf->Image('assets/LOGO.png');
            // $pdf->Ln(10);
            
            $pdf->SetFont('Arial','BU',12);
            $pdf->Cell(1);
            $pdf->Cell(0,10,'LAPORAN MONITORING KEAMANAN RUMAH',0,0,'C');
            $pdf->Ln(20);
            
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(1);
            $pdf->Cell(0,0,'API KEY : '.$this->uri->segment(5),0,0,'L');
            $pdf->Ln(5);
            
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(1);
            $pdf->Cell(0,0,"Periode :".$this->uri->segment(3)." s/d ".$this->uri->segment(4),0,0,'L');
            $pdf->Ln(10);
            //Header Tabel 
            $pdf->SetFillColor(255,0,0);
            $pdf->SetTextColor(255);
            $pdf->SetDrawColor(128,0,0);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('','B');
            $w = array(15, 65, 36, 36, 36);
            for($i=0;$i<count($header);$i++)
            $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
            $pdf->Ln();
            $pdf->SetFillColor(224,235,255);
            $pdf->SetTextColor(0);
            $pdf->SetFont('');
            //Isi Tabel <Dataset>
            $fill = false;
            $ctr = 1;
            foreach($dataset as $row){
                $exp_str = explode("_",$row->state);
                $pdf->Cell($w[0],6,$ctr,'LR',0,'L',$fill);
                $pdf->Cell($w[1],6,$row->datetime,'LR',0,'L',$fill);
                $pdf->Cell($w[2],6,$exp_str[0],'LR',0,'R',$fill);
                $pdf->Cell($w[3],6,$exp_str[1],'LR',0,'R',$fill);
                $pdf->Cell($w[4],6,$exp_str[2],'LR',0,'R',$fill);
                $ctr++;
                $pdf->Ln();
                $fill = !$fill;
            }
            $pdf->output();  
        }
        
    }

    function block_by_username(){
        if($this->uri->segment(3) != null){
            $data = array("status"=>"2");
            $return = $this->mod_user->block_by_username($this->uri->segment(3),$data);
        }else{
            $return = "";
        }
        echo json_encode(array("response"=>array("affected_rows"=>$return)),JSON_PRETTY_PRINT);
    }


}
