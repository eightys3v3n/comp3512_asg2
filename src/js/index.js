document.addEventListener("DOMContentLoaded", main);

function main() {
    document.querySelector('#favorites input[name="unfavorite"]')
        .addEventListener('click', e => {
            fetch(`api/unfavorite-movie.php?movie_id=${e.target.id}`)
                .then(resp => {
                    e.target.disabled = true;
                });
        });
}
