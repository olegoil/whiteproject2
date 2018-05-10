<?php
    // REGISTRATION CONFIRMATION EMAIL
    $sql->registrationEmail = function ($hash, $email) {
        $baseDomain = 'http://whitecoin.blockchaindevelopers.org';
        $baseCookieDomain = 'whitecoin.blockchaindevelopers.org';

        // SEND EMAIL TO NEW USER
        $email_subject = "Email confirmation from ".$baseCookieDomain.".";
        $email_body = '<html style="width:100%;height:100%;"><body style="background-color:#E0F1FF;width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
        $email_body .= '<h2 style="text-align:left;">Confirm Your Registration</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Welcome to <strong>White Standard!</strong></h2>';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Click the link below to complete verification:</h2>';
        $email_body .= '<br/><a style="display:inline-block;background-color:#3C8DC8;color:#fff;padding:20px;text-align:center;font-size:36px;text-decoration:none;" href="'.$baseDomain.'/confirmation.php?emailConf='.urlencode($hash).'&signUpEmail='.urlencode($email).'" target="_blank">Verify Email</a>';
        // $email_body .= '<br/><h2 style="text-align:left;">if this activity is not your own operation, please contact us immediately.</h2>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
        $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
        $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="'.$baseDomain.'" target="_blank">'.$baseDomain.'</a>';
        $email_body .= '</div><br/></body"></html>';
    
        require_once "SendMailSmtpClass.php";
        $mailSMTP = new SendMailSmtpClass(SMTP_USERNAME, SMTP_PWD, SMTP_HOST, SMTP_FROM, SMTP_PORT);
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: White Standard <noreply@".$baseCookieDomain.">\r\n";
        $mailSMTP->send($email, $email_subject, $email_body, $headers);
    };
    // SEND EMAIL
    $sql->sendMail = function ($email, $recId, $amount, $currency) {

        $currency = $this->getCurrency($currency);

        // SEND EMAIL TO NEW USER
        $email_subject = "White Standard token request.";
        $email_body = '<html style="width:100%;height:100%;"><body style="background-color:rgba(106, 164, 203, 1);width:100%;height:100%;">';
        $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="http://whitecoin.blockchaindevelopers.org/images/logo.png" alt="White Standard" /></div>';
        $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
        $email_body .= '<h2 style="text-align:left;">Token request</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Request <strong>White Standard</strong></h2>';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">Please make a wire transfer to the following bank account:</h2>';
        $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
        $email_body .= '<p style="text-align:left;font-weight:normal;">Bank account: 1234567890</p>';
        $email_body .= '<p style="text-align:left;font-weight:normal;">Amount in '.$currency.': '.$amount.'</p>';
        $email_body .= '<p style="text-align:left;font-weight:normal;">Purpose of payment: White Standard purchase - '.$recId.'</p>';
        $email_body .= '<h2 style="text-align:left;font-weight:normal;">For questions please contact:</h2><div style="text-align:left;"><a style="text-align:left;font-weight:bold;font-size:18px;" href="mailto:info@whitecoin.blockchaindevelopers.org">info@whitecoin.blockchaindevelopers.org</a></div>';
        $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4><br/>';
        $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
        $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="http://whitecoin.blockchaindevelopers.org/" target="_blank">http://whitecoin.blockchaindevelopers.org/</a>';
        $email_body .= '</div><br/></body"></html>';
    
        require_once "SendMailSmtpClass.php";
        $mailSMTP = new SendMailSmtpClass(SMTP_USERNAME, SMTP_PWD, SMTP_HOST, SMTP_FROM, SMTP_PORT);
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: White Standard <noreply@whitecoin.blockchaindevelopers.org>\r\n";
        $mailSMTP->send($email, $email_subject, $email_body, $headers);
    
    };
?>