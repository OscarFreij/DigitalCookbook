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
            return  array('returnCode' => 's000', 'msg' => "Connected successfully");
        }
        catch(PDOException $e)
        {
            return  array('returnCode' => 'e001', 'msg' => $e->getMessage());
        }
    }

    public function Close_Connection()
    {
        Global $conn;

        $conn = null;
        return  array('returnCode' => 's001', 'msg' => "Connection closed");
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
                $stmt = $conn->prepare("SELECT * FROM DigitalCookbook__Users WHERE `id` = $userId");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $userData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    return  array('returnCode' => 's010', 'id' => $userData[0]['id'], 'email' => $userData[0]['email'], 'admin' => $userData[0]['admin']); 
                }
                else
                {
                    return  array('returnCode' => 'e010', 'msg' => "account not found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e011', 'msg' => $e->getMessage()); 
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
                    return  array('returnCode' => 's020', 'id' => $userData[0]['id'], 'email' => $userData[0]['email'], 'admin' => $userData[0]['admin']); 
                }
                else
                {
                    return  array('returnCode' => 'e020', 'msg' => "account not found"); 
                }               
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e021', 'msg' => $e->getMessage()); 
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

                if ($IdCheckObject['returnCode'] == 's020')
                {
                    return  array('returnCode' => 's030', 'msg' => "User Was created!", 'id' => $IdCheckObject['id']); 
                }
                else
                {
                    return  array('returnCode' => 'e030', 'msg' => "Account could not be created. Unknown error");
                }                
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e031', 'msg' => $e->getMessage()); 
            }
        }
    }
    //-- Account Management Functions End --//

    //-- Recepie Management Functions Start --//
    public function GetRecipe($recipeId, $userId)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM DigitalCookbook__Recipes WHERE `id` = '$recipeId' AND `userId` = '$userId'");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $recipeData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    return  array(
                        'returnCode' => 's040',
                        'id' => $recipeData[0]['id'],
                        'ownerId' => $recipeData[0]['ownerId'],
                        'name' => $recipeData[0]['name'],
                        'time' => $recipeData[0]['time'],
                        'portions' => $recipeData[0]['portions'],
                        'scalable' => $recipeData[0]['scalable'],
                        'tags' => $recipeData[0]['tags'],
                        'difficulty' => $recipeData[0]['difficulty'],
                        'picture' => $recipeData[0]['picture'],
                        'description' => $recipeData[0]['description'],
                        'ingredients' => $recipeData[0]['ingredients'],
                        'instructions' => $recipeData[0]['instructions'],
                        'accessibility' => $recipeData[0]['accessibility'],
                    ); 
                }
                else
                {
                    return  array('returnCode' => 'e040', 'msg' => "recepie not found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e041', 'msg' => $e->getMessage()); 
            }
        }
    }
    
    public function CreateRecipe($recipeData, $userId)
    {
        Global $conn;

        $title = $recipeData->title;
        $imageData = $recipeData->imageData;
        $portions = $recipeData->portions;
        $scalable = $recipeData->scalable;
        $time = $recipeData->time;
        $ingredients = json_encode($recipeData->ingredients);
        $howTo = json_encode($recipeData->howTo);
        $description = json_encode($recipeData->description);
        $serving = json_encode($recipeData->serving);
        $tips = json_encode($recipeData->tips);
        $tags = json_encode($recipeData->tags);
        $difficulty = $recipeData->difficulty;
        $category = $recipeData->category;
        $accessibility = $recipeData->accessibility;


        if(isset($conn))
        {
            try
            {
                $sql = "INSERT INTO `DigitalCookbook__Recipes`(`ownerId`, `name`, `time`, `portions`, `scalable`, `tags`, `difficulty`, `picture`, `description`, `ingredients`, `instructions`, `accessibility`) VALUES ('$userId','$title','$time','$portions','$scalable','$tags','$difficulty','$imageData','$description','$ingredients','$howTo','$accessibility')";
                
                
                $conn->exec($sql);

                $responseDataFromInternalFunction = $this->GetUserLatestRecipe($userId);

                if (isset($responseDataFromInternalFunction['id']))
                {
                    $relationResponseData = $this->AddRecipeRelation($responseDataFromInternalFunction['id'], $userId, $category);
                    if ($relationResponseData['returnCode'] == "s090")
                    {
                        return  json_encode(array('returnCode' => 's050', 'msg' => "Recipe Was created!", 'id' => $responseDataFromInternalFunction['id']));              
                    }
                    else
                    {
                        $relationResponseData['returnCode'] == "e050";
                        return json_encode($relationResponseData);
                    }
                    
                }
                else
                {
                    $responseDataFromInternalFunction['returnCode'] == "e051";
                    return json_encode($responseDataFromInternalFunction);
                }
                
            }
            catch(PDOException $e)
            {
                return  json_encode(array('returnCode' => 'e052', 'msg' => "CreateRecipe: ".$e->getMessage())); 
            }
        }
    }

    private function GetUserLatestRecipe($userId)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT `id` FROM DigitalCookbook__Recipes WHERE `ownerId` = '$userId' ORDER BY `id` DESC");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $recipeData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    return  array(
                        'returnCode' => 's060',
                        'id' => $recipeData[0]['id']
                    ); 
                }
                else
                {
                    return  array('returnCode' => 'e060', 'msg' => "no new recepie not found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e061', 'msg' => "GetUserLatestRecipe".$e->getMessage()); 
            }
        }
    }

    public function UpdateRecipe($recipeId, $recipeData)
    {
        //070
    }

    public function RemoveRecipe($recipeId)
    {
        //080
    }
    
    private function AddRecipeRelation($recipeId, $userId, $folderId)
    {
        Global $conn;


        if(isset($conn))
        {
            try
            {
                $sql = "INSERT INTO `DigitalCookbook__Relations`(`recipeId`, `reciverId`, `folderId`) VALUES ('$recipeId', '$userId', '$folderId')";
                
                $conn->exec($sql);

                return  array('returnCode' => 's090', 'msg' => "Relation Was created!");              
                
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e090', 'msg' => "AddRecipeRelation: ".$e->getMessage()); 
            }
        }
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
                $stmt = $conn->prepare("SELECT * FROM `DigitalCookbook__Folders` WHERE `ownerId` = '$userId' ORDER BY `orderNr` ASC");
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
                    return  array('returnCode' => 'e100', 'msg' => "no categories found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e101', 'msg' => $e->getMessage()); 
            }
        }
    }

    public function GetCategoriesForSelection($userId)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM `DigitalCookbook__Folders` WHERE `ownerId` = '$userId' ORDER BY `orderNr` ASC");
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

                            $temp = "<option value='$id'>$name</option>";
                            array_push($categories,$temp);
                        }

                    return  array(
                        'returnCode' => 's110',
                        'categories' => $categories
                    ); 
                }
                else
                {
                    return  array('returnCode' => 'e110', 'msg' => "no categories found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e111', 'msg' => $e->getMessage()); 
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
                return  json_encode(array('returnCode' => 's120', 'msg' => "Folder Was created!"));              
            }
            catch(PDOException $e)
            {
                return  json_encode(array('returnCode' => 'e120', 'msg' => $e->getMessage())); 
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
                return  json_encode(array('returnCode' => 's130', 'msg' => "Folder Was removed!"));              
            }
            catch(PDOException $e)
            {
                return  json_encode(array('returnCode' => 'e130', 'msg' => $e->getMessage())); 
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
                        return  json_encode(array('returnCode' => 'e140', 'msg' => $e->getMessage())); 
                    }
                }
                return  json_encode(array('returnCode' => 's140', 'msg' => "Updated category order")); 
            }
            catch (Exception $me)
            {
                return  json_encode(array('returnCode' => 'e141', 'msg' => $me->getMessage())); 
            }
        }
    }
    
    //-- Category Management Functions End --//

    //-- Tag Management Functions Start --//

    public function GetTagsEdit($tagType)
    {
        Global $conn;

        if(isset($conn))
        {
            try
            {
                $stmt = $conn->prepare("SELECT * FROM `DigitalCookbook__Tags` WHERE `type` = '$tagType' ORDER BY `name` ASC");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $tagData = $stmt->fetchAll();

                if ($stmt->rowCount() > 0)
                {
                    $tags = array();

                        foreach ($tagData as $key => $row) {

                            $type = $row['type'];
                            $name = $row['name'];
                            $id = $row['id'];

                            $temp = "<div><input type='checkbox' value='$id' name='recipe_$name' id='recipe_$name'><label for='recipe__$name'>: $name</label></div>";
                            array_push($tags,$temp);
                        }

                    return  array(
                        'returnCode' => 's150',
                        'tags' => $tags
                    ); 
                }
                else
                {
                    return  array('returnCode' => 'e150', 'msg' => "no tags found"); 
                }  
            }
            catch(PDOException $e)
            {
                return  array('returnCode' => 'e151', 'msg' => $e->getMessage()); 
            }
        }
    }

    //-- Tag Management Functions End --//
}

?>