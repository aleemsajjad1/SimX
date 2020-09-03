<?php 
session_start();
$_SESSION["username"] = $_GET['username'];

// $_SESSION["username"] = "m_vemaNXEkjkjh";

header("Location:index.php");
?>