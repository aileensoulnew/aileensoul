<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function send_email($subject = '', $templ = '', $to_email = '') {
        $this->load->library('email');

        $email_html = '';        
        $email_html .= '<!DOCTYPE html><html><head><title>Aileensoul Notification Mail</title>
            <style>
            body{font-family:arial;}
            p{margin:0;}h3{margin:0;}
            .post-img-div, .post-img-profile{color: #fff;
            width: 60px;
            background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
            background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
            padding: 21px 0;
            text-align: center;
            text-transform: uppercase;
            line-height: 1;}
                        .btn{background:#1b8ab9;
                    font-size:16px;
                    color:#fff !important;
                    padding:8px 20px;
                    text-decoration:none;
                            border-radius:3px;
                }
                .btn:hover{/*opacity:0.8;*/}
                .description_table img { width:50px !important; height:50px !important;}
            </style></head>
            <body>
            <div style="max-width:600px; margin:0 auto; background:#f4f4f4; padding:30px;">
                <table width="100%" style="background:#fff" cellpadding="0" cellspacing="0">
                    <tr><td style="border-bottom:1px solid #ddd;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr><td style="text-align:center"><h2>
                        <a style="color:#1b8ab9; text-decoration:none; font-size:23px;" href="https://www.aileensoul.com/" target="_blank"><img src="https://www.aileensoul.com/assets/images/favicon.png" style="   vertical-align: middle;" /> <span class="sitename">Aileensoul</span></a>
                        </h2></td></tr></table>
                        </td>
                    </tr>
                    <tr><td style="padding-bottom: 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0" class="description_table">
                        <tr><td style="padding:5px;padding-left: 5px; font-size:15px;">' . $templ . '</td></tr>
                        </table>
                        </td></tr>
                        
                </table>';
        
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;padding:10px 0;font-size: 12px;">
                                            Aileensoul Technologies Private Limited<br>
                                            Titanium City Centre, 100 Feet Road, Satellite, Ahmedabad, India.
                                        </td>
                                    </tr>
                                </tbody>
                            </table></div></body></html>';

        require FCPATH.'../phpmailer/vendor/autoload.php'; 
        //Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->isSMTP();

        $sql = "SELECT * FROM ailee_email_settings WHERE status = '1'";
        $email_setting = $this->db->query($sql)->row_array();
        
        $mail->Username = $email_setting['user_name'];//'notification.aileensoul@gmail.com';//Amazon SES SMTP user name.        
        $mail->Password = $email_setting['password'];//'aileensoul@123';//Amazon SES SMTP password.
        $mail->Host = $email_setting['host_name'];//'smtp.gmail.com';
        // $mail->setFrom('notification.aileensoul@gmail.com', 'Aileensoul Notification');
        $mail->setFrom($email_setting['from_email'], ucwords($email_setting['from_name']));
        //Set an alternative reply-to address
        // $mail->addReplyTo('notification.aileensoul@gmail.com', 'Aileensoul Notification');
        $mail->addReplyTo($email_setting['replyto_email'], ucwords($email_setting['replyto_name']));
        // $mail->addBCC('dm.aileensoul@gmail.com');
        //Set who the message is to be sent to
        $mail->addAddress($to_email);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $email_html;
        // Tells PHPMailer to use SMTP authentication
        $mail->SMTPAuth = true;

        // Enable TLS encryption over port 587
        $mail->SMTPSecure = $email_setting['smtp_secure'];//'tls';
        $mail->Port = $email_setting['out_going_port'];//587;
        // if ($this->email->send()) {
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    function sendEmail($app_name = '', $app_email = '', $to_email = '', $subject = '', $mail_body = '', $cc = '', $bcc = '') {

        $email_html = '';
        $email_html .= '<!DOCTYPE html><html><head><title>Aileensoul Notification Mail</title>
            <style>
            body{font-family:arial;}
            h3{margin:0;}
            .post-img-div, .post-img-profile{color: #fff;
            width: 60px;
            background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
            background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
            padding: 21px 0;
            text-align: center;
            text-transform: uppercase;
            line-height: 1;}
                        .btn{background:#1b8ab9;
                    font-size:16px;
                    color:#fff !important;
                    padding:8px 20px;
                    text-decoration:none;
                            border-radius:3px;
                }
                .btn:hover{/*opacity:0.8;*/}
                .description_table img { width:50px !important; height:50px !important;}
            </style></head>
            <body>
            <div style="max-width:600px; margin:0 auto; background:#f4f4f4; padding:30px;">
                <table width="100%" style="background:#fff" cellpadding="0" cellspacing="0">
                    <tr><td style="border-bottom:1px solid #ddd;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr><td style="text-align:center"><h2>
                        <a style="color:#1b8ab9; text-decoration:none; font-size:23px;" href="https://www.aileensoul.com/" target="_blank"><img src="https://www.aileensoul.com/assets/images/favicon.png" style="   vertical-align: middle;" /> <span class="sitename">Aileensoul</span></a>
                        </h2></td></tr></table>
                        </td>
                    </tr>
                    <tr><td style="padding: 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0" class="description_table">
                        <tr><td style="padding:5px;padding-left: 5px; font-size:15px;">' . $mail_body . '</td></tr>
                        </table>
                        </td></tr>
                        
                </table>';
        
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;padding:10px 0;font-size: 12px;">
                                            Aileensoul Technologies Private Limited<br>
                                            Titanium City Centre, 100 Feet Road, Satellite, Ahmedabad, India.
                                        </td>
                                    </tr>
                                </tbody>
                            </table></div></body></html>';

        require FCPATH.'../phpmailer/vendor/autoload.php'; 

        $sql = "SELECT * FROM ailee_email_settings WHERE status = '1'";
        $email_setting = $this->db->query($sql)->row_array();

        //Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->isSMTP();
        
        $mail->Username = $email_setting['user_name'];//'notification.aileensoul@gmail.com';//Amazon SES SMTP user name.        
        $mail->Password = $email_setting['password'];//'aileensoul@123';//Amazon SES SMTP password.
        $mail->Host = $email_setting['host_name'];//'smtp.gmail.com';
        // $mail->setFrom('notification.aileensoul@gmail.com', 'Aileensoul Notification');
        $mail->setFrom($email_setting['from_email'], ucwords($email_setting['from_name']));
        //Set an alternative reply-to address
        // $mail->addReplyTo('notification.aileensoul@gmail.com', 'Aileensoul Notification');
        $mail->addReplyTo($email_setting['replyto_email'], ucwords($email_setting['replyto_name']));
        // $mail->addBCC('dm.aileensoul@gmail.com');
        //Set who the message is to be sent to
        $mail->addAddress($to_email);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $email_html;
        // Tells PHPMailer to use SMTP authentication
        $mail->SMTPAuth = true;

        // Enable TLS encryption over port 587
        $mail->SMTPSecure = $email_setting['smtp_secure'];//'tls';
        $mail->Port = $email_setting['out_going_port'];//587;
        // if ($this->email->send()) {
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    function do_email($msg = NULL, $sub = NULL, $to = NULL, $from = NULL, $attachment_url = NULL)
    {        
        $this->load->library('email');

        $config['protocol'] = "SMTP";
        $config['smtp_host'] = "Smtp.gmail.com";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "noreply@aileensoul.com";
        $config['smtp_pass'] = "aileensoul@123";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);
        $system_name = "aileensoul";

        $this->email->from('aileensoul@gmail.com', 'Aileensoul');
        $this->email->to($to);
        $this->email->reply_to('no-replay@aileensoul.com', 'Explendid Videos');
        $this->email->subject($sub);
        $this->email->message($msg);
        $this->email->send();

        //echo $this->email->print_debugger(); die();
    }
    
    function test_email($subject = '', $templ = '', $to_email = '') {
        $this->load->library('email');

        $email_html = 'This is test mail from smtp';
        
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = CHARSET;
        $config['mailtype'] = MAILTYPE;
        $config['newline'] = '\r\n';
        
        $this->email->initialize($config);
        $this->email->from('noreply@aileensoul.com', 'Aileensoul');
        $this->email->to($to_email);
        $this->email->bcc('dm.aileensoul@gmail.com');
        //$this->email->reply_to('no-replay@aileensoul.com', 'Explendid Videos');
        $this->email->subject($subject);
        $this->email->message($email_html);
        $this->email->set_mailtype("html");
        //echo '<pre>'; print_r($this->email->print_debugger()); die();
        if ($this->email->send()) {
            return TRUE;
        } else {
            echo '<pre>';
            print_r($this->email->print_debugger());
            return FALSE;
        }        

    }

    public function send_email_new($subject = '', $templ = '', $to_email = '',$unsubscribe = '') {
        $this->load->library('email');

        $email_html = '';
        $email_html .= '<!DOCTYPE html><html><head><title>Aileensoul Notification Mail</title>
            <style>
            body{font-family:arial;}
            p{margin:0;}h3{margin:0;}
            .post-img-div, .post-img-profile{color: #fff;
            width: 60px;
            background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
            background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
            padding: 21px 0;
            text-align: center;
            text-transform: uppercase;
            line-height: 1;}
                        .btn{background:#1b8ab9;
                    font-size:16px;
                    color:#fff !important;
                    padding:8px 20px;
                    text-decoration:none;
                            border-radius:3px;
                }
                .btn:hover{/*opacity:0.8;*/}
                .description_table img { width:50px !important; height:50px !important;}
            </style></head>
            <body>
            <div style="max-width:600px; margin:0 auto; background:#f4f4f4; padding:30px;">
                <table width="100%" style="background:#fff" cellpadding="0" cellspacing="0">
                    <tr><td style="border-bottom:1px solid #ddd;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr><td style="text-align:center"><h2>
                        <a style="color:#1b8ab9; text-decoration:none; font-size:23px;" href="https://www.aileensoul.com/" target="_blank"><img src="https://www.aileensoul.com/assets/images/favicon.png" style="   vertical-align: middle;" /> <span class="sitename">Aileensoul</span></a>
                        </h2></td></tr></table>
                        </td>
                    </tr>
                    <tr><td style="padding-bottom: 20px;border-bottom:1px solid #ddd;">
                        <table width="100%" cellpadding="0" cellspacing="0" class="description_table">
                        <tr><td style="padding:5px;padding-left: 5px; font-size:15px;">' . $templ . '</td></tr>
                        </table>
                        </td></tr>                        
                </table>';
        if($unsubscribe != "")
        {
            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
            <tr><td style="text-align:center; padding:10px 0;"><a style="color:#505050; padding:5px 15px; text-decoration:none;" href="'.$unsubscribe.'">Unsubscribe</a></td></tr>
            </table>';
        }
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;padding:10px 0;font-size: 12px;">
                                            Aileensoul Technologies Private Limited<br>
                                            Titanium City Centre, 100 Feet Road, Satellite, Ahmedabad, India.
                                        </td>
                                    </tr>
                                </tbody>
                            </table></div></body></html>';
        // echo $email_html;exit();
        require FCPATH.'../phpmailer/vendor/autoload.php'; 
        //Create a new PHPMailer instance

        $sql = "SELECT * FROM ailee_email_settings WHERE status = '1'";
        $email_setting = $this->db->query($sql)->row_array();

        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->isSMTP();
        
        $mail->Username = $email_setting['user_name'];//'notification.aileensoul@gmail.com';//Amazon SES SMTP user name.        
        $mail->Password = $email_setting['password'];//'aileensoul@123';//Amazon SES SMTP password.
        $mail->Host = $email_setting['host_name'];//'smtp.gmail.com';
        // $mail->setFrom('notification.aileensoul@gmail.com', 'Aileensoul Notification');
        $mail->setFrom($email_setting['from_email'], ucwords($email_setting['from_name']));
        //Set an alternative reply-to address
        // $mail->addReplyTo('notification.aileensoul@gmail.com', 'Aileensoul Notification');
        $mail->addReplyTo($email_setting['replyto_email'], ucwords($email_setting['replyto_name']));
        // $mail->addBCC('dm.aileensoul@gmail.com');
        //Set who the message is to be sent to
        $mail->addAddress($to_email);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $email_html;
        // Tells PHPMailer to use SMTP authentication
        $mail->SMTPAuth = true;

        // Enable TLS encryption over port 587
        $mail->SMTPSecure = $email_setting['smtp_secure'];//'tls';
        $mail->Port = $email_setting['out_going_port'];//587;
        // if ($this->email->send()) {
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function send_email_template($subject = '', $email_html = '', $to_email = '',$unsubscribe = '')
    {
        $this->load->library('email');

        require FCPATH.'../phpmailer/vendor/autoload.php'; 

        $sql = "SELECT * FROM ailee_email_settings WHERE status = '1'";
        $email_setting = $this->db->query($sql)->row_array();
 
        //Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->isSMTP();
        // $mail->SMTPDebug = 2;
        $mail->Username = $email_setting['user_name'];//'notification@messages.aileensoul.com';// 'notification.aileensoul@gmail.com';//'apikey' //Amazon SES SMTP user name.        
        $mail->Password = $email_setting['password'];//'zxzxZX912912';// 'QAZplm1092';//'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'; //Amazon SES SMTP password.
        $mail->Host = $email_setting['host_name'];//'smtpdm-ap-southeast-1.aliyun.com';//'smtp.sendgrid.net';// 'smtp.gmail.com';
        // $mail->setFrom('notification@messages.aileensoul.com', 'Aileensoul Notification');
        $mail->setFrom($email_setting['from_email'], ucwords($email_setting['from_name']));
        //Set an alternative reply-to address
        // $mail->addReplyTo('notification@messages.aileensoul.com', 'Aileensoul Notification');
        $mail->addReplyTo($email_setting['replyto_email'], ucwords($email_setting['replyto_name']));
        // $mail->addBCC('dm.aileensoul@gmail.com');
        //Set who the message is to be sent to
        $mail->addAddress($to_email);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        // echo $email_html;exit();
        $mail->Body = $email_html;
        // Tells PHPMailer to use SMTP authentication
        $mail->SMTPAuth = true;

        // Enable TLS encryption over port 587
        $mail->SMTPSecure = $email_setting['smtp_secure'];//'ssl';
        $mail->Port = $email_setting['out_going_port'];//465;// 587;
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost" || $_SERVER['HTTP_HOST'] == "staging.aileensoul.com") {
            return true;
        }        
        // return TRUE;
        if ($mail->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
