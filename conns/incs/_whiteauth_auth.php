<?php
    // USER LOGIN
    $sql->loginUser = function ($email, $pwd) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
      
        $query = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd'";
        $checkUsr = $this->dbquery($query);
        $row = odbc_fetch_array($checkUsr);
        $rows = odbc_num_rows($checkUsr);

        if($rows > 0) {

            if($row['user_confirm'] == '1') {

                $uid = $row['user_id'];
                $hash = $when . '_' . $uid;
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash', user_log='$when' WHERE user_id='$uid'";
                $this->dbquery($setUsrHash);

                // SET COOKIES FOR 24 HOURS
                $cookielife = $when + 60*30*24;
                if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
                    setcookie("u", $uid, $cookielife, '/', 'localhost');
                    setcookie("h", $hash, $cookielife, '/', 'localhost');
                }
                else {
                    setcookie("u", $uid, $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                    setcookie("h", $hash, $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                }
            
                $cookiesuccess = "http://whitecoin.blockchaindevelopers.org/main/";
                header(sprintf("Location: %s", $cookiesuccess));

            }
            else {
                $loginFailed = 'http://whitecoin.blockchaindevelopers.org/?failed=2&email='.$email;
                header(sprintf("Location: %s", $loginFailed));
            }

        }
        else {
            $loginFailed = 'http://whitecoin.blockchaindevelopers.org/?failed=1&email='.$email;
            header(sprintf("Location: %s", $loginFailed));
        }

    };
    // USER LOGOUT
    $sql->logoutUser = function () {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $when = time();
            $cookielife = $when - 60*30;
            if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
                setcookie("u", $_COOKIE['u'], $cookielife, '/', 'localhost');
                setcookie("h", $_COOKIE['h'], $cookielife, '/', 'localhost');
            }
            else {
                setcookie("u", $_COOKIE['u'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                setcookie("h", $_COOKIE['h'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
            }
        }
        $headerLogout = "http://whitecoin.blockchaindevelopers.org";
        header(sprintf("Location: %s", $headerLogout));
    };
    // USER CHECK LOGIN
    $sql->checkLogin = function () {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {

                if(urlencode($row['user_hash']) == urlencode($h)) {

                    // SET COOKIES FOR 24 HOURS
                    $when = time();
                    $cookielife = $when + 60*30*24;
                    if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
                        setcookie("u", $_COOKIE['u'], $cookielife, '/', 'localhost');
                        setcookie("h", $_COOKIE['h'], $cookielife, '/', 'localhost');
                    }
                    else {
                        setcookie("u", $_COOKIE['u'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                        setcookie("h", $_COOKIE['h'], $cookielife, '/', 'whitecoin.blockchaindevelopers.org');
                    }

                }
                else {
                    $notcookie = "http://whitecoin.blockchaindevelopers.org/coms/logout.php";
                    header(sprintf("Location: %s", $notcookie));
                }
                
            }
            else {
                $notcookie = "http://whitecoin.blockchaindevelopers.org/coms/logout.php";
                header(sprintf("Location: %s", $notcookie));
            }
        }
        else {
            $notcookie = "http://whitecoin.blockchaindevelopers.org/coms/logout.php";
            header(sprintf("Location: %s", $notcookie));
        }
    };
?>