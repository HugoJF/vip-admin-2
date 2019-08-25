import * as types from "../constants/ActionTypes";
import {del, get, patch, post} from "./helpers";

export const storeToken = (data) => ({
    type: types.STORE_TOKEN,
    data: data,
});

export const updateToken = (data) => ({
    type: types.UPDATE_TOKEN,
    data: data,
});

export const destroyToken = (data) => ({
    type: types.DESTROY_TOKEN,
    data: data,
});

export const useToken = (token) => (
    (dispatch) => {
        return post(`tokens/use/${token}`)
            .then((data) => {
                dispatch(storeToken(data));

                return data;
            });
    }
);

export const getTokens = () => (
    (dispatch) => {
        return get('tokens')
            .then((data) => {
                dispatch(storeToken(data));

                return data;
            });
    }
);

export const postToken = (data) => (
    (dispatch) => {
        return post('tokens', data)
            .then((data) => {
                dispatch(storeToken(data));

                return data;
            })
    }
);

export const patchToken = (id, data) => (
    (dispatch) => {
        console.log(data);
        return patch(`tokens/${id}`, data)
            .then((data) => {
                dispatch(updateToken(data));

                return data;
            });
    }
);

export const deleteToken = (id) => (
    (dispatch) => {
        return del(`tokens/${id}`)
            .then((data) => {
                dispatch(destroyToken(data));

                return data;
            });
    }
);
