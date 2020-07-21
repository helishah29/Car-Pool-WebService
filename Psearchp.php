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

<form name="f1" action="">
<table id="t2">
	<tr><td>Source:</td><td><input type="text" name="src"></td></tr> 
	<tr><td>Destination:</td><td><input type="text" name="dest"></td></tr>
	<tr><td>Date:</td><td><input type="date" name="date">&nbsp;&nbsp;(Date:yyyy-mm-dd)</td></tr>
	<tr><td><br></td></tr>
	<tr><td></td><td><input type="submit" value="Search Pool" name="search" 
		style="background-color:white; color:teal; border-color:teal; border-radius:12px"> &nbsp;&nbsp;&nbsp;
            <input type="reset" value="Reset" 
			style="background-color:white; color:chocolate; border-radius:12px; border-color:chocolate;"></td></tr> 
</table>
</form>

<?php

if(isset($_REQUEST["search"]))
{
	$src=$_REQUEST["src"];
	$dest=$_REQUEST["dest"];
	$date=$_REQUEST["date"];
	$_SESSION['tmpsrc']=$src;
	$_SESSION['tmpdest']=$dest;
	$_SESSION['tmpdate']=$date;
	$link=mysql_connect("localhost","root");
	$db=mysql_select_db("login",$link);
	$result=mysql_query("select * from trip where trip_src='$src' and trip_dest='$dest' and trip_date='$date'");
	
	//$row=mysql_fetch_assoc($result);
	if(mysql_num_rows($result)!=0)
	{	//$i=1;
		$tmp = array();
        global $tmp;
		echo "<form><table cellspacing=10px>";
		echo "<tr><th>Trip Id</th><th>Driver Id</th><th>Source</th><th>Destination</th><th>Date</th><th>Time</th><th>Cost</th><th>Capacity</th><tr>";
		while($row=mysql_fetch_assoc($result))
		{
			echo"<tr><td align=center>".$row['t_id']."</td><td align=center>".$row['d_id']."</td><td align=center>".$row['trip_src']."</td><td align=center>".$row['trip_dest'].
				"</td><td align=center>".$row['trip_date']."</td><td align=center>".$row['trip_time']."</td><td>".$row['price']."</td><td>".$row['capacity']."</td></tr>";
		//$_SESSION['mytid']=$row['t_id'];
		$tmp[]=$row['t_id'];
		
		}
		
		echo "<tr><td></td><td></td><td><input type=submit name='selectRide' value='Select Ride' style=color:teal></td></tr></table></form>";
	
	}
		
	else
	{
		echo "<h3 align=center style=color:teal>No Trips Found</h3>";
	}

}
if(isset($_REQUEST['selectRide']))
{
	echo "<form><table><tr><td> Trip Id:</td><td><input type=text name=tid></td></tr>
		  
		<tr><td><input type=submit value=Select name='sel' 
		style=background-color:white; color:teal; border-color:teal; border-radius:12px></td></tr></table></form>";
}

if(isset($_REQUEST['sel']))
{
	$link=mysql_connect("localhost","root");
	$db=mysql_select_db("login",$link);
	$result=mysql_query("select * from passenger where uname='".$_SESSION['Access']."'");
	
	$row=mysql_fetch_assoc($result);
	$pid=$row['p_id'];
	
	//$time=$_REQUEST["time"];
	//$d_id=$_REQUEST["did"];
	//$tid=$_SESSION['mytid'];
	$stid=$_REQUEST['tid'];
	$src=$_SESSION['tmpsrc'];
$dest=$_SESSION['tmpdest'];
$date=$_SESSION['tmpdate'];

	$rest=mysql_query("select t_id from trip where t_id=$stid and trip_src='$src' and trip_dest='$dest' and trip_date='$date' "); 
	if ($rest==false)
{
    die(mysql_error());
}
	if(mysql_num_rows($rest)!=0)
	{
	//mysql_query("update trip set p_id=$pid where d_id=$d_id and trip_time='$time'");
	//echo $tid;
	$res=mysql_query("select * from addtotrip where t_id=$stid and p_id=$pid");
	if(mysql_num_rows($res)==0)
	{
		$result=mysql_query("select * from trip where t_id=$stid");
		while($row=mysql_fetch_assoc($result))
		{
			$cnt=$row['cnt'];
			$cap=$row['capacity'];
		}
		//echo $cnt;
		//echo $cap;
		if($cnt<$cap)
		{
		
	if(mysql_query("insert into addtotrip values ('$stid','$pid')"))
	{
		$result=mysql_query("select * from trip where t_id=$stid");
		while($row=mysql_fetch_assoc($result))
		{
			$v=$row['cnt'];
			$v=$v+1;
			if(mysql_query("update trip set cnt=$v where t_id=$stid"))
			{
				echo "<h3 align=center style=color:teal>Ride Selected</h3>";
			}
		}
		//echo "added";
	
	
	
	
	}
		}
	else
	{
		echo "<h3 align=center style=color:teal>Trip is full</h3>";
	}
	}
	else
	{
		echo "<h3 align=center style=color:teal>You have already joined this pool</h3>";
	}
	

	}
	else
	{
		echo "<h3 align=center style=color:teal>Enter trip id from the displayed list</h3>";
	}

}

?>




</body>
</html>