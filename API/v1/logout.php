<?php
foreach ( $_COOKIE as $key => $value )
{
    setcookie( $key, '', 0, '/' );
}