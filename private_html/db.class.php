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
            return  array('returnCode' => 'e101', 'msg' => "Connected successfully");
        }
        catch(PDOException $e)
        {
            return  array('returnCode' => 'e102', 'msg' => $e->getMessage());
        }
    }

    public function Close_Connection()
    {
        Global $conn;

        $conn = null;
        return  array('returnCode' => 'e101', 'msg' => "Connection closed");
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
                    return  array('returnCode' => 'e100', 'msg' => "User Was created!", 'id' => $IdCheckObject['id']); 
                }
                else
                {
                    return  array('returnCode' => 'e103', 'msg' => "Account could not be created. Unknown error");
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
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM DigitalCookbook__Recepie WHERE ´id´ = $userId");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $recepieData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    return  array(
                        'returnCode' => 's100',
                        'id' => $recepieData[0]['id'],
                        'ownerId' => $recepieData[0]['ownerId'],
                        'name' => $recepieData[0]['name'],
                        'time' => $recepieData[0]['time'],
                        'portions' => $recepieData[0]['portions'],
                        'scalable' => $recepieData[0]['scalable'],
                        'tags' => $recepieData[0]['tags'],
                        'difficulty' => $recepieData[0]['difficulty'],
                        'picture' => $recepieData[0]['picture'],
                        'description' => $recepieData[0]['description'],
                        'ingredients' => $recepieData[0]['ingredients'],
                        'instructions' => $recepieData[0]['instructions'],
                        'folderId' => $recepieData[0]['folderId'],
                        'accessibility' => $recepieData[0]['accessibility'],
                    ); 
                }
                else
                {
                    return  array('returnCode' => 'e202', 'msg' => "recepie not found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e201', 'msg' => $e->getMessage()); 
            }
        }
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

    //-- Category Management Functions Start --//

    public function GetCategories($userId)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM `DigitalCookbook__Folders` WHERE `ownerId` = '$userId'");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $categoryData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    $categories = array();

                        foreach ($categoryData as $key => $row) {

                            $orderID = $row['orderNr'];
                            $name = $row['titel'];
                            $id = $row['id'];

                            $temp = "<div id='category_$orderID' class='category list-group-item list-group-item-action' data-order='$orderID' data-categoryid='$id'><a href='?page=cookbook&?category=$id'>$name</a></div>";
                            array_push($categories,$temp);
                        }

                    return  array(
                        'returnCode' => 's100',
                        'categories' => $categories
                    ); 
                }
                else
                {
                    return  array('returnCode' => 'e202', 'msg' => "no categories found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e201', 'msg' => $e->getMessage()); 
            }
        }
    }

    public function CreateCategory($name, $nextID)
    {
        Global $conn;

        $uid = $_SESSION['uid'];

        if(isset($conn))
        {
            try
            {
                $sql = "INSERT INTO `DigitalCookbook__Folders`(`ownerId`, `titel`, `orderNr`) VALUES ('$uid', '$name', '$nextID')";
                
                // use exec() because no results are returned
                $conn->exec($sql);
                return  json_encode(array('returnCode' => 'e100', 'msg' => "Folder Was created!"));              
            }
            catch(PDOException $e)
            {
                return  json_encode(array('returnCode' => 'e101', 'msg' => $e->getMessage())); 
            }
        }
    }

    public function RemoveCategory($id)
    {
        Global $conn;

        $uid = $_SESSION['uid'];

        if(isset($conn))
        {
            try
            {
                $sql = "DELETE FROM `DigitalCookbook__Folders` WHERE `id` = '$id'";
                
                // use exec() because no results are returned
                $conn->exec($sql);
                return  json_encode(array('returnCode' => 'e100', 'msg' => "Folder Was removed!"));              
            }
            catch(PDOException $e)
            {
                return  json_encode(array('returnCode' => 'e101', 'msg' => $e->getMessage())); 
            }
        }
    }

    public function UpdateCategories($JSON_Categories)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                foreach (json_decode($JSON_Categories) as $key => $category) {

                    $categoryId = $category[0];
                    $OrderId = $category[1];
                    try
                    {
                        $sql = "UPDATE `DigitalCookbook__Folders` SET `orderNr`='$OrderId' WHERE `id` = '$categoryId'";

                        // Prepare statement
                        $stmt = $conn->prepare($sql);
                    
                        // execute the query
                        $stmt->execute();
                    }
                    catch(PDOException $e)
                    {
                        return  json_encode(array('returnCode' => 'e101', 'msg' => $e->getMessage())); 
                    }
                }
                return  json_encode(array('returnCode' => 'e100', 'msg' => "Updated category order")); 
            }
            catch (Exception $me)
            {
                return  json_encode(array('returnCode' => 'e101', 'msg' => $me->getMessage())); 
            }
        }
    }
    
    //-- Category Management Functions End --//

}

?>