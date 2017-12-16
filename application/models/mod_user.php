<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_user extends CI_Model{
    
    function get_user_by_username($data){
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

    function verifikasi_daftar($data){
        $query = "select t_user.username "
                ."from t_user "
                ."where "
                ."t_user.username = '".$data["username"]."' ";
        $result = $this->db->query($query);
        return $result->result();
    }

    function daftar($data){
        $this->db->insert('t_user',$data);
        return $this->db->affected_rows();
    }

    function cek_random_key_to_database($key){
        $query = "select count(*) as jumlah from t_user where secure_key='".$key."' ";
        $result = $this->db->query($query);
        return $result->result();
    }

    function update_detail_user($id,$data){
        $this->db->where('id',$id);
        $this->db->update('t_user',$data);
        return $this->db->affected_rows();
    }

    function update_pengguna($id,$data){
        $this->db->where('id',$id);
        $this->db->update('t_user',$data);
        return $this->db->affected_rows();
    }

    function do_approve($id,$data){
        $this->db->where('id',$id);
        $this->db->update('t_request_open',$data);
        return $this->db->affected_rows();
    }

    function cek_password($id,$data){
        $query = "select count(t_user.password) as jumlah from t_user where id='".$id."' and password='".$data["password"]."'";
        $result = $this->db->query($query);
        return $result->result();
    }

    function update_password($id,$data){
        $this->db->where('id',$id);
        $this->db->update('t_user',$data);
        return $this->db->affected_rows();
    }

    function block_by_username($username,$data){
        $this->db->where('username',$username);
        $this->db->update('t_user',$data);
        return $this->db->affected_rows();
    }

    //---------------------------LOAD USER -----------------
    function load_all_parent(){
        $query = "select t_user.id, t_user.username,  t_user.nama, t_user.tipe, t_user.status "
                ."from t_user "
                ."where "
                ."t_user.tipe = '2' and "
                ."status = '1' order by id asc";
        $result = $this->db->query($query);
        return $result->result();
    }

    function load_sibling_by_parent($parent){
        $query = "select * "
                ."from t_user "
                ."where "
                ."parent = '".$parent."' order by id asc";
        $result = $this->db->query($query);
        return $result->result();
    }

    function load_all_user(){
        $query = "select t_user.*, "
                ."t_ref_tipe_user.tipe as tipe_user, "
                ."t_ref_status_user.status as status_user "
                ."from t_user "
                ."inner join "
                ."t_ref_tipe_user "
                ."on t_ref_tipe_user.id = t_user.tipe "
                ."inner join "
                ."t_ref_status_user "
                ."on t_ref_status_user.id = t_user.status "
                ."where "
                ."t_user.tipe <> '1' order by API_KEY asc";
        $result = $this->db->query($query);
        return $result->result();
    }

    function load_all_family($API_KEY){
        $query = "select t_user.*, "
                ."t_ref_tipe_user.tipe as tipe_user, "
                ."t_ref_status_user.status as status_user "
                ."from t_user "
                ."inner join "
                ."t_ref_tipe_user "
                ."on t_ref_tipe_user.id = t_user.tipe "
                ."inner join "
                ."t_ref_status_user "
                ."on t_ref_status_user.id = t_user.status "
                ."where "
                ."t_user.tipe <> '1' and "
                ."t_user.API_KEY ='".$API_KEY."' order by API_KEY asc";
        $result = $this->db->query($query);
        return $result->result();
    }

    function load_detail_user($id){
        $query_str = "select t_user.*, "
        ."t_ref_tipe_user.tipe as tipe_user, "
        ."t_ref_status_user.status as status_user "
        ."from t_user "
        ."inner join "
        ."t_ref_tipe_user "
        ."on t_ref_tipe_user.id = t_user.tipe "
        ."inner join "
        ."t_ref_status_user "
        ."on t_ref_status_user.id = t_user.status "
        ."where "
        ."t_user.id = '".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function get_tipe_user($id){
        $query_str = "Select tipe,API_KEY from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function jumlah_user(){
        $query_str = "select count(*) as jumlah from t_user where tipe <> '1'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function delete_single_user($id){
        $query_str = "delete from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
    }

    function delete_family($API_KEY){
        $query_str = "delete from t_user where API_KEY='".$API_KEY."'";
        $query = $this->db->query($query_str);
    }
  
    function get_password_by_id($id){
        $query_str = "select t_user.password as password from t_user where id='".$id."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function summary_pengguna_all(){
        $query_str = "SELECT count(id) as jumlah_user_total, (select count(*) from t_user where status='2') as jumlah_user_blocked  FROM t_user where id <> '1'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function summary_pengguna_by_api($API_KEY){
        $query_str = "SELECT count(id) as jumlah_user_total, (select count(*) from t_user where status='2' and API_KEY='".$API_KEY."') as jumlah_user_blocked  FROM t_user where API_KEY='".$API_KEY."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function secure_key_by_api($API_KEY){
        $query_str = "SELECT secure_key as secure_key FROM t_user where API_KEY='".$API_KEY."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function total_koordinator(){
        $query_str = "SELECT count(tipe) as jumlah_koordinator from t_user where tipe='2'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function total_sibling(){
        $query_str = "SELECT count(tipe) as jumlah_sibling from t_user where tipe='3'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function request_buka_block(){
        $query_str = "SELECT count(status) as request_buka_block from t_request_open where status='1'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function load_blocked_user_by_api_key($API_KEY){
        $query_str = "SELECT "
        ."t_user.id, " 
        ."t_user.username, "
        ."t_user.nama, "
        ."t_ref_tipe_user.tipe as tipe, "
        ."(select t_request_open.status from t_request_open, t_user "
        ."where t_request_open.user_blocked = t_user.id  order by t_request_open.id desc limit 1) as status, "
        ."(select count(t_request_open.user_blocked) from t_request_open, t_user "
        ."where t_request_open.user_blocked = t_user.id and t_request_open.status='1') as jumlah "
        ."from t_user "
        ."inner join t_ref_tipe_user "
        ."on t_user.tipe = t_ref_tipe_user.id "
        // ."and t_request_open.status = '1' "
        // ."inner join t_request_open "
        // ."on t_user.id = t_request_open.id "
        // ."and t_request_open.status='1' "
        ."and t_user.status='2' and t_user.API_KEY='".$API_KEY."' "
        ."";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function request_open_block($data){
        $this->db->insert('t_request_open',$data);
        return $this->db->affected_rows();
    }

    function load_request_block(){
        $query_str = "select t_request_open.id, t_request_open.user_blocked, t_user.username, t_user.nama, t_user.tipe as tp, (Select t_ref_tipe_user.tipe from t_user,t_ref_tipe_user where t_ref_tipe_user.id = tp limit 1) as tipe from t_request_open INNER JOIN t_user on t_request_open.user_blocked = t_user.id and t_request_open.status = '1'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

}
