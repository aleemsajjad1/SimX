<?php 
session_start();
// echo $_GET['username'];
$_SESSION["username"] = $_GET['username'];

header("location:index.php");
?>