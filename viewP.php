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
$cnt=0;
		echo "<table cellspacing=10px>";
		echo "<tr><th>Index</th><th>Source</th><th>Destination</th><th>Date</th><th>Time</th><tr>";
		while($row=mysql_fetch_assoc($result))
		{
			$tid=$row['t_id'];
			$res=mysql_query("select * from addtotrip where t_id=$tid");
			if(mysql_num_rows($res)!=0)
			{
			while($r=mysql_fetch_row($res))
			{
				$cnt++;
			}
			}
			//$pid=$row['p_id'];
		
			echo"<tr><td align=center>".$i."</td><td align=center>".$row['trip_src']."</td><td align=center>".$row['trip_dest'].
				"</td><td align=center>".$row['trip_date']."</td><td align=center>".$row['trip_time'].
				"<td align=center>".$cnt." Poolers Joined";
			$i++;
			$cnt=0;
		}
	}
		
	else
	{
		echo "<h3 align=center style=color:teal>No Trips Uploaded</h3>";
	}

?>


</body>
</html>