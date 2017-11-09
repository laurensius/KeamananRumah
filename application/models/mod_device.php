<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_device extends CI_Model{
    
    function post_sensor_data($data){
		$this->db->insert('t_sensor',$data);
        return $this->db->affected_rows();
    }
<<<<<<< HEAD
=======

    function recent($API_KEY){
        $query_str = "Select * from t_sensor where API_KEY='".$API_KEY."' order by id desc limit 1";
        $result = $this->db->query($query_str);
        return $result->result();
    }

>>>>>>> caed26356b58de5dcfc5295674711d58f72f255b
}