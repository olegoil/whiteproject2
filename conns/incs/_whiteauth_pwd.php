<?php
class pwds extends usrdatas {
    // USER PASSWORD RESET
    public function passwordReset ($useremail) {
    
        if($useremail == "") return json_encode(array("emailReset" => 0), JSON_UNESCAPED_UNICODE);

        $useremailhash = $this->hashword($useremail);
    
        $q = "SELECT * FROM users WHERE user_email='$useremailhash'";
        $result = $this->dbquery($q);
        $results = odbc_fetch_array($result);
        $resrows = odbc_num_rows($result);
    
        if($resrows > 0) {

            $userId = $results['user_id'];
            $forgotHash = time() . '_' . $userId;
            $forgotHash = $this->hashword($forgotHash);
    
            $qupd = "UPDATE users SET user_reset_pwd = '$forgotHash' WHERE user_id = '$userId'";
            $resultupd = $this->dbquery($qupd);
    
            $results['user_reset_pwd'] = $forgotHash;
            $results['emailReset'] = 1;

            $baseDomain = BASE_DOMAIN;
            $baseCookieDomain = COOKIE_DOMAIN;

            // SEND RESET EMAIL TO USER
            $email_subject = "Email password reset from whitecoin.blockchaindevelopers.org.";
            $email_body = '<html style="width:100%;height:100%;"><body style="background-color:#E0F1FF;width:100%;height:100%;">';
            $email_body .= '<div style="text-align:center;"><img style="margin:10px auto;height:60px;" src="'.$baseDomain.'/images/logo.png" alt="White Standard" /></div>';
            $email_body .= '<div style="margin:30px;padding:20px;background-color:#fff;text-align:center;">';
            $email_body .= '<h2 style="text-align:left;">Password Reset</h2>';
            $email_body .= '<hr style="color:#E0F1FF;background-color:#E0F1FF;border-color:#E0F1FF;" />';
            $email_body .= '<h2 style="text-align:left;font-weight:normal;">Click the link below to reset Your password:</h2>';
            $email_body .= '<br/><a href="'.$baseDomain.'/coms/resetpwd.php?forgotEmail='.$useremail.'&forgotHash='.urlencode($forgotHash).'" target="_blank" style="display:inline-block;background-color:#3C8DC8;color:#fff;padding:20px;text-align:center;font-size:24px;text-decoration:none;">Reset password</a>';
            // $email_body .= '<br/><h2 style="text-align:left;">if this activity is not your own operation, please contact us immediately.</h2>';
            $email_body .= '<br/><br/><br/><h4 style="color:#999;text-align:left;font-weight:normal;margin-bottom:0px;">White Standard Team</h4>';
            $email_body .= '<h4 style="color:#888;text-align:left;font-weight:normal;margin-top:0px;">Automated message. Please do not reply.</h4>';
            $email_body .= '<a style="text-decoration:none;font-weight:normal;color:#3C8DC8;font-size:1.5em;" href="http://www.support.'.$baseCookieDomain.'/" target="_blank">http://support.'.$baseCookieDomain.'</a>';
            $email_body .= '</div><br/></body"></html>';
        
            require_once "SendMailSmtpClass.php";
            $mailSMTP = new SendMailSmtpClass(SMTP_USERNAME, SMTP_PWD, SMTP_HOST, SMTP_FROM, SMTP_PORT);
            $headers= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: White Standard <noreply@".$baseCookieDomain.">\r\n";
            $mailSMTP->send($useremail, $email_subject, $email_body, $headers);
            
            return json_encode($results, JSON_UNESCAPED_UNICODE);
    
        }
        return json_encode(array("emailReset" => 0), JSON_UNESCAPED_UNICODE);
    
    }
    // USER PASSWORD CHANGE
    public function passwordChange ($oldpwd, $newpwd) {

        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $oldpwd = $this->hashword($oldpwd);
        $newpwd = $this->hashword($newpwd);
        $when = time();
    
        $q = "SELECT * FROM users WHERE user_id='$u' AND user_hash='$h'";
        $result = $this->dbquery($q);
        $results = odbc_fetch_array($result);
        $resrows = odbc_num_rows($result);
    
        if($resrows > 0) {

            $qpwd = "SELECT * FROM users WHERE user_id='$u' AND user_hash='$h' AND user_pwd='$oldpwd'";
            $resultpwd = $this->dbquery($qpwd);
            $resultspwd = odbc_fetch_array($resultpwd);
            $resrowspwd = odbc_num_rows($resultpwd);

            if($resrowspwd > 0) {
                $qupd = "UPDATE users SET user_pwd = '$newpwd' WHERE user_id = '$u'";
                $this->dbquery($qupd);
                return json_encode(array("success" => 1), JSON_UNESCAPED_UNICODE);
            }
            else {
                return json_encode(array("success" => 2), JSON_UNESCAPED_UNICODE);
            }
    
        }
        else {
            return json_encode(array("success" => 0), JSON_UNESCAPED_UNICODE);
        }
    
    }
}
?>