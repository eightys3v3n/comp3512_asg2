document.addEventListener("DOMContentLoaded", main);


function main() {
    // Stuff goes hereee!
    let singleMovieform = document.querySelector('#remove');

    singleMovieform.addEventListener('click', async (event) => {
        event.preventDefault();
        let movieId = event.currentTarget.parentNode.id;
        console.log(movieId);

        fetch(`api/unfavorite-movie.php?movie_id=${movieId}`)
        .then(res => {
            console.log(res);
            res.text().then((response) => {
                console.log(response);
            })
        })
        .then(resp => {
            console.log(resp);
        })
        .catch(err => console.log(err))
    })

    let unfavoriteMovie = () => {
    }

}
