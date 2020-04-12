document.addEventListener("DOMContentLoaded", main);


function main() {
    // Stuff goes hereee!
    let movieForms = document.querySelectorAll('.remove');

    
    for (let btn of movieForms){
    btn.addEventListener('click', async (event) => {
        event.preventDefault();
        let movieId = event.currentTarget.parentNode.id;
        console.log(movieId);

        fetch(`api/unfavorite-movie.php?movie_id=${movieId}`)
        .then(res => {
            console.log(res);
            res.text().then((response) => {
                console.log(response);
                // console.log(response.trim());
                event.returnValue = true;
            })
        })
        .catch(err => console.log(err))
    })
    };

    let unfavoriteMovie = () => {

    }

}
