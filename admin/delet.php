<?php
extract($_POST);
include("../database1.php");
$dl= new database1;
$dl->userdelet($userid);
