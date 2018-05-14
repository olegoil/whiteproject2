<?php
class ips extends transes {
    // GET CLIENTS IP
    public function get_client_ip_server () {
        $ipaddress = '';
        if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }
}
?>