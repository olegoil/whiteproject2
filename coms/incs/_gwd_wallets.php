<?php
    // FOR SEARCHING
    $aColumns = array( 'recid', 'userid', 'type', 'amount', 'date' );

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
        $sOrder = "ORDER BY ";
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
    }

    /* 
    * Filtering
    */
    $sWhere = "WHERE type='0' ";
    if ( $_POST['sSearch'] != "" )
    {
        $sWhere = "WHERE type='0' AND ";
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


    $query_getData = "SELECT * FROM wallets $sWhere $sOrder";
    $getData = $sql->dbquery($query_getData);
    $row_getData = odbc_fetch_array($getData);
    $getDataRows  = odbc_num_rows($getData);

    $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM wallets WHERE type = '0'";
    $getDataLength = $sql->dbquery($query_getDataLength);
    $row_getDataLength = odbc_fetch_array($getDataLength);
    $getDataLengthRows  = odbc_num_rows($getDataLength);

    if($getDataRows > 0) {

    do {
        
        $gotdata['aaData'][] = array($row_getData['recid'], $row_getData['userid'], $sql->getCurrency($row_getData['type']), $row_getData['amount'], date('m/d/Y h:i A', $row_getData['datetime']));
    
    } while ($row_getData = odbc_fetch_array($getData));

    }
    else {
    $gotdata['aaData'][] = array(null, null, null, null, null);
    }

    $gotdata['sEcho'] = intval($_POST['sEcho']);
    $gotdata['iTotalRecords'] = $getDataRows;
    $gotdata['iTotalDisplayRecords'] = $getDataRows;

    echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);
?>