class Api {
    post(url, data, callback = (e) => {}) {
        let request = new XMLHttpRequest();
        request.open("POST", url);
        request.setRequestHeader("Content-type", "application/json");
        request.send(JSON.stringify(data));
        request.onreadystatechange = callback;
    }

    get(url, callback = (e) => {}) {
        let request = new XMLHttpRequest();
        request.open("GET", url);
        request.send();
        request.onreadystatechange = callback;
    }
}

let api = new Api();
