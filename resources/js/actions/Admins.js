import * as types from "../constants/ActionTypes";
import {del, get, patch, post} from "./helpers";

export const storeAdmin = (data) => ({
    type: types.STORE_ADMIN,
    data: data,
});

export const updateAdmin = (data) => ({
    type: types.UPDATE_ADMIN,
    data: data,
});

export const destroyAdmin = (data) => ({
    type: types.DESTROY_ADMIN,
    data: data,
});

export const getAdmins = () => (
    (dispatch) => {
        return get('admins')
            .then((data) => {
                dispatch(storeAdmin(data));

                return data;
            });
    }
);

export const postAdmin = (data) => (
    (dispatch) => {
        return post('admins', data)
            .then((data) => {
                dispatch(storeAdmin(data));

                return data;
            })
    }
);

export const patchAdmin = (id, data) => (
    (dispatch) => {
        console.log(data);
        return patch(`admins/${id}`, data)
            .then((data) => {
                dispatch(updateAdmin(data));

                return data;
            });
    }
);

export const deleteAdmin = (id) => (
    (dispatch) => {
        return del(`admins/${id}`)
            .then((data) => {
                dispatch(destroyAdmin(data));

                return data;
            });
    }
);
