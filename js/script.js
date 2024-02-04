let i = 0;
let txt = "Today's Headline:";
let speed = 60;

const typeWriter = () => {
    if (i < txt.length) {
        document.getElementById("headline").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
}

window.onload = () => {typeWriter()}