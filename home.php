<html>
<head>
<?php include("header.php")?>
</head>
<body>
<?php
session_start();
echo "<center><h2 style=color:teal>WELCOME ".$_SESSION["Access"]."!</h2></center>";


?>
</body>
</html>