<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
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

    public function unread_message_count_wc()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        if(include_once './mongo/vendor/autoload.php')
        {

            $userid = $this->session->userdata('aileenuser');
            $user_data = $this->user_model->getUserData($userid);            

            $client = new MongoDB\Client(MONGO_URL.(MONGO_USER != '' ? MONGO_USER.':'.MONGO_PASS.'@' : '').MONGO_SERVER.'/'.MONGO_DB);
            if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost" || $_SERVER['HTTP_HOST'] == "staging.aileensoul.com") {
                $collection = $client->testchat->messages;
            }
            else
            {
                $collection = $client->aileensoulchat->messages;
            }
            $pipeline = array(
                array(
                    '$match' => array(
                        'to_username' => $user_data['user_slug'],
                        'msg_status' => 1
                    )
                ),
                array(
                    '$group' => array(
                        '_id' => array(
                            'from_username' => '$from_username'
                        ),
                    )
                )
            );
            $result = $collection->aggregate($pipeline)->toArray();
            $msg_cnt = count($result);
            echo "data:{$msg_cnt}\n\n";
            flush();
        }
        else
        {
            echo "data:0\n\n";
            flush();
        }
    }

    public function contact_request_count_wc()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $userid = $this->session->userdata('aileenuser');

        $cr_count = $this->user_model->contactRequestCount($userid);
        $count = $cr_count['total'];
        echo "data:{$count}\n\n";
        flush();
    }

}