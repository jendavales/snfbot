class Pause {
    elem;

    constructor() {
        this.elem = document.createElement('div');
        this.elem.innerHTML =
            '    <div class="spinner-border text-light" role="status">\n' +
            '        <span class="sr-only">Loading...</span>\n' +
            '    </div>';
        this.elem.classList.add('page-loading');
        document.body.append(this.elem);
    }

    stop() {
        this.elem.classList.remove('loading');
    }

    start() {
        this.elem.classList.add('loading');
    }
}

let pause = new Pause();
