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
        countryInfo.innerText = ""
        country.style.background = "rgb(181, 255, 121)"
        info.country = true
    } else {
        countryInfo.innerText = "Incorrect country"
        countryInfo.style.color = "red"
        country.style.background = "rgb(252, 134, 134)"
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
        birthInfo.innerText = ""
        birth.style.background = "rgb(181, 255, 121)"
        info.birth = true
    } else {
        birthInfo.innerText = "Adult only"
        birthInfo.style.color = "red"
        birth.style.background = "rgb(252, 134, 134)"
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
        phoneInfo.innerText = ""
        phone.style.background = "rgb(181, 255, 121)"
        info.phone = true
    } else {
        phoneInfo.innerText = "French phone number only"
        phoneInfo.style.color = "red"
        phone.style.background = "rgb(252, 134, 134)"
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