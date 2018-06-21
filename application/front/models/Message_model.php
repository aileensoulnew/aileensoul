<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_Model {

    function add_message($message, $message_file, $message_file_type, $message_file_size, $userid, $id, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id) {
        date_default_timezone_set('Asia/Kolkata');
        $data1 = array(
            'message' => (string) $message,
            'message_file' => $message_file,
            'message_file_size' => $message_file_size,
            'message_file_type' => $message_file_type,
            'message_from' => (string) $userid,
            'message_to' => (string) $id,
            'message_from_profile' => (int) $message_from_profile,
            'message_from_profile_id' => (int) $message_from_profile_id,
            'message_to_profile' => (int) $message_to_profile,
            'message_to_profile_id' => (int) $message_to_profile_id,
            'timestamp' => NOW(),
                //'timestamp' => time() + 92,
        );

        $this->db->insert('messages', $data1);
        $msg_insert_id = $this->db->insert_id();

        if ($message_from_profile == 1) {
            $not_from = 2;
        } elseif ($message_from_profile == 2) {
            $not_from = 1;
        } elseif ($message_from_profile == 3) {
            $not_from = 5;
        } elseif ($message_from_profile == 4) {
            $not_from = 4;
        } elseif ($message_from_profile == 5) {
            $not_from = 6;
        } else {
            $not_from = 3;
        }
        if ($this->uri->segment(3) == $id) {
            $not_active = 1;
        } else {
            $not_active = 1;
        }
        $data2 = array(
            'not_type' => '2',
            'not_from_id' => $userid,
            'not_to_id' => $id,
            'not_read' => '2',
            'not_img' => '0',
            'not_active' => $not_active,
            'not_from' => $not_from,
            'not_product_id' => $msg_insert_id,
            'not_created_date' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('notification', $data2);
        return $msg_insert_id;
    }

    function getBusinessUserChatList($business_profile_id = '') {
        $this->db->select("max(m.id) as max_id")->from("messages m");
        //$this->db->where("m.message_from_profile_id='" . $business_profile_id . "' OR m.message_to_profile_id='" . $business_profile_id . "' AND m.is_deleted = '0' and m.message_from_profile = '5' AND m.message_to_profile = '5'");
        $this->db->where("((m.message_from_profile_id='" . $business_profile_id . "') OR (m.message_to_profile_id='" . $business_profile_id . "')) AND m.message_from_profile = '5' AND m.message_to_profile = '5' AND (CASE WHEN (m.message_from_profile_id = '$business_profile_id') THEN (m.is_message_from_delete = '0' AND m.is_deleted = '0') WHEN (m.message_to_profile_id = '$business_profile_id') THEN (m.is_message_to_delete = '0' AND m.is_deleted = '0') END)");
        $this->db->group_by("(CASE WHEN m.message_from_profile_id ='" . $business_profile_id . "' THEN m.message_to_profile_id ELSE m.message_from_profile_id END)");
        $query1 = $this->db->get();
        $result_array1 = $query1->result_array();

        $this->db->select("b.business_profile_id,b.company_name,b.business_user_image,b.business_slug,b.user_id,m.message,m.id,m.message_file_type")->from("business_profile  b");
        $this->db->join('messages m', 'b.business_profile_id = (CASE WHEN m.message_from_profile_id=' . $business_profile_id . ' THEN m.message_to_profile_id ELSE m.message_from_profile_id END)');
        $this->db->where("m.id IN (" . implode(',', array_column($result_array1, 'max_id')) . ")");
        $this->db->order_by("m.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessUserChatSearchList($business_profile_id = '', $search_key = '') {

        $this->db->select("max(m.id) as max_id")->from("messages m");
        //$this->db->where("m.message_from_profile_id='" . $business_profile_id . "' OR m.message_to_profile_id='" . $business_profile_id . "' AND m.is_deleted = '0' and m.message_from_profile = '5' AND m.message_to_profile = '5'");
        $this->db->where("((m.message_from_profile_id='" . $business_profile_id . "') OR (m.message_to_profile_id='" . $business_profile_id . "')) AND m.message_from_profile = '5' AND m.message_to_profile = '5' AND (CASE WHEN (m.message_from_profile_id = '$business_profile_id') THEN (m.is_message_from_delete = '0' AND m.is_deleted = '0') WHEN (m.message_to_profile_id = '$business_profile_id') THEN (m.is_message_to_delete = '0' AND m.is_deleted = '0') END)");
        $this->db->group_by("(CASE WHEN m.message_from_profile_id ='" . $business_profile_id . "' THEN m.message_to_profile_id ELSE m.message_from_profile_id END)");
        $query1 = $this->db->get();
        $result_array1 = $query1->result_array();

        $this->db->select("b.business_profile_id,b.company_name,b.business_user_image,b.business_slug,b.user_id,m.message,m.id")->from("business_profile  b");
        $this->db->join('messages m', 'b.business_profile_id = (CASE WHEN m.message_from_profile_id=' . $business_profile_id . ' THEN m.message_to_profile_id ELSE m.message_from_profile_id END)');
        $this->db->where("m.id IN (" . implode(',', array_column($result_array1, 'max_id')) . ") AND b.company_name LIKE '%" . $search_key . "%' ");
        $this->db->order_by("m.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessChat($business_profile_id = '', $business_to_profile_id = '') {
        $this->db->select("m.id,m.message,m.message_file,m.message_file_type,m.message_file_size,m.timestamp,m.message_from_profile_id,DATE_FORMAT(from_unixtime(timestamp),'%W, %d %M %Y') as date,b.company_name,b.business_user_image,b.business_slug")->from("messages m");
        $this->db->join('business_profile b', 'b.business_profile_id = m.message_from_profile_id');
        $this->db->where("((m.message_from_profile_id='" . $business_profile_id . "' AND m.message_to_profile_id='" . $business_to_profile_id . "' ) OR (m.message_to_profile_id='" . $business_profile_id . "' AND m.message_from_profile_id='" . $business_to_profile_id . "')) AND m.message_from_profile = '5' AND m.message_to_profile = '5' AND (CASE WHEN (m.message_from_profile_id = '$business_profile_id' AND m.message_to_profile_id = '$business_to_profile_id') THEN (m.is_message_from_delete = '0' AND m.is_deleted = '0') WHEN (m.message_to_profile_id = '$business_profile_id' AND m.message_from_profile_id = '$business_to_profile_id') THEN (m.is_message_to_delete = '0' AND m.is_deleted = '0') END)");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessLastMessage($business_profile_id = '', $business_to_profile_id = '') {
        $this->db->select("m.id,m.message,m.message_file,m.message_file_type,m.message_file_size,m.timestamp,m.message_from_profile_id,DATE_FORMAT(from_unixtime(timestamp),'%W, %d %M %Y') as date,b.company_name,b.business_user_image,b.business_slug")->from("messages m");
        $this->db->join('business_profile b', 'b.business_profile_id = m.message_from_profile_id');
//        $this->db->where("(m.message_from_profile_id='" . $business_profile_id . "' AND m.message_to_profile_id='" . $business_to_profile_id . "' ) OR (m.message_to_profile_id='" . $business_profile_id . "' AND m.message_from_profile_id='" . $business_to_profile_id . "')AND m.is_deleted = '0' AND m.is_message_from_delete != '.$business_profile_id.' AND m.is_message_to_delete != '.$business_profile_id.' AND m.message_from_profile = '5' AND m.message_to_profile = '5'");
        $this->db->where("(m.message_from_profile_id='" . $business_profile_id . "' AND m.message_to_profile_id='" . $business_to_profile_id . "' ) OR (m.message_to_profile_id='" . $business_profile_id . "' AND m.message_from_profile_id='" . $business_to_profile_id . "') AND m.message_from_profile = '5' AND m.message_to_profile = '5' AND (CASE WHEN (m.message_from_profile_id = '$business_profile_id' AND m.message_to_profile_id = '$business_to_profile_id') THEN (m.is_message_from_delete = '0' AND m.is_deleted = '0') ELSE (m.is_message_to_delete = '0' AND m.is_deleted = '0') END)");
        $this->db->order_by('m.id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $result_array = $query->row();
        return $result_array;
    }

    function businessMessageData($message_for = '', $business_profile_id = '', $message_id = '') {
        if ($message_for == 1) {
            //$data = array('is_message_from_delete'=>$business_profile_id);
            $data = array('is_message_from_delete' => '1');
        } else {
            //$data = array('is_message_to_delete'=>$business_profile_id);
            $data = array('is_message_to_delete' => '1');
        }
        $this->db->where('id', $message_id);
        $update_data = $this->db->update('messages', $data);
        return $update_data;
    }

    function allMessageDelete($business_profile_id = '', $business_to_profile_id = '') {
//        $this->db->set('is_message_from_delete', "CASE WHEN `message_from_profile_id` ='".$business_profile_id."' THEN '1' ELSE '0' END", FALSE);
//        $this->db->set('is_message_to_delete', "CASE WHEN `message_to_profile_id` ='".$business_profile_id."' THEN '1' ELSE '0' END", FALSE);
//        $this->db->where("(message_from_profile_id='" . $business_profile_id . "' AND message_to_profile_id='" . $business_to_profile_id . "' ) OR (message_to_profile_id='" . $business_profile_id . "' AND message_from_profile_id='" . $business_to_profile_id . "') ");
//        $update_data = $this->db->update('messages');
//        return $update_data;


        $this->db->select("*")->from("messages");
        $this->db->where("(message_from_profile_id='" . $business_profile_id . "' AND message_to_profile_id='" . $business_to_profile_id . "') OR (message_to_profile_id='" . $business_profile_id . "' AND message_from_profile_id='" . $business_to_profile_id . "') AND is_deleted = '0' and message_from_profile = '5' AND message_to_profile = '5'");
        $query1 = $this->db->get();
        $result_array1 = $query1->result_array();

        foreach ($result_array1 as $result) {
            if ($result['message_from_profile_id'] == $business_profile_id && $result['message_to_profile_id'] == $business_to_profile_id) {
                $data = array('is_message_from_delete' => '1', 'is_message_to_delete' => $result['is_message_to_delete']);
                $this->db->where('id='.$result['id']);
            } else {
                $data = array('is_message_to_delete' => '1', 'is_message_from_delete' => $result['is_message_from_delete']);
                $this->db->where('id='.$result['id']);
            }
            $update_data = $this->db->update('messages', $data);
        }
        return $update_data;
    }

    public function getAllContactData($user_id = '', $select_data = '', $page = '',$login_user_id = '') {
        // $limit = '6';
        // $start = ($page - 1) * $limit;
        // if ($start < 0)
        //     $start = 0;

        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("uc.id,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_contact  uc");
        $this->db->join('user u', 'u.user_id = (CASE WHEN uc.from_id=' . $user_id . ' THEN uc.to_id ELSE uc.from_id END)', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        /*if ($limit != '') {
            $this->db->limit($limit, $start);
        }*/
        $query = $this->db->get();
        $result_array = $query->result_array();
        /*$total_record = $this->getContactCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        foreach ($result_array as $key => $value) {
            $is_userContactInfo= $this->userContactStatus($login_user_id, $value['user_id']);
            if(isset($is_userContactInfo) && !empty($is_userContactInfo))
            {
                $result_array[$key]['contact_detail']['contact_status'] = 1;
                $result_array[$key]['contact_detail']['contact_value'] = $is_userContactInfo['status'];
                $result_array[$key]['contact_detail']['contact_id'] = $is_userContactInfo['id'];
            }
            else
            {
                $result_array[$key]['contact_detail']['contact_status'] = 0;
                $result_array[$key]['contact_detail']['contact_value'] = 'new';
                $result_array[$key]['contact_detail']['contact_id'] = $is_userContactInfo['id'];   
            }
        }

        $data = array(
            'contactrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;*/
        return $result_array;
    }

    function get_messages_from_jid($login_jid = "",$to_jid = "")
    {
        $this->db->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;");        
        $sql = "SELECT * FROM ofMessageArchive WHERE fromJID = '".$login_jid."' AND toJID = '".$to_jid."' UNION  SELECT * FROM ofMessageArchive WHERE fromJID = '".$to_jid."' AND toJID = '".$login_jid."' ORDER By messageID";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }
}
