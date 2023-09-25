<?php
$hostname = 'localhost';
$username = 'root';
$password = '12345678';
$database = 'students';
$charset = 'utf8';

$connection = @new mysqli($hostname, $username, $password, $database, $port);
?>