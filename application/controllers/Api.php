<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();
		header('Content-Type:application/json');
		$this->load->model('mod_user');
        $this->load->model('mod_device');
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
                "message_severity" => "danger",
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
                $this->buat_session($resultcek);
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
                if($this->session->userdata("session_appssystem_tipe_user") == 1){
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
                if($this->session->userdata("session_appssystem_tipe_user") == 2){
                    $tipe = "3";
                    $parent = $this->session->userdata("session_appssystem_id");
                    $API_KEY = $this->session->userdata("session_appssystem_api_key");
                    $secure_key = $this->session->userdata("session_appssystem_secure_key");
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

    function update_detail_user(){
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
			echo json_encode($data);
		}else{
			echo "HTTP GET User Error, Pastikan anda kirim ID";
		}
	}

    function load_all_parent(){
        $return = $this->mod_user->load_all_parent();
        echo json_encode(array("response"=>$return));
    }

    function load_all_user(){
        $return = $this->mod_user->load_all_user();
        echo json_encode(array("response"=>$return),JSON_PRETTY_PRINT);
    }



    //-------------------------------- DEVICE -------------------------------------------------
    //                                           1          2         3      4      5      6
    // http://localhost/keamananrumah/index.php/api/post_sensor_data/state/outdoor/indoor/ussrf/
    function post_sensor_data(){
        if($this->uri->segment(3)!=null && $this->uri->segment(4)!=null && $this->uri->segment(5)!=null && $this->uri->segment(6)!=null && $this->uri->segment(7)!=null ){
            $data = array(
                "state" => $this->uri->segment(3),
                "outdoor" => $this->uri->segment(4),
                "indoor" => $this->uri->segment(5),
                "ussrf" => $this->uri->segment(6),
                "API_KEY" => $this->uri->segment(7),
                "datetime" => date("Y-m-d H:i:s"));

            $return = "#".$this->mod_device->post_sensor_data($data)."^";
        }else{
            $return = "#0^";
        }
        echo $return;
    }
}