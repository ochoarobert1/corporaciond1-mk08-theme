let menuOpen = document.getElementById('menuOpen'),
    menuClose = document.getElementById('menuClose');
/* CUSTOM ON LOAD FUNCTIONS */
function proyectoCustomLoad() {
    "use strict";
    console.log('Functions Correctly Loaded');
    menuOpen.addEventListener('click', menuToggler, false);
    menuClose.addEventListener('click', menuToggler, false);
}

function menuToggler() {
    console.log('click');
    document.getElementById('menuContent').classList.toggle('menu-hidden');
}

document.addEventListener("DOMContentLoaded", proyectoCustomLoad, false);