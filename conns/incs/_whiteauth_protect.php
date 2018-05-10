<?php
    // PROTECT FUNCTION FROM INJECTION, ETC (TO SAVE STRINGS IN DB)
    function protect($v) {
        $v = trim($v);
        $v = stripslashes($v);
        $v = htmlentities($v, ENT_QUOTES);
        $v = str_replace("'", "''", $v);
        $v = addslashes($v);
        return $v;
    }
?>