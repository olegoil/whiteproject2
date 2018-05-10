<?php
    var $serverName = "BlockChain5-SQL";
    var $database = "WhiteCoin";
    var $user= "sa";
    var $password = "Pos!2014";
    var $hostname = "olegtronics.com";
    var $salt = 'bestprojectever';
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