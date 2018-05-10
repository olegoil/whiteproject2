<?php
    // USER DATA CHANGE
    $sql->usrDataChange = function ($name, $lastname, $mobile, $skype, $country, $city, $plz, $address) {

        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
    
        $q = "SELECT * FROM users WHERE user_id='$u' AND user_hash='$h'";
        $result = $this->dbquery($q);
        $results = odbc_fetch_array($result);
        $resrows = odbc_num_rows($result);
    
        if($resrows > 0) {

            // $email = $this->hashword($email);
            // if($results['user_confirm'] == 1) {
            //     $email = $results['user_email'];
            // }
            if($results['user_adress_confirm'] == 1) {
                $country = $results['user_country'];
                $city = $results['user_city'];
                $plz = $results['user_postal'];
                $address = $results['user_adress'];
            }
            if($results['user_passport_confirm'] == 1) {
                $name = $results['user_name'];
                $lastname = $results['user_lastname'];
            }
            if($results['user_mobile_confirm'] == 1) {
                $mobile = $results['user_mobile'];
            }
            if(!isset($skype)) {
                $skype = $results['user_skype'];
            }

            $qupd = "UPDATE users SET user_name = '$name', user_lastname='$lastname', user_mobile='$mobile', user_mobile_confirm='1', user_skype='$skype', user_country='$country', user_city='$city', user_postal='$plz', user_adress='$address' WHERE user_id='$u'";
            $this->dbquery($qupd);
            return json_encode(array("success" => 1), JSON_UNESCAPED_UNICODE);
    
        }
        else {
            return json_encode(array("success" => 0), JSON_UNESCAPED_UNICODE);
        }
    
    };
    // USER NOTES
    $sql->usrNotes = function ($usr, $notes) {
        if($this->checkLevel() != '0') {
            $q = "SELECT * FROM users WHERE user_id='$usr'";
            $result = $this->dbquery($q);
            $results = odbc_fetch_array($result);
            $resrows = odbc_num_rows($result);
        
            if($resrows > 0) {

                $qupd = "UPDATE users SET user_notes = '$notes' WHERE user_id='$usr'";
                $this->dbquery($qupd);
                return json_encode(array("success" => 1), JSON_UNESCAPED_UNICODE);
        
            }
            else {
                return json_encode(array("success" => 0), JSON_UNESCAPED_UNICODE);
            }
        }
    };
    // USER DATA
    $sql->getUser = function () {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u' AND user_hash = '$h'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {
                return $row;
            }
        }
    };
    // ADMIN USER DATA
    $sql->getAdminUser = function ($usr) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u' AND user_hash = '$h'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {
                if($usr != $u) {
                    $queryCheck = "SELECT * FROM users WHERE user_id = '$usr'";
                    $checkOtherUsr = $this->dbquery($queryCheck);
                    $rowUsr = odbc_fetch_array($checkOtherUsr);
                    $rowsUsr = odbc_num_rows($checkOtherUsr);

                    if($rowsUsr > 0) {
                        return $rowUsr;
                    }
                }
                else {
                    return $row;
                }
            }
            else {
                return $row;
            }
        }
    };
?>