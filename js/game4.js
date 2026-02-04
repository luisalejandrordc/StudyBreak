const area = document.getElementById("area");
const timeEl = document.getElementById("time");
const scoreEl = document.getElementById("score");
const result = document.getElementById("result");

let time = 30;
let score = 0;
let interval = null;
let target = null;
let playing = false;


// Start game
area.addEventListener("click", () => {

    if (!playing) {
        startGame();
    }

});


function startGame() {

    playing = true;

    score = 0;
    time = 30;

    scoreEl.textContent = score;
    timeEl.textContent = time;
    result.textContent = "";

    spawnTarget();

    interval = setInterval(() => {

        time--;
        timeEl.textContent = time;

        if (time <= 0) finish();

    }, 1000);
}


// Create target
function spawnTarget() {

    if (target) target.remove();

    target = document.createElement("div");
    target.classList.add("target");

    let maxX = area.clientWidth - 40;
    let maxY = area.clientHeight - 40;

    let x = Math.random() * maxX;
    let y = Math.random() * maxY;

    target.style.left = x + "px";
    target.style.top = y + "px";

    target.addEventListener("click", (e) => {

        e.stopPropagation();

        score++;
        scoreEl.textContent = score;

        spawnTarget();
    });

    area.appendChild(target);
}


// Finish game
function finish() {

    clearInterval(interval);

    playing = false;

    if (target) target.remove();

    result.textContent = `Time's up! Score: ${score} 🎯`;

    saveScore(score);
}


// Save to DB
function saveScore(score) {

    fetch("../save_score.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `game=focus&score=${score}`
    })
    .then(res => res.text())
    .then(data => console.log("Saved:", data));
}
