<?php
require "../../logic/database.php";
$time = time();

$name = clean($_POST["uname"]);
$pass = $_POST["pass"];

if (!empty($name) && !empty($pass))
{

    // Ensuring the username is the correct size
    if (strlen($name) < 4)
    {
        // Creates alert saying "Login Error: Username is too short. Please make sure your username is atleast 4 characters long"
        header("Location: ../../?ERROR=Register%20Error%3A%20Username%20is%20too%20short.%20Please%20make%20sure%20your%20username%20is%20atleast%204%20characters%20long");
        exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
    }

    // Forcing password to be atleast 8 characters long
    // for the sake of keeping their account secure
    if (strlen($pass) < 8)
    {
        // Creates alert saying "Login Error: Password too short. Please make sure your password is atleast 8 characters long"
        header("Location: ../../?ERROR=Register%20Error%3A%20Password%20too%20short.%20Please%20make%20sure%20your%20password%20is%20atleast%208%20characters%20long");
        exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
    }

    $db = db_connect();

    // Checking if the account exists
    $query = $db->prepare("SELECT count(*) FROM tblusers WHERE user_name = :name");
    if($query->execute([":name" => $name]))
    {
        if ( $query->fetchColumn() == 0)
        {
            $query = NULL;
            // PASSWORD_DEFAULT applies the BCRYPT Hashing algorithm 
            $password = password_hash($pass, PASSWORD_DEFAULT);
            
            $query = $db->prepare("INSERT INTO `tblusers` (`user_name`, `user_password`) VALUES (:name, :pass)");

            if($query->execute([":name" => $name, ":pass" => $password]))
            {
                // Cookies expire 24 hours after login
                setcookie("LOGIN", sha1($_POST["uname"] . strval($time) ), $time + (86400 * 30), "/");
                setcookie("NAME", $name, $time + (86400 * 30), "/");

                $db = NULL;
                header("Location: ../../index.php");
                exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
            }

        }
        $db = NULL;
        // creates alert saying "Register Error: [[name]] already exists"
        header("Location: ../../?ERROR=Register%20Error%3A%20$name%20already%20exists");
        exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
    }

    $db = NULL;
    exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
}

// creates alert saying "Login Error: Please Provide Login Details"
header("Location: ../../?ERROR=Register%20Error%3A%20Please%20Provide%20Login%20Details");
exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
