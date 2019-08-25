import * as types from "../constants/ActionTypes";
import {get, patch, post} from './helpers';

export const storeAuth = (data) => ({
    type: types.STORE_AUTH,
    data: data,
});

export const destroyAuth = (data) => ({
    type: types.DESTROY_AUTH,
    data: data,
});

export const getAuth = () => (
    (dispatch) => {
        return get('auth')
            .then((data) => {
                console.log('auth info', data);

                dispatch(storeAuth(data));

                return data;
            });
    }
);

export const refreshAuth = () => (
    (dispatch) => {
        return post('auth/refresh')
            .then((data) => {
                console.log('auth info', data);

                dispatch(storeAuth(data));

                return data;
            });
    }
);

export const postAuth = (query) => (
    (dispatch) => {
        return post(`auth${query}`)
            .then((data) => {
                if (data.authed)
                    dispatch(storeAuth(data));

                return data;
            })
    }
);