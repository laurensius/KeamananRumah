<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_user extends CI_Model{
    
    public function get_user_by_username($data){
        $query = "select t_user.id, t_user.username, t_user.password, t_user.nama, t_user.tipe, t_user.status, t_user.API_KEY, t_user.secure_key "
                ."from t_user "
                ."where "
                ."t_user.username = '".$data["username"]."' ";
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function update_login_timestamp($id,$data){
        $this->db->where('id', $id);
        $this->db->update('t_user', $data);  
    }
    
    function last_login($id){
        $query_str = "select t_user.last_login from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function load_detail_user($id){
        $query_str = "select * from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function get_api_key_by_id($id){
        $query_str = "select t_user.API_KEY from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function get_secure_key_by_id($id){
        $query_str = "select t_user.secure_key from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    //---------
    public function verifikasi_daftar($data){
        $query = "select t_user.username "
                ."from t_user "
                ."where "
                ."t_user.username = '".$data["username"]."' ";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function daftar($data){
        $this->db->insert('t_user',$data);
        return $this->db->affected_rows();
    }

    public function cek_random_key_to_database($key){
        $query = "select count(*) as jumlah from t_user where secure_key='".$key."' ";
        $result = $this->db->query($query);
        return $result->result();
    }
        
}
