import * as types from "../constants/ActionTypes";
import {get, patch, post} from "./helpers";

export const storeOrder = (data) => ({
    type: types.STORE_ORDER,
    data: data,
});

export const updateOrder = (data) => ({
    type: types.UPDATE_ORDER,
    data: data,
});

export const activatesOrder = (id) => (
    (dispatch) => {
        return patch(`orders/${id}/activate`)
            .then((data) => {
                dispatch(updateOrder(data));

                return data;
            })
    }
);

export const getOrders = () => (
    (dispatch) => {
        return get('orders')
            .then((data) => {
                dispatch(storeOrder(data));

                return data;
            });
    }
);

export const postOrder = (data) => (
    (dispatch) => {
        return post('orders', data)
            .then((data) => {
                dispatch(storeOrder(data));

                return data;
            });
    }
);

export const patchOrder = (id, data) => (
    (dispatch) => {
        console.log(data);
        return patch(`orders/${id}`, data)
            .then((data) => {
                dispatch(updateOrder(data));

                return data;
            });
    }
);
