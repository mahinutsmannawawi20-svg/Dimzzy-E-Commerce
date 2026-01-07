const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

// ------------------ GAME STATE ------------------
let stage = 1;
let score = 0;

let paddleWidth = 120;
let paddleHeight = 15;
let paddleX = (canvas.width - paddleWidth) / 2;
let rightPressed = false;
let leftPressed = false;

let ballRadius = 10;
let ballX = canvas.width / 2;
let ballY = canvas.height / 2;
let ballSpeedX = 3;
let ballSpeedY = -3;

let gameRunning = false;

let bricks = [];

// ------------------ INPUT ------------------
document.addEventListener("keydown", keyDownHandler);
document.addEventListener("keyup", keyUpHandler);

document.addEventListener("keydown", function (e) {
    if (e.code === "Space" && !gameRunning) {
        startGame();
    }
});

function keyDownHandler(e) {
    if (e.key === "ArrowRight") rightPressed = true;
    else if (e.key === "ArrowLeft") leftPressed = true;
}
function keyUpHandler(e) {
    if (e.key === "ArrowRight") rightPressed = false;
    else if (e.key === "ArrowLeft") leftPressed = false;
}

// ------------------ GAME INIT ------------------
function startGame() {

    if (!gameRunning) {
        generateBricks();
    }

    gameRunning = true;

    ballX = canvas.width / 2;
    ballY = canvas.height / 2;

    let difficultyBoost = stage * 0.5;

    ballSpeedX = 1 + difficultyBoost;
    ballSpeedY = -(1 + difficultyBoost);

    paddleX = (canvas.width - paddleWidth) / 2;

    draw();
}

// ------------------ BRICK GENERATOR ------------------
function generateBricks() {
    bricks = [];

    let brickWidth = 80;
    let brickHeight = 22;
    let padding = 12;

    let maxCols = Math.floor(canvas.width / (brickWidth + padding)) - 1;
    let rows = Math.min(2 + stage, 8);

    let totalBricks = Math.min(rows * maxCols, 40);

    let startX = (canvas.width - (maxCols * (brickWidth + padding))) / 2;
    let startY = 60;

    let count = 0;

    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < maxCols; c++) {
            if (count >= totalBricks) break;

            let chance = Math.random();
            if (chance > 0.3 || stage < 2) {
                bricks.push({
                    x: startX + c * (brickWidth + padding),
                    y: startY + r * (brickHeight + padding),
                    width: brickWidth,
                    height: brickHeight,
                    destroyed: false
                });

                count++;
            }
        }
    }
}

// ------------------ DRAW ------------------
function drawBall() {
    ctx.beginPath();
    ctx.arc(ballX, ballY, ballRadius, 0, Math.PI * 2);
    ctx.fillStyle = "#00FFAA";
    ctx.fill();
}

function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height - paddleHeight - 10, paddleWidth, paddleHeight);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
}

function drawBricks() {
    bricks.forEach(b => {
        if (!b.destroyed) {
            ctx.beginPath();
            ctx.rect(b.x, b.y, b.width, b.height);
            ctx.fillStyle = "#ffcc00";
            ctx.fill();
        }
    });
}

// ------------------ UI ------------------
function drawStage() {
    ctx.font = "18px Arial";
    ctx.fillStyle = "#FFFFFF";
    ctx.textAlign = "left";
    ctx.fillText(`Stage: ${stage}`, 15, 28);
    ctx.fillText(`Score: ${score}`, 15, 50);
}

function drawStartScreen() {
    ctx.fillStyle = "#111";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.font = "bold 36px Arial";
    ctx.fillStyle = "#00FFCC";
    ctx.textAlign = "center";
    ctx.fillText("DIMZZ PONG", canvas.width / 2, canvas.height / 2 - 20);

    ctx.font = "20px Arial";
    ctx.fillStyle = "#FFFFFF";
    ctx.fillText("Press SPACE to Start", canvas.width / 2, canvas.height / 2 + 20);
}

function drawWin() {
    gameRunning = false;

    ctx.fillStyle = "rgba(0,200,100,0.2)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.font = "bold 32px Arial";
    ctx.fillStyle = "#00FFAA";
    ctx.textAlign = "center";
    ctx.fillText("YOU WIN!", canvas.width / 2, canvas.height / 2 - 30);

    ctx.font = "18px Arial";
    ctx.fillStyle = "#FFFFFF";
    ctx.fillText("Press SPACE for Next Stage", canvas.width / 2, canvas.height / 2 + 10);

    stage++;
}

function drawGameOver() {
    gameRunning = false;

    // Save score and check for coupon
    saveScore();

    ctx.fillStyle = "rgba(0,0,0,0.7)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.font = "bold 32px Arial";
    ctx.fillStyle = "#FF5555";
    ctx.textAlign = "center";
    ctx.fillText("GAME OVER", canvas.width / 2, canvas.height / 2 - 40);

    ctx.font = "20px Arial";
    ctx.fillStyle = "#FFAA00";
    ctx.fillText(`Final Score: ${score}`, canvas.width / 2, canvas.height / 2 - 5);

    ctx.font = "18px Arial";
    ctx.fillStyle = "#ffffff";
    ctx.fillText("Press SPACE to Restart", canvas.width / 2, canvas.height / 2 + 30);

    stage = 1;
    score = 0;
}

// ------------------ LOOP ------------------
function draw() {

    if (!gameRunning) {
        drawStartScreen();
        return;
    }

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    drawStage();
    drawBricks();
    drawBall();
    drawPaddle();

    if (ballX + ballSpeedX > canvas.width - ballRadius || ballX + ballSpeedX < ballRadius) {
        ballSpeedX = -ballSpeedX;
    }

    if (ballY + ballSpeedY < ballRadius) {
        ballSpeedY = -ballSpeedY;
    } else if (ballY + ballSpeedY > canvas.height - ballRadius - paddleHeight - 10) {

        if (ballX > paddleX && ballX < paddleX + paddleWidth) {
            ballSpeedY = -ballSpeedY;
        } else {
            drawGameOver();
            return;
        }
    }

    bricks.forEach(brick => {

        if (!brick.destroyed) {
            if (
                ballX > brick.x &&
                ballX < brick.x + brick.width &&
                ballY + ballRadius > brick.y &&
                ballY - ballRadius < brick.y + brick.height
            ) {

                brick.destroyed = true;
                ballSpeedY = -ballSpeedY;
                score += 100; // Add score when brick is destroyed
            }
        }
    });

    if (bricks.every(b => b.destroyed)) {
        drawWin();
        return;
    }

    ballX += ballSpeedX;
    ballY += ballSpeedY;

    if (rightPressed && paddleX < canvas.width - paddleWidth) paddleX += 7;
    else if (leftPressed && paddleX > 0) paddleX -= 7;

    requestAnimationFrame(draw);
}

// ------------------ START ------------------
drawStartScreen();

// ------------------ SAVE SCORE & COUPON ------------------
function saveScore() {
    const playerName = prompt("Enter your name:") || "Guest";
    const finalScore = score;

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/save-score', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            player_name: playerName,
            score: finalScore,
            game_type: 'pingpong'
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.coupon_generated && data.coupon) {
                // Show coupon modal
                if (typeof showCouponModal === 'function') {
                    showCouponModal(data.coupon);
                }
            } else if (data.message) {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Maaf, terjadi kesalahan saat menyimpan skor. Silakan coba lagi. \nDetail: ' + error.message);
        });
}
