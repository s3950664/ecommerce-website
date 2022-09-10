<?php 
session_start();

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
  header("location: index.php");
  exit;
}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    unset($_SESSION["loggedin"]);
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header("Location: index.php");
    exit;
}
