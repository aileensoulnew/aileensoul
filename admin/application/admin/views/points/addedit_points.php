<?php
echo $header;
echo $leftmenu;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-rss" aria-hidden="true"></i>
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
            <li class="active"><?php echo $module_name; ?></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $section_title; ?></h3>
                    </div><!-- /.box-header -->
                    <div>
                        <?php
                        if ($this->session->flashdata('error')) {
                            echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                        }
                        if ($this->session->flashdata('success')) {
                            echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                        }?>
                    </div>
                    <!-- form start -->                    
                    <form id="add-points" name="add-points" method="post" action="<?php echo base_url('points/save_points'); ?>">
                        <input type="hidden" name="id_points" id="id_points" value="<?php echo $id_points; ?>">
                        <?php 
                        if(isset($points_data) && !empty($points_data)){
                            $post_type = $points_data['post_type'];
                            $points = $points_data['points'];
                        }
                        else{
                            $post_type = '';
                            $points = '';
                        } ?>
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="post_type" name="post_type_lbl" id="post_type_lbl">Points Type*</label>
                                <select class="form-control" id="post_type" name="post_type">
                                    <option value="">Select Point Type</option>
                                    <option value="1" <?php echo ($post_type == '1' ? 'selected="selected"' : '' ); ?>>Opportunity</option>
                                    <option value="2" <?php echo ($post_type == '2' ? 'selected="selected"' : '' ); ?>>Post Video</option>
                                    <option value="3" <?php echo ($post_type == '3' ? 'selected="selected"' : '' ); ?>>Post Article</option>
                                    <option value="4" <?php echo ($post_type == '4' ? 'selected="selected"' : '' ); ?>>Give Answer</option>
                                    <option value="5" <?php echo ($post_type == '5' ? 'selected="selected"' : '' ); ?>>Ask Question</option>
                                    <option value="6" <?php echo ($post_type == '6' ? 'selected="selected"' : '' ); ?>>Post Photo</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="point" name="point_lbl" id="point_lbl">Point*</label>
                                <input type="input" class="form-control" name="point" id="point" value="<?php echo $points; ?>" maxlength="3">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btn_save" name="btn_save" type="submit" class="btn btn-primary">Save</button>
                            <button type="button" onclick="window.history.back();" class="btn btn-default">Back</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php echo $footer; ?>
<!-- <script src="<?php //echo base_url('admin/assets/js/jquery.min.js?ver='.time()); ?>"></script> -->
<script src="<?php echo base_url('admin/assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>'; 
    //validation for edit email formate form
    $(document).ready(function () {
        $("#add-points").validate({
            rules: {
                post_type: {
                    required: true,
                },
                point: {
                    required: true,
                    number: true
                },
            },
            messages:
            {
                post_type: {
                    required: "Please select point type",
                },
                point: {
                    required: "Please enter point",
                },
            },
        });
    });    
    $(".alert").delay(3200).fadeOut(300);
</script>