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
            <li class="active">Points</li>
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
                        <h3 class="box-title">Points</h3>
                        <div class="box-tools">
                            <a href="<?php echo base_url('points/add_points') ?>"><i class="fa fa-plus"></i> Add Points</a>
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
                                        <a href="javascript:void(0);">Post Type</a>
                                    </th>
                                    <th><i class="fa fa-gift"></i>
                                        <a href="javascript:void(0);">Points</a>
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
                                if (count($points_data) != 0){
                                    $i=1;
                                    foreach ($points_data as $_points_data) {?>
                                        <tr id="row<?php echo $_points_data['id_points'];?>">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php
                                                if($_points_data['post_type'] == '1'){
                                                    echo "Opportunity";
                                                }
                                                elseif($_points_data['post_type'] == '2'){
                                                    echo "Post Video";
                                                }
                                                elseif($_points_data['post_type'] == '3'){
                                                    echo "Post Article";
                                                }
                                                elseif($_points_data['post_type'] == '4'){
                                                    echo "Give Answer";
                                                }
                                                elseif($_points_data['post_type'] == '5'){
                                                    echo "Ask Question";
                                                }
                                                elseif($_points_data['post_type'] == '6'){
                                                    echo "Post Photo";
                                                }
                                            ?></td>
                                            <td><?php echo $_points_data['points']; ?></td>
                                            <td><?php echo $_points_data['modify_date']; ?></td>
                                            <td><?php echo $_points_data['status'] == '1' ? "Active" : "Deactive"; ?></td>           
                                            <td>
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url('points/edit_points/'.$_points_data['id_points'] ); ?>" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr><?php
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

<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('.callout-danger').delay(3000).hide('700');
        $('.callout-success').delay(3000).hide('700');
    });
</script>