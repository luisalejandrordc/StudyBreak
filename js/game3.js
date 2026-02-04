const textEl = document.getElementById("text");
const input = document.getElementById("input");
const timeEl = document.getElementById("time");
const wpmEl = document.getElementById("wpm");
const result = document.getElementById("result");


const texts = [
    "Success is the sum of small efforts repeated every day.",
    "Learning never exhausts the mind.",
    "Discipline is choosing between what you want now and what you want most.",
    "Great things are done by a series of small things brought together.",
    "Believe in yourself and all that you are."
];

let text = "";
let timer = 0;
let interval = null;
let started = false;


// Load random text
function loadText() {

    text = texts[Math.floor(Math.random() * texts.length)];

    textEl.textContent = text;

    input.value = "";
    input.disabled = false;

    timer = 0;
    started = false;

    timeEl.textContent = 0;
    wpmEl.textContent = 0;
    result.textContent = "";

    input.focus();
}

loadText();


// Start on typing
input.addEventListener("input", () => {

    if (!started) {
        started = true;
        interval = setInterval(updateTime, 1000);
    }

    let typed = input.value;

    // Highlight errors (optional later)
    if (typed === text) finish();

});


function updateTime() {

    timer++;
    timeEl.textContent = timer;

    let words = input.value.trim().split(/\s+/).length;
    let minutes = timer / 60;

    let wpm = Math.round(words / minutes) || 0;

    wpmEl.textContent = wpm;
}


function finish() {

    clearInterval(interval);
    input.disabled = true;

    let words = text.split(" ").length;
    let minutes = timer / 60;

    let wpm = Math.round(words / minutes);

    result.textContent = `Finished! Your speed: ${wpm} WPM 🚀`;

    saveScore(wpm);
}


// Save score
function saveScore(score) {

    fetch("../save_score.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `game=typing&score=${score}`
    })
    .then(res => res.text())
    .then(data => console.log("Saved:", data));
}
