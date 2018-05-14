<?php
class transes extends transesp {
    // GET TRANSACTIONS
    public function getTransactions () {
        $u = $_COOKIE['u'];
        $query = "SELECT * FROM transactions WHERE userid = '$u' ORDER BY datetime DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        $tblobj = '';
        if($rows > 0) {
            $i = 0;
            do {
                $handleBtn = '&nbsp;';
                if($row['acception'] == 0) {
                    $handleBtn = '<button class="btn btn-warning">Pending</button>';
                }
                else if($row['acception'] == 1) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                else if($row['acception'] == 2) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                else if($row['acception'] == 3) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                else if($row['acception'] == 4) {
                    $handleBtn = '<button class="btn btn-danger">Pending</button>';
                }
                else if($row['acception'] == 6) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                else if($row['acception'] == 7) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$row['recid'].'</td>';
                    // $tblobj .= '<td>'.$row['userid'].'</td>';
                    $tblobj .= '<td>'.$row['amount_from'].' '.$this->getCurrency($row['currency_from']).'</td>';
                    $tblobj .= '<td>'.$row['amount_to'].' '.$this->getCurrency($row['currency_to']).'</td>';
                    $tblobj .= '<td>'.$row['commissions'].'</td>';
                    $tblobj .= '<td>'.$row['notes'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y h:i A', $row['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$row['recid'].'</td>';
                    // $tblobj .= '<td>'.$row['userid'].'</td>';
                    $tblobj .= '<td>'.$row['amount_from'].' '.$this->getCurrency($row['currency_from']).'</td>';
                    $tblobj .= '<td>'.$row['amount_to'].' '.$this->getCurrency($row['currency_to']).'</td>';
                    $tblobj .= '<td>'.$row['commissions'].'</td>';
                    $tblobj .= '<td>'.$row['notes'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$row['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y h:i A', $row['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($row = odbc_fetch_array($checkBank));
        }
        return $tblobj;
    }
    // GET TRANSACTIONS GRAPH
    public function getTransactionsGraph () {
        $u = $_COOKIE['u'];
        $wallet = $this->getBalance(0)['recid'];
        $query = "SELECT * FROM transactions WHERE userid='$u' OR wallet_to='".$this->getBalance(0)['recid']."' ORDER BY datetime DESC, changed DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        $tblobj = array();
        if($rows > 0) {
            do {
                array_push($tblobj, $row);
            } while ($row = odbc_fetch_array($checkBank));
        }
        return json_encode($tblobj, JSON_UNESCAPED_UNICODE);
    }
    // GET INCOME TRANSACTIONS SUM
    public function getIncomeTransactions () {
        $u = $_COOKIE['u'];
        $wcr = $this->getBalance(0)['recid'];
        $query = "SELECT * FROM transactions WHERE wallet_from!='0' AND wallet_from!='".$wcr."' AND wallet_to='".$wcr."' ORDER BY datetime DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        $amount = 0;
        if($rows > 0) {
            do {
                $amount += $row['amount_to'];
            } while ($row = odbc_fetch_array($checkBank));
        }
        return $amount;
    }
    // GET OUTGOING TRANSACTIONS SUM
    public function getOutTransactions () {
        $u = $_COOKIE['u'];
        $wcr = $this->getBalance(0)['recid'];
        $query = "SELECT * FROM transactions WHERE wallet_to!='0' AND wallet_to!='".$wcr."' AND wallet_from='".$wcr."' ORDER BY datetime DESC";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);
        
        $amount = 0;
        if($rows > 0) {
            do {
                $amount += $row['amount_from'];
            } while ($row = odbc_fetch_array($checkBank));
        }
        return $amount;
    }
    // GET TRANSACTION
    public function getTransaction ($transid) {
        $query = "SELECT * FROM transactions WHERE recid=".$transid;
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        if($rows > 0) {
            return $row;
        }
    }
    // LIST TRANSACTIONS MINT
    public function mintGetTransactions ($bankID) {
        $queryTrans = "SELECT * FROM transactions WHERE acception = '0' AND (wallet_from = '$bankID' OR wallet_to = '$bankID') ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        $tblobj = '';
        if($rowsTrans > 0) {
            $i = 0;
            do {
                $handleBtn = '&nbsp;';
                if($rowTrans['acception'] == 0) {
                    $handleBtn = '<button class="btn btn-warning">Pending</button>';
                }
                else if($rowTrans['acception'] == 1) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                else if($rowTrans['acception'] == 2) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    // $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowTrans = odbc_fetch_array($checkTrans));
        }
        return $tblobj;
    }
    // LIST TRANSACTIONS ADMIN
    public function adminGetTransactions () {
        $queryTrans = "SELECT * FROM transactions ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        $tblobj = '';
        if($rowsTrans > 0) {
            $i = 0;
            do {
                $handleBtn = '&nbsp;';
                if($rowTrans['acception'] == 0) {
                    $handleBtn = '<button class="btn btn-success" onclick="permitTrans(\''.$rowTrans['recid'].'\')">Permit</button><button class="btn btn-danger" onclick="refuseTrans(\''.$rowTrans['recid'].'\')">Refuse</button>';
                }
                else if($rowTrans['acception'] == 1) {
                    $handleBtn = '<button class="btn btn-success">Aprofed</button>';
                }
                else if($rowTrans['acception'] == 2) {
                    $handleBtn = '<button class="btn btn-danger">Declined</button>';
                }
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '<td>'.$handleBtn.'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowTrans = odbc_fetch_array($checkTrans));
        }
        return $tblobj;
    }
    // MAKE PRIVATE TRANSACTION
    public function makeTransaction ($from, $to, $amount, $notes) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $queryCheck = "SELECT * FROM wallets WHERE recid = '$from' AND userid = '$u' AND amount >= '$amount'";
            $checkWalletFrom = $this->dbquery($queryCheck);
            $rowFrom = odbc_fetch_array($checkWalletFrom);
            $rowsFrom = odbc_num_rows($checkWalletFrom);

            if($rowsFrom > 0) {

                $queryWallet = "SELECT * FROM wallets WHERE recid = '$to'";
                $checkWalletFrom = $this->dbquery($queryWallet);
                $rowFromWallet = odbc_fetch_array($checkWalletFrom);
                $rowsFromWallet = odbc_num_rows($checkWalletFrom);

                if($rowsFromWallet > 0) {

                    $recAmount = $amount;
                    $commissions = 0;
                    $when = time();
                    $recID = $this->createRecordID();
                    $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', '".$rowFrom['type']."', '$recAmount', '".$rowFrom['type']."', '$notes', 0, '$when', 0, 0, 0, '$from', '$to', '$commissions')";
                    $this->dbquery($queryTrans);

                    $newAmount = $rowFromWallet['amount']+$recAmount;
                    $querySet = "UPDATE wallets SET amount = '$newAmount', datetime = '$when' WHERE recid = '$to'";
                    $this->dbquery($querySet);

                    $newAmount2 = $rowFrom['amount']-$amount;
                    $querySet2 = "UPDATE wallets SET amount = '$newAmount2', datetime = '$when' WHERE recid = '$from'";
                    $this->dbquery($querySet2);

                    $this->commissionsToBank($this->getBank()['recid'], $from, $commissions);

                    return 1;

                }
                else {
                    return 2;
                }

            }
            else {
                return 0;
            }
        }
    }
    // SEND WHITECOINS UNRESTRICTED
    public function coinSendUR ($from, $to, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        // if($this->getBalance(1)['amount'] >= $amount) {
            $when = time();
            $recID = $this->createRecordID();
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 3, '$amount', 3, '$notes', 0, '$when', 7, 0, 0, '$from', '$to', '0')";
            $this->dbquery($queryTrans);

            $this->sendMail($this->getUser()['user_mail'], $recID, $amount, 3);

            return 1;
        // }
        // else {
        //     return 0;
        // }
    }
    // ADMIN CONFIRM TRANSACTION
    public function adminConfirmTransaction ($recID, $confirm) {
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID' AND acception = '0'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            $queryTo = "SELECT * FROM wallets WHERE recid = '".$rowTrans['wallet_from']."' AND userid = '".$rowTrans['userid']."'";
            $checkWalletTo = $this->dbquery($queryTo);
            $rowTo = odbc_fetch_array($checkWalletTo);
            $rowsTo = odbc_num_rows($checkWalletTo);

            if($rowsTo > 0) {
                $newAmount = $rowTo['amount']+$rowTrans['amount_to'];
                $querySet = "UPDATE wallets SET amount = '$newAmount' WHERE recid = '".$rowTrans['wallet_to']."'";
                $this->dbquery($querySet);
            }
        }
    }
    // GET BANK TRANSACTIONS
    public function adminGetBankTransactions ($recId) {
        $queryTrans = "SELECT * FROM transactions WHERE wallet_from = '$recId' OR wallet_to = '$recId' ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        $tblobj = '';
        if($rowsTrans > 0) {
            $i=0;
            do {
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowTrans['recid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['userid'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_from'].' '.$this->getCurrency($rowTrans['currency_from']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['amount_to'].' '.$this->getCurrency($rowTrans['currency_to']).'</td>';
                    $tblobj .= '<td>'.$rowTrans['commissions'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['notes'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_from'].'</td>';
                    $tblobj .= '<td>'.$rowTrans['wallet_to'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowTrans['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowTrans = odbc_fetch_array($checkTrans));
        }
        return $tblobj;
    }
    // MAKE ADMIN TRANSACTION
    public function adminMakeTransaction ($from, $to, $amount, $notes) {
        $u = $_COOKIE['u'];
        $h = $_COOKIE['h'];
        $queryCheck = "SELECT * FROM bank WHERE recid = '$from' AND amount >= '$amount'";
        $checkBankFrom = $this->dbquery($queryCheck);
        $rowFrom = odbc_fetch_array($checkBankFrom);
        $rowsFrom = odbc_num_rows($checkBankFrom);

        if($rowsFrom > 0) {

            $queryWallet = "SELECT * FROM wallets WHERE recid = '$to'";
            $checkWalletFrom = $this->dbquery($queryWallet);
            $rowFromWallet = odbc_fetch_array($checkWalletFrom);
            $rowsFromWallet = odbc_num_rows($checkWalletFrom);

            if($rowsFromWallet > 0) {
                
                $when = time();
                $recID = $this->createRecordID();
                $u = $_COOKIE['u'];
                $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, '$notes', 0, '$when', 1, 0, 0, '$from', '$to', 0)";
                $this->dbquery($queryTrans);

                $newAmount = $rowFromWallet['amount']+$amount;
                $querySet = "UPDATE wallets SET amount = '$newAmount', datetime = '$when' WHERE recid = '$to'";
                $this->dbquery($querySet);

                $newAmount2 = $rowFrom['amount']-$amount;
                $querySet2 = "UPDATE bank SET amount = '$newAmount2', datetime = '$when' WHERE recid = '$from'";
                $this->dbquery($querySet2);

                return $newAmount2;

            }
            else {
                return 'no wallet';
            }
        }
        else {
            return 'no money';
        }
    }
    // GET BALANCE
    public function getBalance ($type) {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM wallets WHERE userid = '$u' AND type='$type'";
            $checkWallet = $this->dbquery($query);
            $row = odbc_fetch_array($checkWallet);
            $rows = odbc_num_rows($checkWallet);
            if($rows > 0) {
                return $row;
            }
        }
    }
}
?>