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

    function itung_rows(){
        $result = $this->db->query("select count(*) as jumlah from t_sensor");
        return $result->result();
    }

    function summary_database_all(){
        $query_str = "SELECT count(id) as jumlah_record_total, (select count(*) from t_sensor where datetime like '".date("Y-m-d")."%') as jumlah_record_today  FROM t_sensor";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function summary_database_by_api($API_KEY){
        $query_str = "SELECT count(id) as jumlah_record_total, (select count(*) from t_sensor where datetime like '".date("Y-m-d")."%' and  API_KEY='".$API_KEY."') as jumlah_record_today  FROM t_sensor where API_KEY='".$API_KEY."'";
        $query = $this->db->query($query_str);
        return $query->result();
    }
}