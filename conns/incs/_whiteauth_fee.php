<?php
    // GET FEE
    $sql->getFee = function ($from, $to) {
        $query = "SELECT * FROM fee WHERE currfrom = '$from' AND currto='$to'";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        if($rows > 0) {
            return $row;
        }
    };
    // SET FEE
    $sql->setFee = function ($from, $to, $percent) {
        
        $when = time();

        $query = "SELECT * FROM fee WHERE currfrom = '$from' AND currto='$to'";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        if($rows > 0) {
            $queryUpd = "UPDATE fee SET fee='$percent', datetime='$when' WHERE recid='".$row['recid']."'";
            $this->dbquery($queryUpd);
            return 1;
        }
        else {
            $recID = $this->createRecordID();
            $queryIns = "INSERT INTO fee (recid, currfrom, currto, fee, datetime) VALUES ('$recID', '$from', '$to', '".$percent."', '$when')";
            $this->dbquery($queryIns);
            return 1;
        }
        
    };
    // LIST FEES
    $sql->listFee = function () {
        $query = "SELECT * FROM fee";
        $checkFee = $this->dbquery($query);
        $row = odbc_fetch_array($checkFee);
        $rows = odbc_num_rows($checkFee);
        $result = '';
        if($rows > 0) {
            do {
                $result .= '<tr>
                <td>'.$this->currName($row['currfrom']).'</td>
                <td>'.$this->currName($row['currto']).'</td>
                <td>'.$row['fee'].'%</td></tr>';
            } while ($row = odbc_fetch_array($checkFee));
        }
        return $result;
    };
?>