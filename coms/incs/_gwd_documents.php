<?php
    // FOR SEARCHING
    $aColumns = array( 'recid', 'doctype', 'datetime', 'confirmed', 'userid' );

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
    }

    /* 
    * Filtering
    */
    $sWhere = "WHERE docdel != '1' ";
    if ( $_POST['sSearch'] != "" )
    {
        $sWhere = "WHERE docdel != '1' AND (";
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


    $query_getData = "SELECT * FROM documents $sWhere $sOrder";
    $getData = $sql->dbquery($query_getData);
    $row_getData = odbc_fetch_array($getData);
    $getDataRows  = odbc_num_rows($getData);

    $query_getDataLength = "SELECT COUNT(*) AS dataCnt FROM documents";
    $getDataLength = $sql->dbquery($query_getDataLength);
    $row_getDataLength = odbc_fetch_array($getDataLength);
    $getDataLengthRows  = odbc_num_rows($getDataLength);

    if($getDataRows > 0) {

    $numId = $getDataRows;

    do {

        $query_getUser = "SELECT * FROM users WHERE user_id='".$row_getData['userid']."' ORDER BY user_when DESC";
        $getUser = $sql->dbquery($query_getUser);
        $row_getUser = odbc_fetch_array($getUser);
        $getRowsUser  = odbc_num_rows($getUser);
        
        $gotdata['aaData'][] = array($row_getData['recid'], $row_getData['doctype'], date('m/d/Y h:i A', $row_getData['datetime']), $row_getData['docdel'], $row_getData['confirmed'], date('m/d/Y h:i A', $row_getData['confdatetime']), $row_getData['userid'], $row_getData['docurl'], $row_getUser['user_name'], $row_getUser['user_lastname'], $numId);
        
        $numId--;
    
    } while ($row_getData = odbc_fetch_array($getData));

    }
    else {
    $gotdata['aaData'][] = array(null, null, null, null, null, null, null, null, null);
    }

    $gotdata['sEcho'] = intval($_POST['sEcho']);
    $gotdata['iTotalRecords'] = $getDataRows;
    $gotdata['iTotalDisplayRecords'] = $getDataRows;

    echo json_encode($gotdata, JSON_UNESCAPED_UNICODE);
?>