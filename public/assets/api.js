class Api {
    post(url, data, successCallback = (request) => {}, errorCallback = (e) => {}) {
        let request = new XMLHttpRequest();
        request.open("POST", url);
        request.setRequestHeader("Content-type", "application/json");
        request.send(JSON.stringify(data));
        request.onreadystatechange = (e) => {
            if(request.readyState === 4 && request.status === 200) {
                successCallback(request)
            }
        };
        request.onerror = errorCallback;
    }

    get(url, callback = (e) => {}) {
        let request = new XMLHttpRequest();
        request.open("GET", url);
        request.send();
        request.onreadystatechange = callback;
    }
}

let api = new Api();
