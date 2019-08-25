import * as types from '../constants/ActionTypes';
import {produce}  from "immer/dist/immer";

const breadcrumbs = (state = {}, action) => (
    produce(state, draft => {
        switch (action.type) {
            case types.ADD_BREADCRUMB:
                draft[action.id] = action.data;

                break;
            case types.REMOVE_BREADCRUMB:
                delete draft[action.id];
        }
    })
);

export default breadcrumbs