<?php
//session_start();
extract($_POST);
extract($_GET);
//extract($_SESSION);
class database1
{
function __construct()
    {
$cn=mysql_connect("localhost","root","") or die("Could not Connect My Sql");
$cn1=mysql_select_db("quiz",$cn)  or die("Could connect to Database");
return $cn1;
}
    function exist($lid,$pass,$name,$address,$city,$phone,$email)
    {
    $rs=mysql_query("select * from mst_user where login='$lid'");
 if (mysql_num_rows($rs)>0)
{
	echo "<br><br><br><div class=head1>Login Id Already Exists</div>";
	exit;
}
else
{
$query="insert into mst_user(user_id,login,pass,username,address,city,phone,email) values('$uid','$lid','$pass','$name','$address','$city','$phone','$email')";
$rs=mysql_query($query)or die("Could Not Perform the Query");
echo "<br><br><br><div class=head1>Your Login ID  $lid Created Sucessfully</div>";
echo "<br><div class=head1>Please Login using your Login ID to take Quiz</div>";
echo "<br><div class=head1><a href=index.php>Login</a></div>";
}
}
function profile($loginid,$pass)
{
    $rs=mysql_query("select * from mst_user where login='$loginid' and pass='$pass'");
	if(mysql_num_rows($rs)<1)
	{
		$found="N";
	}
	else
	{
		$_SESSION[login]=$loginid;
	}
if (isset($_SESSION[login]))
{
echo "<h1 class='style8' align=center>Wel come to Online Exam</h1>";
		echo '<table width="28%"  border="0" align="center">
  <tr>
    <td width="7%" height="65" valign="bottom"><img src="image/HLPBUTT2.JPG" width="50" height="50" align="middle"></td>
    <td width="93%" valign="bottom" bordercolor="#0000FF"> <a href="sublist.php" class="style4">Subject for Quiz </a></td>
  </tr>
  <tr>
    <td height="58" valign="bottom"><img src="image/DEGREE.JPG" width="43" height="43" align="absmiddle"></td>
    <td valign="bottom"> <a href="result.php" class="style4">Result </a></td>
  </tr>
</table>';
exit;
}
}
function subject()
{
    $rs=mysql_query("select * from mst_subject");
echo "<table align=center>";
while($row=mysql_fetch_row($rs))
{
	echo "<tr><td align=center ><a href=showtest.php?subid=$row[0]><font size=4>$row[1]</font></a>";
}
echo "</table>";
}
function subids($subid)
{

$rs1=mysql_query("select * from mst_subject where sub_id='$subid'");
$row1=mysql_fetch_array($rs1);
echo "<h1 align=center><font color=blue> $row1[1]</font></h1>";
$rs=mysql_query("select * from mst_test where sub_id='$subid'");
if(mysql_num_rows($rs)<1)
{
	echo "<br><br><h2 class=head1> No Quiz for this Subject </h2>";
	exit;
}
echo "<h2 class=head1> Select Quiz Name to Give Quiz </h2>";
echo "<table align=center>";

while($row=mysql_fetch_row($rs))
{
	echo "<tr><td align=center ><a href=quiz.php?testid=$row[0]&subid=$subid><font size=5>$row[2]</font></a>";
//$_SESSION[sid]=$subid;
//$_SESSION[tid]=$row[0];
}
echo "</table>";
}
function question($tid)
{
//$query="select * from mst_question";
//$rs=mysql_query("select * from mst_question where test_id='$tid'") or die(mysql_error());
if(!isset($_SESSION[qn]))
{
	$_SESSION[qn]=0;
	mysql_query("delete from mst_useranswer where sess_id='" . session_id() ."'") or die(mysql_error());
	$_SESSION[trueans]=0;
     //echo$submit;
}
else
{
$rs=mysql_query("select * from mst_question where test_id='$tid'") or die(mysql_error());
mysql_data_seek($rs,$_SESSION[qn]);
$row= mysql_fetch_row($rs);
echo "<form name=myfm method=post action=quiz.php>";
echo "<table width=100%> <tr> <td width=30>&nbsp;<td> <table border=0>";
$n=$_SESSION[qn]+1;
echo "<tR><td><span class=style2>Que ".  $n .": $row[2]</style>";
echo "<tr><td class=style8><input type=radio name=ans value=1>$row[3]";
echo "<tr><td class=style8> <input type=radio name=ans value=2>$row[4]";
echo "<tr><td class=style8><input type=radio name=ans value=3>$row[5]";
echo "<tr><td class=style8><input type=radio name=ans value=4>$row[6]";
if($_SESSION[qn]<mysql_num_rows($rs)-1)
echo "<tr><td><input type=submit name=submit value='Next Question'></form>";
else
echo "<tr><td><input type=submit name=submit value='Get Result'></form>";
echo "</table></table>";
$rs=mysql_query("select * from mst_question where test_id='$tid'") or die(mysql_error());
echo$_SESSION[qn];
if($_SESSION[qn]>mysql_num_rows($rs)-1)
{
unset($_SESSION[qn]);
echo "<h1 class=head1>Some Error  Occured</h1>";
session_destroy();
echo "Please <a href=index.php> Start Again</a>";
}
}
}
function useran($sessionid,$tid,$ans)
{
$rs=mysql_query("select * from mst_question where test_id='$tid'") or die(mysql_error());
mysql_data_seek($rs,$_SESSION[qn]);
$row= mysql_fetch_row($rs);
mysql_query("insert into mst_useranswer(sess_id, test_id, que_des, ans1,ans2,ans3,ans4,true_ans,your_ans) values ('$sessionid','$tid','$row[2]','$row[3]','$row[4]','$row[5]', '$row[6]','$row[7]','$ans')") or die(mysql_error());
               if($ans==$row[7])
				{
							$_SESSION[trueans]=$_SESSION[trueans]+1;
				}
}
function revew($sessionid,$tid,$ans)
{
$rs=mysql_query("select * from mst_question where test_id='$tid'") or die(mysql_error());
mysql_data_seek($rs,$_SESSION[qn]);
$row= mysql_fetch_row($rs);
mysql_query("insert into mst_useranswer(sess_id, test_id, que_des, ans1,ans2,ans3,ans4,true_ans,your_ans) values ('$sessionid', '$tid','$row[2]','$row[3]','$row[4]','$row[5]', '$row[6]','$row[7]','$ans')") or die(mysql_error());
               if($ans==$row[7])
				{
							$_SESSION[trueans]=$_SESSION[trueans]+1;
				}
}

function v($sessionid)
{
$rs=mysql_query("select * from mst_useranswer where sess_id='$sessionid'") or die(mysql_error());
mysql_data_seek($rs,$_SESSION[qn]);
$row= mysql_fetch_row($rs);
$n=$_SESSION[qn]+1;
echo "<tR><td><span class=style2>Que ".  $n .": $row[2]</style>";
echo "<tr><td class=".($row[7]==1?'tans':'style8').">1.$row[3]";
echo "<tr><td class=".($row[7]==2?'tans':'style8').">2.$row[4]";
echo "<tr><td class=".($row[7]==3?'tans':'style8').">3.$row[5]";
echo "<tr><td class=".($row[7]==4?'tans':'style8').">4.$row[6]";
}
function marksheet($sessionid)
{
    mysql_query("delete from mst_useranswer where sess_id='$sessionid'") or die(mysql_error());
    unset($_SESSION[qn]);
   echo"<script>window.location.href='index.php'</script>";
}
function qq($sessionid)
{   $rs=mysql_query("select * from mst_useranswer where sess_id='$sessionid'") or die(mysql_error());
    if($_SESSION[qn]<mysql_num_rows($rs)-1)
    {
echo "<tr><td><input type=submit name=submit value='Next Question'></form>";
$_SESSION['submit']="Next Question";

}
else
{
echo "<tr><td><input type=submit name=submit value='Finish'></form>";
$_SESSION['submit']="Finish";
}
}
 function result($login)
 {
     $rs=mysql_query("select t.test_name,t.total_que,r.test_date,r.score from mst_test t, mst_result r where
t.test_id=r.test_id and r.login='$login'") or die(mysql_error());

echo "<h1 class=head1> Result </h1>";
if(mysql_num_rows($rs)<1)
{
	echo "<br><br><h1 class=head1> You have not given any quiz</h1>";
	exit;
}
echo "<table border=1 align=center><tr class=style2><td width=300>Test Name <td> Total<br> Question <td> Score";
while($row=mysql_fetch_row($rs))
{
echo "<tr class=style8><td>$row[0] <td align=center> $row[1] <td align=center> $row[3]";
}
echo "</table>";
 }
 function adminlogin($loginid,$pass)
 {
     $rs=mysql_query("select * from mst_admin where loginid='$loginid' and pass='$pass'") or die(mysql_error());
	if(mysql_num_rows($rs)<1)
	{
		echo "<BR><BR><BR><BR><div class=head1> Invalid User Name or Password<div>";
		exit;

	}
	$_SESSION[alogin]="true";
 }
 function subchk($subname)
 {
     $rs=mysql_query("select * from mst_subject where sub_name='$subname'");
     if (mysql_num_rows($rs)>0)
{
	echo "<br><br><br><div class=head1>Subject is Already Exists</div>";
	exit;
}
 }
 function subadd($subname)
 {
     mysql_query("insert into mst_subject(sub_name) values ('$subname')") or die(mysql_error());
    echo "<p align=center>Subject  <b> \"$subname \"</b> Added Successfully.</p>";
    $submit="";
 }

 function sublist()
 {
     $rs=mysql_query("Select * from mst_subject order by  sub_name");
	  while($row=mysql_fetch_array($rs))
{
if($row[0]==$subid)
{
echo "<option value='$row[0]' selected>$row[1]</option>";
}
else
{
echo "<option value='$row[0]'>$row[1]</option>";
}
}
 }
 function testadd($subid,$testname,$totque)
 {
 mysql_query("insert into mst_test(sub_id,test_name,total_que) values ('$subid','$testname','$totque')") or die(mysql_error());
echo "<p align=center>Test <b>\"$testname\"</b> Added Successfully.</p>";
 }
 function testnamelist()
 {
     $rs=mysql_query("Select * from mst_test order by test_name");
	  while($row=mysql_fetch_array($rs))
{
if($row[0]==$testid)
{
echo "<option value='$row[0]' selected>$row[2]</option>";
}
else
{
echo "<option value='$row[0]'>$row[2]</option>";
}
}
 }
 function addqa($testid,$addque,$ans1,$ans2,$ans3,$ans4,$anstrue)
 {
 mysql_query("insert into mst_question(test_id,que_desc,ans1,ans2,ans3,ans4,true_ans) values ('$testid','$addque','$ans1','$ans2','$ans3','$ans4','$anstrue')") or die(mysql_error());
 echo "<p align=center>Question Added Successfully.</p>";
 }
 function userdetails()
 { ?>
<table border=1 align=center><tr class=style2><td>User id </td> <td>User_name</td><td>Adress</td><td>City</td><td>Phone no</td><td>Mail_id</td><td>Action</td></tr>
<?php
$s=mysql_query("select * from mst_user ");
     if(mysql_num_rows($s)>=1)
     while($row=mysql_fetch_array($s))
     //print_r($row);
echo"<tr class=style2>
<td>$row[user_id]</td>
<td>$row[username]</td>
<td>$row[address]</td>
<td>$row[city]</td>
<td>$row[phone]</td>
<td>$row[email]</td>
<td><a href=delet.php?userid=$row[user_id]>Delet</a></td></tr>";
}
function userdelet($userid)
{
    mysql_query("delete from mst_user where user_id='$userid'") or die(mysql_error());
    echo"<script>alert('user account sucessfully deleted')</script>";
    echo"<script>window.location.href='user.php'</script>";
}
}

?>

