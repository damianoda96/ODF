<html>
<body style="background-color:black;">
<?php

//Get input values
$user = $_POST["user"];
$planet = $_POST["planet"];
$password = $_POST["password"];

if($user == null || $planet == null || $password == null)
{
	echo "<p style='color:#36FB1A'>*ERROR - PLEASE ENTER ALL VALUES*</p>";
	//header("Location: create.html");
    exit;
}

//MYSQL

$sql = mysql_connect("50.62.209.73:3306", "damianoda96", "Damiano102296", "DatabaseDamiano");
if(!$sql)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT CONNECT TO MYSQL!*</p>";
	//header("Location: create.html");
    exit;
}

//database

$database = mysql_select_db("DatabaseDamiano");
if(!$database)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT CONNECT TO DATABASE!*</p>";
	//header("Location: create.html");
    exit;
}

//check to see if user already exists

$result = mysql_query("select * from Recruits WHERE UserName='$user' and Pass='$password'");
$rows = mysql_num_rows($result);

if($rows > 0)
{
	echo "<p style='color:#36FB1A'>*ERROR - NAME ALREADY EXISTS*</p>$rows";
	//header("Location: create.html");
    exit;
}

//query

$query1 = "insert into Recruits (UserName, planet, Pass, HighScore) values ('$user','$planet','$password', 0)";

//Execute the query

$result1 = mysql_query($query1);
if(!$result1)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT EXECUTE QUERY!*</p>";
	$error = mysql_error();
    echo "<p style='color:#36FB1A'>" . $error . "</p>";
	//header("Location: create.html");
    exit;
}
else
{
	header("Location: index.html");
	
}

?>
</body>
</html>