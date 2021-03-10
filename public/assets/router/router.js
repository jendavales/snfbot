class Router {
    routes;

    constructor(routes) {
        let routesArr = [];
        routes.forEach((routeArray) => {
            routesArr[routeArray['name']] = new Route(routeArray['name'], routeArray['path'], routeArray['regex'], routeArray['parameters']);
        });
        this.routes = routesArr;
    }

    generateUrl(routeName, parameters = {}, absolute = false) {
       return this.routes[routeName].getUrl(parameters, absolute);
    }
}

let router = new Router(routes);
