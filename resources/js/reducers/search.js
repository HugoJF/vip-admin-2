import * as types from '../constants/ActionTypes';
import {produce}  from "immer/dist/immer";

const search = (state = {}, action) => (
    produce(state, draft => {
        switch (action.type) {
            case types.SET_RESULTS:
                draft.results = action.data;

                break;
            case types.SET_LOADING:
                draft.loading = action.loading === true;

                break;
        }
    })
);

export default search