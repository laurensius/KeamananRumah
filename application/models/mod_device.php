<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_device extends CI_Model{
    
    function post_sensor_data($data){
		$this->db->insert('t_sensor',$data);
        return $this->db->affected_rows();
    }

    function recent($API_KEY){
        $query_str = "Select 
            t_sensor.id,  
            t_sensor.state, 
            t_sensor.outdoor, 
            t_sensor.indoor, 
            t_sensor.ussrf, 
            t_sensor.magnetic, 
            t_sensor.datetime,  
            t_sensor.API_KEY, 
            t_status_monitoring.status as status_perangkat, 
            t_status_monitoring.datetime as datetime_perangkat, 
            t_status_monitoring.user as pengubah_status_perangkat 
            from 
            t_sensor 
            inner join 
            t_status_monitoring
            on 
            t_sensor.API_KEY = t_status_monitoring.API_KEY 
            and t_sensor.API_KEY='".$API_KEY."' order by t_sensor.id desc limit 1";
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

    function total_perangkat_aktif(){
        $query_str = "SELECT count(distinct(api_key)) as jumlah_perangkat_aktif from t_sensor ";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    function change_device_status($API_KEY,$data){
        $this->db->where('API_KEY', $API_KEY);
        $this->db->update('t_status_monitoring', $data);  
    }

    function status_perangkat_by_api($API_KEY){
        $query_str = "SELECT * from t_status_monitoring where API_KEY='".$API_KEY."'";
        $query = $this->db->query($query_str);
        return $query->result();   
    }
}