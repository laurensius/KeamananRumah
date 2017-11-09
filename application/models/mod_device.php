<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_device extends CI_Model{
    
    function post_sensor_data($data){
		$this->db->insert('t_sensor',$data);
        return $this->db->affected_rows();
    }


    function recent($API_KEY){
        $query_str = "Select * from t_sensor where API_KEY='".$API_KEY."' order by id desc limit 1";
        $result = $this->db->query($query_str);
        return $result->result();
    }
<<<<<<< HEAD
=======

    function itung_rows(){
        $result = $this->db->query("select count(*) as jumlah from t_sensor");
        return $result->result();
    }
>>>>>>> 6b262a253bbcc2424520fd8348c441340316f993
}