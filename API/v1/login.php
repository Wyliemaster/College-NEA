<?php
require "../../logic/database.php";
$time = time();

$name = clean($_POST["uname"]);
$pass = $_POST["pass"];


if (!empty($name) && !empty($pass))
{

    $db = db_connect();

    $query = $db->prepare("SELECT user_password FROM tblusers WHERE user_name = :name");
    if($query->execute([":name" => $name]))
    {
        if ( $db_password = $query->fetchColumn() )
        {
            if (password_verify($pass, $db_password))
            {
                setcookie("LOGIN", sha1($_POST["uname"] . strval($time) ), $time + (86400 * 30), "/");
                setcookie("NAME", $name, $time + (86400 * 30), "/");

                $db = NULL;
                exit("$name is logged in <br><a href='../../'>Return to home page</a>");
            }
        }
        $db = NULL;
        exit("Unable to find user");
    }

    $db = NULL;
    exit();
}
exit("Please Provide Login Details");
