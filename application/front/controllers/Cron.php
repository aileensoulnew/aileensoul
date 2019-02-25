<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('notification_model');
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

    public function get_notification_unread_count_wc()
    {        
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $userid = $this->session->userdata('aileenuser');
        $count = $this->notification_model->get_notification_unread_count($userid);

        $time = "1";// date('r');
        $userid = $this->session->userdata('aileenuser');
        echo "data:{$count}\n\n";
        flush();
    }

}