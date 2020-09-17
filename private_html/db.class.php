<?php

class DB
{
    public $conn;

    public function Open_Connection()
    {
        $servername = "localhost";
        $dbname = "";
        $username = "";
        $password = "";

        try
        {
            Global $conn;

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function Close_Connection()
    {
        Global $conn;

        $conn = null;
        echo "Connection closed";
    }
}

?>