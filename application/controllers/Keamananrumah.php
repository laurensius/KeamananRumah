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
    //------------------------------END OF MENU KELOLA PENGGUNA--------------------------------------
	

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