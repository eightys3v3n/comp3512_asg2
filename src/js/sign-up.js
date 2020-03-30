const letters = /^[A-Za-z]+$/;

const validInfo = {
    "fname" : {
        "required" : true,
        "minLength" : 1,
        "pattern" : /^[A-Za-z]+$/
    },
    "lname" : {
        "required" : true,
        "minLength" : 1,
        "pattern" : /^[A-Za-z]+$/
    },
    "city" : {
        "required" : true,
        "minLength" : 1,
        "pattern" : /^[A-Za-z]+$/
    },
    "country" : {
        "required" : true,
        "minLength" : 1,
        "pattern" : /^[A-Za-z]+$/
    },
    "email" : {
        "required" : false,
        "minLength" : 4,
        "pattern" : /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/

    },
    "password" : {
        "required" : true,
        "minLength" : 8,
        "pattern" : ""
    },
    "passwordconfirm" : {
        "required" : true,
        "minLength" : 8,
        "pattern" : ""
    }

}



let validateForm = () => {
    let valid = true;
    let alertText = '';
    let pwd = document.getElementById('password');
    let pwd2 = document.getElementById('passwordconfirm');

     if (pwd.value != pwd2.value) {
        valid = false;
        alertText = alertText += 'Passwords Need To Match';
    }
    for (key in validInfo) {
        let field = document.getElementById(key);
        if (field.value.length <= validInfo[key].minLength){
            console.log('bruh');
            alertText = alertText += `${field.placeholder} Too Short `;
            valid = false;
        }
        if (validInfo[key].pattern != ""){
            if (field.value.match(validInfo[key].pattern)) {
            // if (field.value.match(letters)) {
                console.log('we got a hit');
                console.log(validInfo[key].pattern)
            }
            else {
                // console.log('No Bueno')
                // console.log(field.value)
                // console.log(validInfo[key].pattern)
                valid = false;
                alertText = alertText += `${field.placeholder} Not Valid `;
            }

        }   
    }
    
    // alert('boy you betta')
    // console.log('wtf')
    if (valid){
        return valid
    } else {
        alert(alertText)
        return valid;
    }
}

// document.myForm.onsubmit = function() {
//     alert('?????')
//     return false;
// }

document.addEventListener('DOMContentLoaded', () => {




const form = document.querySelector('form');
// console.log(form)
// form.addEventListener('submit', (event) => {
// let validSubmit = false;
// let pwd = document.querySelector('input[name="password"]').value;
// let pwdConfirm = document.querySelector('input[name="confirmPassword"]').value;
// console.log(pwd)
// console.log(pwdConfirm)
// checkPassword(pwd, pwdConfirm);
// event.preventDefault();
// console.log(form)
// form.submit();
// return true
// })

let validateForm = (event) => {
    // console.log(event.target);
    // event.preventDefault();
    console.log('wtf')
    // return false
}

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