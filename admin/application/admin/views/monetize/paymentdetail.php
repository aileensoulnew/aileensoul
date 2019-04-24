<?php
echo $header;
echo $leftmenu;
?>
<style type="text/css">
    .feedback-img {
        width: 25% !important;
        float: left;
        padding-left: 10px;
        height: 180px;
    }
    .feedback-img img {
        height: 170px;
        width: 170px;
    }

    .feedback .modal-dialog{
        margin: 15px auto !important;
    }
    .pop_content img {
        width: 100%;
    }
    del.diffmod {
    color: red;
    display: none;
    }

    ins.diffmod {
    color: #000;
    background: #1b8ab921;
    text-decoration: none
    }

    ins.diffins {
    color: #000;
    background: #1b8ab921;
    text-decoration: none;
    }
    ins.mod {
    text-decoration: none;
    }
    del.diffdel {
    display: none;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>            
            <?php echo $module_name; ?>
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard"></i>Home
                </a>
            </li>
            <li class="active">Payment Detail</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content feedback">
        <div class="row">
            <div class="col-md-6">
                <!-- About Me Box -->
                <div class="box box-primary mt0">
                    <div class="box-header with-border">
                        <h3 class="box-title">About User</h3>
                    </div>
                    <div class="box-body">
                        <strong>Full Name</strong>
                        <p> <?php echo ucwords($payment_detail['first_name'] . ' ' . $payment_detail['last_name']); ?> </p>
                        <strong>Email Address</strong>
                        <p> <?php echo $payment_detail['email']; ?> </p>
                        <strong>Earn Point</strong>
                        <p> <?php echo $payment_detail['earn_points']; ?> </p>
                        <strong>Earn Amount</strong>
                        <p> <?php echo $payment_detail['earn_amount']; ?> </p>
                        <strong>Threshold Date</strong>
                        <p> <?php echo date("d M,Y", strtotime($payment_detail['modify_date'])); ?> </p>
                        <?php if($payment_detail['payment_date'] != ''){ ?>
                            <strong>Payment Date</strong>
                            <p> <?php echo date("d M,Y", strtotime($payment_detail['payment_date'])); ?> </p>
                        <?php } ?>
                    </div>
                </div>
                <div class="box box-primary mt0">
                    <div class="box-body box-profile">
                        <div class="profile-username text-center payment-<?php echo $payment_detail['id_user_payment_mapper']; ?>">
                            <?php
                            if ($payment_detail['status'] == 'unpaid'): ?>
                                <a class="btn1 btn-lg" id="paybtn" onclick="pay_amount(<?php echo $payment_detail['id_user_payment_mapper']; ?>)" href="javascript:void(0);" data-dismiss="modal" title="Pay Amount">Pay Amount</a>
                                <a class="btn1 btn-lg" id="rejectbtn" onclick="reject_amount(<?php echo $payment_detail['id_user_payment_mapper']; ?>)" href="javascript:void(0);" data-dismiss="modal" title="Reject">Reject</a>
                            <?php
                            elseif ($payment_detail['status'] == 'paid'): ?>
                                <a class="btn1 btn-lg" id="paycomplebtn" href="javascript:void(0);" title="Payment Complete">Payment Completed</a>
                            <?php
                            elseif ($payment_detail['status'] == 'reject'): ?>
                                <a class="btn1 btn-lg" id="payrejectbtn" href="javascript:void(0);" title="Payment Rejected">Payment Rejected</a>
                            <?php
                            endif;?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-primary mt0">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bank detail</h3>
                    </div>
                    <?php if ($bank_detail): ?>
                    <div class="box-body">
                        <strong>Bank Name</strong>
                        <p> <?php echo ucwords($bank_detail['bank_name']); ?> </p>
                        <strong>Bank Account Holder Name</strong>
                        <p> <?php echo ucwords($bank_detail['bank_ac_holder_name']); ?> </p>
                        <strong>Bank Account Number</strong>
                        <p> <?php echo $bank_detail['bank_ac_number']; ?> </p>
                        <strong>Bank IFSC Code</strong>
                        <p> <?php echo $bank_detail['bank_ifsc']; ?> </p>
                        <strong>Bank SWIFT Code</strong>
                        <p> <?php echo $bank_detail['bank_swift']; ?> </p>
                        <strong>User Contact Number</strong>
                        <p> <?php echo '(' . $bank_detail['country_code'] . ') ' . $bank_detail['contact_number']; ?> </p>
                    </div>
                <?php endif;?>
                </div>
            </div>
        </div>
     </section>
     <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Footer start -->
<?php echo $footer; ?>
<!-- Footer End -->
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
</body>
</html>

<!-- This script and css are used for tabbing at graduation and work experience Start -->
<script type="text/javascript">

function pay_amount(id)
{
   $("#publishmodal .mes .msg").html("Are you sure want to complete payment ?");
   $("#okbtn").attr("onclick","amount_pay("+id+")");
   $("#publishmodal").modal("show");
}
function reject_amount(id)
{
   $("#publishmodal .mes .msg").html("Are you sure want to reject payment ?");
   $("#okbtn").attr("onclick","amount_reject("+id+")");
   $("#publishmodal").modal("show");
}

function amount_pay(id)
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "monetize/payamount" ?>',
        data: {'id':id},
        success: function (response){
            $('.'+'payment-'+id).html('<a class="btn1 btn-lg" id="paycomplebtn" href="javascript:void(0);" title="Payment Complete">'+response+'</a>');
        }
    });
}
function amount_reject(id)
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . "monetize/rejectamount" ?>',
        data: {'id':id},
        success: function (response){
            // $('.'+'art-pub-'+id).html(response);
            $('.'+'payment-'+id).html('<a class="btn1 btn-lg" id="payrejectbtn" href="javascript:void(0);" title="Payment Complete">'+response+'</a>');
        }
    });
}
</script>
