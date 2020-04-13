document.addEventListener("DOMContentLoaded", main);


function main() {
    // Put stuff here. This runs after DOMContentLoaded.
    let listItems = document.querySelector('.nav-list');
    let hamburger = document.querySelector('.navbar-toggle');

    hamburger.addEventListener('click', (e) => {
        listItems.classList.toggle("active");
        console.log('hihi');
    })
}
