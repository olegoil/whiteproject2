<?php
class banks extends coins {
    // BANK DATA
    public function getBank () {
        $query = "SELECT * FROM bank";
        $checkBank = $this->dbquery($query);
        $row = odbc_fetch_array($checkBank);
        $rows = odbc_num_rows($checkBank);

        if($rows > 0) {
            return $row;
        }
    }
    // LIST WALLETS
    public function adminGetWallets () {
        $queryWallet = "SELECT * FROM wallets WHERE type = '0' ORDER BY datetime DESC";
        $checkWallet = $this->dbquery($queryWallet);
        $rowWallet = odbc_fetch_array($checkWallet);
        $rowsWallet = odbc_num_rows($checkWallet);

        $tblobj = '';
        if($rowsWallet > 0) {
            $i=0;
            do {
                if($i%2 == 0) {
                    $tblobj .= '<tbody><tr class="even pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowWallet['recid'].'</td>';
                    $tblobj .= '<td>'.$rowWallet['userid'].'</td>';
                    $tblobj .= '<td><i class="fa fa-krw"></i> WTR</td>';
                    $tblobj .= '<td>'.$rowWallet['amount'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowWallet['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                else {
                    $tblobj .= '<tbody><tr class="odd pointer">';
                    $tblobj .= '<td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>';
                    $tblobj .= '<td>'.$rowWallet['recid'].'</td>';
                    $tblobj .= '<td>'.$rowWallet['userid'].'</td>';
                    $tblobj .= '<td><i class="fa fa-krw"></i> WTR</td>';
                    $tblobj .= '<td>'.$rowWallet['amount'].'</td>';
                    $tblobj .= '<td>'.date('m/d/Y', $rowWallet['datetime']).'</td>';
                    $tblobj .= '</tr></tbody>';
                }
                $i++;
            } while ($rowWallet = odbc_fetch_array($checkWallet));
        }
        return $tblobj;
    }
    // GET BANK
    public function adminGetBank () {
        $queryBank = "SELECT * FROM bank";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);
        if($rowsBank > 0) {
            return $rowBank;
        }
    }
    // ADD TO BANK
    public function adminCoinCreate ($bankID, $amount) {
        $queryBank = "SELECT * FROM bank WHERE recid = '$bankID'";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);

        if($rowsBank > 0) {
            $when = time();
            $recID = $this->createRecordID();
            $u = $_COOKIE['u'];
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, 'Coin Create', 0, '$when', 1, 0, 0, '$bankID', '$bankID', 0)";
            $this->dbquery($queryTrans);

            $newAmount = $rowBank['amount']+$amount;
            $querySet = "UPDATE bank SET amount = '$newAmount', datetime = '$when' WHERE recid = '$bankID'";
            $this->dbquery($querySet);

            return $newAmount;

        }
        else {
            return 'no wallet';
        }
    }
    // REMOVE FROM BANK
    public function adminCoinRemove ($bankID, $amount) {
        $queryBank = "SELECT * FROM bank WHERE recid = '$bankID'";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);

        if($rowsBank > 0) {
            if($amount <= $rowBank['amount']) {
                $when = time();
                $recID = $this->createRecordID();
                $u = $_COOKIE['u'];
                $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, 'Coin Destroy', 0, '$when', 1, 0, 0, '$bankID', 0, 0)";
                $this->dbquery($queryTrans);

                $newAmount = $rowBank['amount']-$amount;
                $querySet = "UPDATE bank SET amount = '$newAmount', datetime = '$when' WHERE recid = '$bankID'";
                $this->dbquery($querySet);

                return $newAmount;
            }
            else {
                return 'no money';
            }
        }
    }
    // COMMISSIONS TO BANK
    public function commissionsToBank ($bankID, $from, $amount) {
        $queryBank = "SELECT * FROM bank WHERE recid = '$bankID'";
        $checkBank = $this->dbquery($queryBank);
        $rowBank = odbc_fetch_array($checkBank);
        $rowsBank = odbc_num_rows($checkBank);

        if($rowsBank > 0) {
            $when = time();
            $recID = $this->createRecordID();
            $u = $_COOKIE['u'];
            $queryTrans = "INSERT INTO transactions (recid, userid, amount_from, currency_from, amount_to, currency_to, notes, chain, datetime, acception, changed, transdel, wallet_from, wallet_to, commissions) VALUES ('$recID', '$u', '$amount', 0, '$amount', 0, 'Commissions', 0, '$when', 1, 0, 0, '$from', '$bankID', 0)";
            $this->dbquery($queryTrans);

            $newAmount = $rowBank['amount']+$amount;
            $querySet = "UPDATE bank SET amount = '$newAmount', datetime = '$when' WHERE recid = '$bankID'";
            $this->dbquery($querySet);

            return $newAmount;
        }
        else {
            return 'no wallet';
        }
    }
    // CHECK CURRENCY
    public function getCurrency ($val) {
        switch ($val) {
            case 0: return 'WCR';
                break;
            case 1: return 'WCUR';
                break;
            case 2: return 'BTC';
                break;
            case 3: return 'ETH';
                break;
            case 5: return 'USD';
                break;
            default: return 'WCR';
                break;
        }
    }
    // GET EXCHANGE RATES
    public function getExchangeRate ($currency1, $currency2) {
        $queryExchange = "SELECT * FROM exchange WHERE currency1 = '$currency1' AND currency2 = '$currency2'";
        $checkExchange = $this->dbquery($queryExchange);
        $row = odbc_fetch_array($checkExchange);
        $rows = odbc_num_rows($checkExchange);
        if($rows > 0) {
            return $row;
        }
    }
    // GET EXCHANGE RATES
    public function getRates () {
        $lasttime = time() - 600;
        $queryCheck = "SELECT * FROM exchange WHERE currency1 != 'WCR' AND currency2 != 'WCR' AND currency1 != 'WCUR' AND currency2 != 'WCUR' AND datetime <= '$lasttime' ORDER BY datetime DESC";
        $checkRates = $this->dbquery($queryCheck);
        $rowFrom = odbc_fetch_array($checkRates);
        $rowsFrom = odbc_num_rows($checkRates);

        if($rowsFrom > 0) {
            
        }
        else {
            $when = time();
            $recID = $this->createRecordID();
            $queryTrans = "INSERT INTO exchange (recid, amount1, amount2, currency1, currency2, datetime) VALUES ('$recID', '$u', '$amount', '".$rowFrom['type']."', '$recAmount', '".$rowFrom['type']."', '$notes', 0, '$when', 0, 0, 0, '$from', '$to', '$commissions')";
            $this->dbquery($queryTrans);
        }

    }
    // MAKE EXCHANGE
    public function makeExchange ($from, $to, $amount, $notes) {
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

                    $recAmount = $amount*0.95;
                    $commissions = $amount*0.05;
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
    // CURRENCY NAME
    public function currName ($name) {
        $realName = '';
        switch($name) {
            case 'WCR':
                $realName = 'White Standard Restricted';
                break;
            case 'WCUR':
                $realName = 'White Standard Unrestricted';
                break;
            case 'ETH':
                $realName = 'Ethereum';
                break;
            case 'BTC':
                $realName = 'Bitcoin';
                break;
            case 'USD':
                $realName = 'USD';
                break;
            case 'BA':
                $realName = 'Bank wire';
                break;
            case 'CC':
                $realName = 'Credit Card';
                break;
            case 'CA':
                $realName = 'ACH';
                break;
            default:
                $realName = '';
                break;
        }
        return $realName;
    }
    // SET QUOTE
    public function setQuote ($amount) {
        
        $when = time();

        $query = "SELECT * FROM exchange WHERE currency1='USD' AND currency2='WCR'";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        if($rows > 0) {
            $queryUpd = "UPDATE exchange SET amount1='$amount', datetime='$when' WHERE currency1='USD' AND currency2='WCR'";
            $this->dbquery($queryUpd);
            return 1;
        }
        else {
            $recID = $this->createRecordID();
            $queryIns = "INSERT INTO exchange (recid, amount1, amount2, currency1, currency2, datetime) VALUES ('$recID', '$amount', '1', 'USD', 'WCR', '$when')";
            $this->dbquery($queryIns);
            return 1;
        }
        
    }
    // SET ETHEREUM WALLET
    public function setEthWallet ($ethwallet) {
        $u = $_COOKIE['u'];
        $updWallet = "UPDATE wallets SET wallet_minter='$ethwallet' WHERE type='3' AND userid='$u'";
        $this->dbquery($updWallet);
    }
}
?>