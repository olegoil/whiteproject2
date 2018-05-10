<?php

include '../conns/whiteauth.php';

$gotdata = array();

if(isset($_POST['req']) && $_POST['req'] == 'transactions') {

	include 'incs/_gwd_transactions.php';

}
else if(isset($_POST['req']) && $_POST['req'] == 'wallets') {

    include 'incs/_gwd_wallets.php';

}
else if(isset($_POST['req']) && $_POST['req'] == 'users') {

    include 'incs/_gwd_users.php';

}
else if(isset($_POST['req']) && $_POST['req'] == 'minters') {

    include 'incs/_gwd_minters.php';

}
else if(isset($_POST['req']) && $_POST['req'] == 'kycaml') {

    include 'incs/_gwd_kycaml.php';

}
else if(isset($_POST['req']) && $_POST['req'] == 'documents') {

    include 'incs/_gwd_documents.php';

}

?>