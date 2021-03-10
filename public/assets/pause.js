class Pause {
    elem;

    constructor() {
        this.elem = document.createElement('div');
        this.elem.classList.add();
        document.body.append(this.elem);
    }

    stop() {
        this.elem.classList.remove('');
    }

    start() {
        this.elem.classList.add('');
    }
}

let pause = new Pause();
