let i = 0;
let txt = document.getElementById('headline').innerHTML || "Welcome to ZaTtv:";
let speed = 60;

document.getElementById("headline").innerHTML = ""
const typeWriter = () => {
    if (i < txt.length) {
        document.getElementById("headline").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
}

window.onload = () => {typeWriter()}