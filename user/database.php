<?php
class database1
{
function __construct()
    {
$cn=mysql_connect("localhost","root","") or die("Could not Connect My Sql");
$cn1=mysql_select_db("quiz",$cn)  or die("Could connect to Database");
return $cn1;
}
 }
?>

