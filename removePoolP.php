<html>
<head>
<?php include("Pheader.php");
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
	
	$result=mysql_query("select * from passenger where uname='".$_SESSION["Access"]."'");
	
	$row=mysql_fetch_assoc($result);
	$p_id=$row["p_id"];
	
	$result=mysql_query("select t_id from addtotrip where p_id=$p_id");
	
	if(mysql_num_rows($result)!=0)
	{	
		$i=1;

		echo "<form><table cellspacing=10px>";
		echo "<tr><th>Trip Id</th><th>Driver Id</th><th>Source</th><th>Destination</th><th>Date</th><th>Time</th><th>Cost</th><th>Capacity</th><tr>";
		while($row=mysql_fetch_row($result))
		{	$tid[]=$row[0];
	//echo $row[0];
		}
		foreach($tid as $val)
		{
			//echo $val;
	$res=mysql_query("select * from trip where t_id=$val");
	while($rw=mysql_fetch_row($res))
	{ //echo "hi";
			echo "<tr><td align=center>".$rw[0]."<td align=center>".$rw[1]."</td><td align=center>".$rw[2]."</td><td align=center>".$rw[3].
				"</td><td align=center>".$rw[4]."</td><td align=center>".$rw[5]."</td><td align=center>".$rw[6]."</td><td align=center>".$rw[7]."</td></tr>";
	}
		}
		echo "<tr><td></td><td></td><td><input type=submit name='delete' value='Delete Ride' style=color:teal></td></tr></table></form>";
	
	}
	else
	{
		echo "<h3 align=center style=color:teal>No Trips Joined</h3>";
	}

	
	if(isset($_REQUEST["delete"]))
	{
		echo "<form><table><tr><td>Trip Id:</td><td><input type=text name='tid'></td></tr>
		
		<tr><td><input type=submit value=Delete name='del' 
		style=background-color:white; color:teal; border-color:teal; border-radius:12px></td></tr></table></form>";
	}
	
	if(isset($_REQUEST["del"]))
	{
		$link=mysql_connect("localhost","root");
		$db=mysql_select_db("login",$link);
		$result=mysql_query("select * from passenger where uname='".$_SESSION['Access']."'");

		$row=mysql_fetch_assoc($result);
		$pid=$row['p_id'];

		$t_id=$_REQUEST["tid"];
		//echo $t_id."".$pid;
	//$time=$_REQUEST["time"];

	/*	if(mysql_query("update trip set p_id=NULL where d_id=$d_id and trip_time='$time'"))
			echo "<h3 align=center style=color:teal>Ride Left</h3>";
		else
			echo "<h3 align=center style=color:teal>Unable to Leave</h3>";
	}*/
	
	mysql_query("delete from addtotrip where t_id=$t_id and p_id=$pid");
	if(mysql_affected_rows()>0)
	{
		
		ob_end_clean();
		include("Pheader.php");
	echo "<h3 align=center style=color:teal>Ride Left</h3>";
	}
		else
		{
			ob_end_clean();
		include("Pheader.php");
			echo "<h3 align=center style=color:teal>Unable to Leave</h3>";
	}
	}
?>

</body>
</html>