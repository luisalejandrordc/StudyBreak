const board = document.getElementById("board");
const timeEl = document.getElementById("time");
const result = document.getElementById("result");

let symbols = ["🍎","🍌","🍇","🍒","🍓","🍍"];
let cards = [...symbols, ...symbols];

let first = null;
let second = null;
let lock = false;

let matched = 0;
let timer = 0;
let interval = null;


// Shuffle cards
cards.sort(() => Math.random() - 0.5);


// Start timer
function startTimer() {
    interval = setInterval(() => {
        timer++;
        timeEl.textContent = timer;
    }, 1000);
}


// Create board
cards.forEach(symbol => {

    let card = document.createElement("div");
    card.classList.add("card");
    card.dataset.symbol = symbol;

    card.addEventListener("click", () => flip(card));

    board.appendChild(card);

});


function flip(card) {

    if (lock) return;
    if (card.classList.contains("flipped")) return;

    if (timer === 0) startTimer();

    card.textContent = card.dataset.symbol;
    card.classList.add("flipped");

    if (!first) {
        first = card;
        return;
    }

    second = card;
    lock = true;


    if (first.dataset.symbol === second.dataset.symbol) {

        // Match
        first.classList.add("matched");
        second.classList.add("matched");

        matched += 2;

        reset();

        if (matched === cards.length) finish();

    } else {

        // No match
        setTimeout(() => {

            first.textContent = "";
            second.textContent = "";

            first.classList.remove("flipped");
            second.classList.remove("flipped");

            reset();

        }, 800);
    }
}


function reset() {
    first = null;
    second = null;
    lock = false;
}


function finish() {

    clearInterval(interval);

    result.textContent = `Finished in ${timer} seconds! 🎉`;

    saveScore(timer);
}


// Save to DB
function saveScore(time) {

    fetch("../save_score.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `game=memory&score=${time}`
    })
    .then(res => res.text())
    .then(data => console.log("Saved:", data));
}
