<?php
    // FOR SEARCHING
    $aColumns = array( 'recid', 'userid', 'notes', 'wallet_from', 'wallet_to' );

    /* 
    * Paging
    */
    $sLimit = "";
    if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".$sql->protect( $_POST['iDisplayStart'] ).", ".
        $sql->protect( $_POST['iDisplayLength'] );
    }

    /*
    * Ordering
    */
    if ( isset( $_POST['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
        {
            if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
                    ".$sql->protect( $_POST['sSortDir_'.$i] ) .", ";
            }
        }
        
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "ORDER BY datetime DESC";
        }

        $sOrder = "ORDER BY datetime DESC";

    }

    /* 
    * Filtering
    */
    if(isset($_POST['utype'])) {
        if($_POST['utype'] == 2) {
            $sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='0' AND transdel='0'";
            if ( $_POST['sSearch'] != "" )
            {
                $sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='0' AND transdel='0' AND (";
            }
        }
        else if($_POST['utype'] == 1) {
            $sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='4' AND transdel='0'";
            if ( $_POST['sSearch'] != "" )
            {
                $sWhere = "WHERE (wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."' OR userid=wallet_to) AND acception='4' AND transdel='0' AND (";
            }
        }
        else if($_POST['utype'] == 0) {
            $sWhere = "WHERE userid='".$_POST['userid']."' OR wallet_to='".$sql->getBalance(0)['recid']."' OR wallet_to='".$sql->getBalance(1)['recid']."' OR wallet_to='".$sql->getBalance(2)['recid']."' OR wallet_to='".$sql->getBalance(3)['recid']."'";
            if ( $_POST['sSearch'] != "" )
            {
                $sWhere = "WHERE userid='".$_POST['userid']."' OR wallet_to='".$sql->getBalance(0)['recid']."' OR wallet_to='".$sql->getBalance(1)['recid']."' OR wallet_to='".$sql->getBalance(2)['recid']."' OR wallet_to='".$sql->getBalance(3)['recid']."') AND (";
            }
        }
    }
    if ( $_POST['sSearch'] != "" )
    {
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }

    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".$sql->protect($_POST['sSearch_'.$i])."%' ";
        }
    }

    $query_getData = "SELECT * FROM transactions $sWhere $sOrder";
    $getData = $sql->dbquery($query_getData);
    $row_getData = odbc_fetch_array($getData);
    $getDataRows  = odbc_num_rows($getData);

    $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM transactions WHERE wallet_from = '".$_POST['bankId']."' OR wallet_to = '".$_POST['bankId']."'";
    $getDataLength = $sql->dbquery($query_getDataLength);
    $row_getDataLength = odbc_fetch_array($getDataLength);
    $getDataLengthRows  = odbc_num_rows($getDataLength);

    if($getDataRows > 0) {

        $numId = $getDataRows;
        
        do {

            $amountfrom = $row_getData['amount_from'].' '.$sql->getCurrency($row_getData['currency_from']);
            $amountto = $row_getData['amount_to'].' '.$sql->getCurrency($row_getData['currency_to']);

            $walletTo = $row_getData['wallet_to'];
            if($row_getData['notes'] == 'Request BTC to WCR') {

                $query_getWalletId = "SELECT * FROM wallets WHERE userid = '".$row_getData['wallet_to']."' AND type = '0'";
                $getWalletId = $sql->dbquery($query_getWalletId);
                $row_getWalletId = odbc_fetch_array($getWalletId);
                $getWalletIdRows  = odbc_num_rows($getWalletId);
                
                if($getWalletIdRows > 0) {
                    $walletTo = $row_getWalletId['recid'];
                }

            }
            
            $gotdata['aaData'][] = array($row_getData['recid'], $row_getData['userid'], $amountfrom, $amountto, $row_getData['commissions'], $row_getData['notes'], $row_getData['wallet_from'], $walletTo, date('m/d/Y h:i A', $row_getData['datetime']), $row_getData['acception'], $row_getData['state'], $row_getData['transid'], $row_getData['mintreq'], $numId);

            $numId--;
        
        } while ($row_getData = odbc_fetch_array($getData));

    }
    else {
        $gotdata['aaData'][] = array(null, null, null, null, null, null, null, null, null, null, null, null, null);
    }

    $gotdata['sEcho'] = intval($_POST['sEcho']);
    $gotdata['iTotalRecords'] = $getDataRows;
    $gotdata['iTotalDisplayRecords'] = $getDataRows;

    echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);
?>