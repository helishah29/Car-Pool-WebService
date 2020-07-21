<html>
<head>
<?php include("header.php");
session_start();
if(!isset($_SESSION["Access"]))
{
	header("Location:index.php");
}
?>
<style>

		#grad1
		{
			height:592px;
			background:linear-gradient(to bottom,white,yellowgreen)
		}
		
		#t2
		{
            margin-top:30px;
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
		th
		{
			font-size: 22px;
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

<?php
	$link=mysql_connect("localhost","root");
	$db=mysql_select_db("login",$link);
	
	$result=mysql_query("select * from driver where uname='".$_SESSION["Access"]."'");
	
	$row=mysql_fetch_assoc($result);
	$d_id=$row["d_id"];
	
	$result=mysql_query("select * from trip where d_id=$d_id");
	
	if(mysql_num_rows($result)!=0)
	{	
		$i=1;
		echo "<form><table cellspacing=10px>";
		echo "<tr><th>Trip Id</th><th>Source</th><th>Destination</th><th>Date</th><th>Time</th><th>Cost</th><th>Capacity</th></tr>";
		while($row=mysql_fetch_assoc($result))
		{
			echo"<tr><td align=center>".$row['t_id']."</td><td align=center>".$row['trip_src']."</td><td align=center>".$row['trip_dest'].
				"</td><td align=center>".$row['trip_date']."</td><td align=center>".$row['trip_time']."</td><td align=center>".$row['price']."</td><td align=center>".$row['capacity']."</td></tr>";
			$i++;
		}
		
		echo "<tr><td></td><td></td><td><input type=submit name='delete' value='Delete Ride' style=color:teal></td></tr></table></form>";
	
		if(isset($_REQUEST["delete"]))
		{
			echo "<form><table><tr><td>Trip Id:<input type='text' name='t_id'></td></tr>
		<tr><td><input type=submit value=Delete name='del' 
		style=background-color:white; color:teal; border-color:teal; border-radius:12px></td></tr></table></form>";
		}
		
		if(isset($_REQUEST["del"]))
		{
			$link=mysql_connect("localhost","root");
			$db=mysql_select_db("login",$link);
			$t_id=$_REQUEST['t_id'];
			//$tdate=$_REQUEST["tdate"];
			//$src=$_REQUEST["src"];
			 
			$result=mysql_query("select * from driver where uname='".$_SESSION["Access"]."'");
	
			$row=mysql_fetch_assoc($result);
			$d_id=$row["d_id"];
			//echo $d_id;
			$res=mysql_query("select * from trip where t_id=$t_id and d_id=$d_id");
	$r=mysql_num_rows($res);
	if($r!=0)
	{
			mysql_query("delete from trip where t_id=$t_id and d_id=$d_id");
			if(mysql_affected_rows()>0)
			{
				if(mysql_query("delete from addtotrip where t_id=$t_id"))
					ob_end_clean();
		include("header.php");
				echo "<h3 align=center style=color:teal>Trip Deleted</h3>";	
			}
			else
			{
				echo "<h3 align=center style=color:teal>Unable to Delete</h3>";
			}
	}
	else
	{
		echo "<h3 align=center style=color:teal>No such trip has been uploaded by you</h3>";
	} 
	}
	}
	else
	{
		echo "<h3 align=center style=color:teal>No Trips Uploaded</h3>";
	}
		
?>


</body>
</html>