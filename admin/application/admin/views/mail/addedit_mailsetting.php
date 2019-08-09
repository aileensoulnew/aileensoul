<?php
echo $header;
echo $leftmenu;
$host_name = "";
$outgoing_port = "";
$username = "";
$password = "";
$from_email = "";
$from_name = "";
$replyto_email = "";
$replyto_name = "";
$smtp_secure = "";

if(isset($setting_data) && !empty($setting_data))
{
    $host_name = $setting_data['host_name'];
    $outgoing_port = $setting_data['out_going_port'];
    $username = $setting_data['user_name'];
    $password = $setting_data['password'];
    $from_email = $setting_data['from_email'];
    $from_name = $setting_data['from_name'];
    $replyto_email = $setting_data['replyto_email'];
    $replyto_name = $setting_data['replyto_name'];
    $smtp_secure = $setting_data['smtp_secure'];
}
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
                    <form id="add-setting" name="add-setting" method="post" action="<?php echo base_url('email/save_setting'); ?>">
                        <input type="hidden" name="id_email_settings" id="id_email_settings" value="<?php echo $id_email_settings; ?>">                                               
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="host_name" name="host_name_lbl" id="host_name_lbl">Host Name*</label>
                                <input type="input" class="form-control" name="host_name" id="host_name" maxlength="200" value="<?php echo $host_name; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="outgoing_port" name="outgoing_port_lbl" id="outgoing_port_lbl">Out Going Port*</label>
                                <input type="input" class="form-control" name="outgoing_port" id="outgoing_port" maxlength="200" value="<?php echo $outgoing_port; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="username" name="username_lbl" id="username_lbl">User Name*</label>
                                <input type="input" class="form-control" name="username" id="username" maxlength="200" value="<?php echo $username; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="password" name="password_lbl" id="password_lbl">Password*</label>
                                <input type="input" class="form-control" name="password" id="password" maxlength="200" value="<?php echo $password; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-5">
                                <label for="from_email" name="from_email_lbl" id="from_email_lbl">From Email*</label>
                                <input type="input" class="form-control" name="from_email" id="from_email" maxlength="200" value="<?php echo $from_email; ?>">
                            </div>
                        
                            <div class="form-group col-sm-5">
                                <label for="from_name" name="from_name_lbl" id="from_name_lbl">From Name*</label>
                                <input type="input" class="form-control" name="from_name" id="from_name" maxlength="200" value="<?php echo $from_name; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-5">
                                <label for="replyto_email" name="replyto_email_lbl" id="replyto_email_lbl">Reply To Email*</label>
                                <input type="input" class="form-control" name="replyto_email" id="replyto_email" maxlength="200" value="<?php echo $replyto_email; ?>">
                            </div>                        
                            <div class="form-group col-sm-5">
                                <label for="replyto_name" name="replyto_name_lbl" id="replyto_name_lbl">Reply To Name*</label>
                                <input type="input" class="form-control" name="replyto_name" id="replyto_name" maxlength="200" value="<?php echo $replyto_name; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-10">
                                <label for="smtp_secure" name="smtp_secure_lbl" id="smtp_secure_lbl">SMTP Secure*(tls,ssl)</label>
                                <input type="input" class="form-control" name="smtp_secure" id="smtp_secure" maxlength="200" value="<?php echo $smtp_secure; ?>">
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
        $("#add-setting").validate({
            rules: {
                host_name: {
                    required: true,
                },
                outgoing_port: {
                    required: true,
                },
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
                from_email: {
                    required: true,
                    email: true
                },
                from_name: {
                    required: true,
                },
                replyto_email: {
                    required: true,
                    email: true
                },
                replyto_name: {
                    required: true,
                },
                smtp_secure: {
                    required: true,
                },
            },
        });
    });    
    $(".alert").delay(3200).fadeOut(300);
</script>