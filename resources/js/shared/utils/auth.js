export function isLoggedIn() {
    return localStorage.getItem("isLoggedIn") != false;
}

export function login(){
    return localStorage.setItem("isLoggedIn", true);
}

export function logout(){
    return localStorage.setItem("isLoggedIn", false);
}
