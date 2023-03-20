<?php
error_reporting(0);
include "../../logic/database.php";

// The different filters can can be used. Put into a dataclass for the sake of tidyness
class FilterTypes
{
     const DEFAULT = 0;
     const MOST_LIKES = 1;
     const MY_CODE = 5;
}

switch($_GET["filter"])
{
    // The user can check the code he uploaded
    case FilterTypes::MY_CODE:
        if (isset($_COOKIE["LOGIN"]))
        {
            $name = $_GET["user"] ? $_GET["user"] : $_COOKIE["NAME"];


            $db = db_connect();


        /*
            SELECT DISTINCT - This ensures that the query returns no duplicate entries

            CASE
                WHEN :name <> '' THEN (
                    SELECT count(*) 
                    FROM tblratings 
                    WHERE tblusers.user_name = :name AND tblratings.user_id = tblusers.user_id
                )
            END AS rating_id  - This checks if there is a user logged in.
                                If they have, it gets the rate state of
                                the content in question and stores it
                                inside of a rating_id column

        
            LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id - OUTER JOIN
            to make content from the tblratings optional

            WHERE tblusers.user_name = :name - filter by name
        */
            $query = $db->prepare("SELECT DISTINCT
            tblcontent.content_id, 
            tblcontent.content_title, 
            tblcontent.content_description, 
            tblcontent.content_code, 
            CASE
                WHEN :name <> '' THEN (
                    SELECT count(*) 
                    FROM tblratings 
                    WHERE tblusers.user_name = :name AND tblratings.user_id = tblusers.user_id
                )
            END AS rating_id 
            FROM tblcontent INNER JOIN tblusers ON tblcontent.user_id = tblusers.user_id 
            LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id
            WHERE tblusers.user_name = :name ORDER BY tblcontent.content_id DESC LIMIT 25;");
            
            // Return the data as a JSON
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

    case FilterTypes::MOST_LIKES:
        $db = db_connect();
    

        /*
            SELECT DISTINCT - This ensures that the query returns no duplicate entries

            CASE
                WHEN :name <> '' THEN (
                    SELECT count(*) 
                    FROM tblratings 
                    WHERE tblusers.user_name = :name AND tblratings.user_id = tblusers.user_id
                )
            END AS rating_id  - This checks if there is a user logged in.
                                If they have, it gets the rate state of
                                the content in question and stores it
                                inside of a rating_id column

        
            LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id - OUTER JOIN
            to make content from the tblratings optional

            GROUP BY tblratings.content_id - Group the results using content_id
            ORDER BY count(tblrating.content_id) - Order the results by number of occurances for content_id
        */
        $query = $db->prepare("SELECT DISTINCT
        tblcontent.content_id, 
        tblcontent.content_title, 
        tblcontent.content_description, 
        tblcontent.content_code, 
        CASE
            WHEN :name <> '' THEN (
                SELECT count(*) 
                FROM tblratings 
                WHERE tblusers.user_name = :name AND tblratings.user_id = tblusers.user_id
            )
        END AS rating_id 
        FROM tblcontent INNER JOIN tblusers ON tblcontent.user_id = tblusers.user_id 
        LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id 
        GROUP BY tblratings.content_id 
        ORDER BY count(tblratings.content_id) DESC LIMIT 25;");
            
        // return the data as a JSON
        if($query->execute([":name" => $_COOKIE["NAME"] ? $_COOKIE["NAME"] : ""]))
        {
            if( $data = $query->fetchAll())
            {
                echo json_encode($data);
            }
        }
        $query = NULL;
        $db = NULL;
        break;
    default:
        $db = db_connect();
    
        /*
            SELECT DISTINCT - This ensures that the query returns no duplicate entries

            CASE
                WHEN :name <> '' THEN (
                    SELECT count(*) 
                    FROM tblratings 
                    WHERE tblusers.user_name = :name AND tblratings.user_id = tblusers.user_id
                )
            END AS rating_id  - This checks if there is a user logged in.
                                If they have, it gets the rate state of
                                the content in question and stores it
                                inside of a rating_id column


            LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id - OUTER JOIN
            to make content from the tblratings optional
            
        */
        $query = $db->prepare("SELECT DISTINCT
        tblcontent.content_id, 
        tblcontent.content_title, 
        tblcontent.content_description, 
        tblcontent.content_code, 
        CASE
            WHEN :name <> '' THEN (
                SELECT count(*) 
                FROM tblratings 
                WHERE tblusers.user_name = :name AND tblratings.user_id = tblusers.user_id
            )
        END AS rating_id 
        FROM tblcontent INNER JOIN tblusers ON tblcontent.user_id = tblusers.user_id 
        LEFT OUTER JOIN tblratings ON tblcontent.content_id = tblratings.content_id 
        ORDER BY tblcontent.content_id DESC LIMIT 25;");
            
        // Echos the response as a JSON if the query was successful
        if($query->execute([":name" => $_COOKIE["NAME"] ? $_COOKIE["NAME"] : ""]))
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

// set cookie to save filter
setcookie("CONTENT", $filter, time() + (86400 * 30), "/");
