<?php
    // GET CLIENTS IP
    $sql->get_client_ip_server = function () {
        $ipaddress = '';
        if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    };
?>