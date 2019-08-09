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
            <li class="active">User Visit</li>
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
                        <h3 class="box-title">User Visit</h3>                        
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
                                        <i class="fa fa-clock-o"></i>
                                        <a href="javascript:void(0);">Visit Date</a>
                                    </th>
                                    <th>
                                        <i class="fa fa-fw fa-user-md"></i> 
                                        <a href="javascript:void(0);">Visitor</a>
                                    </th>
                                </tr>
                                <?php
                                if ($total_rows != 0) {
                                    $i = $offset + 1; 
                                    foreach ($site_visitor as $_site_visitor) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $_site_visitor['visit_date']; ?></td>
                                            <td><?php echo $_site_visitor['visitor']; ?></td>
                                        </tr>
                                    <?php
                                    }//for loop close
                                }//if close
                                else 
                                { ?>
                                    <tr>
                                        <td align="center" colspan="3"> Oops! No Data Found</td>
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

<script type="text/javascript">    
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
                $("#verify-"+user_id).html("Deleted");
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

    //Verification Email
    function send_verify_mail_user(user_id){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "user_manage/send_verify_mail_user" ?>',
            data: 'user_id=' + user_id,
            cache: false,
            success: function (response) 
            {                
                window.location.reload();
            }
        });
    }

    //Manual Verification
    function manual_verify_user(user_id){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "user_manage/manual_verify_user" ?>',
            data: 'user_id=' + user_id,
            cache: false,
            success: function (response) 
            {
                if(response == '1')
                {
                    $("#verify-"+user_id).html("Verifed");
                }
            }
        });
    }
</script>