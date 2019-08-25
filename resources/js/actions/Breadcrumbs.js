import * as types from "../constants/ActionTypes";

export const addBreadcrumb = (id, data) => ({
    type: types.ADD_BREADCRUMB,
    id: id,
    data: data,
});

export const removeBreadcrumb = (id) => ({
    type: types.REMOVE_BREADCRUMB,
    id: id,
});