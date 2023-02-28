<?php
include "../../logic/database.php";

$id = $_POST["id"];

if (!empty($id) && $_COOKIE["LOGIN"] && $_COOKIE["NAME"])
{
    $db = db_connect();

    $query = $db->prepare("SELECT user_id FROM tblusers WHERE user_name = :name LIMIT 1");

    if($query->execute([":name" => $_COOKIE["NAME"]]))
    {
        $user = $query->fetchColumn();

        if(!empty($user))
        {
            $query = $db->prepare("SELECT count(*) FROM tblratings WHERE content_id = :content AND user_id = :user");

            if ($query->execute([":content" => $id, ":user" => $user]))
            {

                
                    $query = $db->prepare("INSERT INTO tblratings (content_id, user_id) VALUES (:content, :user)");
                    $query->execute([":content" => $id, ":user" => $user]);
                }
            
        }
    }
}

?>