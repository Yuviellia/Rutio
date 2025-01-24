const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const phoneInput = form.querySelector('input[name="phone"]');
const nameInput = form.querySelector('input[name="name"]');
const surnameInput = form.querySelector('input[name="surname"]');
const confirmedPasswordInput = form.querySelector('input[name="password2"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function isPhone(phone) {
    return /^\d{9}$/.test(phone);
}

function isName(name) {
    return /^[A-Za-z]+$/.test(name);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail() {
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value));
        },
        100
    );
}

function validatePhone() {
    setTimeout(function () {
            markValidation(phoneInput, isPhone(phoneInput.value));
        },
        100
    );
}

function validateName() {
    setTimeout(function () {
            markValidation(nameInput, isName(nameInput.value));
        },
        100
    );
}

function validateSurname() {
    setTimeout(function () {
            markValidation(surnameInput, isName(surnameInput.value));
        },
        100
    );
}

function validatePassword() {
    setTimeout(function () {
            const condition = arePasswordsSame(
                confirmedPasswordInput.previousElementSibling.value,
                confirmedPasswordInput.value
            );
            markValidation(confirmedPasswordInput, condition);
        },
        100
    );
}

emailInput.addEventListener('keyup', validateEmail);
phoneInput.addEventListener('keyup', validatePhone);
nameInput.addEventListener('keyup', validateName);
surnameInput.addEventListener('keyup', validateSurname);
confirmedPasswordInput.addEventListener('keyup', validatePassword);
