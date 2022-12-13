import './bootstrap';

window.toggleDisplay = function (id) {
    const el = document.getElementById(id);

    if (el.classList.contains('d-none')) {
        el.classList.remove('d-none');
    } else {
        el.classList.add('d-none');
    }
}

window.sendGetRequest = function (url) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", url, false);
    xhr.send();
}
