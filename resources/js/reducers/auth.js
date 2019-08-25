import * as types from '../constants/ActionTypes';

/* This reducer avoids using Immer to avoid immutability problems with persistence */
const auth = (state = {}, action) => {
        switch (action.type) {
            case types.STORE_AUTH:
                return {
                    ...state,
                    ...action.data,
                };
            case types.UPDATE_USER:
                return {
                    ...state,
                    user: {
                        ...state.user,
                        ...action.data,
                    }
                };
            case types.DESTROY_AUTH:
                return {
                    redirect: state.redirectToPayment
                };
            default:
                return state;
        }
    }
;

export default auth