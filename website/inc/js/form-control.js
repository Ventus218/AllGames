const form = document.querySelector("form");
const emailInput = document.getElementById("email");
const usernameInput = document.getElementById("username");
const passwordInput = document.getElementById("password");
const confermaPasswordInput = document.getElementById("conferma-password");
const usernameSpinner = document.getElementById("username-spinner")
const emailSpinner = document.getElementById("email-spinner")

const currentUsername = usernameInput.value;
const currentEmail = emailInput.value;

function showSpinner(spinner, isShown) {
    if (isShown) {
        spinner.classList.remove("d-none");
        spinner.classList.add("d-block");
    } else {
        spinner.classList.remove("d-block");
        spinner.classList.add("d-none");
    }
}

function setInputValid(input, isValid) {
    if (isValid) {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
    }
}

function clearInputValidationClasses(input) {
    input.classList.remove("is-valid");
    input.classList.remove("is-invalid");
}

// checking if username already exists after 2 seconds from last change on username input
let usernameTimer;

usernameInput.addEventListener("input", () => {
    window.clearTimeout(usernameTimer);
    if (usernameInput.value != "" && usernameInput.value != currentUsername) {
        usernameTimer = window.setTimeout(() => {
            axios.get("api/check-username-available.php?username=" + usernameInput.value).then( res => {
                const isAvailable = res.data;
                setInputValid(usernameInput, isAvailable);
                showSpinner(usernameSpinner, false);
            });
        }, 2000)
        showSpinner(usernameSpinner, true);
    } else {
        showSpinner(usernameSpinner, false);
        clearInputValidationClasses(usernameInput);
    }
});

// checking if email already exists after 2 seconds from last change on email input
let emailTimer;

emailInput.addEventListener("input", () => {
    window.clearTimeout(emailTimer);
    if (emailInput.value != "" && emailInput.value != currentEmail) {
        emailTimer = window.setTimeout(() => {
            axios.get("api/check-email-available.php?email=" + emailInput.value).then( res => {
                const isAvailable = res.data;
                setInputValid(emailInput, isAvailable);
                showSpinner(emailSpinner, false);
            });
        }, 2000)
        showSpinner(emailSpinner, true);
    } else {
        showSpinner(emailSpinner, false);
        clearInputValidationClasses(emailInput);
    }
});

const passwError = document.getElementById("passw-error");
form.addEventListener("submit", (event) => {
    if (passwordInput.value != confermaPasswordInput.value) {
        passwError.classList.remove("d-none");
        event.preventDefault();
        return false;
    } else {
        return true;
    }
});
