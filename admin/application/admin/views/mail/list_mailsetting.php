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
            <li class="active">Email Setting</li>
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
                        <h3 class="box-title">Email Setting</h3>
                        <div class="box-tools">
                            <a href="<?php echo base_url('email/add_setting') ?>"><i class="fa fa-plus"></i> Add Email Setting</a>
                        </div>
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
                                    <th><i class="fa fa-bullhorn"></i>
                                        <a href="javascript:void(0);">ID.</a>
                                    </th>
                                    <th style="width: 10%;"><i class="fa fa-file"></i>
                                        <a href="javascript:void(0);">Host Name</a>
                                    </th>
                                    <th><i class="fa fa-gift"></i>
                                        <a href="javascript:void(0);">Username</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-pencil-square"></i> 
                                        <a href="javascript:void(0);">Modify Date</a>
                                    </th>
                                    <th><i class="fa fa-fw fa-info-circle"></i> 
                                        <a href="javascript:void(0);">Status</a>
                                    </th>
                                    <th><i class=" fa fa-edit"></i> 
                                        <a href="javascript:void(0);">Action</a>
                                    </th>
                                </tr>
                                <?php
                                if (count($setting_data) != 0){
                                    $i=1;
                                    foreach ($setting_data as $_setting_data) {?>
                                        <tr id="row<?php echo $_setting_data['id_email_settings'];?>">
                                            <td><?php echo $i; ?></td>
                                            <td><?php
                                                echo $_setting_data['host_name'];
                                            ?></td>
                                            <td><?php echo $_setting_data['user_name']; ?></td>
                                            <td><?php echo $_setting_data['modify_date']; ?></td>
                                            <td><?php echo $_setting_data['status'] == '1' ? "Active" : "Deactive"; ?></td>           
                                            <td>
                                                <?php if($_setting_data['status'] == '0'){ ?>
                                                    <a class="btn btn-info btn-xs" href="javascript:void(0);" title="Active" onclick="active_setting(<?php echo $_setting_data['id_email_settings'];?>)">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                <?php } ?>
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url('email/edit_setting/'.$_setting_data['id_email_settings'] ); ?>" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr><?php
                                        $i++;
                                    }//for loop close
                                }//if close
                                else{ ?>
                                <tr>
                                    <td align="center" colspan="6"> Oops! No Data Found</td>
                                </tr><?php
                                } ?>
                            </tbody>
                        </table>
                    </div><!--box-body table-responsive no-padding -->
                </div><!-- /.box -->
            </div><!-- /.col -->            
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

    function active_setting(id){
        $("#action-modal .mes .msg").html("Other email setting will deactive and this setting is active only.<br>Its effect whole site. Are you sure you want to active this setting ?");
        $("#okbtn").attr("onclick","setting_active("+id+")");
        $("#action-modal").modal("show");
    }
    function setting_active(id) 
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "email/setting_active" ?>',
            cache: false,
            data: {'id':id},
            success: function (response){
                window.location.reload();
            }
        });
    }
</script>