<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: ' . $date);
header('Last-Modified: ' . $date);

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html lang="en">
    <head>
        <title>Registration - Aileensoul</title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="description" content="Register into Aileensoul.com for Free, Find job search, Hire employee, Get Freelance work, Grow business network & make Artistic Profiles.">


        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
        <?php } ?>

        
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <script data-pagespeed-no-defer src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
        <script data-pagespeed-no-defer src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> 
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="registeration outer-page">
        <div class="main-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 left-header col-xs-4 fw-479">
                            <?php $this->load->view('main_logo'); ?>
                        </div>
                        <div class="col-md-6 col-sm-6 right-header col-xs-8 fw-479">
                            <div class="btn-right">
                                <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                  <!--              <a href="<?php echo base_url('registration'); ?>" class="btn3">creat an account</a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="middle-main">
                <div class="container">

                    <div class="form-pd row">
                        <div class="inner-form pt-100">
                            <div class="login">
                                <div class="title">
                                    <h1>Join Aileensoul - It's Free</h1>
                                </div>
                                <form name="register_form" id="register_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="first_name" id="first_name" tabindex="1" class="form-control input-sm" placeholder="First Name*">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="last_name" tabindex="2" id="last_name" class="form-control input-sm" placeholder="Last Name*">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email_reg" id="email_reg" tabindex="3" class="form-control input-sm" placeholder="Email Address*" autocomplete="new-email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_reg" id="password_reg" tabindex="4" class="form-control input-sm" placeholder="Password*" autocomplete="new-password">
                                    </div>
                                    <div class="form-group dob">
                                        <label class="d_o_b"> Date Of Birth *:</label>
                                        <!--span class="d_o_b">DOB </span-->
                                        <span>
                                            <select class="day" name="selday" id="selday" tabindex="5">
                                                <option value="" disabled selected>Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </span>
                                        <span>
                                            <select class="month" name="selmonth" id="selmonth" tabindex="6">
                                                <option value="" disabled selected>Month</option>
                                                <?php
//                  for($i = 1; $i <= 12; $i++){
                                                ?>
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                                <option value="3">Mar</option>
                                                <option value="4">Apr</option>
                                                <option value="5">May</option>
                                                <option value="6">Jun</option>
                                                <option value="7">Jul</option>
                                                <option value="8">Aug</option>
                                                <option value="9">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                                <?php
                                                //  }
                                                ?>
                                            </select>
                                        </span>
                                        <span>
                                            <select class="year" name="selyear" id="selyear" tabindex="7">
                                                <option value="" disabled selected>Year</option>
                                                <?php
                                                for ($i = date('Y'); $i >= 1900; $i--) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select></span>

                                    </div>

                                    <div class="form-group gender-custom">
                                        <span>
                                            <select class="gender" name="selgen" id="selgen" tabindex="8">
                                                <option value="" disabled selected>Gender*</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </span>
                                    </div>

                                    <div class="clr-c fs12 form-group term_condi_check">
                                        <label id="lbl_term_condi" class="control control--checkbox" for="term_condi">
                                            <input tabindex="9" type="checkbox" name="term_condi" id="term_condi" value="1" />
                                            <span>I have read and agree to use this website as subjected to Aileensoul</span> 
                                            <a tabindex="10" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="11" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                    <p>
                                        <button class="btn1" tabindex="12">Create an account</button>
                                    </p>

                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="12" href="<?php echo base_url('login'); ?>" > Log In </a>
                                        </p>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </section>

            
        </div>
		<?php
            echo $login_footer
            ?>
        <script>
            $(document).ready(function () {

                // text animation effect 
                var $lines = $('.top-middle h3.text-effect');
                $lines.hide();
                var lineContents = new Array();

                var terminal = function () {

                    var skip = 0;
                    typeLine = function (idx) {
                        idx == null && (idx = 0);
                        var element = $lines.eq(idx);
                        var content = lineContents[idx];
                        if (typeof content == "undefined") {
                            $('.skip').hide();
                            return;
                        }
                        var charIdx = 0;

                        var typeChar = function () {
                            var rand = Math.round(Math.random() * 150) + 25;

                            setTimeout(function () {
                                var char = content[charIdx++];
                                element.append(char);
                                if (typeof char !== "undefined")
                                    typeChar();
                                else {
                                    element.append('<br/><span class="output">' + element.text().slice(9, -1) + '</span>');
                                    element.removeClass('active');
                                    typeLine(++idx);
                                }
                            }, skip ? 0 : rand);
                        }
                        content = '' + content + '';
                        element.append(' ').addClass('active');
                        typeChar();
                    }

                    $lines.each(function (i) {
                        lineContents[i] = $(this).text();
                        $(this).text('').show();
                    });

                    typeLine();
                }

                terminal();

            });
        </script>
        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <?php } ?>

        <script src='<?php echo base_url(); ?>assets/chatjs/strophe.js'></script>
        <script src='<?php echo base_url(); ?>assets/chatjs/strophe.register.js'></script>
        <!-- validation for edit email formate form strat -->

        <script>
            var openfirelink = '<?php echo OPENFIRELINK; ?>';
            var openfireserver = '<?php echo OPENFIRESERVER; ?>';
            var conn_new = new Strophe.Connection(openfirelink);
            $(document).ready(function () {
                $("#register_form").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        email_reg: {
                            required: true,
                            remote: {
                                url: "<?php echo site_url() . 'registration/check_email' ?>",
                                type: "post",
                                data: {
                                    email_reg: function () {
                                        // alert("hi");
                                        return $("#email_reg").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },
                        },
                        password_reg: {
                            required: true,
                        },
                        selday: {
                            required: true,
                        },
                        selmonth: {
                            required: true,
                        },
                        selyear: {
                            required: true,
                        },
                        selgen: {
                            required: true,
                        },
                        term_condi: {
                            required: true,
                        }
                    },
                    groups: {
                        selyear: "selyear selmonth selday"
                    },
                    messages:
                    {
                        first_name: {
                            required: "Please enter first name",
                        },
                        last_name: {
                            required: "Please enter last name",
                        },
                        email_reg: {
                            required: "Please enter email address",
                            remote: "Email address already exists",
                        },
                        password_reg: {
                            required: "Please enter password",
                        },

                        selday: {
                            required: "Please enter your birthdate",
                        },
                        selmonth: {
                            required: "Please enter your birthdate",
                        },
                        selyear: {
                            required: "Please enter your birthdate",
                        },
                        selgen: {
                            required: "Please enter your gender",
                        },
                        term_condi: {
                            required: "Please read and accept privacy policy, terms and conditions",
                        }

                    },
                    errorPlacement: function (error, element) {
                        if (element.attr("type") == "checkbox") {
                            error.insertAfter($("#lbl_term_condi"));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: submitRegisterForm
                });
                /* register submit */
                function submitRegisterForm()
                {
                    var first_name = $("#first_name").val();
                    var last_name = $("#last_name").val();
                    var email_reg = $("#email_reg").val();
                    var password_reg = $("#password_reg").val();
                    var selday = $("#selday").val();
                    var selmonth = $("#selmonth").val();
                    var selyear = $("#selyear").val();
                    var selgen = $("#selgen").val();
                    var term_condi = $("#term_condi").val();

                    var post_data = {
                        'first_name': first_name,
                        'last_name': last_name,
                        'email_reg': email_reg,
                        'password_reg': password_reg,
                        'selday': selday,
                        'selmonth': selmonth,
                        'selyear': selyear,
                        'selgen': selgen,
                        'term_condi' : term_condi,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>registration/reg_insert',
                        dataType: 'json',
                        data: post_data,
                        beforeSend: function ()
                        {
                            $("#register_error").fadeOut();
                            $("#btn-register").html('Sign Up ...');
                        },
                        success: function (response)
                        {
                            var userid = response.userid;
                            if (response.okmsg == "ok") {
                                $("#btn-register").html('<img src="<?php echo base_url() ?>images/btn-ajax-loader.gif" /> &nbsp; Sign Up ...');

                                //window.location = "<?php echo base_url() ?>profiles/<?php //echo $this->session->userdata('aileenuser_slug'); ?>";
                                sendmail(userid);
                                var username = response.userslug.replace(/-/g, "_")
                                var callback = function (status) {
                                    if (status === Strophe.Status.REGISTER) {
                                        conn_new.register.fields.username = username;
                                        conn_new.register.fields.password = username;
                                        conn_new.register.fields.name = first_name+" "+last_name;
                                        conn_new.register.fields.email = email_reg;
                                        conn_new.register.submit();
                                    } else if (status === Strophe.Status.REGISTERED) {
                                        console.log("registered!");
                                        conn_new.authenticate();
                                    } else if (status === Strophe.Status.CONNECTED) {
                                        console.log("logged in!");
                                    } else {
                                        // every other status a connection.connect would receive
                                    }
                                };
                                conn_new.register.connect("<?php echo base_url() ?>" + "basic-information", callback, 0, 0);
                                window.location = "<?php echo base_url() ?>" + "basic-information";
                                // setTimeout(' window.location.href = "<?php //echo base_url()   ?>dashboard"; ', 4000);
                            } else {
                                $("#register_error").fadeIn(1000, function () {
                                    $("#register_error").html('<div class="alert alert-danger registration"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                                    $("#btn-register").html('Sign Up');
                                });
                            }
                        }
                    });
                    return false;
                }
            });

            function sendmail(userid) {
                var post_data = {
                    'userid': userid,
                }
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() ?>" + 'registration/sendmail',
                    data: post_data,
                    success: function (response)
                    {
                    }
                });
                return false;
            }

        </script>
        <script type="text/javascript">
            //For Scroll page at perticular position js Start
            $(document).ready(function () {
                //  $(document).load().scrollTop(1000);
                $("#email_reg").val('');
                $("#password_reg").val('');
            });
            //For Scroll page at perticular position js End
        </script>
    </body>
</html>