<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Points extends CI_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }
        // Get Site Information
        $this->data['title']       = 'Points Management | Aileensoul';
        $this->data['module_name'] = 'Points Management';
        //Loadin Pagination Custome Config File
        $this->config->load('paging', true);
        $this->paging = $this->config->item('paging');
        include 'include.php';
    }

    public function index()
    {
        $this->data['title'] = 'Points Management | Aileensoul';
        $this->data['module_name'] = 'Points Management';
        $this->data['section_title'] = 'Points Management';        
        $sql = "SELECT * FROM ailee_points WHERE status = '1' ORDER BY id_points ASC";
        $this->data['points_data'] = $this->db->query($sql)->result_array();
        $this->load->view('points/list_points', $this->data);   
    }
    public function add_points()
    {
        $this->data['title'] = 'Points Management | Aileensoul';
        $this->data['module_name'] = 'Points Management';
        $this->data['section_title'] = 'Points Management';
        $this->data['id_points'] = '';
        $this->load->view('points/addedit_points', $this->data);
    }

    public function edit_points($id_points)
    {
        $this->data['title'] = 'Points Management | Aileensoul';
        $this->data['module_name'] = 'Points Management';
        $this->data['section_title'] = 'Points Management';
        $this->data['id_points'] = $id_points;
        $sql = "SELECT * FROM ailee_points WHERE id_points = '".$id_points."'";
        $this->data['points_data'] = $this->db->query($sql)->row_array();
        $this->load->view('points/addedit_points', $this->data);
    }

    public function save_points()
    {
        $id_points = ($this->input->post('id_points') ? $this->input->post('id_points') : 0);
        $post_type = $this->input->post('post_type');
        $point = $this->input->post('point');
        if($id_points == 0)
        {
            $data = array(
                'post_type' => $post_type,
                'points' => $point,
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time())
            );
            $insert_id = $this->common->insert_data_getid($data, 'points');
            if ($insert_id) {
                $this->session->set_flashdata('success', 'New Points Added successfully');
                redirect('points');
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('points/add_points');
            }
        }
        else
        {
            $data = array(
                'post_type' => $post_type,
                'points' => $point,
                'status' => '1',
                'modify_date' => date('Y-m-d H:i:s', time())
            );
            $updatdata = $this->common->update_data($data, 'points', 'id_points', $id_points);

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Points updated successfully');
                 redirect('points');
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not updated');
                redirect('points/edit_points/'.$id);
            }
        }
    }

}