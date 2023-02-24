<?php
require "../../logic/database.php";
$time = time();

$name = clean($_POST["uname"]);
$pass = $_POST["pass"];


if (!empty($name) && !empty($pass)) {

    // Ensuring the username is the correct size
    if (strlen($name) < 4)
    {
        exit("Username too short");
    }
    // Forcing password to be atleast 7 characters long
    // for the sake of keeping their account secure
    if (strlen($pass) < 8)
    {
        exit("Password too short");
    }

    $db = db_connect();

    // Password is needed to verify if the details are correct
    $query = $db->prepare("SELECT user_password FROM tblusers WHERE user_name = :name");
    if ($query->execute([":name" => $name])) {
        if ($db_password = $query->fetchColumn()) {
            if (password_verify($pass, $db_password)) { // Verify password
                // set cookies for 24 hours
                setcookie("LOGIN", sha1($_POST["uname"] . strval($time)), $time + (86400 * 30), "/");
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
