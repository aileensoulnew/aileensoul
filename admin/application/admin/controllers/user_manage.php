<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_manage extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        $this->load->model('searchelastic_model');
        $this->load->model('email_model');
        // Get Site Information
        $this->data['title']       = 'User Management | Aileensoul';
        $this->data['module_name'] = 'User Management';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', true);
        $this->paging = $this->config->item('paging');

        include 'include.php';
    }

    //for list of all user start
    public function user()
    {
        // This is userd for pagination offset and limoi start
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'user_id';

            $orderby = 'desc';

        }

        $this->data['offset'] = $offset;        

        $join_str[0]['table'] = "user_login";
        $join_str[0]['join_table_id'] = "user_login.user_id";
        $join_str[0]['from_table_id'] = "user.user_id";

        $join_str[1]['table'] = "user_info";
        $join_str[1]['join_table_id'] = "user_info.user_id";
        $join_str[1]['from_table_id'] = "user.user_id";

        $condition_array = array('user_login.email !=' => '');

        $select_data = "user.user_id,user.first_name ,user.last_name ,user_login.email ,user.user_dob ,user.user_verify ,user.user_gender, user_info.user_image, user_login.status, user_login.is_delete, user.created_date, user.user_slug";

        $this->data['users'] = $this->common->select_data_by_condition('user', $condition_array, $data = $select_data, $short_by = 'user_id', $order_by = 'desc', $limit, $offset, $join_str);

        $total_rows = $this->common->select_data_by_condition('user', $condition_array, $data = $select_data, $short_by = 'user_id', $order_by = 'desc', $limit = "", $offset = "", $join_str);

        // This is userd for pagination offset and limoi End

        //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("user_manage/user/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("user_manage/user/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('is_delete =' => '0');
        $this->paging['total_rows'] = count($total_rows);

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';

        $this->load->view('users/index', $this->data);
    }
    //activate user with ajax Start
    public function active_user()
    {
        $user_id = $_POST['user_id'];
        $data    = array(
            'status' => '1',
        );
        $update = $this->common->update_data($data, 'user', 'user_id', $user_id);

        $select = '<td id= "active(' . $user_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' . $user_id . ')">
                              Active
                      </button>';
        $select .= '</td>';
        echo $select;
        die();
    }
    //activate user with ajax End
    //deactivate user with ajax Start
    public function deactive_user()
    {
        $user_id = $_POST['user_id'];
        $data    = array(
            'status' => '0',
        );

        $update = $this->common->update_data($data, 'user', 'user_id', $user_id);

        $select = '<td id= "active(' . $user_id . ')">';
        $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' . $user_id . ')">
                              Deactive
                      </button>';
        $select .= '</td>';

        echo $select;
        die();
    }
    //deactivate user with ajax End

    //Delete user with ajax Start
    public function delete_user()
    {

        $user_id = $_POST['user_id'];        

        $u_data    = array(
            'status' => '0',
            'is_delete' => '1'
        );
        $update   = $this->common->update_data($u_data, 'user_login', 'user_id', $user_id);
        
        $b_data = array(
            'status' => '0',
            'is_deleted' => '1'
        );
        $update1 = $this->common->update_data($b_data, 'business_profile', 'user_id', $user_id);
        $update1 = $this->common->update_data($b_data, 'business_profile_search_tmp', 'user_id', $user_id);

        $p_data = array(
            'status' => 'draft',
            'is_delete' => '1'
        );
        $update1 = $this->common->update_data($p_data, 'user_post', 'user_id', $user_id);

        $this->searchelastic_model->delete_people_data($user_id);
        $this->searchelastic_model->delete_business_data($user_id);
        $this->searchelastic_model->delete_post_data($user_id);
        $this->searchelastic_model->delete_opportunity_data($user_id);
        $this->searchelastic_model->delete_question_data($user_id);
        $this->searchelastic_model->delete_article_data($user_id);

        die();
    }
    //Delete user with ajax End

    public function search()
    {

        if ($this->input->post('search_keyword')) {
            //echo "222"; die();

            $this->data['search_keyword'] = $search_keyword = trim($this->input->post('search_keyword'));

            $this->session->set_userdata('user_search_keyword', $search_keyword);

            $this->data['user_search_keyword'] = $this->session->userdata('user_search_keyword');

            // This is userd for pagination offset and limoi start
            $limit = $this->paging['per_page'];
            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

                $sortby = $this->uri->segment(3);

                $orderby = $this->uri->segment(4);

            } else {

                $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

                $sortby = 'user_id';

                $orderby = 'asc';

            }

            $this->data['offset'] = $offset;

            $join_str[0]['table'] = "user_login";
            $join_str[0]['join_table_id'] = "user_login.user_id";
            $join_str[0]['from_table_id'] = "user.user_id";

            $join_str[1]['table'] = "user_info";
            $join_str[1]['join_table_id'] = "user_info.user_id";
            $join_str[1]['from_table_id'] = "user.user_id";


            $data = 'user.user_id,user.first_name ,user.last_name ,user_login.email ,user.user_dob ,user.user_gender,user_info.user_image,user_login.status, user_login.is_delete, user.created_date, user.user_slug';

            $search_condition    = "((CONCAT(ailee_user.first_name,' ',ailee_user.last_name) LIKE '%$search_keyword%' OR CONCAT(ailee_user.last_name,' ',ailee_user.first_name) LIKE '%$search_keyword%') OR ailee_user_login.email LIKE '%$search_keyword%')";
            $contition_array     = array('ailee_user_login.email != ' => '');
            $this->data['users'] = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str);
            
            $total_rows = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data, $sortby, $orderby, $limit = '', $offset = '', $join_str);
            //echo "<pre>";print_r( $this->data['users']);die();
            // This is userd for pagination offset and limoi End

            // echo "<pre>";print_r($this->userdata['users'] );die();

            //This if and else use for asc and desc while click on any field start
            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("user_manage/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("user_manage/search/");

            }

            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($total_rows);

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);

        } else if ($this->session->userdata('user_search_keyword')) {
            $this->data['search_keyword'] = $search_keyword = trim($this->session->userdata('user_search_keyword'));
            // This is userd for pagination offset and limoi start
            $limit = $this->paging['per_page'];
            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

                $sortby = $this->uri->segment(3);

                $orderby = $this->uri->segment(4);

            } else {

                $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

                $sortby = 'user_id';

                $orderby = 'asc';

            }

            $this->data['offset'] = $offset;

            $join_str[0]['table'] = "user_login";
            $join_str[0]['join_table_id'] = "user_login.user_id";
            $join_str[0]['from_table_id'] = "user.user_id";

            $join_str[1]['table'] = "user_info";
            $join_str[1]['join_table_id'] = "user_info.user_id";
            $join_str[1]['from_table_id'] = "user.user_id";


            $data = 'user.user_id,user.first_name ,user.last_name ,user_login.email ,user.user_dob ,user.user_gender,user_info.user_image,user_login.status, user_login.is_delete, user.created_date, user.user_slug';

            $search_condition    = "((CONCAT(ailee_user.first_name,' ',ailee_user.last_name) LIKE '%$search_keyword%' OR CONCAT(ailee_user.last_name,' ',ailee_user.first_name) LIKE '%$search_keyword%') OR ailee_user_login.email LIKE '%$search_keyword%')";
            $contition_array     = array('ailee_user_login.email != ' => '');
            $this->data['users'] = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str);
            $total_rows = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data, $sortby, $orderby, $limit = '', $offset = '', $join_str);
            
            //echo "<pre>";print_r( $this->data['users']);die();
            // This is userd for pagination offset and limoi End

            // echo "<pre>";print_r($this->userdata['users'] );die();

            //This if and else use for asc and desc while click on any field start
            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("user_manage/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("user_manage/search/");

            }

            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($total_rows);

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
        }

        $this->load->view('users/index', $this->data);

    }

    //clear search is used for unset session start
    public function clear_search()
    {
        if ($this->session->userdata('user_search_keyword')) {

            $this->session->unset_userdata('user_search_keyword');

            redirect('user_manage/user', 'refresh');
        }
    }
    //clear search is used for unset session End

    public function edit($user_id)
    {

        $data = 'user_id,first_name ,last_name ,user_email ,user_dob ,user_gender,user_image';
        $contition_array = array('is_delete' => '0', 'user_id' => $user_id);
        $user_data = $this->data['users'] = $this->common->select_data_by_condition('user', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);
        $dob = $user_data[0]['user_dob'];
        $dob_final = explode('-', $dob);
        $this->data['year']  = $dob_final[0];
        $this->data['month'] = $dob_final[1];
        $day = $this->data['day']= $dob_final[2];
        $this->load->view('users/edit', $this->data);

    }
    public function edit_insert($id)
    {

        $date  = $this->input->post('select_day');
        $month = $this->input->post('select_month');
        $year  = $this->input->post('select_year');
        $dob   = $year . '-' . $month . '-' . $date;

        if (empty($_FILES['profilepic']['name'])) {

            $user_image = $this->input->post('image_name');
            // echo $userimage;die();

        } else {

            $user_image            = '';
            $user['upload_path']   = $this->config->item('user_main_upload_path');
            $user['allowed_types'] = $this->config->item('user_main_allowed_types');
            $user['max_size']      = $this->config->item('user_main_max_size');
            $user['max_width']     = $this->config->item('user_main_max_width');
            $user['max_height']    = $this->config->item('user_main_max_height');
            $this->load->library('upload');
            $this->upload->initialize($user);
            //Uploading Image
            $this->upload->do_upload('profilepic');
            //Getting Uploaded Image File Data
            $imgdata  = $this->upload->data();
            $imgerror = $this->upload->display_errors();

            if ($imgerror == '') {
                //Configuring Thumbnail
                $user_thumb['image_library']  = 'gd2';
                $user_thumb['source_image']   = $user['upload_path'] . $imgdata['file_name'];
                $user_thumb['new_image']      = $this->config->item('user_thumb_insert_upload_path') . $imgdata['file_name'];
                $user_thumb['create_thumb']   = true;
                $user_thumb['maintain_ratio'] = true;
                $user_thumb['thumb_marker']   = '';
                $user_thumb['width']          = $this->config->item('user_thumb_width');
                //$user_thumb['height'] = $this->config->item('user_thumb_height');
                $user_thumb['height']     = 2;
                $user_thumb['master_dim'] = 'width';
                $user_thumb['quality']    = "100%";
                $user_thumb['x_axis']     = '0';
                $user_thumb['y_axis']     = '0';
                //Loading Image Library
                $this->load->library('image_lib', $user_thumb);
                $dataimage = $imgdata['file_name'];
                //Creating Thumbnail
                $this->image_lib->resize();
                $thumberror = $this->image_lib->display_errors();
            } else {
                $thumberror = '';
            }
            if ($imgerror != '' || $thumberror != '') {
                $error[0] = $imgerror;
                $error[1] = $thumberror;
            } else {
                $error = array();
            }
            if ($error) {
                $this->session->set_flashdata('error', $error[0]);
                $redirect_url = site_url('user_manage/edit/' . $id);
                redirect($redirect_url, 'refresh');
            } else {
                $user_image = $imgdata['file_name'];
            }

            $data = array(
                'first_name'    => trim($this->input->post('first_name')),
                'last_name'     => trim($this->input->post('last_name')),
                'user_email'    => trim($this->input->post('user_email')),
                'user_dob'      => $dob,
                'user_gender'   => $this->input->post('gender'),
                'user_image'    => $user_image,
                'modified_date' => date('Y-m-d', time()),
            );

            //  echo "<pre>"; print_r($data);die();
            $updatdata = $this->common->update_data($data, 'user', 'user_id', $id);

            if ($updatdata) {

                redirect('user_manage/user', refresh);

            } else {

                $this->session->flashdata('error', 'Your data not inserted');
                redirect('user_manage/edit/' . $id, refresh);
            }

        }
    }

    public function send_verify_mail_user()
    {
        $user_id = $this->input->post('user_id');
        $sql = "SELECT u.first_name,u.last_name,ul.email FROM ailee_user u LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id WHERE u.user_id = '".$user_id."'";
        $user_data = $this->db->query($sql)->row_array();
        $first_name = $user_data['first_name'];
        $last_name = $user_data['last_name'];
        $to_email = $user_data['email'];
        $email_html = "";
        $email_html .= '<table cellpadding="0" cellspacing="0">
                    <tr>                                
                        <td class="reg-user-pad-cus">
                            <div class="user-content">
                                <p>
                                    <b>Hi '.ucwords($first_name). ' ' . ucwords($last_name). ',</b> please verify your email address.
                                </p>
                                <span>'.date('j F').' at '.date('H:i').'</span>
                            </div>
                        </td>
                        <td class="mail-btn">
                            <a href="' . base_url() . 'registration/verify/' . $user_insert . '" class="btn">View</a>
                        </td>
                    </tr>
                </table>';

        $this->data['main_part'] = $email_html;
        $this->data['unsubscribe_link'] = '';

        $email_html = $this->load->view('email_template/all_mail',$this->data,TRUE);

        $subject = ucwords($first_name).", Verify your Aileensoul Account";
        $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email,$unsubscribe);
        if($send_email){
            $this->session->set_flashdata('success', 'Verification mail send successfully.');
            echo "1";
        }
        else
        {
            $this->session->set_flashdata('error', 'Please try again leter.');
            echo "0";
        }
    }

    public function manual_verify_user()
    {
        $user_id = $this->input->post('user_id');
        $data = array(
            'user_verify' => '1',
            'verify_date' => date('Y-m-d h:i:s', time()),
        );
        $updatdata = $this->common->update_data($data, 'user', 'user_id', $user_id);
        if($updatdata)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
    }

    public function visitor()
    {
        // This is userd for pagination offset and limoi start
        $this->paging['per_page'] = 20;
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'user_id';

            $orderby = 'desc';

        }

        $this->data['offset'] = $offset;  

        
        $sql = "SELECT COUNT(*) AS visitor,DATE_FORMAT(insert_date,'%Y-%m-%d') AS visit_date FROM ailee_user_visit GROUP BY DATE_FORMAT(insert_date,'%Y-%m-%d') ORDER BY visit_date DESC LIMIT $offset,$limit";
        $this->data['site_visitor'] =  $this->db->query($sql)->result_array();

        $tot_sql = "SELECT COUNT(*) AS visitor,DATE_FORMAT(insert_date,'%Y-%m-%d') AS visit_date FROM ailee_user_visit GROUP BY DATE_FORMAT(insert_date,'%Y-%m-%d') ORDER BY visit_date DESC";
        $total_rows =  $this->db->query($tot_sql)->result_array();
        // This is userd for pagination offset and limoi End

        //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("user_manage/visitor/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("user_manage/visitor/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('is_delete =' => '0');
        $this->paging['total_rows'] = count($total_rows);

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);
        $this->load->view('users/user_visit', $this->data);
    }
}