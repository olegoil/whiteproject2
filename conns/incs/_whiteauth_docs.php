<?php
class doxs extends fees {
    // UPLOAD FILE
    public function uploadFile ($filename, $doctype) {
        $recId = $this->createRecordID();
        $u = $_COOKIE['u'];
        $when = time();
        $query = "INSERT INTO documents (recid, userid, doctype, datetime, docdel, confirmed, confdatetime, docurl) VALUES ('$recId', '$u', '$doctype', '$when', '0', '0', '0', '$filename')";
        $this->dbquery($query);
    }
    // DOCUMENT PROOFED
    public function docProof ($recID, $amount) {
        $when = time();
        
        $queryTrans = "SELECT * FROM documents WHERE recid = '$recID'";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            if($amount == 2) {
                $updTrans = "UPDATE documents SET confirmed='2', confdatetime='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);
                return 1;
            }
            else if($amount == 1) {
                $updTrans = "UPDATE documents SET confirmed='1', confdatetime='$when' WHERE recid='$recID'";
                $this->dbquery($updTrans);

                $queryUser = "SELECT * FROM users WHERE user_id='".$rowTrans['userid']."'";
                $checkUser = $this->dbquery($queryUser);
                $rowUser = odbc_fetch_array($checkUser);
                $rowsUser = odbc_num_rows($checkUser);
                
                if($rowsUser > 0) {
                    if($rowTrans['doctype'] == 'mobile') {
                        $updUsers = "UPDATE users SET user_mobile_confirm ='1' WHERE user_id='".$rowTrans['userid']."'";
                        $this->dbquery($updUsers);
                        return 1;
                    }
                    else if($rowTrans['doctype'] == 'address') {
                        $updUsers = "UPDATE users SET user_adress_confirm ='1' WHERE user_id='".$rowTrans['userid']."'";
                        $this->dbquery($updUsers);
                        return 1;
                    }
                    else if($rowTrans['doctype'] == 'passport') {
                        $updUsers = "UPDATE users SET user_passport_confirm ='1' WHERE user_id='".$rowTrans['userid']."'";
                        $this->dbquery($updUsers);
                        return 1;
                    }
                    else {
                        return 'no doctype';
                    }
                }
                else {
                    return 'no user';
                }
            }
            else {
                return 'no handler';
            }
        }
        else {
            return 'no doc';
        }
    }
    // CHECK CONFIRMED DOCS
    public function getDocsConfirmed ($doctype, $usr) {
        $queryTrans = "SELECT * FROM documents WHERE userid = '$usr' AND doctype='$doctype' ORDER BY datetime DESC";
        $checkTrans = $this->dbquery($queryTrans);
        $rowTrans = odbc_fetch_array($checkTrans);
        $rowsTrans = odbc_num_rows($checkTrans);

        if($rowsTrans > 0) {
            return $rowTrans['confirmed'];
        }
        else {
            return 'no doc';
        }
    }
}
?>