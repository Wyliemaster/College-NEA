<?php
// Removes all cookies and removes the session in the process
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', 0, '/');
}
