<?php
if (!function_exists('OpenConnection')) {
    function OpenConnection()
    {
        $serverName = "cure4soul.database.windows.net";
        $connectionOptions = array(
            "Database" => "Cure4soul",
            "Uid" => "cure4soul",
            "PWD" => "AdminAdmin123"
        );
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $conn;
    }
}
?>