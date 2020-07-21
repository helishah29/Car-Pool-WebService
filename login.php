<html>
<body>
<?php

$sub=$_REQUEST["check"];
$uname=$_REQUEST["uname"];
$pass=$_REQUEST["pass"];

$link=mysql_connect("localhost","root");
$db=mysql_select_db("login",$link);

if($sub=="Driver")
{
	$result=mysql_query("select * from driver where uname='$uname' and password='$pass'");
	
	while($row =@mysql_fetch_row($result))
	{
		if($row==null)
		{	
			alert("Uname or password Invalid");
		}
		else
		{
			header("Location:home.php");
		}	
	}
}
else if($sub=="Passenger")
{
	$result=mysql_query("select * from passenger where uname='$uname' and password='$pass'");
	
	while($row =mysql_fetch_row($result))
	{
		if($row==null)
		{
			alert("Uname or password Invalid");
		}
		else
		{
			header("Location:Phome.php");
		}
	}
}

else if($sub=="Passenger SignUp")
{
	header("Location:PsignUp.html");
}
else
{
	header("Location:DsignUp.html");
}
?>
</body>
</html>