<html>
<head>
    
    <link rel="stylesheet" href="basic.css">
    
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
    
var f2=0;
//var f3=0;
var f4=0;
var f5=0;

function checkAge()
{
	var age=f1.age.value;
	var pattern="^[0-9]{2}$";
	var rex=new RegExp(pattern);
	
	var chkage=document.getElementById("agechk");
	
	if(rex.test(age))
        {
            chkage.innerHTML="";
            f2=1;
        }
	else
	   chkage.innerHTML="Please Enter Valid AGE";
} 

/*function checkPass()
{
    var pass=f1.pass.value;
    var pat="^.*(?=.{8,})(?=..*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).*$";
    
    var rex=new RegExp(pat);
    chkpass=document.getElementById("passchk");
    
    if(rex.test(pass))
    {
        if(pass.equals(f1.uname.value))
            chkpass.innerHTML="Password Cannot Be Same As UserName";
        
        else
        {
            chkpass.innerHTML="";
            f3=1;
        }
    }                               
     else
    {
        if(pass.equals(f1.uname.value))
            chkpass.innerHTML="Password Cannot Be Same As UserName";
        
        else
            chkpass.innerHTML="Invalid Password";    
    }   
}*/

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
	if(f2==0 || f4==0 || f5==0)
		return false;
	else
		return true;
			
}
</script>    
    
    
</head>
<body id="grad1"> 

<form name="f1" action="" method="post" onsubmit="return verify()">
<table align="center">
    <tr><td>Name:</td><td><input type="text" name="name"></td><td><span id="namechk"></span></td></tr>
    <tr><td>UserName:</td><td><input type="text" name="uname"></td><td><span id="unamechk"></span></td></tr>
    <tr><td>Password:</td><td><input type="password" name="pass"></td><td><span id="passchk"></span></td></tr>
    <tr><td>Age:</td><td><input type="text" name="age" onblur="checkAge()"></td><td><span id="agechk"></span></td></tr> 
    <tr><td>Phone No.:</td><td><input type="text" name="ph" onblur="checkPh()"></td><td><span id="phchk"></span></td></tr>
    <tr><td>E-mail:</td><td><input type="text" name="mail" onblur="checkm()"></td><td><span id="mailchk"></span></td></tr>
    <tr><td>Sex:</td><td><input type="radio" name="sex" value="Male" checked="checked">Male &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="sex" value="Female">Female </td></tr>
	<tr><td>Address:</td><td><textarea name="add" cols="23" wrap="wrap"></textarea></td></tr>
    <tr><td>License Number:</td><td><input type="text" name="Lno"></td><td><span id="lnochk"></span></td></tr>
    <tr><td>Car Name:</td><td><input type="text" name="car"></td></tr>
    <tr><tr>
    <tr><td></td><td><input type="submit" value="SignUp" name="sub"
		style="background-color:white; color:teal; border-color:teal; border-radius:12px"> &nbsp;&nbsp;&nbsp;
            <input type="reset" value="Reset" 
			style="background-color:white; color:chocolate; border-radius:12px; border-color:chocolate;"></td>
    </tr>    
</table>
</form>

<?php
	session_start();
	if(isset($_REQUEST["sub"]))
	{
		$Name=$_REQUEST["name"];
		$uname=$_REQUEST["uname"];
		$pass=$_REQUEST["pass"];
		$age=$_REQUEST["age"];
		$ph=$_REQUEST["ph"];
		$mail=$_REQUEST["mail"];
		$sex=$_REQUEST["sex"];
		$add=$_REQUEST["add"];
		$ln=$_REQUEST["Lno"];
		$cn=$_REQUEST["car"];
		
		$link=mysql_connect("localhost","root");
		$db=mysql_select_db("login",$link);
		
		$result=mysql_query("select * from driver where uname='$uname' or email='$mail' or ph=$ph");
		
		if(mysql_num_rows($result)==0)
		{
			mysql_query("insert into driver(Name,uname,password,age,ph,email,sex,Addr,licenseNo,carName) values('$Name','$uname','$pass',$age,$ph,'$mail','$sex','$add','$ln','$cn')");
			$_SESSION["Access"]=$uname;
			header("Location:home.php");
		}
		else
		{
			$result=mysql_query("select * from driver where uname='$uname' or email='$mail' or ph=$ph");
			$row=mysql_fetch_assoc($result);
			
				$un=$row["uname"];
				$em=$row["email"];
				$p=$row["ph"];
				
				$result=mysql_query("select * from driver where uname='$un'");
				if(mysql_num_rows($result)!=0)
				{
					echo " <br> <h4 align=center style=color:teal>UserName Already Exists</h4>";
				}

				$result=mysql_query("select * from driver where email='$em'");
				if(mysql_num_rows($result)!=0)
				{
					echo " <br> <h4 align=center style=color:teal>Email Already Exists</h4>";
				}
				
				$result=mysql_query("select * from driver where ph=$p");
				if(mysql_num_rows($result)!=0)
				{
					echo " <br> <h4 align=center style=color:teal>UserName Already Exists</h4>";
				}
		}
		
	}
?>


</body>
</html>