<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>User Signup</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include("database1.php");
include("header.php");
extract($_POST);
//include("database1.php");
$ui=new database1;
$ui->exist($lid,$pass,$name,$address,$city,$phone,$email);
?>
</body>
</html>

