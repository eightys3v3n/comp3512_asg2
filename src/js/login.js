document.addEventListener("DOMContentLoaded", main);

function main() {
    // If this is a login attempt, enable or disable the status text.
    // login_attempt is set by the PHP in a <script> tag. It is undefined
    // if this is a user browsing to the page, or a dictionary if this
    // is a post from a user clicking the login button.
    if (login_attempt && login_attempt.status) {
        if (login_attempt.status == "failure") {
            console.log("Failed login");
            document.querySelector("#failure").style.display = "block";
        } else if (login_attempt.status == "success") {
            document.querySelector(".box").style.display = "none";
            document.querySelector("#success").style.display = "block";
            console.log("Successful login");
        } else {
            console.warning("invalid login status, '"+login_attempt.status+"'");
        }
    }
}

