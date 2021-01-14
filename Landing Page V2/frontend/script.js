const BACKEND_HOST = 'localhost';
const BACKEND_PORT = 8000;


const firstname = document.getElementById('firstname')
const lastname = document.getElementById('lastname')
const genders = document.getElementsByName('gender')
const email = document.getElementById('email')
const birth = document.getElementById('birth')
const phone = document.getElementById('phone')
const country = document.getElementById('country')

const submit = document.getElementById('submit')


const generalInfo = document.getElementById('generalInfo')
const emailInfo = document.getElementById('emailInfo')
const firstnameInfo = document.getElementById('firstnameInfo')
const lastnameInfo = document.getElementById('lastnameInfo')
const birthInfo = document.getElementById('birthInfo')
const phoneInfo = document.getElementById('phoneInfo')
const countryInfo = document.getElementById('countryInfo')

/**
 *  info combine all comformity checked
 */
let info = {
    "firstname": false,
    "lastname": false,
    "email": false,
    "birth": false,
    "phone": false,
    "country": false
}

/**
 * 
 *  fetch to backend for create User
 * 
 */
submit.addEventListener('click', () => {
    if (info.firstname && info.lastname && info.email && info.birth && info.phone && info.country) {
        generalInfo.innerText = "Form completed !"
        generalInfo.style.color = "green"
        let genderChecked;
        for (var i = 0; i < genders.length; i++) {
            if (genders[i].checked) {
                genderChecked = genders[i].value;
            }
        }
        const body = {
            "firstname": firstname.value,
            "lastname": lastname.value,
            "type": genderChecked,
            "email": email.value,
            "birth": birth.value,
            "phone": phone.value,
            "country": country.value
        }
        fetch("http://" + BACKEND_HOST + ":" + BACKEND_PORT + "/api/user", {
                "mode": 'no-cors',
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json",
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Credentials': 'true'
                },
                "body": JSON.stringify(body)
            })
            .then(response => {
                console.log(response);
            })
            .catch(err => {
                console.error(err);
            });
    }else{
        generalInfo.innerText = "Error : Empty fieds of check message below fieds."
        generalInfo.style.color = "red"
    }

})




/**
 *                          *****************************
 * 
 *                          User INPUT comformity control
 * 
 *                          *****************************
 */




/**
 * 
 *  check Email validity
 */
email.addEventListener('keyup', () => {
    if (validateEmail(email.value)) {
        emailInfo.innerText = "Email ok"
        emailInfo.style.color = "green"
        info.email = true
    } else {
        emailInfo.innerText = "Incorrect email address"
        emailInfo.style.color = "red"
        info.email = false
    }
})

function validateEmail(value) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 
 *  check Firstnam, lastname, country validity
 */
firstname.addEventListener('keyup', () => {
    if (validateName(firstname.value)) {
        firstnameInfo.innerText = "Firstname ok"
        firstnameInfo.style.color = "green"
        info.firstname = true
    } else {
        firstnameInfo.innerText = "Incorrect firstname"
        firstnameInfo.style.color = "red"
        info.firstname = false
    }
})

lastname.addEventListener('keyup', () => {
    if (validateName(lastname.value)) {
        lastnameInfo.innerText = "Lastname ok"
        lastnameInfo.style.color = "green"
        info.lastname = true
    } else {
        lastnameInfo.innerText = "Incorrect Lastname"
        lastnameInfo.style.color = "red"
        info.lastname = false
    }
})

country.addEventListener('keyup', () => {
    if (validateName(country.value)) {
        countryInfo.innerText = "Country ok"
        countryInfo.style.color = "green"
        info.country = true
    } else {
        countryInfo.innerText = "Incorrect country"
        countryInfo.style.color = "red"
        info.country = false
    }
})

function validateName(value) {
    if (/^[a-zA-Z0-9_]{1,16}$/.test(value)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 
 *  check birthdate validity
 */
birth.addEventListener('change', () => {
    if (validateBirth(birth.value)) {
        birthInfo.innerText = "You can subscribe"
        birthInfo.style.color = "green"
        info.birth = true
    } else {
        birthInfo.innerText = "You cannot register if you are a minor"
        birthInfo.style.color = "red"
        info.birth = false
    }
})

function validateBirth(value) {
    let date = new Date(value)
    if (getAge(date) < 18) {
        return false;
    } else {
        return true;
    }
}

function getAge(date) {
    const diff = Date.now() - date.getTime();
    const age = new Date(diff);
    return Math.abs(age.getUTCFullYear() - 1970);
}

/**
 * 
 *  check birthdate validity
 */
phone.addEventListener('keyup', () => {
    if (validatePhone(phone.value)) {
        phoneInfo.innerText = "Phone ok"
        phoneInfo.style.color = "green"
        info.phone = true
    } else {
        phoneInfo.innerText = "You need a french number for subscrib"
        phoneInfo.style.color = "red"
        info.phone = false
    }
})

function validatePhone(value) {
    if (/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/.test(value)) {
        return true;
    } else {
        return false;
    }
}