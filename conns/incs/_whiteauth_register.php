<?php
class registers extends confmails {
    // USER REGISTRATION
    public function registerUser ($email, $pwd) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
        $recID = $this->createRecordID();
        $accesLevel = array("User" => 0, "Manager" => 1, "Minter" => 2, "KYCAML" => 3);
      
        $query = "SELECT * FROM users WHERE user_id = '$recID' OR user_email = '$emailhash'";
        $checkUsr = $this->dbquery($query);
        $rows = odbc_num_rows($checkUsr);

        $regArr = array();
      
        // IF USER NOT EXISTS
        if($rows == 0) {

            $uip = $this->get_client_ip_server();
            $queryIns = "INSERT INTO users (user_id, user_email, user_pwd, user_when, user_ip, user_confirm, user_mobile_confirm, user_type, user_mail) VALUES ('$recID', '$emailhash', '$pwd', '$when', '$uip', 0, 1, 0, '$email')";
            $insUsr = $this->dbquery($queryIns);

            $querySel = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd' AND user_when = '$when'";
            $selUsr = $this->dbquery($querySel);
            $rowUsr = odbc_fetch_array($selUsr);
            $rowsUsr = odbc_num_rows($selUsr);

            if($rowsUsr > 0) {

                $this->createWallets($rowUsr);

                $hash = $when . '_' . $rowUsr['user_id'];
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash' WHERE user_id='".$rowUsr['user_id']."'";
                $this->dbquery($setUsrHash);

                $this->registrationEmail($hash, $email);

                array_push($regArr, array("success" => 1));

            }
            else {
                // $headerErrCreate = 'http://whitecoin.blockchaindevelopers.org?msg=errcreate2';
                // header(sprintf("Location: %s", $headerErrCreate));
                array_push($regArr, array("success" => 2));
            }
      
        }
        // IF USER EXISTS
        else {
            // $this->checkLogin();
            array_push($regArr, array("success" => 0));
        }

        return $regArr;

    }
    // MINTER REGISTRATION
    public function registerMinter ($email, $pwd, $firstname, $lastname) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
        $recID = $this->createRecordID();
        $accesLevel = array("User" => 0, "Manager" => 1, "Minter" => 2, "KYCAML" => 3);
      
        $query = "SELECT * FROM users WHERE user_id = '$recID' OR user_email = '$emailhash'";
        $checkUsr = $this->dbquery($query);
        $rows = odbc_num_rows($checkUsr);

        $regArr = array();
      
        // IF USER NOT EXISTS
        if($rows == 0) {

            $uip = $this->get_client_ip_server();
            $queryIns = "INSERT INTO users (user_id, user_email, user_pwd, user_when, user_ip, user_confirm, user_mobile_confirm, user_type, user_name, user_lastname, user_mail) VALUES ('$recID', '$emailhash', '$pwd', '$when', '$uip', 1, 1, 2, '$firstname', '$lastname', '$email')";
            $insUsr = $this->dbquery($queryIns);

            $querySel = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd' AND user_when = '$when'";
            $selUsr = $this->dbquery($querySel);
            $rowUsr = odbc_fetch_array($selUsr);
            $rowsUsr = odbc_num_rows($selUsr);

            if($rowsUsr > 0) {

                $this->createWallets($rowUsr);

                $hash = $when . '_' . $rowUsr['user_id'];
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash' WHERE user_id='".$rowUsr['user_id']."'";
                $this->dbquery($setUsrHash);

                array_push($regArr, array("success" => 1));

            }
            else {
                // NO USER CREATED
                array_push($regArr, array("success" => 2));
            }
      
        }
        // IF USER EXISTS
        else {
            // $this->checkLogin();
            array_push($regArr, array("success" => 0));
        }

        return $regArr;

    }
    // KYC REGISTRATION
    public function registerKYCAML ($email, $pwd, $firstname, $lastname) {

        $emailhash = $this->hashword($email);
        $pwd = $this->hashword($pwd);
        $when = time();
        $recID = $this->createRecordID();
        $accesLevel = array("User" => 0, "Manager" => 1, "Minter" => 2, "KYCAML" => 3);
      
        $query = "SELECT * FROM users WHERE user_id = '$recID' OR user_email = '$emailhash'";
        $checkUsr = $this->dbquery($query);
        $rows = odbc_num_rows($checkUsr);

        $regArr = array();
      
        // IF USER NOT EXISTS
        if($rows == 0) {

            $uip = $this->get_client_ip_server();
            $queryIns = "INSERT INTO users (user_id, user_email, user_pwd, user_when, user_ip, user_confirm, user_mobile_confirm, user_type, user_name, user_lastname, user_mail) VALUES ('$recID', '$emailhash', '$pwd', '$when', '$uip', 1, 1, 3, '$firstname', '$lastname', '$email')";
            $insUsr = $this->dbquery($queryIns);

            $querySel = "SELECT * FROM users WHERE user_email = '$emailhash' AND user_pwd = '$pwd' AND user_when = '$when'";
            $selUsr = $this->dbquery($querySel);
            $rowUsr = odbc_fetch_array($selUsr);
            $rowsUsr = odbc_num_rows($selUsr);

            if($rowsUsr > 0) {

                $this->createWallets($rowUsr);

                $hash = $when . '_' . $rowUsr['user_id'];
                $hash = $this->hashFwd($hash);

                $setUsrHash = "UPDATE users SET user_hash='$hash' WHERE user_id='".$rowUsr['user_id']."'";
                $this->dbquery($setUsrHash);

                array_push($regArr, array("success" => 1));

            }
            else {
                // NO USER CREATED
                array_push($regArr, array("success" => 2));
            }
      
        }
        // IF USER EXISTS
        else {
            // $this->checkLogin();
            array_push($regArr, array("success" => 0));
        }

        return $regArr;

    }
    // CREATE WALLETS AT REGISTRATION
    public function createWallets ($rowUsr) {
        $recIDwalletWCR = $this->createRecordID();
        $recIDwalletWCUR = $this->createRecordID();
        $recIDwalletBTC = $this->createRecordID();
        $recIDwalletETH = $this->createRecordID();
        $when = time();
        $queryWalletWCR = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletWCR', '".$rowUsr['user_id']."', 0, 0, '$when', 0)";
        $this->dbquery($queryWalletWCR);
        $queryWalletWCUR = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletWCUR', '".$rowUsr['user_id']."', 1, 0, '$when', 0)";
        $this->dbquery($queryWalletWCUR);
        $queryWalletBTC = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletBTC', '".$rowUsr['user_id']."', 2, 0, '$when', 0)";
        $this->dbquery($queryWalletBTC);
        $queryWalletETH = "INSERT INTO wallets (recid, userid, type, amount, datetime, walletdel) VALUES ('$recIDwalletETH', '".$rowUsr['user_id']."', 3, 0, '$when', 0)";
        $this->dbquery($queryWalletETH);
    }
    // DELETE MINTER
    public function minterDel ($recID) {
        $queryTrans = "SELECT * FROM users WHERE user_id = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            $delUser = "DELETE FROM users WHERE user_id='$recID'";
            $this->dbquery($delUser);
            $queryDelMinter = "DELETE FROM wallets WHERE userid='$recID'";
            $this->dbquery($queryDelMinter);
            return 1;
        }
        else {
            return 0;
        }
    }
    // TOGGLE MINTER RESTRICTION
    public function minterRest ($amnt, $to, $fromadr) {
        if($amnt == 0) {
            $updUser = "UPDATE users SET user_minter='0' WHERE user_id='$fromadr'";
            $this->dbquery($updUser);
        }
        else if($amnt == 1) {
            $queryWallet = "SELECT * FROM wallets WHERE userid='$fromadr' AND type='3'";
            $checkWallet = $this->dbquery($queryWallet);
            $rowWallet = odbc_fetch_array($checkWallet);
            $rowsWallet = odbc_num_rows($checkWallet);
            if($rowsWallet > 0) {
                $updUser = "UPDATE users SET user_minter='".$rowWallet['wallet_minter']."' WHERE user_id='$fromadr'";
                $this->dbquery($updUser);
            }
        }
    }
}
?>