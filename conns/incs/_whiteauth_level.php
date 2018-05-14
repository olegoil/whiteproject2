<?php
class levels extends ips {
    // USER CHECK USER TYPE
    public function checkLevel () {
        if(isset($_COOKIE['u']) && isset($_COOKIE['h'])) {
            $u = $_COOKIE['u'];
            $h = $_COOKIE['h'];
            $query = "SELECT * FROM users WHERE user_id = '$u' AND user_hash = '$h'";
            $checkUsr = $this->dbquery($query);
            $row = odbc_fetch_array($checkUsr);
            $rows = odbc_num_rows($checkUsr);

            if($rows > 0) {
                return $row['user_type'];
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
    // LEVEL NAME
    public function levelName ($usertype) {
        switch($usertype) {
            case 0:
                return 'USER';
                break;
            case 1:
                return 'MANAGER';
                break;
            case 2:
                return 'MINTER';
                break;
            case 3:
                return 'KYCAML';
                break;
            default:
                return 'USER';
                break;
        }
    }
}
?>