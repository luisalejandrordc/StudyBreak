const box = document.getElementById("box");
const result = document.getElementById("result");

let startTime = 0;
let timeout = null;
let waiting = false;
let ready = false;

box.addEventListener("click", () => {

    // Start game
    if (!waiting && !ready) {

        result.textContent = "";
        box.textContent = "Wait...";
        box.className = "game-box waiting";

        waiting = true;

        let delay = Math.random() * 3000 + 2000; // 2-5 sec

        timeout = setTimeout(() => {

            startTime = Date.now();

            box.textContent = "CLICK!";
            box.className = "game-box ready";

            waiting = false;
            ready = true;

        }, delay);
    }

    // Clicked too early
    else if (waiting) {

        clearTimeout(timeout);

        box.textContent = "Too Soon!";
        box.className = "game-box too-soon";

        waiting = false;
        ready = false;

    }

    // Correct click
    else if (ready) {

        let reaction = Date.now() - startTime;

        box.textContent = "Click to Start";
        box.className = "game-box waiting";

        ready = false;

        result.textContent = `Your Time: ${reaction} ms`;

        saveScore(reaction);
    }

});


// Save score to server
function saveScore(score) {

    fetch("../save_score.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `game=reaction&score=${score}`
    })
    .then(res => res.text())
    .then(data => {
        console.log("Saved:", data);
    });
}
