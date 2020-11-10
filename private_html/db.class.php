<?php

class DB
{
    public $conn;
    private $accessFilePath = "access.json";

    private function Get_Credentials()
    {
        try
        {
            // New and small version
            fclose($fileContent = fread(fopen($accessFilePath, "r"),filesize($accessFilePath)));
            return json_decode($fileContent);
        }
        catch (Exeptiopn $e)
        {
            echo "Error: $e";
            return false;
        }
    }

    public function Open_Connection()
    {
        $credentials = Get_Credentials();
        $servername = $credentials['servername'];
        $dbname = $credentials['dbname'];
        $username = base64_decode($credentials['username']);
        $password = base64_decode($credentials['password']);

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