import * as types from '../constants/ActionTypes';

const flags = (state = {}, action) => {
    switch (action.type) {
        case types.SET_FLAG:
            return {
                ...state,
                [action.flag]: action.value,
            };
        default:
            return state
    }
};

export default flags