const set_key = (key, value) => {
    return localStorage.setItem(key, value);
}
const get_key = (key) => {
    return localStorage.getItem(key);
}
const remove_key = (key) => {
    return localStorage.removeItem(key);
}
const flush = () => {
    return localStorage.flush();
}
const is_logged_in = () => {
    return (!(get_key('auth_token') == null) && !(get_key('auth_token') == ''));
}
const logout = () => {
    return flush();
}
export {set_key, get_key, remove_key, flush, is_logged_in, logout}