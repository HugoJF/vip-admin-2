import {store} from '../app';
import {baseUrl} from '../constants/variables'

export const route = (rest) => (`${baseUrl}${rest}`);

const headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
};

const transformToJson = (response) => response.json();

const handleErrors = (response) => {
    if (!response.ok) {
        return response.json()
            .then((e) => {
                throw Error(e.message);
            })
    } else {
        return response;
    }
};

const checkToken = () => {
    if (!store) return;

    let state = store.getState();

    if (!state) return;

    let auth = state.auth;

    if (!auth) return;

    if (!auth.token) return;
    headers['Authorization'] = `Bearer ${auth.token}`;
};

export const get = (url) => {
    checkToken();

    return fetch(route(url), {
        headers: headers,
    })
        .then(handleErrors)
        .then(transformToJson)
};

export const post = (url, data = undefined) => {
    checkToken();

    return fetch(route(url), {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(data || {}),
    })
        .then(handleErrors)
        .then(transformToJson)
};

export const patch = (url, data = undefined) => {
    checkToken();

    return fetch(route(url), {
        method: 'PATCH',
        headers: headers,
        body: JSON.stringify(data || {}),
    })
        .then(handleErrors)
        .then(transformToJson)
};

export const del = (url) => {
    checkToken();

    return fetch(route(url), {
        method: 'DELETE',
        headers: headers,
    })
        .then(handleErrors)
        .then(transformToJson)
};
