<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keamananrumah extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('mod_user');
    }
    //------------------------------DAFTAR-------------------------------------- 
    public function daftar(){
        $this->load->view("apps/daftar");
    }
    //------------------------------END OF DAFTAR--------------------------------------

    //------------------------------LANDING PAGE USER--------------------------------------
	public function index(){
		if($this->session->userdata("session_appssystem_code")){
            redirect(site_url()."/keamananrumah/dashboard");
        }else{
            $this->load->view("apps/login");
        }
    }
    //------------------------------END OF LANDING PAGE USER--------------------------------------

    //------------------------------MENU DASHBOARD--------------------------------------
	public function dashboard(){
		if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            $this->load->view("apps/body_dashboard");
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }

    public function profile(){
        if($this->session->userdata("session_appssystem_code")){
            if($this->uri->segment(3)=="update"){
                $data["disabled"] = "";
            }else{
                $data["disabled"] = "disabled";
            }
            $this->load->view("apps/header");
            $this->load->view("apps/body_profile",$data);
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }

    public function ubah_password(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            $this->load->view("apps/body_ubah_password");
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }
    //------------------------------END OF MENU DASHBOARD--------------------------------------

    //------------------------------MENU KELOLA PENGGUNA--------------------------------------
    public function tambah_pengguna(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            $this->load->view("apps/body_tambah_pengguna");
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }

    public function daftar_pengguna(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            if(($this->uri->segment(3) != "" || $this->uri->segment(3) != null) && ($this->uri->segment(4) != "" || $this->uri->segment(4) != null)){
                if($this->uri->segment(3) == "edit"){
                    $this->load->view("apps/body_daftar_pengguna_edit"); 
                }else
                if($this->uri->segment(3) == "view"){
                    $this->load->view("apps/body_daftar_pengguna_view"); 
                }else
                if($this->uri->segment(3) == "delete"){
                    $this->load->view("apps/body_daftar_pengguna_delete"); 
                }else{
                    $this->load->view("apps/body_daftar_pengguna");    
                }
            }else{
                $this->load->view("apps/body_daftar_pengguna");
            }
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }

    public function request_open_block(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            if($this->session->userdata('session_appssystem_id') == "1"){
                $this->load->view("apps/body_approve_open_block");
            }else{
                $this->load->view("apps/body_request_open_block");
            }
            
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }

    //------------------------------END OF MENU KELOLA PENGGUNA--------------------------------------

    //------------------------------MONITORING--------------------------------------
    function monitoring(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            $this->load->view("apps/body_monitoring");
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }

    function kelola_perangkat(){
        if($this->session->userdata("session_appssystem_code")){
            $this->load->view("apps/header");
            $this->load->view("apps/body_kelola_perangkat");
            $this->load->view("apps/footer");
        }else{
            $this->load->view("apps/login");
        }
    }
    //------------------------------END OF MONITORING--------------------------------------





    //------------------------------LOGOUT--------------------------------------
	public function logout(){
        if($this->session->userdata("session_appssystem_code")){
            $this->session->sess_destroy();
            $return = array(
                "status_cek" => null,
                "message" => "Anda baru saja logout.",
                "message_severity" => "success",
                "data_user" => null
            );
        }else{
            $return = array(
                "status_cek" => null,
                "message" => "Silahkan login",
                "message_severity" => "info",
                "data_user" => null
            );
        }
        $this->load->view("apps/login",$return);
    }
    //------------------------------END OF LOGOUT--------------------------------------

	
}