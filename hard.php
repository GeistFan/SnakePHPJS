<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <br>
    <a class="logout" href="logout.php">Abmelden</a>
    <canvas class="box-game" id="canvas" width="720" height="720"></canvas>
    <script>
        let canvas = document.getElementById('canvas');
        let ctx = canvas.getContext('2d');
        let rows = 30;
        let cols = 30;
        let snake = [
            {x: 2, y: 3}
        ];
        let cellWidth = canvas.width / cols;
        let cellHeight = canvas.height / rows;
        let direction = '';
        let foodCollected = false;
        var score = 0;

        setInterval(gameLoop, 135); // die funktion gameLoop alle 200 Millisekunden ausführen
        document.addEventListener('keydown', keyDown); // wenn taste gedrückt wird, event starten

        placeFood(); // Food plazieren
        draw(); // Canvas färben

        function draw()
        {
            ctx.fillStyle = 'black'; // Farbe schwarz auswählen
            ctx.fillRect(0, 0, canvas.width, canvas.height); // Ganze leinwand füllen


            ctx.fillStyle = 'white'; // weiß auswählen
            add(130, 170); // füllen
            add(160, 170); // fühlen
            snake.forEach(part => add(part.x, part.y)); // die snake bewegen

            ctx.fillStyle = 'yellow'; // gelb auswählen
            add(food.x, food.y); // food färben
            drawScore();

            requestAnimationFrame(draw); // draw die ganze zeit ausführen
        }
        function drawScore() {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Score: "+score, 8, 20);
        }
        function placeFood() // Food plazieren
        {
            let randomX = Math.floor(Math.random() * cols); // Zufällige Variable 'X' errechnen
            let randomY = Math.floor(Math.random() * rows); // Zufällige Variable 'Y' errechnen

            food = {
                x: randomX,
                y: randomY
            } // 'X' & 'Y' zusammen rechnen und bereich food bestimmen
        }
        function testGameOver()
        {
            let firstPart = snake[0];
            let otherParts = snake.slice(1);
            let duplicatePart = otherParts.find(part => part.x == firstPart.x && part.y == firstPart.y);
            if (snake[0].x < 0 ||
                snake[0].x > cols - 1 ||
                snake[0].y < 0 ||
                snake[0].y > rows - 1 ||
                duplicatePart
                )
            {
                placeFood();
                snake = [{
                    x: 2, y: 3
                }]
                let direction = '';
                score = 0;
            }
        }
        function add(x, y)
        {
            ctx.fillRect(x * cellWidth, y * cellHeight, cellWidth - 3, cellHeight - 3);
        }
        function shiftSnake()
        {
            for (let i = snake.length - 1; i > 0; i--) {
                const part = snake[i];
                const lastpart = snake[i - 1];
                part.x = lastpart.x;
                part.y = lastpart.y;
                
            }
        }
        function gameLoop() // Tasten ausführen
        {
            testGameOver();
            if(foodCollected)
            {
                score = score +1;
                snake = [{x: snake[0].x, y: snake[0].y}, ...snake];
                foodCollected = false;
            }
            shiftSnake();
            if(direction == 'LEFT')
            {
                snake[0].x--;
            }
            if(direction == 'RIGHT')
            {
                snake[0].x++;
            }
            if(direction == 'UP')
            {
                snake[0].y--;
            }
            if(direction == 'DOWN')
            {
                snake[0].y++;
            }
            if(snake[0].x == food.x &&  snake[0].y == food.y)
            {
                foodCollected = true;
                placeFood(); // Food neu Plazieren
            }
        }
        function keyDown(e) // Tasten bestimmen
        {
            if(e.keyCode == 37)
            {
                direction = 'LEFT';
            }
            if(e.keyCode == 38)
            {
                direction = 'UP';
            }
            if(e.keyCode == 39)
            {
                direction = 'RIGHT';
            }
            if(e.keyCode == 40)
            {
                direction = 'DOWN';
            }
        }
    </script>
    <h1><center>Drücke die Pfeiltasten um zu beginnen</center></h1>
  </br>

</body>
</html>
