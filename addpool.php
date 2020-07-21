<html>
<head>
<?php include("header.php");?>
<style>

		#grad1
		{
			height:592px;
			background:linear-gradient(to bottom,white,yellowgreen)
		}
		
		#t2
		{
            margin-top:70px;
            padding: 20px;
        }    
        
        p
		{
            text-align: center;
            text-decoration: underline;
            color:teal;
            font-size:72px;
            font-weight: bold;
        }
        
        td
		{
            font-size: 19px;
            font-weight: bold;
            color:teal;
            
        }
        
        input
		{
			border-color:teal;
			border-radius:12px;
            font-size: 18px;
        }
		
</style>
</head>
<body id="grad1">

<form name="f1" action="" method="post"> 
<table id="t2" align="center">
	<tr><td>Source:</td><td><input type="text" name="src"></td></tr> 
	<tr><td>Destination:</td><td><input type="text" name="dest"></td></tr>
	<tr><td>Date:</td><td><input type="date" name="date">&nbsp;&nbsp;(Date:dd-mm-yyyy)</td></tr>
	<tr><td>Time:</td><td><input type="time" name="time"></td></tr>
	<tr><td>Cost:</td><td><input type="text" name="cost"></td></tr>
	<tr><td>Car Capacity:</td><td><input type="text" name="cap"></td></tr>
	<tr><td><br></td></tr>
	<tr><td></td><td><input type="submit" value="Add Pool" name="add" 
		style="background-color:white; color:teal; border-color:teal; border-radius:12px"> &nbsp;&nbsp;&nbsp;
            <input type="reset" value="Reset" 
			style="background-color:white; color:chocolate; border-radius:12px; border-color:chocolate;"></td>
    </tr>
    </tr>
</table>
</form>

<?php
session_start();
if(isset($_REQUEST["add"]))
{
	$link=mysql_connect("localhost","root");
	$db=mysql_select_db("login",$link);
	
	$src=$_REQUEST["src"];
	$dest=$_REQUEST["dest"];
	$date=$_REQUEST["date"];
	$time=$_REQUEST["time"];
	$cost=$_REQUEST["cost"];
	$cap=$_REQUEST["cap"];
	$result=mysql_query("select * from driver where uname='".$_SESSION["Access"]."'");
	
	$row=mysql_fetch_assoc($result);
	$d_id=$row["d_id"];
$result=mysql_query("select * from trip where d_id=$d_id and trip_src='$src' and trip_dest='$dest' and trip_date='$date' and trip_time='$time'");
if(mysql_num_rows($result)==0)
{
	if(mysql_query("insert into trip (d_id,trip_src,trip_dest,trip_date,trip_time,price,capacity,cnt) values ($d_id,'$src','$dest','$date','$time',$cost,$cap,0)"))
	echo "<h3 align=center style=color:teal>Trip Uploaded</h3>";
}
else
{
	echo "<h3 align=center style=color:teal>Trip has already been uploaded by you</h3>";
}
}
?>


</body>
</html>