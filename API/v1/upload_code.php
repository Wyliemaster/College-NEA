<?php
include "../../logic/database.php";
include "../../logic/helper.php";

if ($_COOKIE["LOGIN"]) {

    $name = $_COOKIE["NAME"];

    // sanitising
    $title = clean($_GET["title"]);
    $desc = clean($_GET["desc"]);
    $code = strip_tags($_GET["code"]);

    if (!empty($title) && !empty($desc) && !empty(Decompiler::decompile($code, FileMagic::ASSEMBLY))) {

        $db = db_connect();

        // user_id is needed to assign the content to the user
        $query = $db->prepare('SELECT user_id FROM tblusers WHERE user_name = :name');

        if ($query->execute([":name" => $name])) {
            if ($ID = $query->fetchColumn()) {
                // uploading...
                $query = $db->prepare("INSERT INTO tblcontent (content_title, content_description, content_code, user_id) VALUES (:title, :desc, :code, :id)");
                if ($query->execute([
                    ":title" => $title,
                    ":desc" => $desc,
                    ":code" => $code,
                    ":id" => $ID
                ])) {
                    header("Location: ../../user_content/?filter=5");
                    exit();
                }
            }
        }
    }
    header("Location: ../../?ERROR=UPLOAD%3A%20INVALID%20INPUT");
    exit();
}
