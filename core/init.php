<?php
session_start();
include 'connect.php';

$database = new Database();
$db = $database->connect();
?>