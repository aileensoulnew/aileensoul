<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('notification_model');
        $this->load->model('user_post_model');
    }

    public function kill_all_query()
    {
        $query = $this->db->query("SHOW FULL PROCESSLIST");
        $result = $query->result_array();
        foreach ($result as $key => $value) {
            $process_id = $value['Id'];
            if ($value["Command"] == 'Sleep' ) {
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
        // header('Content-Type: text/event-stream');
        // header('Cache-Control: no-cache');
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
            echo json_encode(array("unread_user"=>$msg_cnt));
            // echo "data:{$msg_cnt}\n\n";
            // flush();
        }
        else
        {
            // echo "data:0\n\n";
            echo json_encode(array("unread_user"=>0));
            // flush();
        }
        exit();
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

    public function manual_like($offset = 0)
    {
        $limit = 10;
        $offset = ($offset ? $offset : 0);
        $query = $this->db->query("SELECT *  FROM ailee_user_post WHERE post_for IN ('simple', 'opportunity', 'article', 'question', 'share') AND status = 'publish' AND `is_delete` = '0' ORDER BY created_date DESC LIMIT $offset,$limit");
        $result = $query->result_array();
        if($result)
        {            
            foreach ($result as $key => $value) {
                $post_like_count = $this->user_post_model->likepost_count($value['id']);            
                if($post_like_count < 91)
                {
                    gotoRandom:
                    $q_user = $this->db->query("SELECT u.*  FROM ailee_user u LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id WHERE ul.status = '1' AND ul.is_delete = '0' order by rand() limit 1");
                    $res_user = $q_user->row_array();                

                    $is_likepost = $this->user_post_model->is_likepost($res_user['user_id'], $value['id']);
                    if($is_likepost && $is_likepost['is_like'] == '1')
                    {
                        goto gotoRandom;
                    }
                    else
                    {
                        // echo "user_id-->".$res_user['user_id']."<----->".$value['id']."<--post_id<br>";
                        $insert_data = array();
                        $insert_data['user_id'] = $res_user['user_id'];
                        $insert_data['post_id'] = $value['id'];
                        $insert_data['created_date'] = date('Y-m-d H:i:s', time());
                        $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                        $insert_data['is_like'] = '1';
                        $user_post_like_id = $this->common->insert_data_getid($insert_data, 'user_post_like');
                    }
                }
            }
            $offset = $offset + $limit;
            $this->manual_like($offset);
        }
    }

}