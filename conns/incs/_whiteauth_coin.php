<?php
    // REQUEST WHITECOINS
    $sql->coinRequest = function ($bankID, $amount, $notes, $state) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
        $recID = $this->createRecordID();
        $recamount = $amount / $this->getExchangeRate('USD', 'WCR')['amount1'];
        // GENERATE BANKWIRE CODE
        $user = $this->getUser();
        $transid = '';

        // initials
        $initials = 'XX';
        if(isset($user['user_name']) && $user['user_name'] != '') {
            $initials = substr($user['user_name'], 0, 1);
            if(isset($user['user_lastname']) && $user['user_lastname'] != '') {
                $initials .= substr($user['user_lastname'], 0, 1);
            }
        }

        // transnum
        $daybegin = mktime(0,0,0, date("m", $when), date("d", $when), date("Y", $when));
        $dayend = mktime(23,59,59, date("m", $when), date("d", $when), date("Y", $when));
        $queryLastTrans = "SELECT * FROM transactions WHERE datetime > '$daybegin' AND datetime <= '$dayend'";
        $checkLastTrans = $this->dbquery($queryLastTrans);
        $rowLastTrans = odbc_fetch_array($checkLastTrans);
        $rowsLastTrans = odbc_num_rows($checkLastTrans);
        $transnum = '000000';
        $nexttrans = $rowsLastTrans+1;
        $transcnt = strlen($nexttrans);
        $transnum = substr_replace($transnum, $nexttrans, -$transcnt);

        // date
        $datetoday = date('mdy', $when);

        $transid = (string)$initials . (string)$transnum . (string)$datetoday . (string)$this->createBankWireID();

        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions, state, transid) VALUES ('$recID', '$u', '$amount', 5, '$recamount', 0, '$notes', 0, '$when', 0, 0, 0, '$bankID', '$u', 0, '$state', '$transid')";
        $this->dbquery($queryTrans);

        $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 0);
        return 1;
    };
    // SELL REQUEST WHITECOINS
    $sql->coinSell = function ($bankID, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        if($this->getBalance(0)['amount'] >= $amount) {
            $when = time();
            $recID = $this->createRecordID();
            $recamount = $amount * $this->getExchangeRate('USD', 'WCR')['amount1'];
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$recamount', 5, '$notes', 0, '$when', 0, 0, 0, '$u', '$bankID', 0)";
            $this->dbquery($queryTrans);

            $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 5);

            return 1;
        }
        else {
            return 0;
        }
    };
    // REQUEST WHITECOINS UNRESTRICTED
    $sql->coinRequestUR = function ($bankID, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
        $recID = $this->createRecordID();
        $recamount = $amount / $this->getExchangeRate('ETH', 'WCUR')['amount1'];
        $commissions = $recamount*0.05;
        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 3, '$recamount', 1, '$notes', 0, '$when', 7, 0, 0, '$bankID', '$u', '$commissions')";
        $this->dbquery($queryTrans);

        $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 1);
    };
    // REQUEST WHITECOINS SELLING BITCOINS
    $sql->coinRequestBTC = function ($bankID, $amount, $notes, $state, $fromadr) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $when = time();
        $recID = $this->createRecordID();
        $fee = str_replace(',', '.', $this->getFee('BTC', 'WCR')['fee']);
        $recamount = $amount / 100;
        $recamount = $recamount * (100 - $fee);
        // GENERATE BANKWIRE CODE
        $user = $this->getUser();
        $transid = '';
        $toadr = $this->getBalance(0)['recid'];

        // initials
        $initials = 'XX';
        if(isset($user['user_name']) && $user['user_name'] != '') {
            $initials = substr($user['user_name'], 0, 1);
            if(isset($user['user_lastname']) && $user['user_lastname'] != '') {
                $initials .= substr($user['user_lastname'], 0, 1);
            }
        }

        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions, state) VALUES ('$recID', '$u', '$amount', 2, '$recamount', 2, '$notes', 0, '$when', 0, 0, 0, '$fromadr', '$u', '$fee', '$state')";
        $this->dbquery($queryTrans);

        return 1;
    };
    // SELL REQUEST WHITECOINS TO GET BITCOINS
    // $sql->coinSellBTC = function ($bankID, $amount, $notes) {
    //     $u = $_COOKIE['u'];
    //     $h = $_COOKIE['h'];
    //     if($this->getBalance(0)['amount'] >= $amount) {
    //         $when = time();
    //         $recID = $this->createRecordID();
    //         $recamount = $amount * $this->getExchangeRate('USD', 'WCR')['amount1'];
    //         $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$recamount', 5, '$notes', 0, '$when', 0, 0, 0, '$u', '$bankID', 0)";
    //         $this->dbquery($queryTrans);

    //         $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 5);

    //         return 1;
    //     }
    //     else {
    //         return 0;
    //     }
    // };
    // RESTRICTED TO UNRESTRICTED WHITECOIN
    $sql->wcrtoWcur = function ($amount) {
        $u = $_COOKIE['u'];
        $when = time();
        $recID = $this->createRecordID();
        // $accFrom = $this->getBalance(1)['recid'];
        $accFrom = $this->getBank()['recid'];
        $accTo = $this->getBalance(3)['wallet_minter'];
        $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 1, 'WCR to WCUR', 0, '$when', 0, 0, 0, '$accFrom', '$accTo', '0')";
        $this->dbquery($queryTrans);
        $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 3);
        return 1;
    };
    // REQUEST WHITECOINS UNRESTRICTED
    $sql->coinSellUR = function ($bankID, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        if($this->getBalance(1)['amount'] >= $amount) {
            $when = time();
            $recID = $this->createRecordID();
            $recamount = $amount * $this->getExchangeRate('ETH', 'WCUR')['amount1'];
            $commissions = $recamount*0.05;
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 1, '$recamount', 3, '$notes', 0, '$when', 7, 0, 0, '$u', '$bankID', '$commissions')";
            $this->dbquery($queryTrans);

            $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 3);

            return 1;
        }
        else {
            return 0;
        }
    };
?>