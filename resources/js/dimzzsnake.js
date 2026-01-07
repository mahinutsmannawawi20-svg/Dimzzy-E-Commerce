const canvas = document.getElementById("snakeCanvas");
const ctx = canvas.getContext("2d");

const box = 20;
let snake = [{ x: 10 * box, y: 10 * box }];
let direction = null;
let food = {
    x: Math.floor(Math.random() * (canvas.width / box)) * box,
    y: Math.floor(Math.random() * (canvas.height / box)) * box,
};
let gameRunning = false;
let score = 0;

document.addEventListener("keydown", (e) => {
    if (!gameRunning && e.code === "Space") startGame();

    if (e.key === "ArrowLeft" && direction !== "RIGHT") direction = "LEFT";
    else if (e.key === "ArrowUp" && direction !== "DOWN") direction = "UP";
    else if (e.key === "ArrowRight" && direction !== "LEFT") direction = "RIGHT";
    else if (e.key === "ArrowDown" && direction !== "UP") direction = "DOWN";
});

function startGame() {
    gameRunning = true;
    snake = [{ x: 10 * box, y: 10 * box }];
    direction = null;
    score = 0;
    food = {
        x: Math.floor(Math.random() * (canvas.width / box)) * box,
        y: Math.floor(Math.random() * (canvas.height / box)) * box,
    };
    draw();
}

function drawStartScreen() {
    ctx.fillStyle = "#111";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.font = "bold 36px Arial";
    ctx.fillStyle = "#00FFAA";
    ctx.textAlign = "center";
    ctx.fillText("DimzzSnake", canvas.width / 2, canvas.height / 2 - 20);
    ctx.font = "20px Arial";
    ctx.fillStyle = "#FFFFFF";
    ctx.fillText("Press SPACE to Start", canvas.width / 2, canvas.height / 2 + 20);
}

function drawGameOver() {
    ctx.fillStyle = "rgba(0, 0, 0, 0.8)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.font = "bold 36px Arial";
    ctx.fillStyle = "#FF5555";
    ctx.textAlign = "center";
    ctx.fillText("GAME OVER!", canvas.width / 2, canvas.height / 2 - 20);
    ctx.font = "20px Arial";
    ctx.fillStyle = "#FFFFFF";
    ctx.fillText(`Score: ${score}`, canvas.width / 2, canvas.height / 2 + 10);
    ctx.fillText("Press SPACE to Restart", canvas.width / 2, canvas.height / 2 + 40);
    gameRunning = false;
}

function draw() {
    if (!gameRunning) {
        drawStartScreen();
        return;
    }

    ctx.fillStyle = "#000";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Makanan
    ctx.fillStyle = "#FFD700";
    ctx.fillRect(food.x, food.y, box, box);

    // Ular
    for (let i = 0; i < snake.length; i++) {
        ctx.fillStyle = i === 0 ? "#00FFAA" : "#0099CC";
        ctx.fillRect(snake[i].x, snake[i].y, box, box);
    }

    // Posisi kepala ular
    let snakeX = snake[0].x;
    let snakeY = snake[0].y;

    if (direction === "LEFT") snakeX -= box;
    if (direction === "UP") snakeY -= box;
    if (direction === "RIGHT") snakeX += box;
    if (direction === "DOWN") snakeY += box;

    // Wrap-around (kalau keluar layar, muncul di sisi sebaliknya)
    if (snakeX < 0) snakeX = canvas.width - box;
    else if (snakeX >= canvas.width) snakeX = 0;
    if (snakeY < 0) snakeY = canvas.height - box;
    else if (snakeY >= canvas.height) snakeY = 0;

    // Jika makan makanan
    if (snakeX === food.x && snakeY === food.y) {
        score++;
        food = {
            x: Math.floor(Math.random() * (canvas.width / box)) * box,
            y: Math.floor(Math.random() * (canvas.height / box)) * box,
        };
    } else {
        snake.pop();
    }

    const newHead = { x: snakeX, y: snakeY };

    // Jika nabrak badan sendiri
    if (collision(newHead, snake)) {
        drawGameOver();
        return;
    }

    snake.unshift(newHead);

    // Skor
    ctx.fillStyle = "#FFF";
    ctx.font = "20px Arial";
    ctx.fillText("Score: " + score, 50, 40);

    // Kecepatan ular (lebih lambat biar nyaman)
    setTimeout(draw, 150);
}

function collision(head, arr) {
    for (let i = 0; i < arr.length; i++) {
        if (head.x === arr[i].x && head.y === arr[i].y) return true;
    }
    return false;
}

drawStartScreen();
