<?php
session_start();
require("../database1.php");
include("header.php");
?>
<link href="../quiz.css" rel="stylesheet" type="text/css">
<?php
$tt= new database1;
$tt->userdetails();
?>
