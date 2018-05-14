<?php
    class connects extends protects {
        var $salt = HASH_SALT;
        var $key = HASH_KEY;
        // CONNECT TO DB
        public function connectDB () {
            return $connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=".DB_SERVER_NAME.";Database=".DB_NAME.";", DB_USER, DB_PWD);
        }
        // CLOSE DB CONNECTION
        public function closeConn() {
            odbc_close($this->conn);
        }
        // QUERY EXECUTION
        public function dbquery($q) {
            $connection = $this->connectDB();
            $result = odbc_exec($connection, $q) or die("<p>".odbc_errormsg());
            return $result;
        }
    }
?>