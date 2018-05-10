<?php
    // FOR SEARCHING
    $aColumns = array( 'user_id', 'user_email', 'user_name', 'user_lastname', 'user_postal', 'user_adress', 'user_mobile' );

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
            $sOrder = "ORDER BY user_when DESC";
        }
    }

    /* 
    * Filtering
    */
    $sWhere = "WHERE ";
    if ( $_POST['sSearch'] != "" )
    {
        $sWhere = "WHERE ";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".$sql->protect( $_POST['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
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

    $query_getData = "SELECT * FROM users WHERE user_type='3' ORDER BY user_when DESC";
    $getData = $sql->dbquery($query_getData);
    $row_getData = odbc_fetch_array($getData);
    $getDataRows = odbc_num_rows($getData);

    $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM users WHERE user_type='3'";
    $getDataLength = $sql->dbquery($query_getDataLength);
    $row_getDataLength = odbc_fetch_array($getDataLength);
    $getDataLengthRows  = odbc_num_rows($getDataLength);

    if($getDataRows > 0) {
        
        do {

            $adress_confirm = $row_getData['user_adress_confirm'];
            $passport_confirm = $row_getData['user_passport_confirm'];
            $adressid = 0;
            $passid = 0;

            $query_getDocs = "SELECT * FROM documents WHERE userid='".$row_getData['user_id']."' ORDER BY datetime DESC";
            $getDocs = $sql->dbquery($query_getDocs);
            $row_getDocs = odbc_fetch_array($getDocs);
            $getRowsDocs  = odbc_num_rows($getDocs);

            if($getRowsDocs > 0) {
                do {
                    if($row_getDocs['confirmed'] == '2' && $row_getDocs['doctype'] == 'address') {
                        $adress_confirm = $row_getDocs['confirmed'];
                        $adressid = $row_getDocs['recid'];
                    }
                    else if($row_getDocs['confirmed'] == '2' && $row_getDocs['doctype'] == 'passport') {
                        $passport_confirm = $row_getDocs['confirmed'];
                        $passid = $row_getDocs['recid'];
                    }
                    else if($row_getDocs['confirmed'] != '1' && $row_getDocs['doctype'] == 'address') {
                        $adress_confirm = $row_getDocs['docurl'];
                        $adressid = $row_getDocs['recid'];
                    }
                    else if($row_getDocs['confirmed'] != '1' && $row_getDocs['doctype'] == 'passport') {
                        $passport_confirm = $row_getDocs['docurl'];
                        $passid = $row_getDocs['recid'];
                    }
                } while ($row_getDocs = odbc_fetch_array($getDocs));
            }

            $queryWallet = "SELECT * FROM wallets WHERE type='3' AND userid='".$row_getData['user_id']."'";
            $checkWallet = $sql->dbquery($queryWallet);
            $rowWallet = odbc_fetch_array($checkWallet);
            $rowsWallet = odbc_num_rows($checkWallet);
            
            $gotdata['aaData'][] = array($row_getData['user_id'], $row_getData['user_email'], date('m/d/Y h:i A', $row_getData['user_when']), date('m/d/Y h:i A', $row_getData['user_log']), $row_getData['user_ip'], $row_getData['user_type'], $row_getData['user_name'], $row_getData['user_lastname'], $row_getData['user_skype'], $row_getData['user_country'], $row_getData['user_city'], $row_getData['user_postal'], $row_getData['user_adress'], $row_getData['user_mobile'], $row_getData['user_pic'], $row_getData['user_confirm'], $row_getData['user_mobile_confirm'], $adress_confirm, $passport_confirm, $adressid, $passid, $row_getData['user_minter'], $rowWallet['wallet_minter']);
        
        } while ($row_getData = odbc_fetch_array($getData));

    }
    else {
        $gotdata['aaData'][] = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
    }

    $gotdata['sEcho'] = intval($_POST['sEcho']);
    $gotdata['iTotalRecords'] = $getDataRows;
    $gotdata['iTotalDisplayRecords'] = $getDataRows;

    echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);
?>