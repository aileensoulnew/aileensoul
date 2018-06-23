<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {
    public function get_notification($user_id)
    {
        $sql = "SELECT * FROM `ailee_notification` WHERE not_to_id = '".$user_id."' AND AND not_type != 2";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }
}
