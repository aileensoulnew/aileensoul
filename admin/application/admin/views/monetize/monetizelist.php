<?php
echo $header;
echo $leftmenu;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
   <section class="content-header">
        <h1>
            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
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
            <li class="active">Monetization</li>
        </ol>        
   </section>

   <!-- Main content -->
   <section class="content">
        <div class="row" >
            <div class="col-xs-12" >
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="callout callout-success">
                        <p><?php echo $this->session->flashdata('success'); ?></p>
                    </div>
                <?php }
                if ($this->session->flashdata('error')) { ?>  
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
                        <h3 class="box-title">Monetization</h3>                  
                    </div><!-- box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <?php
                                    if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'user') {
                                        $segment2 = 'user';
                                    } 
                                    else {
                                        $segment2 = 'search';
                                    }
                                    ?>
                                    <th><i class="fa fa-bullhorn"></i>
                                        <a href="javascript:void(0);">ID.</a>
                                    </th>
                                    <th style="width: 10%;"><i class="fa fa-user"></i>
                                        <a href="javascript:void(0);">Fullname</a>
                                    </th>
                                    <th><i class="fa fa-envelope"></i>
                                        <a href="javascript:void(0);">Email</a>
                                    </th>
                                    <th style="width: 15%;"><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Title</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Post for</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Description</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Created Date</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Status</a>
                                    </th>
                                    <th><i class=" fa fa-edit"></i> 
                                        <a href="javascript:void(0);">Action</a>
                                    </th>
                                </tr>
                                <?php
                                if (count($points_list) != 0){
                                   $i = $offset + 1; 
                                   foreach ($points_list as $_points_list) { ?>
                                        <tr id="delete<?php echo $_points_list['id_user_point_mapper'];?>">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo ucwords($_points_list['first_name'].' '.$_points_list['last_name']); ?></td>
                                            <td><?php echo $_points_list['email']; ?></td>
                                            <td><a href="<?php echo SITEURL.$_points_list['slug']; ?>"><?php echo $_points_list['title']; ?></a></td>
                                            <td><?php 
                                                if($_points_list['points_for'] == '1')
                                                  echo "Post opportunity";
                                                elseif($_points_list['points_for'] == '2')
                                                  echo "Post video";
                                                elseif($_points_list['points_for'] == '3')
                                                  echo "Post article";
                                                elseif($_points_list['points_for'] == '4')
                                                  echo "Give answer";
                                                elseif($_points_list['points_for'] == '5')
                                                  echo "Ask question";
                                                elseif($_points_list['points_for'] == '6')
                                                  echo "Post Image";
                                               ?></td>
                                            <td><?php echo substr($_points_list['description'], 0,200); ?></td>
                                         
                                            <td><?php echo $_points_list['created_date']; ?></td>
                                            <td id="status-<?php echo $_points_list['id_user_point_mapper']; ?>">
                                                <?php
                                                if($_points_list['point_status'] == '0'):
                                                    echo "Pending";
                                                elseif($_points_list['point_status'] == '1'):
                                                    echo "Approved";
                                                elseif($_points_list['point_status'] == '2'):
                                                    echo "Rejected";
                                                endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($_points_list['point_status'] == '0'):
                                                ?>
                                                    <button id="approve-btn-<?php echo $_points_list['id_user_point_mapper']; ?>" title="Approve" class="btn btn-primary btn-xs" onclick="approve_post_point(<?php echo $_points_list['id_user_point_mapper']; ?>);" >
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button id="reject-btn-<?php echo $_points_list['id_user_point_mapper']; ?>" title="Reject" class="btn btn-danger btn-xs art-pub-<?php echo $_points_list['id_user_point_mapper']; ?>" onclick="reject_post_point(<?php echo $_points_list['id_user_point_mapper']; ?>);">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                <?php 
                                                elseif($_points_list['point_status'] == '1'):?>
                                                    <button style="display: none;" id="approve-btn-<?php echo $_points_list['id_user_point_mapper']; ?>" title="Approve" class="btn btn-primary btn-xs" onclick="approve_post_point(<?php echo $_points_list['id_user_point_mapper']; ?>);" >
                                                        <i class="fa fa-check"></i>
                                                    </button>

                                                    <button id="reject-btn-<?php echo $_points_list['id_user_point_mapper']; ?>" title="Reject" class="btn btn-danger btn-xs art-pub-<?php echo $_points_list['id_user_point_mapper']; ?>" onclick="reject_post_point(<?php echo $_points_list['id_user_point_mapper']; ?>);">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                <?php
                                                elseif($_points_list['point_status'] == '2'):  ?>
                                                    <button id="approve-btn-<?php echo $_points_list['id_user_point_mapper']; ?>" title="Approve" class="btn btn-primary btn-xs art-pub-<?php echo $_points_list['id_user_point_mapper']; ?>" onclick="approve_post_point(<?php echo $_points_list['id_user_point_mapper']; ?>);" >
                                                        <i class="fa fa-check"></i>
                                                    </button>

                                                    <button style="display: none;" id="reject-btn-<?php echo $_points_list['id_user_point_mapper']; ?>" title="Reject" class="btn btn-danger btn-xs" onclick="reject_post_point(<?php echo $_points_list['id_user_point_mapper']; ?>);">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                <?php
                                                endif; ?>
                                            </td>
                                        </tr>
                                      <?php
                                   }//for loop close
                                }//if close
                                else 
                                { ?>
                                    <tr>
                                        <td align="center" colspan="11"> Oops! No Data Found</td>
                                    </tr>
                                    <?php
                                } ?>
                            </tbody>
                        </table>
                    </div><!--box-body table-responsive no-padding -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="dta_left col-md-6" id="pagination">
            <?php
            if ($total_rows > 0)
            {
                if ($this->pagination->create_links())
                {
                    $rec1 = $offset + 1;
                    $rec2 = $offset + $limit;
                    if ($rec2 > $total_rows) 
                    {
                        $rec2 = $total_rows;
                    } ?>
                    <div style="margin-left: 20px;">
                        <?php  echo "Records $rec1 - $rec2 of $total_rows"; ?>
                    </div>
                    <?php
                }
                else 
                { ?>
                    <div style="margin-left: 20px;">
                        <?php echo "Records 1 - $total_rows of $total_rows"; ?>
                    </div>
                <?php
                }
            } ?>
            </div><!-- dta_left col-md-6--> 
            <!-- /pagination Start-->
            <?php
            if ($this->pagination->create_links()) 
            {
                $tot_client = ceil($total_rows / $limit);
                $cur_client = ceil($offset / $limit) + 1; ?>
                <div class="text-right data_right col-md-6">
                    <div id="example2_paginate" class="dataTables_paginate paging_simple_numbers">
                        <?php echo $this->pagination->create_links(); ?> 
                    </div>
                </div>
            <?php
            } ?>
            <!-- /pagination End-->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Model Popup Start -->
<div class="modal fade message-box biderror" id="publishmodal" role="dialog" data-backdrop="static" data-keyboard="false">
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
<!-- Model Popup End -->

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
//Publish Article Start
function approve_post_point(id) 
{
  $("#publishmodal .mes .msg").html("Are you sure want to approve point for post ?");
  $("#okbtn").attr("onclick","approve_point("+id+")");
  $("#publishmodal").modal("show");
}
function approve_point(id) 
{
    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "monetize/approve_point" ?>',
        data: {'id':id},      
        success: function (response){
            $('#approve-btn-'+id).hide();
            $('#reject-btn-'+id).show();
            $('#status-'+id).html(response);            
        }
    });
}
//Publish Article End

//Reject Article Start
function reject_post_point(id) 
{
   $("#publishmodal .mes .msg").html("Are you sure want to reject point for post ?");
   $("#okbtn").attr("onclick","reject_point("+id+")");
   $("#publishmodal").modal("show");
}
function reject_point(id) 
{    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "monetize/reject_point" ?>',
        data: {'id':id},      
        success: function (response){
            $('#approve-btn-'+id).show();
            $('#reject-btn-'+id).hide();
            $('#status-'+id).html(response);            
        }
    });
}
//Reject Article End


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