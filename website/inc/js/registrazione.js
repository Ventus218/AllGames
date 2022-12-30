const form = document.querySelector("form");
const emailInput = document.getElementById("email");
const usernameInput = document.getElementById("username");
const passwordInput = document.getElementById("password");
const confermaPasswordInput = document.getElementById("conferma-password");
const usernameSpinner = document.getElementById("username-spinner")
const emailSpinner = document.getElementById("email-spinner")

// checking if username already exists after 2 seconds from last change on username input
let usernameTimer;

usernameInput.addEventListener("input", () => {
    window.clearTimeout(usernameTimer);
    if (usernameInput.value != "") {
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
    if (emailInput.value != "") {
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
