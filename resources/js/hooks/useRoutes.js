import history from "../constants/history.js"
import pathToRegexp from "path-to-regexp/index";
import useReactRouter from "use-react-router/use-react-router";

const routes = {
    orders: {
        index: '/orders',
        redirect: '/orders/:orderId/redirect',
        create: '/orders/creating/:duration',
        show: '/orders/:orderId',
    },
    tokens: {
        index: '/tokens',
        show: '/tokens/:tokenId',
    },
    admins: {
        index: '/admins',
    },
    home: '/',
    login: '/login',
    search: '/search/:term?',
    settings: '/settings',
};

let router = undefined;

const compile = (route, data) => {
    return pathToRegexp.compile(route)({
        ...router.match.params,
        ...data,
    });
};

const endPoint = (route) => ({
    url: (data) => compile(route, data),
    redirect: (data) => history.push(compile(route, data)),
    raw: () => route,
});

const bindRoutes = (routes) => {
    return Object.entries(routes).reduce((result, [key, value]) => {
        if (typeof value === 'object') {
            result[key] = bindRoutes(value);
        } else if (typeof value === 'string') {
            result[key] = endPoint(value);
        } else {
            throw Error(`Unsupported route type: ${typeof value}`);
        }

        return result;
    }, {});
};

export default function useRoutes() {
    router = useReactRouter();

    return bindRoutes(routes, router);
};