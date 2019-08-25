import * as types from '../constants/ActionTypes';
import {produce} from "immer/dist/immer";
import moment from "moment";

const unix = (date) => moment(date.created_at).unix();

const orders = (state = {allIds: [], byId: {}}, action) => (
    produce(state, (draft) => {
        switch (action.type) {
            case types.UPDATE_ADMIN:
            case types.STORE_ADMIN:
                if (!Array.isArray(action.data))
                    action.data = [action.data];

                action.data.forEach((e) => {
                    draft.byId[e.id] = e;
                });

                break;
            case types.DESTROY_ADMIN:
                delete draft.byId[action.data.id];

                break;
        }

        draft.allIds = Object.keys(draft.byId).sort((a, b) => unix(draft.byId[b]) - unix(draft.byId[a]));
    })
);

export default orders