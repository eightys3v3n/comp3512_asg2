document.addEventListener("DOMContentLoaded", main);


function main() {
    if (signup_attempt_status == "success") {
        document.querySelector("#success").style.display = "block";
        document.querySelector("#signupForm").style.display = "none";
    } else if (signup_attempt_status == "failure") {
        document.querySelector("#failure").style.display = "block";
    } else {
        console.warning("Invalid signup attempt status: '"+signup_attempt_status+"'");
    }
}

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
        "required" : true,
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
        alertText = alertText += 'Passwords Need To Match \n';
    }
    for (key in validInfo) {
        let field = document.getElementById(key);
        if (field.value.length <= validInfo[key].minLength){
            alertText = alertText += `${field.placeholder} Too Short \n`;
            valid = false;
        }
        if (validInfo[key].pattern != ""){
            if (!field.value.match(validInfo[key].pattern)) {
                valid = false;
                alertText = alertText += `${field.placeholder} Not Valid \n`;
            }

        }   
    }
    if (valid){
        return valid;
    } else {
        alert(alertText);
        return valid;
    }
}
