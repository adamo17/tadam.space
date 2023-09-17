const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

function validatePwd(pwd, pwd1) {
    if (!pwd || !pwd1) {
        return "Please fill in the password.";
    }
    if (pwd.length < 8 || pwd.length > 64) {
        return "Password must be between 8 and 64 characters long.";
    }
    re_lc = new RegExp("[a-z]");
    re_uc = new RegExp("[A-Z]");
    re_num = new RegExp("[0-9]");
    re_sc = new RegExp("[\"!#$%&'()*+,-./:;<=>?@[\\]^_`{|}~]");

    if (
        !re_lc.test(pwd) ||
        !re_uc.test(pwd) ||
        !re_num.test(pwd) ||
        !re_sc.test(pwd)
    ) {
        return "Password must contain an uppercase letter, a lowercase letter, a number and a special character.";
    }

    if (pwd != pwd1) {
        return "Passwords don't match.";
    }

    return true;
}

function validateUsername(username) {
    if (!username) {
        return "Please fill in the username.";
    }
    if (username.length < 3 || username.length > 32) {
        return "Username must be between 3 and 32 characters long.";
    }

    re_allowed = new RegExp("[a-zA-Z0-9\._]");
    re_result = re_allowed.test(username)

    if (
        !re_result
    ) {
        return "Username must only contain alphanumeric characters, a full-stop (.) or an underscore (_).";
    }

    return true;
}
