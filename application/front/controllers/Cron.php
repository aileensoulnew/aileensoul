<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function kill_all_query()
    {
        $query = $this->db->query("SHOW FULL PROCESSLIST");
        $result = $query->result_array();
        foreach ($result as $key => $value) {            
            $process_id = $value['Id'];
            if ($value["Time"] > 0 ) {
                $sql="KILL $process_id";                
                $query = $this->db->query($sql);
            }
            # code...
        }
    }

}