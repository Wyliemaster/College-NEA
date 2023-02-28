<?php
include "../../logic/database.php";

class FilterTypes
{
     const DEFAULT = 0;
     const MOST_LIKES = 1;
     const MY_CODE = 5;
}

$filter = $_GET["filter"];
// $name = $_GET["user"] ? $_GET["user"] : $_COOKIE["NAME"] ;

switch($filter)
{
    // The user can check the code he uploaded
    case FilterTypes::MY_CODE:
        if (isset($_COOKIE["LOGIN"]))
        {
            $name = $_GET["user"] ? $_GET["user"] : $_COOKIE["NAME"];


            $db = db_connect();

            $query = $db->prepare("SELECT tblcontent.content_id, tblcontent.content_title, tblcontent.content_description, tblcontent.content_code, tblratings.rating_id 
            FROM tblcontent 
            INNER JOIN tblusers ON tblcontent.user_id = tblusers.user_id 
            LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id AND tblusers.user_id = tblratings.user_id
            WHERE tblusers.user_name = :name LIMIT 25");
            
            if($query->execute([":name" => $name]))
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
    
        $query = $db->prepare("SELECT tblcontent.content_id, tblcontent.content_title, tblcontent.content_description, tblcontent.content_code, 
		CASE 
        	WHEN tblusers.user_name = :name THEN 1
		END AS rating_id
        FROM tblcontent 
        INNER JOIN tblusers ON tblcontent.user_id = tblusers.user_id 
        LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id AND tblusers.user_id = tblratings.user_id;");
            
        if($query->execute([":name" => $_COOKIE["NAME"]]))
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
