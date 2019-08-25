import * as types from "../constants/ActionTypes";

export const setFlag = (flag, value) => ({
    type: types.SET_FLAG,
    flag: flag,
    value: value,
});
