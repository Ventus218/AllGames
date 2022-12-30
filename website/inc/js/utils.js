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