<?php

session_start();

?>
<html>
<body>
<?php
//Get input values
$user = $_POST["user"];
$password = $_POST["password"];

if($user == null || $password == null)
{
	echo "<p style='color:#36FB1A'>*ERROR - PLEASE ENTER ALL VALUES*</p>";
	header("Location: index.html");
    exit;
}

//MYSQL

$MYSQL = mysql_connect("50.62.209.73:3306", "damianoda96", "Damiano102296", "DatabaseDamiano");
if(!$MYSQL)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT CONNECT TO MYSQL!*</p>";
	header("Location: index.html");
    exit;
}

//database

$database = mysql_select_db("DatabaseDamiano");
if(!$database)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT CONNECT TO DATABASE!*</p>";
	header("Location: index.html");
    exit;
}

//query

$query = "select * from Recruits WHERE UserName='$user' and Pass='$password'";

$result = mysql_query($query);
$rows = mysql_num_rows($result);
if($rows == 0)
{
	echo "<p style='color:#36FB1A'>*ERROR - USER DOESN'T EXIST!*</p>";
	$error = mysql_error();
    echo "<p style='color:#36FB1A'>" . $error . "</p>";
	header("Location: index.html");
    exit;
}
else
{
	$planetSQL = "SELECT Planet FROM Recruits WHERE UserName = '$user' and Pass = '$password'";
	$scoreSQL = "SELECT HighScore FROM Recruits WHERE UserName = '$user' and Pass = '$password'";
	$planetASSOC = mysql_query($planetSQL);
	$highscoreASSOC = mysql_query($scoreSQL);
	$planet = mysql_fetch_assoc($planetASSOC);
	$highscore = mysql_fetch_assoc($highscoreASSOC);
	$_SESSION["username"] = $user;
	$_SESSION["planet"] = $planet['Planet'];
	$_SESSION["highscore"] = $highscore['HighScore'];
	header("Location: http://arcadiadamiano.co/game.php");
    exit;
	
}


?>
</body>
</html>