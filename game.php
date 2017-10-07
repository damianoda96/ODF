<!-- created by: DEVEN DAMIANO - dad152 - ISP - 12/9/2016 -->
<?php

session_start();

if(!isset($_SESSION['username'])){
header("Location:index.html");
}

?>
<html>

<style>
body{
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>

<script>

var astro;
var astroX;
var astroY;

var player;
var playerScore = 0;
var highScore;

var damage = 5;

var visualScore;
var visualHits;

var level = 0;

var endDiv;

var hits;

var scoreForm;

var canClear = false;

var width = parseFloat(screen.width);
var windowHalf = width/2.0;

var canShoot = false;

var player = document.createElement('img'); 
player.id = "player";
player.src = "./images/cannon.png";
player.style.width = "50px";
player.style.height = "120px";
player.style.position = "absolute";
player.style.top = "650px";
player.style.left = windowHalf + "px";

var playerX = parseInt(player.style.left);

var song = new Audio('./sounds/song.wav');
		song.loop = true;
        song.play();

function startGame()
{
    if(level == 0)
	{
                document.getElementById('gameWindow').appendChild(player);
     
		document.getElementById('gameWindow').removeChild(document.getElementById('startDiv'));
		document.getElementById('gameWindow').removeChild(document.getElementById('logo'));
		level = 1;
		visualScore = document.createElement('p');
		visualScore.style.color = "#36FB1A";
		visualScore.style.fontFamily = "courier";
		visualScore.style.fontSize = "30px";
		visualScore.innerHTML = "SCORE: " + playerScore;
		visualScore.style.position = "absolute";
		visualScore.style.left = "15%";
		
		visualHits = document.createElement('p');
		visualHits.style.color = "#36FB1A";
		visualHits.style.fontFamily = "courier";
		visualHits.style.fontSize = "30px";
		visualHits.innerHTML = "City Health: " + damage;
		visualHits.style.position = "absolute";
		visualHits.style.top = "200px";
		visualHits.style.left = "15%";
	
		document.getElementById('gameWindow').appendChild(visualScore);
		document.getElementById('gameWindow').appendChild(visualHits);
	}
	
	if(level > 0)
	{
		canShoot = true;
	
		astro = new Array(3*level);
		astroX = new Array(astro.length);
		astroY = new Array(astro.length);

		hits = astro.length;

		for(var i = 0; i < astro.length; i++)
		{
			var randsize = (Math.floor(Math.random() * 40) + 40);
			astro[i] = document.createElement('img');
			astro[i].src = "./images/astroid.gif";
			astro[i].width = randsize;
			astro[i].height = randsize;
			astro[i].style.position = "absolute";
			astro[i].class = "astroids";
			document.getElementById('gameWindow').appendChild(astro[i]);
			
			
			var randX = (Math.floor(Math.random() * 1000) + parseInt(document.getElementById('gameWindow').offsetLeft));
			astro[i].style.left = randX + 'px';

			var randY = (Math.floor(Math.random() * 1500) - 2000);
			astro[i].style.top = randY + 'px';
			
			astroX[i] = parseFloat(astro[i].style.left);
			astroY[i] = parseFloat(astro[i].style.top);
			
			
		  }
		    
		  var id = setInterval(frame, 5)

		  function frame()
		  {
		    if (hits == 0)
			{
			   clearInterval(id);
			   changeLevel();
			}
			
			for(var i = 0; i < astro.length; i++)
			{
			  var randslopeX = (Math.floor(Math.random() * 100) + -50);
			  var randslopeY = (Math.floor(Math.random() * 100) + 50);
			  var dist = Math.sqrt(randslopeX*randslopeX+randslopeY*randslopeY);
			  //var velX = (randslopeX/dist)*(Math.floor(Math.random() * 1) + 1);
			  //var velY = (randslopeY/dist)*(Math.floor(Math.random() * 1) + 1);
			  var velX = (randslopeX/dist)*1;
			  var velY = (randslopeY/dist)*1;
			  astroY[i]+=velY;
			  astroX[i]+=velX;
			  astro[i].style.top = astroY[i] + 'px';
			  astro[i].style.left = astroX[i] + 'px';
			  
			  if(astro[i].offsetTop > 710 || astro[i].offsetLeft > 1300 || astro[i].offsetLeft < 0)
			  {
				document.getElementById('gameWindow').removeChild(astro[i]);
				createBomb(astro[i].width, astro[i].height, astroX[i], astroY[i]);
				damage--;
				hits--;
				
				visualHits.innerHTML = "City Health: " + damage;
				
				if(damage == 0)
				{
				  endGame();
				  clearInterval(id);
				
				}
			  }
			}
		  }
	}
}

function createBomb(asW, asH, asX, asY)
{
	var explosion1 = new Audio('./sounds/explosion1.wav');
    explosion1.play();
	
	var explosion = document.createElement('img');
	explosion.src = "./images/bomb.gif";
	explosion.width = "100";
	explosion.height = "100";
	explosion.style.position = "absolute";
	explosion.style.top = 600 + 'px';
	explosion.style.left = asX + 'px';
	
	document.getElementById('gameWindow').appendChild(explosion);
	
	var change = setInterval(pic, 700);
				
	function pic()
	{
		explosion.src = "explode.gif"+"?a="+Math.random();
		document.getElementById('gameWindow').removeChild(explosion);
		clearInterval(change);
	}
}

function endGame()
{
	canShoot = false;

       // endGameBomb();
	
	scoreForm = document.createElement('form');
	scoreForm.setAttribute("action", "http://arcadiadamiano.co/store.php");
    scoreForm.setAttribute("method", "post");
	scoreForm.setAttribute("id", "scoreForm");
	
	var inputelement = document.createElement('input');
    inputelement.setAttribute("type", "text");
	inputelement.setAttribute("name", "score");
	inputelement.setAttribute("value", playerScore);
	scoreForm.appendChild(inputelement);
	
	endDiv = document.createElement('div');
	endDiv.style.width = '50%';
	endDiv.style.top = '200px';
	endDiv.style.left = '25%';
	endDiv.style.position = 'absolute';
	endDiv.style.color = '#36FB1A';
	//endDiv.style.border = '5px solid #36FB1A';
	endDiv.id = 'end';
	endDiv.style.textAlign = 'center';
	
	var restartDiv = document.createElement('div');
	restartDiv.style.width = '60%';
	//restartDiv.style.top = '100px';
	restartDiv.style.left = '20%';
	restartDiv.style.position = 'absolute';
	restartDiv.style.color = '#36FB1A';
	restartDiv.style.border = '2px solid #36FB1A';
	restartDiv.id = 'restart';
	restartDiv.style.textAlign = 'center';
	restartDiv.onclick = submitScore;
	
	var para = document.createElement('p');
	para.style.fontSize = '45px';
	para.style.fontFamily = 'courier';
	para.innerHTML = "GAME OVER";
	
	var scoreText = document.createElement('p');
	scoreText.style.fontSize = '45px';
	scoreText.style.fontFamily = 'courier';
	scoreText.innerHTML = playerScore;
	
	var highscoreText = document.createElement('p');
	scoreText.style.fontSize = '45px';
	scoreText.style.fontFamily = 'courier';
	
	if(playerScore < <?php echo $_SESSION["highscore"]; ?>)
	{
		scoreText.innerHTML = "HIGHSCORE:" + <?php echo $_SESSION["highscore"]; ?>;
	}
	else
	{
		scoreText.innerHTML = "HIGHSCORE:" + playerScore;
	}
	
	var para1 = document.createElement('p');
	para1.style.fontSize = '20px';
	para1.style.fontFamily = 'courier';
	para1.innerHTML = "RESTART";
	
	restartDiv.appendChild(para1);
	
	endDiv.appendChild(para);
	endDiv.appendChild(scoreText);
	endDiv.appendChild(highscoreText);
	endDiv.appendChild(restartDiv);
	
	document.getElementById('gameWindow').appendChild(endDiv);
}

/*function endGameBomb()
{
	var explosion = document.createElement('img');
	explosion.src = "./images/bomb.gif";
	explosion.width = "1000";
	explosion.height = "500";
	explosion.style.position = "absolute";
	explosion.style.top = 600 + 'px';
	explosion.style.left = 100 + 'px';
	
	document.getElementById('gameWindow').appendChild(explosion);
	
	var change = setInterval(pic, 700);
				
	function pic()
	{
		explosion.src = "explode.gif"+"?a="+Math.random();
		document.getElementById('gameWindow').removeChild(explosion);
		clearInterval(change);
	}
}*/


function submitScore()
{
	scoreForm.submit();
	
}

function shoot()
{
  if(level != 0 && canShoot)
  {
	var shot = new Audio('./sounds/shot.wav');
    shot.play();
	
	createShotLight();
	
	var mouseX = parseFloat(event.clientX);
	var mouseY = parseFloat(event.clientY);  
	
	var bullet = document.createElement("img");
		   
		   var slopeY = parseFloat(mouseY-660.0);
		   var slopeX = parseFloat(mouseX-windowHalf);
		   var dist = Math.sqrt(slopeX*slopeX+slopeY*slopeY);
		   var velX = (slopeX/dist)*2.0;
		   var velY = (slopeY/dist)*2.0;
		   
		   bullet.src =  "./images/bullet.gif";
		   bullet.width = 20;
		   bullet.height = 20;
		   bullet.style.position = "absolute";
		   bullet.style.top = "660px";
		   bullet.style.left = windowHalf + 'px';
		   bullet.class = "bullets";
		   document.getElementById('gameWindow').appendChild(bullet);
		   
		   var id = setInterval(frame, 5);
		   
		   function frame()
		   { 
			   var x = parseFloat(bullet.style.left) + velX;
			   var y = parseFloat(bullet.style.top) + velY;
			   bullet.style.left = x + 'px';
			   bullet.style.top = y + 'px';		  
			   
			   if(x < 100 || x > width - 100)
			   {
				 document.getElementById('gameWindow').removeChild(bullet);
				 clearInterval(id);
			   }
				
			   if(y < 100 || y > 800)
			   {
				document.getElementById('gameWindow').removeChild(bullet);
				clearInterval(id);
			   }
			   
			   for(var i = 0; i < astro.length; i++)
			   {
				 var asX = astroX[i];
				 var asW = astro[i].width;
				 var asY = astroY[i];
				 var asH = astro[i].height;
			   
				 if((x + 5) >= asX && x <= (asX + asW) && y <= asY + asH && y >= (asY))
				 { 
			       if(canShoot)
				   {
					playerScore += 10;
				   }
				   hits--;
				   visualScore.innerHTML = "SCORE: " + playerScore;
				   document.getElementById('gameWindow').removeChild(bullet);
				   
				   document.getElementById('gameWindow').removeChild(astro[i]);
				   
				   var explosion = new Audio('./sounds/explosion.wav');
                   explosion.play();
				   
				   createExplosion(asX, asY, asW, asH);
				   
				   astroX[i] = -1000;
				   astroY[i] = -1000;
				   			   
				   clearInterval(id);
				 }
			   }
		   }
	}
	
}

function createShotLight()
{	
	var explosion = document.createElement('img');
	explosion.src = "./images/shotlight.gif";
	explosion.width = "50";
	explosion.height = "50";
	explosion.style.position = "absolute";
	explosion.style.top = 650 + 'px';
	explosion.style.left = player.style.left;
	
	document.getElementById('gameWindow').appendChild(explosion);
	
	var change = setInterval(pic, 200);
				
	function pic()
	{
		explosion.src = "explode.gif"+"?a="+Math.random();
		document.getElementById('gameWindow').removeChild(explosion);
		clearInterval(change);
	}
}

function createExplosion(asX, asY, asW,asH)
{	
    var explosion = document.createElement('img');
	explosion.src = "./images/explode.gif";
	explosion.width = asW;
	explosion.height = asH;
	explosion.style.position = "absolute";
	explosion.style.top = asY + 'px';
	explosion.style.left = asX + 'px';
	
	document.getElementById('gameWindow').appendChild(explosion);
	
	var change = setInterval(pic, 300);
				
	function pic()
	{
		explosion.src = "explode.gif"+"?a="+Math.random();
		document.getElementById('gameWindow').removeChild(explosion);
		clearInterval(change);
	}
	
}

function changeLevel()
{
  level+=1;
  astro.length = 0;
  astroX.length = 0;
  astroY.length = 0;
  
  var anim = setInterval(change, 5);
  
  var changeLevelpara = document.createElement('p');
  changeLevelpara.innerHTML = "WAVE: " + level;
  changeLevelpara.style.fontFamily = "courier";
  changeLevelpara.style.fontSize = "40px";
  changeLevelpara.style.position = "absolute";
  changeLevelpara.style.left = "45%";
  changeLevelpara.style.top = '200px';
  changeLevelpara.style.color = '#36FB1A';
  
  var counter = 0;
  
  document.getElementById('gameWindow').appendChild(changeLevelpara);
  
  function change()
  {
      counter++;
	  if(counter == 500)
	  {
	   document.getElementById('gameWindow').removeChild(changeLevelpara);
	   clearInterval(anim);
	   startGame();
	  }
  }
}

</script>

<body style="background-color:black">

<div id="bigDiv" style="background-color:black; width:80%; margin: 0px auto; color:#36FB1A">
<h1 style="text-align:center; font-family:courier">ORBITAL DEFENCE FORCE</h1>
<div id="logout" style="background-color:black; width:10%; margin-left:60%; top:10px; color:#36FBIA; border:1px solid #36FB1A; position:absolute;" 
onclick="window.location.href = 'logout.php'" onmouseover="this.style.border = '1px solid white'" onmouseleave="this.style.border = '1px solid #36FB1A'">

<p style="font-size:15x; font-family:courier; text-align:center;">LOGOUT</p>
</div>

<div id="gameWindow" onclick="shoot()" style="width:90%; height:700px; border:5px solid #36FB1A; margin:0px auto; background-image:url('./images/space.gif');">

<?php

echo "<h2 style='color:#36FB1A; font-family:courier; text-transform: uppercase;'>". $_SESSION["username"] ." OF PLANET " . $_SESSION["planet"] . "... WE NEED YOUR HELP!</h2>";


?>
<img id='logo' src='./images/odflogo.gif' width='40%' height='300px;' style='position:absolute; left:30%;'>
<div id="startDiv" style="position:absolute; width:50%; border:5px solid #36FB1A; left:25%; top:450px" onclick="startGame();" onmouseover="this.style.border = '5px solid white';" onmouseleave="this.style.border = '5px solid #36FB1A';">

<h2 style="text-align:center; font-family:courier">DEFEND HUMANITY</h2>
</div>

<img src="./images/city.gif" width="70%" height="100px" style="position:absolute; top:670px"/>
</div>

<br>
<br>
</div

</body>

</html>