<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_device extends CI_Model{
    
    function post_sensor_data($data){
		$this->db->insert('t_sensor',$data);
        return $this->db->affected_rows();
    }
}