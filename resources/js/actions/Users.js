import * as types from "../constants/ActionTypes";
import {patch} from "./helpers";

export const updateUser = (data) => ({
    type: types.UPDATE_USER,
    data: data,
});

export const patchUser = (data) => (
    (dispatch) => {
        return patch(`self/settings`, data)
            .then((data) => {
                dispatch(updateUser(data));

                return data;
            });
    }
);
