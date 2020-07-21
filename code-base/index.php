<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <link href="basic.css" rel="stylesheet">
        <style>
		
		#grad1
		{
			height:592px;
			background:linear-gradient(to bottom,white,yellowgreen)
		}
		</style>
    </head>
    <body id="grad1">
      <p>Shar-e-Car</p>
    <center>
	<form name="f1" action="" method="post">

    <table>
    <tr><td>Username:</td><td><input type="text" name="uname"></td></tr>
    <tr><td>Password:</td><td><input type="password" name="pass"></td></tr>
   <!-- <tr><td></td><td><input type="checkbox" name="loggedin" value="yes">Keep Me Logged in?</td></tr> -->
    <tr><td></td><td></td></tr>
    <tr>
        <td></td><td><input type="submit" name="check" value="Driver"
						style="background-color:white; color:teal; border-color:teal; border-radius:12px">
        &nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" name="check" value="Passenger" 
						style="background-color:white; color:teal; border-color:teal; border-radius:12px"></td></tr>
    <tr>
        <tr><td></td><td>New User?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" name="check" value="Passenger SignUp" 
						style="background-color:white; color:teal; border-color:teal; border-radius:12px"><br><BR>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="check" value="Driver SignUp" 
						style="background-color:white; color:teal; border-color:teal; border-radius:12px"></td></tr>
			
		
		</tr>
           
    </table>
    </form>
    
	<?php
		session_start();
		if(isset($_REQUEST["check"]))
		{
			$chk=$_REQUEST["check"];
			$link=mysql_connect("localhost","root");
			$db=mysql_select_db("login",$link);

			if($chk=="Driver")
			{
				$uname=$_REQUEST["uname"];
				$pass=$_REQUEST["pass"];
				
				$result=mysql_query("select * from driver where uname='$uname' and password='$pass'");
				
					if(mysql_num_rows($result)==0)
					{
						echo " <br> <h4 align=center style=color:teal>UserName or Password Invalid</h4>";
					}
					else
					{
						$_SESSION["Access"]=$uname;
						mysql_close($link);
						header("Location:home.php");
					}
			}
			
			elseif($chk=="Passenger")
			{
				$uname=$_REQUEST["uname"];
				$pass=$_REQUEST["pass"];
				$result=mysql_query("select * from passenger where uname='$uname' and password='$pass'");
				
					if(mysql_num_rows($result)==0)
					{
						echo " <br> <h4 align=center style=color:teal>UserName or Password Invalid</h4>";
					}
					else
					{
						$_SESSION["Access"]=$uname;
						$_SESSION['cap']=$capacity;
						mysql_close($link);
						header("Location:Phome.php");
					}
			}
						
			else if($chk=="Passenger SignUp")
			{
				header("Location:PsignUp.php");
			}
			else
			{
				header("Location:DsignUp.php");
			}	
		}
	?>
	</center>
    </body>
</html>
