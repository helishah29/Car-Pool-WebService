<html>
<head>
    <link href="basic.css" rel="stylesheet">
<style>
	#grad1
		{
			height:550px;
			background:linear-gradient(to bottom,white,yellowgreen)
		}
		
		input
		{
			border-color:teal;
			border-radius:12px;
            font-size: 18px;
        }
</style>
<script>
    
var f4=0;
var f5=0;

function checkPh()
{
//first digit must be 7/8/9. and 10 digit long
var ph=f1.ph.value;

var v1=ph.charAt(0);
var v2=ph.substring(1,ph.length);

var p1="^[789]{1}$";
var p2="^[0-9]{9}$";

var r1=new RegExp(p1);
var r2=new RegExp(p2);

var chkph=document.getElementById("phchk");

    if(r1.test(v1) && r2.test(v2))
    {
        chkph.innerHTML="";
        f4=1;
    }
    else	
        chkph.innerHTML="Please Enter Valid Phone Number";
    
}
function checkm()
{
	var mail=f1.mail.value;
	
	var p1="^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[\\w]$";

	var r1=new RegExp(p1);
	
	var chkm=document.getElementById("mailchk");
	
	if(r1.test(mail))
        {
            chkm.innerHTML="";
            f5=1;
        }
	else
	    chkm.innerHTML="Please Enter Valid Email Address";
	
}



function verify()
{
	if(f4==0|| f5==0)
		return false;
	else
		return true;
			
}


</script>    
<?php
	session_start();
	$link=mysql_connect("localhost","root");
	$db=mysql_select_db("login",$link);
	$result=mysql_query("select * from driver where uname='".$_SESSION["Access"]."'");
	$row=mysql_fetch_assoc($result);
	mysql_close($link);
?>  
    
</head>
<body id="grad1"> 

<form name="f1" action="" method="post" onsubmit="return verify()">
<table align="center">
    <tr><td>UserName:</td><td><input type="text" name="uname" value='<?php echo "$row[uname]";?>'></td><td><span id="unamechk"></span></td></tr>
    <tr><td>Phone No.:</td><td><input type="text" name="ph" onblur="checkPh()" value='<?php echo "$row[ph]";?>'></td><td>&nbsp;&nbsp;<span id="phchk"></span></td></tr>
    <tr><td>E-mail:</td><td><input type="email" name="mail" onblur="checkm()" value='<?php echo "$row[email]";?>'></td><td>&nbsp;&nbsp;<span id="mailchk"></span><td></tr>
    <tr><td></td><td><input type="submit" value="Update" name="upd" 
		style="background-color:white; color:teal; border-color:teal; border-radius:12px"> &nbsp;&nbsp;&nbsp;
            <input type="reset" value="Reset" 
			style="background-color:white; color:chocolate; border-radius:12px; border-color:chocolate;"></td>
    </tr>
</table>
</form>

<?php
	if(isset($_REQUEST["upd"]))
	{
		$uname=$_REQUEST["uname"];
		$ph=$_REQUEST["ph"];
		$mail=$_REQUEST["mail"];
		
		$link=mysql_connect("localhost","root");
		$db=mysql_select_db("login",$link);
		
		$result=mysql_query("select * from driver where (uname='$uname' or email='$mail' or ph=$ph) and uname!='".$_SESSION['Access']."'");
		
		if(mysql_num_rows($result)==0)
		{
			mysql_query("update driver set uname='$uname',email='$mail',ph=$ph where uname='".$_SESSION['Access']."'");
			echo " <br> <h4 align=center style=color:teal>Profile Updated</h4>";
			$_SESSION['Access']=$uname;
			header("Location:Phome.php");
		}
		else
		{
			//$result=mysql_query("select * from passenger where (uname='$uname' or email='$mail' or ph=$ph) ");
			$row=mysql_fetch_assoc($result);
			
				$un=$row["uname"];
				$em=$row["email"];
				$p=$row["ph"];
				
				$result=mysql_query("select * from driver where uname='$un'");
				if(mysql_num_rows($result)!=0)
				{
					echo " <br> <h4 align=center style=color:teal>UserName Already Exists</h4>";
				}

				$result=mysql_query("select * from driver where email='$em' and uname!='".$_SESSION['Access']."'");
				if(mysql_num_rows($result)!=0)
				{
					echo "<h4 align=center style=color:teal>Email Already Exists</h4></center>";
				}
				
				$result=mysql_query("select ph from driver where ph=$p and uname!='".$_SESSION['Access']."'");
				
				if(mysql_num_rows($result)!=0)
				{
					echo "<h4 align=center style=color:teal>Phone Number Already Exists</h4>";
				}
		}
		
	}
?>

</body>
</html>