<html>
<head>
<?php include("header.php")?>

</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
//$stmt = $conn->prepare("INSERT INTO trip (d_id,trip_src,trip_dest,trip_date,trip_time) VALUES (?,?,?,?,?)");


// set parameters and execute

$trip_src=$_REQUEST["src"];
$trip_dest=$_REQUEST["dest"];
$trip_date=$_REQUEST["date"];

$result=mysql_query("select * from trip where trip_src='".$trip_src."' and trip_dest='".$trip_dest."' and trip_date='".$trip_date."");


while($row=mysql_fetch_row($result))
{	
	if($row==null)
		break;
	foreach($row as $val)
	{
		echo" ".$val;
	}
	echo"<br>";
}

mysql_close($link);
$stmt->close();
$conn->close();

?>

</body>
</html>
