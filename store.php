<?php

session_start();

?>
<html>
<body style="background-color:black;">
<?php
//MYSQL

$score = $_POST["score"];
$user = $_SESSION["username"];
$planet = $_SESSION["planet"];

//$_SESSION["highscore"] = $score;

$MYSQL = mysql_connect("50.62.209.73:3306", "damianoda96", "Damiano102296", "DatabaseDamiano");
if(!$MYSQL)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT CONNECT TO MYSQL!*</p>";
	header("Location: login.html");
    exit;
}

//database

$database = mysql_select_db("DatabaseDamiano");
if(!$database)
{
	echo "<p style='color:#36FB1A'>*ERROR - CANNOT CONNECT TO DATABASE!*</p>";
	header("Location: login.html");
    exit;
}

if($score > $_SESSION["highscore"])
{
	$query = "update Recruits set HighScore = '$score' where UserName = '$user' and Planet = '$planet'";
	$_SESSION["highscore"] = $score;
	
	$result = mysql_query($query);

	if(!$result)
	{
		echo "<p style='color:#36FB1A'>*ERROR - COULD NOT UPDATE SCORE*</p>";
		exit;
	}
	else
	{
		header("Location: http://arcadiadamiano.co/game.php");
		exit;
	}
}
else
{
	header("Location: http://arcadiadamiano.co/game.php");
	exit;
}

?>
</body>
</html>