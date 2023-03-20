<?php
require "../../logic/database.php";
$time = time();

$name = clean($_POST["uname"]);
$pass = $_POST["pass"];


if (!empty($name) && !empty($pass)) {

    // Ensuring the username is the correct size
    if (strlen($name) < 4)
    {
        // Creates alert saying "Login Error: Username is too short. Please make sure your username is atleast 4 characters long"
        header("Location: ../../?ERROR=Login%20Error%3A%20Username%20is%20too%20short.%20Please%20make%20sure%20your%20username%20is%20atleast%204%20characters%20long");
        exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
    }
    // Forcing password to be atleast 7 characters long
    // for the sake of keeping their account secure
    if (strlen($pass) < 8)
    {
        // Creates alert saying "Login Error: Password too short. Please make sure your password is atleast 8 characters long"
        header("Location: ../../?ERROR=Login%20Error%3A%20Password%20too%20short.%20Please%20make%20sure%20your%20password%20is%20atleast%208%20characters%20long");
        exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
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
                header("Location: ../../index.php");
                exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
            }
        }
        $db = NULL;
        // creates alert saying "Login Error: Cannot Find User"
        header("Location: ../../?ERROR=Login%20Error%3A%20Cannot%20Find%20User");
        exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
    }

    $db = NULL;

    // creates alert saying "Login Error: Query failed. Please try again"
    header("Location: ../../?ERROR=Login%20Error%3A%20Query%20failed.%20Please%20try%again");
    exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
}

// creates alert saying "Login Error: Please Provide Login Details"
header("Location: ../../?ERROR=Login%20Error%3A%20Please%20Provide%20Login%20Details");
exit("REDIRECT_ERROR: <a href='../../'>Return to home page</a>"); // In the event that the redirect doesn't work
