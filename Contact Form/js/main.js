const inputs = document.querySelectorAll(
    ".container .contact-form input, .container .contact-form textarea"
);

const submit = document.querySelector(
    ".container .contact-form input[type='submit']"
);

inputs.forEach((inp) => {
    inp.addEventListener("focusout", function () {
        // "Switch case is considered faster and more readable than nested if-else statements"
        switch (inp.dataset.goal) {
            case "username":
                if (isValidUsername(inp.value)) {
                    toShowErrorMessage(inp, false);
                } else {
                    toShowErrorMessage(inp, true);
                }
                break;
            case "email":
                if (isValidEmail(inp.value)) {
                    toShowErrorMessage(inp, false);
                } else {
                    toShowErrorMessage(inp, true);
                }
                break;
            case "mobile":
                if (isValidMobile(inp.value)) {
                    toShowErrorMessage(inp, false);
                } else {
                    toShowErrorMessage(inp, true);
                }
                break;
            case "message":
                if (isValidMessage(inp.value)) {
                    toShowErrorMessage(inp, false);
                } else {
                    toShowErrorMessage(inp, true);
                }
                break;
            default:
                break;
        }
    });
});

window.onmousemove = () => {
    if (
        isValidUsername(inputs[0].value) &&
        isValidEmail(inputs[1].value) &&
        isValidMobile(inputs[2].value) &&
        isValidMessage(inputs[3].value)
    ) {
        submit.removeAttribute("disabled");
        submit.classList.remove("text-bg-danger", "border", "border-danger");
    } else {
        submit.setAttribute("disabled", "");
        submit.classList.add("text-bg-danger", "border", "border-danger");
    }
};

function isValidUsername(username) {
    return (
        username.length >= minUsernameLen && username.length <= maxUsernameLen
    );
}

function isValidEmail(email) {
    const regEx =
        /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return Boolean(regEx.test(email));
}

function isValidMobile(mobile) {
    if (mobile != "") {
        const regEx = /^\d{10}$/;
        return Boolean(regEx.test(mobile));
    } else {
        return true; // Mobile Field is Optional
    }
}

function isValidMessage(message) {
    return (
        (message.length > minMessageLen && message.length < maxMessageLen) ||
        message == ""
    );
}

function toShowErrorMessage(inp, bool) {
    if (bool) {
        inp.nextElementSibling.classList.remove("d-none");
        inp.classList.add("border-bottom", "border-danger");
    } else {
        inp.nextElementSibling.classList.add("d-none");
        inp.classList.remove("border-bottom", "border-danger");
    }
}
