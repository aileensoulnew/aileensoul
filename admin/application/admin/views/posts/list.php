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
            <li class="active">Post List</li>
        </ol>        
    </section>

   <!-- Main content -->
    <section class="content">
        <div class="row" >
            <div class="col-xs-12" >
                <?php 
                if ($this->session->flashdata('success')) { ?>
                    <div class="callout callout-success">
                        <p><?php echo $this->session->flashdata('success'); ?></p>
                    </div><?php 
                }
                if ($this->session->flashdata('error')) { ?>
                    <div class="callout callout-danger">
                        <p><?php echo $this->session->flashdata('error'); ?></p>
                    </div><?php 
                } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Post List</h3>
                        <div class="box-tools">
                            <?php echo form_open('posts/search', array('method' => 'post', 'id' => 'search_frm', 'class' => 'form-inline','autocomplete' => 'off')); ?>
                            <div class="input-group input-group-sm" >
                                <input type="text" class="form-control input-sm" value="<?php echo $search_keyword; ?>" placeholder="Search" name="search_keyword" id="search_keyword">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default" id="search_btn"><i class="fa fa-search"></i></button>
                                </div><!--input-group-btn-->
                                <?php echo form_close(); 
                                if ($this->session->userdata('user_search_keyword'))
                                {?>
                                    <a href="<?php echo base_url('posts/clear_search') ?>" style="padding: 5px 0;float: left;">Clear Search</a>
                                <?php
                                } ?>
                            </div><!--input-group input-group-sm-->
                        </div><!--box-tools-->
                    </div><!-- box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="col-xs-12">
                            <a id="del-all-btn" onclick="confirm('Are you sure delete all ?') ? alert(true) : false;" class="btn btn-danger btn-xs pull-right" href="javascript:void(0);" title="Delete All">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <?php
                                    if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'user') {
                                        $segment2 = 'user';
                                    } 
                                    else {
                                        $segment2 = 'search';
                                    }?>
                                    <th><i class="fa fa-list"></i>
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
                                    <th  style="width: 21%;"><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Post Type</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-bullhorn"></i> 
                                        <a href="javascript:void(0);">Promote</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Status</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Created Date</a>
                                    </th>
                                    <th><i class=" fa fa-edit"></i> 
                                        <a href="javascript:void(0);">Action
                                        </a>
                                    </th>
                                    <th><input type="checkbox" id="select_all_ids" class="select_all_ids" label="check all"  /></th>
                                </tr>
                                <?php
                                if (count($post_list) != 0){
                                    $i = $offset + 1; 
                                    foreach ($post_list as $_post_list) {?>
                                        <tr id="delete<?php echo $_post_list['id'];?>">
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php
                                                if($_post_list['user_type'] == '1'){ ?>
                                                    <a href="<?php echo SITEURL.$_post_list['user_data']['user_slug'] ?>" target="_blank">
                                                        <?php echo ucwords($_post_list['user_data']['first_name'].' '.$_post_list['user_data']['last_name']); ?>
                                                    </a>
                                                <?php
                                                }
                                                else{ ?>
                                                    <a href="<?php echo SITEURL.'company/'.$_post_list['user_data']['business_slug'].'-'.($_post_list['user_data']['city_name'] != '' ? $_post_list['user_data']['city_name'] : ($_post_list['user_data']['state_name'] != '' ? $_post_list['user_data']['state_name'] : $_post_list['user_data']['country_name'])) ?>" target="_blank">
                                                        <?php echo ucwords($_post_list['user_data']['company_name']); ?>
                                                    </a>
                                                <?php
                                                } ?>
                                            </td>
                                            <td>
                                                <?php echo $_post_list['user_data']['email']; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($_post_list['post_for'] == 'opportunity'){?>
                                                        <a href="<?php echo SITEURL.'o/'.$_post_list['opportunity_data']['oppslug']; ?>" target="_blank">
                                                        <?php
                                                            echo htmlentities($_post_list['opportunity_data']['opptitle']);
                                                        ?>
                                                        </a>
                                                    <?php 
                                                    }
                                                    elseif($_post_list['post_for'] == 'simple'){ ?>
                                                        <a href="<?php echo SITEURL.'p/'.$_post_list['simple_data']['simslug']; ?>" target="_blank">
                                                        <?php
                                                            echo htmlentities($_post_list['simple_data']['sim_title']);
                                                        ?>
                                                        </a>
                                                    <?php
                                                    }
                                                    elseif($_post_list['post_for'] == 'question'){
                                                        $question_slug = $this->common->create_slug($_post_list['question_data']['question']);
                                                        ?>
                                                        <a href="<?php echo SITEURL.'questions/'.$_post_list['question_data']['id'].'/'.$question_slug; ?>" target="_blank">
                                                        <?php
                                                        echo htmlentities($_post_list['question_data']['question']);
                                                        ?>
                                                        </a>
                                                    <?php
                                                    }
                                                    elseif($_post_list['post_for'] == 'article'){ ?>
                                                        <a href="<?php echo SITEURL.'article/'.$_post_list['article_data']['article_slug']; ?>" target="_blank">
                                                        <?php
                                                        echo htmlentities($_post_list['article_data']['article_title']);
                                                        ?>
                                                        </a>
                                                        <?php
                                                    }
                                                    elseif($_post_list['post_for'] == 'share'){
                                                    ?>
                                                        <a href="<?php echo SITEURL.'shp/'.$_post_list['share_data']['shared_post_slug']; ?>" target="_blank">
                                                        <?php
                                                        echo htmlentities($_post_list['share_data']['shared_post_slug']);
                                                        ?>
                                                        </a>
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td><?php echo $_post_list['post_for']; ?></td>

                                            <td>
                                                <?php 
                                                if($_post_list['status'] == 'publish' && $_post_list['is_delete'] == '0' && ($_post_list['post_for'] == 'opportunity' || $_post_list['post_for'] == 'simple' || $_post_list['post_for'] == 'question' || $_post_list['post_for'] == 'article')){
                                                    if($_post_list['is_promoted'] == '1' || $_post_list['is_promoted'] == '2')
                                                    {
                                                        $is_promoted = 'checked="checked"';
                                                    }
                                                    else
                                                    {
                                                        $is_promoted = '';
                                                    }
                                                    ?>  
                                                    <form name="promote-post" id="promote-post<?php echo $_post_list['id'];?>" action="<?php echo base_url('posts/promote_post'); ?>" method="post">
                                                        <input type="hidden" name="post_id" id="post_id<?php echo $_post_list['id'];?>" value="<?php echo $_post_list['id'];?>">
                                                        <input type="checkbox" name="check_post" id="check_post<?php echo $_post_list['id'];?>" onChange="this.form.submit()" value="1" <?php echo $is_promoted; ?> style="cursor: pointer;">
                                                    </form>
                                                <?php 
                                                } ?>
                                            </td>

                                            <td id="status-<?php echo $_post_list['id']; ?>">
                                                <?php 
                                                if($_post_list['status'] == 'publish' && $_post_list['is_delete'] == '0'){
                                                    echo "Active";
                                                }
                                                elseif($_post_list['is_delete'] == '1'){
                                                    echo "Deleted";
                                                }
                                                elseif($_post_list['status'] == 'reject'){
                                                    echo "Rejected";
                                                }
                                                elseif($_post_list['status'] == 'draft' && $_post_list['is_delete'] == '0'){
                                                    echo "Pending";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $_post_list['created_date']; ?></td>
                                            <td>
                                                <?php 
                                                if($_post_list['status'] == 'publish' && $_post_list['is_delete'] == '0'){
                                                    $is_pub = "style='display:none'";
                                                    $is_del = "";
                                                }
                                                elseif($_post_list['is_delete'] == '1'){
                                                    $is_pub = "";
                                                    $is_del = "style='display:none'";
                                                }
                                                else
                                                {
                                                    $is_pub = "style='display:none'";
                                                    $is_del = "style='display:none'";
                                                }
                                                ?>
                                                <a id="del-btn-<?php echo $_post_list['id']; ?>" class="btn btn-danger btn-xs" href="javascript:void(0);" title="Delete" <?php echo $is_del; ?> onclick="delete_post(<?php echo $_post_list['id']; ?>)">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                <a id="rev-btn-<?php echo $_post_list['id']; ?>" class="btn btn-info btn-xs" href="javascript:void(0);" title="Revoke" <?php echo $is_pub; ?> onclick="revoke_post(<?php echo $_post_list['id']; ?>)">
                                                    <i class="fa fa-reply"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <form name="delete-post" id="delete-post<?php echo $_post_list['id'];?>" action="<?php echo base_url('posts/post_delete'); ?>" method="post">
                                                    <input type="checkbox" name="delete_post_ids[]" id="delete_post_ids<?php echo $_post_list['id']; ?>" value="<?php echo $_post_list['id']; ?>" style="cursor: pointer;" class="post_delete_ids" /></td>
                                                </form>
                                        </tr><?php
                                    }//for loop close
                                }//if close
                                else{ ?>
                                <tr>
                                    <td align="center" colspan="11"> Oops! No Data Found</td>
                                </tr><?php
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
                </div><?php 
            } ?>
            <!-- /pagination End-->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!-- Model Popup Start -->
<div class="modal fade message-box biderror" id="action-modal" role="dialog" data-backdrop="static" data-keyboard="false">
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
    function delete_post(id){
        $("#action-modal .mes .msg").html("Are you sure want to delete this post ?");
        $("#okbtn").attr("onclick","post_delete("+id+")");
        $("#action-modal").modal("show");
    }
    function post_delete(id) 
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "posts/post_delete" ?>',
            cache: false,
            data: {'id':id},
            success: function (response){
                // $('.'+'art-pub-'+id).remove();
                $('#del-btn-'+id).hide();
                $('#rev-btn-'+id).show();
                $('#status-'+id).html("Deleted");
            }
        });
    }

    function revoke_post(id){
        $("#action-modal .mes .msg").html("Are you sure want to get back this post ?");
        $("#okbtn").attr("onclick","post_revoke("+id+")");
        $("#action-modal").modal("show");
    }

    function post_revoke(id) 
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "posts/post_revoke" ?>',
            cache: false,
            data: {'id':id},
            success: function (response){
                // $('.'+'art-pub-'+id).remove();
                $('#rev-btn-'+id).hide();
                $('#del-btn-'+id).show();
                $('#status-'+id).html("Active");
            }
        });
    }
    $(document).ready(function(){
        $('#select_all_ids').on('click',function(){
            if(this.checked){
                $('.post_delete_ids').each(function(){
                    this.checked = true;
                });
            }else{
                 $('.post_delete_ids').each(function(){
                    this.checked = false;
                });
            }
        });
        $('.post_delete_ids').on('click',function(){
            if($('.post_delete_ids:checked').length == $('.post_delete_ids').length){
                $('#select_all_ids').prop('checked',true);
            }else{
                $('#select_all_ids').prop('checked',false);
            }
        });
    });
</script>