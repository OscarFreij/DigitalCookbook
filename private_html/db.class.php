<?php

class DB
{
    public $conn;
    protected $accessFilePath = "../private_html/access.json";

    // -- Connection Functions Start --//
    private function Get_Credentials()
    {
        Global $accessFilePath;

        $accessFilePath = "../private_html/access.json";
        
        try
        {
            $myfile = fopen($accessFilePath, "r") or die("Unable to open file!");
            $fileContent = fread($myfile,filesize($accessFilePath));
            fclose($myfile);

            return json_decode($fileContent, true);
        }
        catch (Exeptiopn $e)
        {
            echo "Error: $e";
            return false;
        }
    }

    public function Open_Connection()
    {
        $credentials = $this->Get_Credentials();
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
    //-- Connection Functions End --//

    //-- Account Management Functions Start --//
    public function GetUserDetailsById($userId)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM DigitalCookbook__Users WHERE ´id´ = $userId");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $userData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    return  array('returnCode' => 'e100', 'id' => $userData[0]['id'], 'email' => $userData[0]['email'], 'admin' => $userData[0]['admin']); 
                }
                else
                {
                    return  array('returnCode' => 'e102', 'msg' => "account not found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e101', 'msg' => $e->getMessage()); 
            }
        }
    }

    public function GetUserDetailsByEmail($email)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM `DigitalCookbook__Users` WHERE `email`= '$email'");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $userData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    return  array('returnCode' => 'e100', 'id' => $userData[0]['id'], 'email' => $userData[0]['email'], 'admin' => $userData[0]['admin']); 
                }
                else
                {
                    return  array('returnCode' => 'e102', 'msg' => "account not found"); 
                }               
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e101', 'msg' => $e->getMessage()); 
            }
        }
    }

    public function CreateAccount($email)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $sql = "INSERT INTO DigitalCookbook__Users (email) VALUES ('$email')";
                
                // use exec() because no results are returned
                $conn->exec($sql);

                $IdCheckObject = $this->GetUserDetailsByEmail($email);

                if ($IdCheckObject['returnCode'] == 'e100')
                {
                    return  array('returnCode' => 'e100', 'msg' => $e->getMessage(), 'id' => $IdCheckObject['id']); 
                }
                else
                {
                    return  array('returnCode' => 'e103', 'msg' => $e->getMessage());
                }                
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e101', 'msg' => $e->getMessage()); 
            }
        }
    }
    //-- Account Management Functions End --//

    //-- Recepie Management Functions Start --//
    public function GetRecepie($recepieID)
    {

    }
    
    public function CreateRecepie($recepieData)
    {
        
    }

    public function UpdateRecepie($recepieID, $recepieData)
    {
        
    }

    public function RemoveRecepie($recepieID)
    {
        
    }
    
    public function AddRecepieRelation($recepieID, $userId)
    {
        
    }

    //-- Recepie Management Functions End --//
}

?>