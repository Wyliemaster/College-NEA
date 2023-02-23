<?php error_reporting(0); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="../frontend/css/main.css">
    <link rel="stylesheet" href="../frontend/css/user.css">
    <script src="./../frontend/scripts/main.js"></script>
    <script src="./../frontend/scripts/prefab.js"></script>
    <script src="./../frontend/scripts/helpers.js"></script>
    <script src="./../frontend/scripts/user.js"></script>


</head>

<body style="overflow-y: auto">
    <div class="global-navbar">
        <div>
            <a href="../" class="global-navbar-item">Home</a>
            <a href="./" class="global-navbar-item">User Content</a>
        </div>
        <div class=global-navbar-title>
            <label>Little Man Computer Decompiler</label>
        </div>


        <?php

        if (!isset($_COOKIE["LOGIN"]) && !isset($_COOKIE["NAME"])) {
            echo '<div id="global-navbar-account">
                <a onclick="show_login_popup()" class="global-navbar-item">Login</a>
                <a onclick="show_register_popup();" class="global-navbar-item">Register</a>
            </div>';
        } else {
            $name = $_COOKIE["NAME"] != "" ? $_COOKIE["NAME"] : "[[NAME]]";
            echo '<div id="global-navbar-account">
            <a class="global-navbar-item">' . $name . '\'s Code</a>
            <a onclick="logout(`../`)" class="global-navbar-item">Logout</a>
        </div>';
        }

        ?>

    </div>
    <div id="Prefabs"></div>



    <!-- <label class="user-filter-title">sort by</label>
    <div class="user-filters">
        <div class="user-filter-btn">filter</div>
        <div class="user-filter-btn">filter</div>
        <div class="user-filter-btn">filter</div>
        <div class="user-filter-btn">filter</div>
    </div> -->

    <?php
    // save filter state
    if ($_GET["myCode"] === $_COOKIE["LOGIN"] && $_COOKIE["LOGIN"] != "") {
        $filter = 5;
    } else {
        if ($_COOKIE["CONTENT"]) {
            $filter = $_COOKIE["CONTENT"];
        } else {
            $filter = 1;
        }
    }

        $filter = 1;

    setcookie("CONTENT", $filter, time() + (86400 * 30), "/");

    // first load 
    echo "<script>get_content($filter)</script>";
    ?>


    <div id="user-content-container"></div>

    <div id="details_prefab"></div>
    <script>
        load_content_page_prefabs();
    </script>

</body>

</html>