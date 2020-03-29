document.addEventListener('DOMContentLoaded', () => {

const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
let validSubmit = false;
let pwd = document.querySelector('input[name="password"]').value;
let pwdConfirm = document.querySelector('input[name="confirmPassword"]').value;
console.log(pwd)
console.log(pwdConfirm)
checkPassword(pwd, pwdConfirm);

event.preventDefault();
})

function checkPassword(pw1, pw2) {
if (pw1.length < 8 || pw2.length < 8){
    alert("Password Too Short");
    return false
} else if (pw1 !== pw2){
    alert("Passwords Don't Match")
    return false
}
    return true
}

})