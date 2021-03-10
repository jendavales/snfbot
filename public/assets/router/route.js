class Route {
    name;
    path;
    regex;
    parameters;

    constructor(name, path, regex, parameters) {
        this.name = name;
        this.path = path;
        this.regex = regex;
        this.parameters = parameters;
    }

    getUrl(parameters = {}, absolute = false) {
        if (Object.keys(parameters).length !== this.parameters.length) {
            throw 'Insufficient parameters!';
        }

        let path = this.path;
        for (const index in parameters) {
            path = path.replace('{' + index + '}', parameters[index]);
        }

        if (!absolute) {
            return params.subdirectory + path;
        }

        return window.origin + '/' + params.subdirectory + path;
    }
}
