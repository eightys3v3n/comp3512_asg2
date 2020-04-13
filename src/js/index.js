document.addEventListener("DOMContentLoaded", main);

function main() {
    let buttons = document.querySelectorAll('#favorites input[name="unfavorite"]');
    for (button of buttons) {
        button.addEventListener('click', e => {
            fetch(`api/unfavorite-movie.php?movie_id=${e.target.id}`)
                .then(resp => {
                    e.target.disabled = true;
                });
        });
    }
}
