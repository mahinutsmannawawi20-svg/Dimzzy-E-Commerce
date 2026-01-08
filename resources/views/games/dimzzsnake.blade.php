@extends('layouts.app')

@section('content')
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background-color: #1a202c;
            /* Ensure background is dark */
        }

        #gameContainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding-bottom: 2rem;
        }
    </style>

    <div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!
            Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih! | Yang Beli Dimsum Auto Sigma Loh Ya | Mas Rusdi Pernah Beli
            Mojito Disini
            | Katanya Sayang, Kok Ga Beliin Pacarnya Mojito Sih | Cintaku Hanya Sebatas Dimsum Keju | Musmid Keju</marquee>
    </div>

    <div id="gameContainer">
        <canvas id="snakeCanvas" width="800" height="600" class="bg-black rounded-lg shadow-lg mb-4"></canvas>

        <!-- Footer Coupon Section -->
        @include('components.fresh-coupon-modal')
    </div>

    <script>
        const canvas = document.getElementById("snakeCanvas");
        const ctx = canvas.getContext("2d");

        const box = 20;
        let snake = [{
            x: 10 * box,
            y: 10 * box
        }];
        let direction = null;
        let food = {
            x: Math.floor(Math.random() * (canvas.width / box)) * box,
            y: Math.floor(Math.random() * (canvas.height / box)) * box,
        };
        let gameRunning = false;
        let score = 0;
        let gameLoop; // Store interval ID

        document.addEventListener("keydown", (e) => {
            if (!gameRunning && e.code === "Space") startGame();

            // Prevent default scrolling for arrow keys
            if (["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].indexOf(e.code) > -1) {
                e.preventDefault();
            }

            if (e.key === "ArrowLeft" && direction !== "RIGHT") direction = "LEFT";
            else if (e.key === "ArrowUp" && direction !== "DOWN") direction = "UP";
            else if (e.key === "ArrowRight" && direction !== "LEFT") direction = "RIGHT";
            else if (e.key === "ArrowDown" && direction !== "UP") direction = "DOWN";
        });

        function startGame() {
            if (gameLoop) clearTimeout(gameLoop); // Clear existing loop
            gameRunning = true;
            snake = [{
                x: 10 * box,
                y: 10 * box
            }];
            direction = null; // Reset direction, wait for user input
            score = 0;

            // Reset Footer UI
            const scoreDisplay = document.getElementById('finalScoreDisplay');
            const couponSection = document.getElementById('couponDataSection');
            const noCouponMsg = document.getElementById('noCouponMessage');

            if (scoreDisplay) scoreDisplay.textContent = '0';
            if (couponSection) couponSection.style.display = 'none';
            if (noCouponMsg) noCouponMsg.style.display = 'none';

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
            ctx.font = "14px Arial";
            ctx.fillStyle = "#FFD700";
            ctx.fillText("1 Food = 100 Points! Reach 1000 for Coupon!", canvas.width / 2, canvas.height / 2 + 50);
        }

        function drawGameOver() {
            gameRunning = false;

            ctx.fillStyle = "rgba(0, 0, 0, 0.8)";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.font = "bold 36px Arial";
            ctx.fillStyle = "#FF5555";
            ctx.textAlign = "center";
            ctx.fillText("GAME OVER!", canvas.width / 2, canvas.height / 2 - 20);
            ctx.font = "20px Arial";
            ctx.fillStyle = "#FFFFFF";
            ctx.fillText(`Final Score: ${score}`, canvas.width / 2, canvas.height / 2 + 10);
            ctx.fillText("Press SPACE to Restart", canvas.width / 2, canvas.height / 2 + 40);

            // TRIGGER SAVE SCORE
            saveScore();
        }

        function draw() {
            if (!gameRunning) {
                drawStartScreen();
                return; // Stop loop if not running
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

            // Move ONLY if direction is set
            if (direction === "LEFT") snakeX -= box;
            if (direction === "UP") snakeY -= box;
            if (direction === "RIGHT") snakeX += box;
            if (direction === "DOWN") snakeY += box;

            // Wrap-around
            if (snakeX < 0) snakeX = canvas.width - box;
            else if (snakeX >= canvas.width) snakeX = 0;
            if (snakeY < 0) snakeY = canvas.height - box;
            else if (snakeY >= canvas.height) snakeY = 0;

            // Check Food Collision
            let justAte = false;
            if (snakeX === food.x && snakeY === food.y) {
                score += 100; // INCREASED SCORE PER USER REQUEST
                justAte = true;
                food = {
                    x: Math.floor(Math.random() * (canvas.width / box)) * box,
                    y: Math.floor(Math.random() * (canvas.height / box)) * box,
                };
            } else {
                // Remove tail unless we just ate (snake grows)
                // Only remove tail if we are moving. If just starting (direction null), don't pop.
                if (direction) {
                    snake.pop();
                }
            }

            const newHead = {
                x: snakeX,
                y: snakeY
            };

            // Check Self Collision ONLY if moving
            if (direction && collision(newHead, snake)) {
                drawGameOver();
                return;
            }

            if (direction) {
                snake.unshift(newHead);
            }

            // Skor Display on Canvas
            ctx.fillStyle = "#FFF";
            ctx.font = "20px Arial";
            ctx.textAlign = "left";
            ctx.fillText("Score: " + score, 20, 30);

            // Loop
            gameLoop = setTimeout(draw, 100); // Slightly faster speed
        }

        function collision(head, arr) {
            for (let i = 0; i < arr.length; i++) {
                if (head.x === arr[i].x && head.y === arr[i].y) return true;
            }
            return false;
        }

        // Initial Start Screen
        drawStartScreen();

        // ------------------ SAVE SCORE & COUPON LOGIC (COPIED FROM PINGPONG) ------------------
        function saveScore() {
            const playerName = prompt("Enter your name:") || "Guest";
            const finalScore = score;

            // 1. UPDATE UI INSTANTLY (Score)
            const scoreDisplay = document.getElementById('finalScoreDisplay');
            if (scoreDisplay) scoreDisplay.textContent = finalScore;

            const couponSection = document.getElementById('couponDataSection');
            const noCouponMsg = document.getElementById('noCouponMessage');
            const section = document.getElementById('couponResultSection');

            // Scroll to footer immediately
            if (section) section.scrollIntoView({
                behavior: 'smooth'
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/save-score', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        player_name: playerName,
                        score: finalScore,
                        game_type: 'snake' // IMPORTANT: Correct Game Type
                    })
                })
                .then(response => {
                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error(
                            `Server returned ${response.status}: ${response.statusText}. Expected JSON but got ${contentType}`
                        );
                    }

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (data.coupon_generated && data.coupon) {
                        // WIN: Show Coupon Data
                        if (couponSection) couponSection.style.display = 'block';
                        if (noCouponMsg) noCouponMsg.style.display = 'none';

                        // Fill Fields
                        document.getElementById('generatedCouponCode').textContent = data.coupon.code;
                        document.getElementById('modal-discountPercentage').textContent = data.coupon
                            .discount_percentage + '%';
                        document.getElementById('modal-expiredAt').textContent = data.coupon.expired_at;
                        document.getElementById('modal-minPurchase').textContent = 'Rp ' + data.coupon.min_purchase;

                        // Copy Button Logic
                        const copyBtn = document.getElementById('copyCouponBtn');
                        if (copyBtn) {
                            copyBtn.onclick = function() {
                                navigator.clipboard.writeText(data.coupon.code).then(function() {
                                    var originalText = copyBtn.innerHTML;
                                    copyBtn.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin!';
                                    setTimeout(function() {
                                        copyBtn.innerHTML = originalText;
                                    }, 2000);
                                });
                            };
                        }

                    } else {
                        // LOSE or LIMIT REACHED
                        if (couponSection) couponSection.style.display = 'none';
                        if (noCouponMsg) {
                            noCouponMsg.style.display = 'block';
                            if (data.message) {
                                noCouponMsg.innerHTML = `<p class="text-warning fw-bold">${data.message}</p>`;
                            } else {
                                noCouponMsg.innerHTML =
                                    '<p class="text-muted">Kumpulkan skor minimal 1000 untuk mendapatkan kupon diskon!</p>';
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (noCouponMsg) {
                        noCouponMsg.style.display = 'block';
                        noCouponMsg.innerHTML =
                            `<p class="text-danger">Gagal menyimpan skor: ${error.message}. Coba refresh.</p>`;
                    }
                });
        }
    </script>
@endsection
