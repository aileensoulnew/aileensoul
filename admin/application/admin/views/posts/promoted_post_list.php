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
                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Post Type</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-external-link"></i> 
                                        <a href="javascript:void(0);">Url</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-bullhorn"></i> 
                                        <a href="javascript:void(0);">Priority</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-bullhorn"></i> 
                                        <a href="javascript:void(0);">Change Priority</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Status</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Date</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil"></i> 
                                        <a href="javascript:void(0);">Show Label</a>
                                    </th>
                                    <th><i class=" fa fa-edit"></i> 
                                        <a href="javascript:void(0);">Action</a>
                                    </th>
                                </tr>
                                <?php
                                if (count($promoted_post_list) != 0){
                                    $i = $offset + 1; 
                                    foreach ($promoted_post_list as $_promoted_post_list) {?>
                                        <tr id="delete<?php echo $_promoted_post_list['id'];?>">
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php
                                                if($_promoted_post_list['user_type'] == '1'){ ?>
                                                    <a href="<?php echo SITEURL.$_promoted_post_list['user_data']['user_slug'] ?>" target="_blank">
                                                        <?php echo ucwords($_promoted_post_list['user_data']['first_name'].' '.$_promoted_post_list['user_data']['last_name']); ?>
                                                    </a>
                                                <?php
                                                }
                                                else{ ?>
                                                    <a href="<?php echo SITEURL.'company/'.$_promoted_post_list['user_data']['business_slug'].'-'.($_promoted_post_list['user_data']['city_name'] != '' ? $_promoted_post_list['user_data']['city_name'] : ($_promoted_post_list['user_data']['state_name'] != '' ? $_promoted_post_list['user_data']['state_name'] : $_promoted_post_list['user_data']['country_name'])) ?>" target="_blank">
                                                        <?php echo ucwords($_promoted_post_list['user_data']['company_name']); ?>
                                                    </a>
                                                <?php
                                                } ?>
                                            </td>
                                            <td>
                                                <?php echo $_promoted_post_list['user_data']['email']; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($_promoted_post_list['post_for'] == 'opportunity'){?>
                                                        <a href="<?php echo SITEURL.'o/'.$_promoted_post_list['opportunity_data']['oppslug']; ?>" target="_blank">
                                                        <?php
                                                            echo $_promoted_post_list['opportunity_data']['opptitle'];
                                                        ?>
                                                        </a>
                                                    <?php 
                                                    }
                                                    elseif($_promoted_post_list['post_for'] == 'simple'){ ?>
                                                        <a href="<?php echo SITEURL.'p/'.$_promoted_post_list['simple_data']['simslug']; ?>" target="_blank">
                                                        <?php
                                                            echo $_promoted_post_list['simple_data']['sim_title'];
                                                        ?>
                                                        </a>
                                                    <?php
                                                    }
                                                    elseif($_promoted_post_list['post_for'] == 'question'){
                                                        $question_slug = $this->common->create_slug($_promoted_post_list['question_data']['question']);
                                                        ?>
                                                        <a href="<?php echo SITEURL.'questions/'.$_promoted_post_list['question_data']['id'].'/'.$question_slug; ?>" target="_blank">
                                                        <?php
                                                        echo $_promoted_post_list['question_data']['question'];
                                                        ?>
                                                        </a>
                                                    <?php
                                                    }
                                                    elseif($_promoted_post_list['post_for'] == 'article'){ ?>
                                                        <a href="<?php echo SITEURL.'article/'.$_promoted_post_list['article_data']['article_slug']; ?>" target="_blank">
                                                        <?php
                                                        echo $_promoted_post_list['article_data']['article_title'];
                                                        ?>
                                                        </a>
                                                        <?php
                                                    }
                                                    elseif($_promoted_post_list['post_for'] == 'share'){
                                                    ?>
                                                        <a href="<?php echo SITEURL.'shp/'.$_promoted_post_list['share_data']['shared_post_slug']; ?>" target="_blank">
                                                        <?php
                                                        echo $_promoted_post_list['share_data']['shared_post_slug'];
                                                        ?>
                                                        </a>
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td><?php echo $_promoted_post_list['post_for']; ?></td>
                                            <td>
                                                <input type="text" name="link_url_<?php echo $_promoted_post_list['id']; ?>" id="link_url_<?php echo $_promoted_post_list['id']; ?>" value="<?php echo $_promoted_post_list['link_url']; ?>">
                                            </td>
                                            <td>
                                                <?php echo $_promoted_post_list['priority']; ?>
                                            </td>

                                            <td>
                                                <select name="set_priority_<?php echo $_promoted_post_list['id']; ?>" id="set_priority_<?php echo $_promoted_post_list['id']; ?>">
                                                    <option value="">0</option>

                                                    <option value="1" <?php echo $_promoted_post_list['priority'] == '1' ? 'selected="selected"' : ''; ?>>1</option>

                                                    <option value="2" <?php echo $_promoted_post_list['priority'] == '2' ? 'selected="selected"' : ''; ?>>2</option>

                                                    <option value="3" <?php echo $_promoted_post_list['priority'] == '3' ? 'selected="selected"' : ''; ?>>3</option>

                                                    <option value="4" <?php echo $_promoted_post_list['priority'] == '4' ? 'selected="selected"' : ''; ?>>4</option>

                                                    <option value="5" <?php echo $_promoted_post_list['priority'] == '5' ? 'selected="selected"' : ''; ?>>5</option>

                                                    <option value="6" <?php echo $_promoted_post_list['priority'] == '6' ? 'selected="selected"' : ''; ?>>6</option>

                                                    <option value="7" <?php echo $_promoted_post_list['priority'] == '7' ? 'selected="selected"' : ''; ?>>7</option>

                                                    <option value="8" <?php echo $_promoted_post_list['priority'] == '8' ? 'selected="selected"' : ''; ?>>8</option>

                                                    <option value="9" <?php echo $_promoted_post_list['priority'] == '9' ? 'selected="selected"' : ''; ?>>9</option>

                                                    <option value="10" <?php echo $_promoted_post_list['priority'] == '10' ? 'selected="selected"' : ''; ?>>10</option>

                                                    <option value="15" <?php echo $_promoted_post_list['priority'] == '15' ? 'selected="selected"' : ''; ?>>15</option>

                                                    <option value="20" <?php echo $_promoted_post_list['priority'] == '20' ? 'selected="selected"' : ''; ?>>20</option>

                                                    <option value="25" <?php echo $_promoted_post_list['priority'] == '25' ? 'selected="selected"' : ''; ?>>25</option>

                                                </select>
                                            </td>

                                            <td id="status-<?php echo $_promoted_post_list['id']; ?>">
                                                <?php 
                                                if($_promoted_post_list['promoted_status'] == '1')
                                                {
                                                    echo "Promoted";
                                                }
                                                elseif($_promoted_post_list['promoted_status'] == '2'){
                                                    echo "Pending";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $_promoted_post_list['created_date']; ?></td>
                                            <td>
                                                <select name="set_show_label_<?php echo $_promoted_post_list['id']; ?>" id="set_show_label_<?php echo $_promoted_post_list['id']; ?>">  
                                                    <option value="1" <?php echo $_promoted_post_list['show_label'] == '1' ? 'selected="selected"' : ''; ?>>Yes</option>
                                                    <option value="0" <?php echo $_promoted_post_list['show_label'] == '0' ? 'selected="selected"' : ''; ?>>No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a id="save-btn-<?php echo $_promoted_post_list['id']; ?>" class="btn btn-primary btn-xs" href="javascript:void(0);" title="Save Priority" onclick="set_post_priority(<?php echo $_promoted_post_list['id']; ?>,<?php echo $_promoted_post_list['id_promoted_post']; ?>)">
                                                    <i class="fa fa-save"></i>
                                                </a>

                                                <a id="remove-btn-<?php echo $_promoted_post_list['id']; ?>" class="btn btn-danger btn-xs" href="javascript:void(0);" title="Remove Promote Post" onclick="remove_promote_post(<?php echo $_promoted_post_list['id']; ?>,<?php echo $_promoted_post_list['id_promoted_post']; ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
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
        $('.callout-danger').delay(5000).hide('1000');
        $('.callout-success').delay(5000).hide('1000');
    });
</script>

<script>
    function set_post_priority(id,id_promoted_post){
        var priority = $("#set_priority_"+id).val();
        var link_url = $("#link_url_"+id).val();
        var set_show_label = $("#set_show_label_"+id).val();
        if(priority == 0 || priority == '')
        {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "posts/set_post_priority" ?>',
            cache: false,
            data: {'post_id':id,'priority':priority,'id_promoted_post':id_promoted_post,'link_url':link_url,'set_show_label':set_show_label},
            success: function (response){
                window.location.reload();
            }
        });
    }

    function remove_promote_post(post_id){
        $("#action-modal .mes .msg").html("Are you sure want to remove promoted post ?");
        $("#okbtn").attr("onclick","remove_post_promote("+post_id+")");
        $("#action-modal").modal("show");
    }

    function remove_post_promote(post_id) 
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "posts/remove_promote_post" ?>',
            cache: false,
            data: {'post_id':post_id},
            success: function (response){
                window.location.reload();
            }
        });
    }
</script>