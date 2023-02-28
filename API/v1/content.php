<?php
include "../../logic/database.php";

class FilterTypes
{
     const DEFAULT = 0;
     const MY_CODE = 5;
}

$filter = $_GET["filter"];


switch($filter)
{
    // The user can check the code he uploaded
    case FilterTypes::MY_CODE:
        if (isset($_COOKIE["LOGIN"]))
        {
            $db = db_connect();

            $query = $db->prepare("SELECT tblcontent.content_title, tblcontent.content_description, tblcontent.content_code 
            FROM tblcontent 
            JOIN tblusers 
            ON tblcontent.user_id = tblusers.user_id 
            WHERE tblusers.user_name = :name LIMIT 25");
            
            if($query->execute([":name" => $_COOKIE["NAME"]]))
            {
                if ($data = $query->fetchAll())
                {
                    echo json_encode($data);
                }
            }
            $query = NULL;
        }
        $db = NULL;
        break;

    // fetch content default
    default:
        $db = db_connect();

        $query = $db->prepare("SELECT content_title, content_description, content_code FROM tblcontent LIMIT 25");
            
        if($query->execute())
        {
            if( $data = $query->fetchAll())
            {
                echo json_encode($data);
            }
        }
        $query = NULL;
        $db = NULL;
        break;
}

setcookie("CONTENT", $filter, time() + (86400 * 30), "/");
