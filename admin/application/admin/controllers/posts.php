<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Posts extends CI_Controller
{

    public $data;
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        $this->load->model('email_model');
        $this->load->model('post_model');
        $this->load->model('searchelastic_model');

        // Get Site Information
        $this->data['title']         = 'Posts | Aileensoul';
        $this->data['module_name']   = 'Posts';
        $this->data['section_title'] = 'Posts';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', true);
        $this->paging = $this->config->item('paging');

        include 'include.php';
        $adminid = $this->session->userdata('aileen_admin');

        // echo $this->profile->thumb();
    }

    public function list()
    {
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;
            $sortby = $this->uri->segment(3);
            $orderby = $this->uri->segment(4);
        } else {
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $sortby = 'id';
            $orderby = 'desc';
        }
  
        $this->data['offset'] = $offset;
        $this->paging['base_url'] = site_url("posts/list");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }
        $this->data['post_list'] =  $this->post_model->get_all_post($offset,$limit);        
        $total_rows =  $this->post_model->get_all_post_total();

        $this->paging['total_rows'] = $total_rows;
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        // print_r($this->data['article_list']);exit();        
        $this->load->view('posts/list', $this->data);
    }

    public function post_delete()
    {
        $id = $this->input->post('id');
        $sql = "SELECT post_for FROM ailee_user_post WHERE id='".$id."'";
        $result_array = $this->db->query($sql)->row_array();
        if($result_array['post_for'] == 'opportunity')
        {
            $this->searchelastic_model->delete_opportunity_from_id_data($id);
        }
        elseif($result_array['post_for'] == 'simple')
        {
            $this->searchelastic_model->delete_post_from_id_data($id);
        }
        elseif($result_array['post_for'] == 'question')
        {
            $this->searchelastic_model->delete_question_from_id_data($id);
        }
        elseif($result_array['post_for'] == 'article')
        {
            $this->searchelastic_model->delete_article_id_data($id);
        }

        $data = array(
                    'status'=>'draft',
                    'is_delete'=>'1'
                );
        $this->common->update_data($data, 'user_post', 'id', $id);

        return true;
    }

    public function post_revoke()
    {
        $id = $this->input->post('id');
        $data = array(
                    'status'=>'publish',
                    'is_delete'=>'0'
                );
        $this->common->update_data($data, 'user_post', 'id', $id);

        $sql = "SELECT post_for FROM ailee_user_post WHERE id='".$id."'";
        $result_array = $this->db->query($sql)->row_array();
        if($result_array['post_for'] == 'opportunity')
        {
            $this->searchelastic_model->add_edit_single_opportunity_data($id);
        }
        elseif($result_array['post_for'] == 'simple')
        {
            $this->searchelastic_model->add_edit_single_post_data($id);
        }
        elseif($result_array['post_for'] == 'question')
        {
            $this->searchelastic_model->add_edit_single_question_data($id);
        }
        elseif($result_array['post_for'] == 'article')
        {
            $this->searchelastic_model->add_edit_single_article($id);
        }

        return true;
    }

    public function clear_search()
    {
        if ($this->session->userdata('user_search_keyword'))
        {
            $this->session->unset_userdata('user_search_keyword');
            redirect('posts/list','refresh');
        }
    }

    public function search()
    {
        if($this->input->post('search_keyword'))
        {
            $search_keyword = trim($this->input->post('search_keyword'));
        }
        elseif($this->session->userdata('user_search_keyword'))
        {
            $search_keyword = trim($this->session->userdata('user_search_keyword'));
        }
        else
        {
            redirect('posts/list','refresh');
        }
        $this->data['search_keyword'] = trim($search_keyword);
        $this->session->set_userdata('user_search_keyword', $search_keyword);
        $this->data['user_search_keyword'] = $this->session->userdata('user_search_keyword');

        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;
            $sortby = $this->uri->segment(3);
            $orderby = $this->uri->segment(4);
        } else {
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $sortby = 'id';
            $orderby = 'desc';
        }
  
        $this->data['offset'] = $offset;
        $this->paging['base_url'] = site_url("posts/search");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }
        $this->data['post_list'] =  $this->post_model->get_all_post_search($offset,$limit,$search_keyword);
        $total_rows =  $this->post_model->get_all_post_search_total($search_keyword);

        $this->paging['total_rows'] = $total_rows;
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);        
        // print_r($this->data['article_list']);exit();        
        $this->load->view('posts/list', $this->data);
    }

    public function promote_post()
    {
        $post_id = $this->input->post('post_id');
        $check_post = $this->input->post('check_post');

        if($check_post == 1)
        {
            $sql = "SELECT * FROM ailee_promoted_post WHERE post_id = '".$post_id."'";
            $promote_post = $this->db->query($sql)->row_array();
            if(isset($promote_post) && !empty($promote_post))
            {
                $update_data = array(
                    "status" => '2',
                    "priority" => '0',
                    "modify_date" => date('Y-m-d H:i:s', time()),
                );
                $this->db->where('id_promoted_post', $promote_post['id_promoted_post']);
                $updatdata = $this->db->update('promoted_post', $update_data);
                if ($updatdata) {
                    $this->session->set_flashdata('success', 'Post successfully added to promoted list.');
                    redirect('posts/list');
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not updated');
                    redirect('posts/list');
                }
            }
            else
            {
                $data = array(
                    'post_id' => $post_id,
                    'status' => '2',
                    "priority" => '0',
                    'created_date' => date('Y-m-d H:i:s', time()),
                    'modify_date' => date('Y-m-d H:i:s', time())
                );
                $insert_id = $this->common->insert_data_getid($data, 'promoted_post');
                if ($insert_id) {
                    $this->session->set_flashdata('success', 'Post successfully added to promoted list.');
                    redirect('posts/list');
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('posts/list');
                }
            }
        }
        else
        {
            $sql = "SELECT * FROM ailee_promoted_post WHERE post_id = '".$post_id."'";
            $promote_post = $this->db->query($sql)->row_array();
            if(isset($promote_post) && !empty($promote_post))
            {
                $update_data = array(
                    "status" => '0',
                    "priority" => '0',
                    "modify_date" => date('Y-m-d H:i:s', time()),
                );
                $this->db->where('id_promoted_post', $promote_post['id_promoted_post']);
                $updatdata = $this->db->update('promoted_post', $update_data);
                if ($updatdata) {
                    $this->session->set_flashdata('success', 'Post successfully remove from promoted list.');
                    redirect('posts/list');
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not updated');
                    redirect('posts/list');
                }
            }
            else
            {
                $data = array(
                    'post_id' => $post_id,
                    'status' => '0',
                    "priority" => '0',
                    'created_date' => date('Y-m-d H:i:s', time()),
                    'modify_date' => date('Y-m-d H:i:s', time())
                );
                $insert_id = $this->common->insert_data_getid($data, 'promoted_post');
                if ($insert_id) {
                    $this->session->set_flashdata('success', 'Post successfully remove from promoted list.');
                    redirect('posts/list');
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('posts/list');
                }
            }
        }
    }

    public function promoted_posts()
    {
        $this->data['promoted_post_list'] = $this->post_model->get_promoted_posts();
        $this->load->view('posts/promoted_post_list', $this->data);
    }

    public function set_post_priority()
    {
        $post_id = $this->input->post('post_id');
        $priority = $this->input->post('priority');
        $link_url = $this->input->post('link_url');
        $set_show_label = $this->input->post('set_show_label');
        $id_promoted_post = $this->input->post('id_promoted_post');
        $update_data = array(
            "status" => '1',
            "priority" => $priority,
            "link_url" => $link_url,
            "show_label" => $set_show_label,
            "modify_date" => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('post_id', $post_id);
        $this->db->where('id_promoted_post', $id_promoted_post);
        $updatdata = $this->db->update('promoted_post', $update_data);
        echo "1";
    }
}
