<?php
    var $database = DB_NAME;
    var $serverName = DB_SERVER_NAME;
    var $user = DB_USER;
    var $password = DB_PWD;
    var $hostname = DB_HOST;
    var $salt = DB_SALT;
    var $key = 'whiteprojectforever';
    var $conn;

    // CONNECT TO DB
    $sql->connectDB = function () {
        return $connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$this->serverName;Database=$this->database;", $this->user, $this->password);
    }
    // CLOSE DB CONNECTION
    $sql->closeConn = function () {
        odbc_close($this->conn);
    }
    // QUERY EXECUTION
    $sql->dbquery = function ($q) {
        $connection = $this->connectDB();
        $result = odbc_exec($connection, $q) or die("<p>".odbc_errormsg());
        return $result;
    }
?>