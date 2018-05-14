<?php
class transesp extends banks {
    // MINTER PROOF TRANSACTION
    public function minterProof ($recID, $amount, $fromadr) {
        $when = time();
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 0) {
                $updTrans = "UPDATE transactions SET acception='3', transdel='1', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
            }
            else if($fromadr != '' && $fromadr != '-1') {
                $updTrans = "UPDATE transactions SET acception='4', transdel='0', mintreq='$fromadr', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
            }
            else {
                $updTrans = "UPDATE transactions SET acception='4', transdel='0', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
            }
        }
    }
    // USER PROOF TRANSACTION
    public function userProof ($recID, $amount) {
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            $delTrans = "DELETE FROM transactions WHERE recid='$recID'";
            $this->dbquery($delTrans);
        }
    }
    // ADMIN PROOF TRANSACTION
    public function adminProof ($recID, $amount) {
        $when = time();
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 0) {
                $updTrans = "UPDATE transactions SET acception='6', transdel='1', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
                return 1;
            }
            else {
                $updTrans = "UPDATE transactions SET acception='7', transdel='0', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);

                $queryWallet = "SELECT * FROM wallets WHERE type='0' AND userid='".$rowTrans['userid']."'";
                $checkWallet = $this->dbquery($queryWallet);
                $rowWallet = odbc_fetch_array($checkWallet);
                $rowsWallet = odbc_num_rows($checkWallet);
                
                if($rowsWallet > 0) {
                    if($rowTrans['currency_from'] == '0') {
                        $newAmount = $rowWallet['amount'] - $rowTrans['amount_from'];
                    }
                    else {
                        $amountTo = $rowTrans['amount_to'];
                        if($rowTrans['notes'] == 'Request BTC to WCR') {
                            $amountTo = $amount;
                        }
                        $newAmount = $rowWallet['amount'] + $amountTo;
                    }

                    $updWallet = "UPDATE wallets SET amount='$newAmount', datetime='$when' WHERE type='0' AND userid='".$rowTrans['userid']."'";
                    $this->dbquery($updWallet);
                    return 1;
                }
                else {
                    return 0;
                }
            }
        }
    }
    // ADMIN PROOF TRANSACTION WCR TO WCUR
    public function adminProof2 ($recID, $amount) {
        $when = time();
        
        $queryTrans = "SELECT * FROM transactions WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 0) {
                $updTrans = "UPDATE transactions SET acception='6', transdel='1', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
                return 0;
            }
            else {
                $updTrans = "UPDATE transactions SET acception='4', transdel='0', changed='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);

                $queryWallet = "SELECT * FROM wallets WHERE type='0' AND userid='".$rowTrans['userid']."'";
                $checkWallet = $this->dbquery($queryWallet);
                $rowWallet = odbc_fetch_array($checkWallet);
                $rowsWallet = odbc_num_rows($checkWallet);
                
                if($rowsWallet > 0) {
                    if($rowTrans['currency_from'] == '0') {
                        $newAmount = $rowWallet['amount'] - $rowTrans['amount_from'];
                    }
                    else {
                        $newAmount = $rowWallet['amount'] + $rowTrans['amount_to'];
                    }

                    $updWallet = "UPDATE wallets SET amount='$newAmount', datetime='$when' WHERE type='0' AND userid='".$rowTrans['userid']."'";
                    $this->dbquery($updWallet);
                    return 1;
                }
                else {
                    return 0;
                }
            }
        }
    }
}
?>