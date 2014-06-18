<?php
session_start();
extract($_POST);
extract($_SESSION);
include("database1.php");
$sessionid=session_id();
if($submit=='Finish')
{
 $k= new database1;
 $k->marksheet($sessionid);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Online Quiz - Review Quiz </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include("header.php");
echo "<h1 class=head1> Review Test Question</h1>";

if(!isset($_SESSION[qn]))
{
		$_SESSION[qn]=0;
}
else if($submit=='Next Question' )
{
	$_SESSION[qn]=$_SESSION[qn]+1;
	
}
echo "<form name=myfm method=post action=review.php>";
echo "<table width=100%> <tr> <td width=30>&nbsp;<td> <table border=0>";
$t= new database1;
$t->v($sessionid);
$t1= new database1;
$t1->qq($sessionid);
echo "</table></table>";
?>
