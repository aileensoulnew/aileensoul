<?php
echo $header;
echo $leftmenu;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <img src="<?php echo SITEURL .'assets/img/i1.jpg' ?>" alt=""  style="height: 50px; width: 50px;">
            <?php echo $module_name; ?>
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li class="active">ALL User</li>
        </ol>
        <!-- <div class="fr">
                         <button name="Add" class="btn bg-orange btn-flat margin" ><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i> Add User</button>
        </div> -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row" >
            <div class="col-xs-12" >
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="callout callout-success">
                        <p><?php echo $this->session->flashdata('success'); ?></p>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error')) { ?>  
                    <div class="callout callout-danger">
                        <p><?php echo $this->session->flashdata('error'); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">ALL User</h3>
                        <div class="box-tools">
                           <?php echo form_open('user_manage/search', array('method' => 'post', 'id' => 'search_frm', 'class' => 'form-inline','autocomplete' => 'off')); ?>
                            <div class="input-group input-group-sm" >
                                <input type="text" class="form-control input-sm" value="<?php echo $search_keyword; ?>" placeholder="Search" name="search_keyword" id="search_keyword">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default" id="search_btn"><i class="fa fa-search"></i></button>
                                </div>
                                <?php echo form_close();
                                if ($this->session->userdata('user_search_keyword')){ ?>
                                    <a href="<?php echo base_url('user_manage/clear_search') ?>">Clear Search</a>
                                    <?php 
                                } ?>
                            </div><!--input-group input-group-sm-->
                        </div><!--box-tools-->
                    </div><!-- box-header -->

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr><?php
                                    if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'user'){
                                        $segment2 = 'user';
                                    }
                                    else {
                                        $segment2 = 'search';
                                    } ?>
                                    <th>
                                        <i class="fa fa-bullhorn"></i>
                                        <a href="javascript:void(0);">ID.</a>
                                    </th>
                                    <th>
                                        <i class="fa fa-user"></i>
                                        <a href="<?php echo ( $this->uri->segment(3) == 'first_name' && $this->uri->segment(4) == 'ASC') ? site_url($this->uri->segment(1) . '/' . $segment2 . '/first_name/DESC/' . $offset) : site_url($this->uri->segment(1) . '/' . $segment2 . '/first_name/ASC/' . $offset); ?>"> Name</a>
                                        <?php echo ( $this->uri->segment(3) == 'first_name' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'first_name' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' ); ?>
                                    </th>
                                    <th>
                                        <i class="fa fa-envelope"></i> 
                                        <a href="javascript:void(0);">Email</a>
                                    </th>
                                    <th>
                                        <i class="fa fa-fw fa-venus"></i> 
                                        <a href="javascript:void(0);">Gender</a>
                                    </th>
                                    <th>
                                        <i class="fa fa-fw fa-image"></i> 
                                        <a href="javascript:void(0);">Profile Image</a>
                                    </th>
                                    <!-- <th>
                                        <i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Status</a>
                                    </th> -->
                                    <th>
                                        <i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Created Date</a>
                                    </th>
                                    <th>
                                        <i class=" fa fa-edit"></i> 
                                        <a href="javascript:void(0);">Action</a>
                                    </th>
                                </tr>
                                <?php
                                if ($total_rows != 0) {
                                    $i = $offset + 1; 
                                    foreach ($users as $user) { ?>
                                        <tr id="delete<?php echo $user['user_id']?>">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo ucfirst($user['first_name']); echo ' ';echo ucfirst($user['last_name']);  ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['user_gender']; 
                                                    if($user['user_gender']=="F")
                                                    { ?>
                                                            <i class="fa fa-fw fa-female"></i>
                                                    <?php
                                                    }
                                                    if($user['user_gender']=="M"){ ?>
                                                        <i class="fa fa-fw fa-male"></i>
                                                        <?php
                                                    }?>
                                            </td>
                                            <td><?php
                                            if($user['user_image']) 
                                            { ?>
                                                <img src="<?php echo SITEURL . $this->config->item('user_thumb_upload_path') . $user['user_image']; ?>" alt=""  style="height: 50px; width: 50px;">
                                            <?php }else{ ?>
                                                <img alt="" style="height: 50px; width: 50px;" class="img-circle" src="<?php echo SITEURL.(NOIMAGE); ?>" alt="" />
                                            <?php } ?>
                                        </td>
                    
                                        <!-- <td id="active<?php echo $user['user_id']?>">
                                            <?php
                                                /*if ($user['status'] == '1' && $user['is_delete'] == '0') 
                                                {
                                                    echo "Active";
                                                }
                                                else if ($user['status'] == '0' && $user['is_delete'] == '1') 
                                                {
                                                    echo "Deleted";
                                                }*/ ?>
                                        </td> -->

                                        <td><?php echo $user['created_date']; ?></td>
                                        <td id="action-<?php echo $user['user_id']; ?>">
                                            <?php
                                                if ($user['status'] == '1' && $user['is_delete'] == '0') 
                                                { ?>
                                                    <button id="user_delete_<?php echo $user['user_id']; ?>" class="btn btn-danger btn-xs" onclick="delete_user(<?php echo $user['user_id']; ?>);">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                <?php
                                                }
                                                else{
                                                    echo "Deleted";
                                                } ?>
                                                
                                        </td>
                                    </tr>
                                    <?php
                                    }//for loop close
                                }//if close
                                else 
                                { ?>
                                    <tr>
                                        <td align="center" colspan="11"> Oops! No Data Found</td>
                                        </tr> <?php
                                } ?>
                            </tbody>
                        </table>
                    </div><!--box-body table-responsive no-padding -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="dta_left col-md-6" id="pagination">
                <?php
                if ($total_rows > 0){
                    if ($this->pagination->create_links()){
                        $rec1 = $offset + 1;
                        $rec2 = $offset + $limit;
                        if ($rec2 > $total_rows) 
                        {
                            $rec2 = $total_rows;
                        }
                        ?>
                        <div style="margin-left: 20px;">
                            <?php  echo "Records $rec1 - $rec2 of $total_rows"; ?>
                        </div><?php
                    }
                    else
                    { ?>
                        <div style="margin-left: 20px;">
                            <?php echo "Records 1 - $total_rows of $total_rows"; ?>
                        </div> <?php
                    }
                } ?>
            </div>
            <!-- dta_left col-md-6--> 
            <!-- /pagination Start-->
            <?php
            if ($this->pagination->create_links()) 
            {
                // $tot_client = ceil($total_rows / $limit);
                // $cur_client = ceil($offset / $limit) + 1; ?>
                <div class="text-right data_right col-md-6">
                    <div id="example2_paginate" class="dataTables_paginate paging_simple_numbers">
                        <?php echo $this->pagination->create_links(); ?> 
                    </div>
                </div><?php 
            } ?>
            <!-- /pagination End-->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade message-box biderror" id="deletemodal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lm">
        <div class="modal-content message">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <span class="mes">
                    <div class="msg"></div>
                    <div class="pop_content">
                        <div class="model_ok_cancel">
                            <a class="btn1 btn-lg" id="okbtn" onclick="" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
                            <a class="btn1 btn-lg" id="cancelbtn" href="javascript:void(0);" data-dismiss="modal" title="Cancel">Cancel</a>
                        </div>
                    </div>
                </span>
            </div>               
        </div>
    </div>
</div>

<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>

<script>
    //deactive user Start
   function deactive_user(user_id) 
   {
       $.fancybox.open('<div class="message"><h2>Are you Sure you want to  deactive this User?</h2><button id="activate" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');
        $('.message #activate').on('click', function () 
        {
            $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "user_manage/deactive_user" ?>',
                    data: 'user_id=' + user_id,
                    success: function (response) 
                    {    
                        $.fancybox.close();
                        $('#' + 'active' + user_id).html(response);
                    }
            });   
        });
    }
    //deactive user End

    //active user Start
   function active_user(user_id) 
   {
    
       $.fancybox.open('<div class="message"><h2>Are you Sure you want to  active this User?</h2><button id="deactivate" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #deactivate').on('click', function () 
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "user_manage/active_user" ?>',
                data: 'user_id=' + user_id,
                success: function (response) 
                {        
                    $.fancybox.close();  
                    $('#' + 'active' + user_id).html(response);
                }
            });   
        });
    }
    //active user End\

    //Delete user Start
   /*function delete_user(user_id) 
   {

       $.fancybox.open('<div class="message"><h2>Are you Sure you want to Delete this User?</h2><button id="delete" class="mesg_link btn btn1">OK</a><button data-fancybox-close="" class="btn btn1">Cancel</button></div>');

        $('.message #delete').on('click', function () 
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "user_manage/delete_user" ?>',
                data: 'user_id=' + user_id,
                cache: false,
                success: function (response) 
                {          
                    window.location.reload();
                }
            });   
        });
    }*/
    function delete_user(user_id) 
    {
      $("#deletemodal .mes .msg").html("Are you sure want to delete user ?");
      $("#okbtn").attr("onclick","user_delete("+user_id+")");
      $("#deletemodal").modal("show");
    }
    function user_delete(user_id){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "user_manage/delete_user" ?>',
            data: 'user_id=' + user_id,
            cache: false,
            success: function (response) 
            {
                $("#user_delete_"+user_id).remove();
                $("#action-"+user_id).html("Deleted");
                // window.location.reload();
            }
        });
    }
    //Delete user End

    //Enable search button when user write something on textbox Start
    $(document).ready(function(){
        $('#search_btn').attr('disabled',true);

        $('#search_keyword').keyup(function()
        {  
            if($(this).val().length !=0)
            {
                $('#search_btn').attr('disabled', false);
            }
            else
            {  
                $('#search_btn').attr('disabled', true);        
            }
        })

        $('body').on('keydown', '#search_keyword', function(e) {
            console.log(this.value);
            if (e.which === 32 &&  e.target.selectionStart === 0) {
                return false;
            }  
        });
    });
    //Enable search button when user write something on textbox End

// $(function() {
 
// });
</script>