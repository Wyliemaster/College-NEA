
<?php
function db_connect()
{
    $server = "localhost";
    $database = "dblmc";
    $username = "root";
    $password = "";

    $pdo = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    if ($pdo)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

// clean input
function clean(string $data)
{
    // replaces every character expect abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 with nothing
    return preg_replace("[^a-zA-Z0-9]", "", $data);
}
?>
