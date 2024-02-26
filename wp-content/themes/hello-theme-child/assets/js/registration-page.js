const first_nameEl = document.querySelector('#first_name');
const last_nameEl = document.querySelector('#last_name');
const user_emailEl = document.querySelector('#user_email');
let form = document.querySelector('#register_page');


const checkFirstName = () => {

    let valid = false;

    const min = 3,
        max = 25;

    const first_name = first_nameEl.value.trim();

    if (!isRequired(first_name)) {
        showError(first_nameEl, 'First Name cannot be blank.');
    } else if (!isBetween(first_name.length, min, max)) {
        showError(first_nameEl, `First Name must be between ${min} and ${max} characters.`)
    } else {
        showSuccess(first_nameEl);
        valid = true;
    }
    return valid;
};

const checkLastName = () => {

    let valid = false;

    const last_name = last_nameEl.value.trim();

    if (!isRequired(last_name)) {
        showError(last_nameEl, 'Last Name cannot be blank.');
    } else {
        showSuccess(last_nameEl);
        valid = true;
    }
    return valid;
};
const checkUserEmail = () => {
    let valid = false;
    const user_email = user_emailEl.value.trim();
    if (!isRequired(user_email)) {
        showError(user_emailEl, 'Email cannot be blank.');
    } else if (!isEmailValid(user_email)) {
        showError(user_emailEl, 'Email is not valid.')
    } else {
        showSuccess(user_emailEl);
        valid = true;
    }
    return valid;
};
const isEmailValid = (user_email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(user_email);
};
const isRequired = value => value === '' ? false : true;
const isBetween = (length, min, max) => length < min || length > max ? false : true;


const showError = (input, message) => {
    // get the form-field element
    const formField = input.parentElement;
    // add the error class
    formField.classList.remove('success');
    formField.classList.add('error');

    // show the error message
    const error = formField.querySelector('small');
    error.textContent = message;
};

const showSuccess = (input) => {
    // get the form-field element
    const formField = input.parentElement;

    // remove the error class
    formField.classList.remove('error');
    formField.classList.add('success');

    // hide the error message
    const error = formField.querySelector('small');
    error.textContent = '';
}


form.addEventListener('submit', function (e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isFistNameValid = checkFirstName(),
        isLastNameValid = checkLastName(),
        isEmailValid = checkUserEmail();

    let isFormValid = isFistNameValid &&
        isLastNameValid &&
        isEmailValid;

    // submit to the server if the form is valid
    if (isFormValid) {
        form.submit();
    }
});


const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

form.addEventListener('input', debounce(function (e) {
    switch (e.target.id) {
        case 'first_name':
            checkFirstName();
            break;
        case 'last_name':
            checkLastName();
            break;
        case 'user_email':
            checkUserEmail();
            break;
    }
}));


// const schedule_day=document.querySelectorAll('.schedule_day');
// console.log(schedule_day);