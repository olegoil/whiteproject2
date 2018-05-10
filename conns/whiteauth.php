<?php

class sql {
    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }
}

$sql = new sql();

include 'incs/_whiteauth_conn.php';

include 'incs/_whiteauth_protect.php';

include 'incs/_whiteauth_hash.php';

include 'incs/_whiteauth_random_gen.php';

include 'incs/_whiteauth_register.php';

include 'incs/_whiteauth_conf_email.php';

include 'incs/_whiteauth_auth.php';

include 'incs/_whiteauth_pwd.php';

include 'incs/_whiteauth_userdata.php';

include 'incs/_whiteauth_level.php';

include 'incs/_whiteauth_ip.php';

include 'incs/_whiteauth_transactions.php';

include 'incs/_whiteauth_transactions_proof.php';

include 'incs/_whiteauth_bank.php';

include 'incs/_whiteauth_docs.php';

include 'incs/_whiteauth_fee.php';

?>