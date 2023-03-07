var menu = document.getElementById("menu");

function showMenu() {
    menu.style.transform = "none";
    menu.style.visibility = "visible";
    menu.style.opacity = "1";
}

function hideMenu() {
    menu.style.transform = "translateX(+100vw)";
    menu.style.visibility = "hidden";
    menu.style.opacity = "0";
}
