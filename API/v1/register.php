<?php
require "../../logic/database.php";
$time = time();

$name = clean($_POST["uname"]);
$pass = $_POST["pass"];

if (!empty($name) && !empty($pass))
{

    if (strlen($name) < 4)
    {
        exit("Username too short");
    }
    if (strlen($pass) < 8)
    {
        exit("Password too short");
    }

    $db = db_connect();

    $query = $db->prepare("SELECT count(*) FROM tblusers WHERE user_name = :name");
    if($query->execute([":name" => $name]))
    {
        if ( $query->fetchColumn() == 0)
        {
            $query = NULL;
            $password = password_hash($pass, PASSWORD_DEFAULT);
            
            $query = $db->prepare("INSERT INTO `tblusers` (`user_name`, `user_password`) VALUES (:name, :pass)");

            if($query->execute([":name" => $name, ":pass" => $password]))
            {
                setcookie("LOGIN", sha1($_POST["uname"] . strval($time) ), $time + (86400 * 30), "/");
                setcookie("NAME", $name, $time + (86400 * 30), "/");

                $db = NULL;
                exit("Congrats $name. Your registration was successful. <br><a href='../../'>Return to home page</a>");
            }

        }
        $db = NULL;
        exit("$name already exists");
    }

    $db = NULL;
    exit();
}
exit("Please Login Details");

?>