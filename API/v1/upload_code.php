<?php
include "../../logic/database.php";

if ($_COOKIE["LOGIN"])
{

    $name = $_COOKIE["NAME"];

    $title = clean($_GET["title"]);
    $desc = clean($_GET["desc"]);
    $code = strip_tags($_GET["code"]);

    $db = db_connect();

    $query = $db->prepare('SELECT user_id FROM tblusers WHERE user_name = :name');

    if($query->execute([":name" => $name]))
    {
        if ($ID = $query->fetchColumn())
        {
            $query = $db->prepare("INSERT INTO tblcontent (content_title, content_description, content_code, user_id) VALUES (:title, :desc, :code, :id)");
            if ($query->execute([
                ":title" => $title,
                ":desc" => $desc,
                ":code" => $code,
                ":id" => $ID
            ]))
            {
                exit("Code Uploaded");
            }
        }


    }
}